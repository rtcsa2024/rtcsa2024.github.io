# rtcsa2024.github.io

# 구조
- 기본적인 페이지(결제 모듈 제외)는 모두 github.io에서 구동되는 것을 상정하여 개발되었습니다.
- 결제 관련 시스템은 AWS EC2 서버에서 작동중이며 'LAMP' 설치  스택으로 환경을 구성하였습니다.
   - 결제 DB 관련하여 자세한 내용은 aws 디렉토리 내부의 readme에 상세히 기제되어 있습니다.


# 학회에 맞도록 코드 수정해야하는 곳
- php 파일에 있는 Allow Origin 의 url 또는 ip 정보 (보안장치, 기입된 url 또는 ip만 서버와 통신할 수 있습니다.)
   - 이런 코드입니다 : $allowed_origins = ['http://127.0.0.1:5500','https://rtcsa2024.io'];
- 각 코드에 있는 mysql 서버 계정 정보
   - 이런 코드입니다 : mysqli_connect("localhost", "root", "RTCSA2024@pay@cau", "rtcsa2024_paymentServer");
- DB 테이블 이름
   - kgmob_try_registrant.. 등등
- 각 코드에 있는 호출 url 주소 (return url, status url, 등등..)
   - https://서버주소/~~~.php 에 해당되는 값
- eximbay의 경우 mid, api key
- kgmob의 경우 서비스 아이디 바꿔야함 $CN_SVCID = "kiise2"

# 결제 구조
결제는 국내 / 국외 결제 모듈이 따로 구성되어 있습니다.

- 국내 : KGmob(Kg 모빌리언스)
- 국외 : Eximbay

## 결제 결과 창 호출하기
결제 결과 창을 호출하기 위해선 반드시 사용하듣 url 또는 domain 이 https, 즉 SSL 인증을 받아야합니다.

특히 rtcsa2024의 경우 결제 모듈 파츠를 외부 aws 서버로 빼면서 기본적으로는 http만 지원하는 현상이 있었습니다.

이를 해결하기 위해서는 다음과 같은 조치를 취해야합니다.
- domain 구매
- SSL 인증서 발급
- HTTPS 포트 (443 포트) 인바운드 규칙 설정
- load balancer 설정

아래 페이지에서 많은 도움을 얻었습니다.

https://jindevelopetravel0919.tistory.com/192

## 결제 흐름 및 구조
각 모듈의 결제 흐름은 다음과 같습니다.
### 국내
1. domestic_registr.html 에서 submit() 호출

2. approval.js에서 호출의 발신처 (domestic | international)에 따라서 각기 다른 함수 호출

   - domestic_registr.html 가 호출하였기에 kgmob_approval.js의 함수 사용할 것

3. payment_kgmob() 호출 됨
   - html 에서 넘겨준 option 값들 모두 읽어들임
   - submit_kgmob() 함수 호출 -> aws 서버의 kgmob_approval.php 호출하는 것

4. kgmob_approval.php 호출 됨
   - $_POST에 dictionary 형식으로 html에서 넘긴 데이터가 존재함
   - 관련 정보를 kgmob_try_registrant 테이블에 저장 (필요에 따라 수정)
   - kgmob 결제 모듈 호출 -> 결제 시퀀스 끝난 후 다음 php 호출

5. kgmob_notiurl.php 호출 됨 (건드릴 것 없음) -> kgmob_okurl.php 호출

6. kgmob_okurl.php 호출 됨
   - kgmob_auth_registrant 테이블에 이메일과 함께 결제 결과 정보 저장 (필요에 따라 수정)
   - 이후 kgmob_finish.php 호출

7. kgmob_finish.php 호출 됨
   - 전달 받은 email을 기준으로 kgmob_try_registrant에서 매칭되는 이메일 정보 중 가장 마지막으로 저장된 데이터 불러와 register 정보를 표로 보여줌

### 국외
1. internat_registr.html 에서 submit() 호출

2. approval.js에서 호출의 발신처 (domestic | international)에 따라서 각기 다른 함수 호출

   - internat_registr.html 가 호출하였기에 eximbay_approval.js의 함수 사용할 것

3. payment_eximbay() 호출 됨
   - html 에서 넘겨준 option 값들 모두 읽어들임
   - js 코드에서 eximbay사가 제공하는 openapi를 호출
   - open api 호출시 필요한 fgkey값 생성을 위해, aws 서버의 eximbay_openapi.php 호출

4. eximbay_openapi.php 호출 됨
   - $_POST에 dictionary 형식으로 html에서 넘긴 데이터가 존재함
   - 관련 정보를 eximbay_try_registrant 테이블에 저장 (필요에 따라 수정)
   - openapi 의 결제 준비 모듈을 호출하여 fgkey 생성 (고유한 mid, api key 사용해야 함)
   - api key의 경우 끝에 = 를 추가로 붙여 base64로 인코딩한 값을 활용해야함
      - 예를 들어 asdfasdfasdf= 라는 키가 있다면 asdfasdfasdf== 로하여 base64 인코딩 진행한 값을 사용함

5. 생성된 fgkey 값을 가지고 eximbay_approval.js 상에서 api 호출 -> EXIMBAY.request_pay(sendObj);
   - 호출 시 returnurl 과 statusurl을 같이 전송하게 됨.
      - statusurl의 경우 결제의 투명성을 검증하기 위한 처리가 있음, 현재 eximbay_status.php로 선언되어 있음
      - returnurl의 경우 결제 완료 페이지, 현재 eximbay_return.php로 선언되어 있음
      - statusurl 호출 이후 returnurl이 호출 됨

6. statusurl에서 verify를 통해fgkey키가 변형되었을 가능성을 체크하게 됨
   - 정상적이라면 서버 DB의 eximbay_auth_registrant 테이블에 이메일과 함께 결과 정보 저장 (필요에 따라 수정)
   - 이후 returnurl 호출

6. returnurl 호출 됨
   - 전달 받은 email을 기준으로 eximbay_try_registrant에서 매칭되는 이메일 정보 중 가장 마지막으로 저장된 데이터 불러와 register 정보를 표로 보여줌

### 알립니다
현재 데이터는 email로 각 table 열의 unique 데이터를 구분하고 있습니다.

하지만 이는 올바르지 않은 방식으로 이후 개발해주시는 분께서는 'id' 필드를 추가하여 고유한 id를 기준으로 table 검색을 진행하여 주십시오.