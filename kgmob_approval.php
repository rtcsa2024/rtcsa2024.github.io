<?php
/****************************************************************************************
* 파일명 : cn_web.php
* 작성자 : 서비스운영
* 작성일 : 2019.07
* 용  도 : 신용카드(CN) Webnoti 방식 결제 연동 페이지
* 버	전 : 0003
* ---------------------------------------------------------------------------------------
* 소스 임의변경에 따른 손실은 모빌리언스에서 책임지지 않습니다.
* 요청 파라미터 및 결제결과 전달 정보는 반드시 연동 매뉴얼을 참조하십시오.
* 신용카드(CN)는 결제테스트 환경을 제공하지 않습니다.
* 테스트 결제건은 가맹점 관리자 또는 취소 모듈을 이용하여 직접 취소 처리를 해야 합니다.
*
* 암호화 사용시 필수 파일
* seed.php 파일을 가맹점측 서버에 설치
****************************************************************************************/

error_reporting(E_ALL);
ini_set('display_errors', '1');

include "inc/seed.php";		// 좌측의 경로는 가맹점 서버에 설치한 seed파일의 절대경로로 수정 필수

/*****************************************************************
함수명 : cipher 암호화 실행
사용법 : cipher ("암호화할데이터", "가맹점거래번호")
주의사항 : 절대수정금지
*****************************************************************/
function cipher($seedStr, $seedKey) {
	return encodeString($seedStr, getKey($seedKey));
}

function getKey($value) {
	$padding = "123456789123456789";
	$tmpKey = $value;
	$keyLength = strlen($value);
	if($keyLength < 16) $tmpKey = $tmpKey.substr($padding, 0, 16-$keyLength);
	else $tmpKey = substr($tmpKey, strlen($tmpKey)-16,  strlen($tmpKey));
}

/*****************************************************************
함수명 : appr_dtm 결제 요청일시 구하기
*****************************************************************/
function appr_dtm() {
	$microtime = microtime();
	$comps = explode(" ", $microtime);
	return date("YmdHis") . sprintf("%04d", $comps[0] * 10000);
}


/*****************************************************************************************
- 필수 입력 항목
*****************************************************************************************/
$VER = "ALL_NEW";					//ALL_NEW : 버전설정 고정
$CASH_GB = "CN"; 					// 대표결제수단. 고정
//$CN_SVCID = "190115066123";						//서비스아이디
$CN_SVCID = "adminkiise2";						//서비스아이디
$PAY_MODE = "10";					//10 : 실거래결제 고정
$Prdtprice = $_POST['Prdtprice']; // "1000";					//결제요청금액.
$Prdtnm = $_POST['Prdtnm']; //상품명 ( 50byte 이내 )
$Siteurl = "https://apsys23.skku.edu";						//가맹점도메인
$Okurl = "https://apsys23.skku.edu/kgmob_okurl.php";						//성공화면처리URL : 결제완료통보페이지 full Url (예:http://www.mcash.co.kr/okurl.jsp )
$Tradeid = $CN_SVCID . "_" . appr_dtm();	//가맹점거래번호 //결제 요청 시 마다 unique한 값을 세팅해야 함.

/*****************************************************************************************
- 선택 입력 항목
*****************************************************************************************/
$Notiurl = "https://apsys23.skku.edu/kgmob_notiurl.php";						//결제처리URL : 결제 완료 후, 가맹점측 과금 등 처리할 가맹점측 URL
//$Notiurl = "";						//결제처리URL : 결제 완료 후, 가맹점측 과금 등 처리할 가맹점측 URL
$CALL_TYPE = "";					//결제창 호출방식
$Failurl = "";						//결제 실패 시 사용자에게 보여질 가맹점 측 실패 페이지
$Closeurl = "";						//닫기버튼 클릭 시 호출되는 가맹점 측 페이지. CALL_TYPE = ‘I’ 또는 ‘SELF’ 셋팅 시 필수
$MSTR = "";							//가맹점콜백변수 //가맹점에서 추가적으로 파라미터가 필요한 경우 사용하며 &,%,?,^ 는 사용불가 ( 예 : MSTR="a=1|b=2|c=3" )
$Payeremail = "";					//결제자email
$Userid = "";						//가맹점결제자ID
$CN_BILLTYPE = "";					//매출전표 출력 시 과세/비과세 구분
$CN_TAXFREE = "";					//비과세
$CN_TAX = "";						//부과세 - 전체금액의 10%이하로 설정
$CN_FREEINTEREST = "";				//무이자할부정보
$CN_POINT = "";						//카드사포인트사용여부
$Termregno = "";					//하위가맹점사업자번호
$APP_SCHEME = "";					//APP SCHEME
$Username = "";						//결제자명
$CN_INSTALL = "";					//할부개월
$CN_FIXCARDCD = "";					//카드사 선택노출 '결제창에 노출할 카드사 코드 셋팅
$CN_DIRECT = "";					//카드사 직접호출 ( 예 : KBC:00:N )
/* XXX */
$Deposit = $_POST['misc'];						//일회용컵보증금


/*****************************************************************************************
- 암호화 처리 (암호화 사용 시)
Cryptstring 항목은 금액변조에 대한 확인용으로 반드시 아래와 같이 문자열을 생성하여야 합니다.

주) 암호화 스트링은 가맹점에서 전달하는 거래번호로 부터 추출되어 사용되므로
암호화에 이용한 거래번호가  변조되어 전달될 경우 복호화 실패로 결제 진행이 불가합니다.
*****************************************************************************************/
$Cryptyn = "N";		//Y: 암호화 사용, N: 암호화 미사용
$Cryptstring = "";		//암호화 사용 시 암호화된 스트링

if($Cryptyn == "Y") {
	$Cryptstring = $Prdtprice.$Okurl;	//금액변조확인 (결제요청금액 + Okurl)
	$Okurl = cipher($Okurl, $Tradeid);
	$Failurl = cipher($Failurl, $Tradeid);
	$Notiurl = cipher($Notiurl, $Tradeid);
	$Prdtprice = cipher($Prdtprice, $Tradeid);
	$Cryptstring = cipher($Cryptstring, $Tradeid);
}

$output= "";
parse_str($Deposit, $output);

$name = $output['name'];
$email = $output['email'];
$affiliation = $output['affiliation'];
$country = $output['country'];
$acm_type = $output['acm_type'];
$acm_num = $output['acm_num'];

/* for kgmob backend */
$Payeremail = $email; // XXX: not showing in website
$Userid = $email;
$Username = $name;

$mysql_err = "";
$result = 1;

$connect = mysqli_connect("localhost", "root", "apsys23secret", "apsys23_db");
if (!$connect) {
  $mysql_err = "ERR_BACKEND_MYSQL_CONNECTION";
} else {   
  $query = "INSERT IGNORE INTO kgmob_try_registrant (name, email, affiliation, country, acm_type, acm_num)
      VALUES ('$name', '$email', '$affiliation', '$country', '$acm_type', '$acm_num')";

  $result = mysqli_query($connect, $query);
  if ($result != 1) {
    $mysql_err = "ERR_BACKEND_MYSQL_QUERY";
  }
  mysqli_close($connect);
}

?>

<!--  가맹점의 결제요청 페이지 -->
<!DOCTYPE html>
<html>
<head>
<style>
	body {font-size:14px;}
	table td {font-size:13px;}
	table {border-collapse: collapse; text-align: left;}
</style>
<script src="https://mup.mobilians.co.kr/js/ext/ext_inc_comm.js"></script>
<script language="javascript">
  function payRequest(){
		//아래와 같이 ext_inc_comm.js에 선언되어 있는 함수를 호출
		MCASH_PAYMENT(document.payForm);
  }

  window.onload = function() {
    payRequest(); // payRequest() 함수 호출
    window.close();
  };

</script>

<div id="id" style="display:none">
<form name="payForm" accept-charset="euc-kr">
  <td><input type="hidden" name="CASH_GB" id="CASH_GB" size="2" value="<?php echo $CASH_GB;?>"></td>
  <td><input type="hidden" name="CN_SVCID" id="CN_SVCID" size="12" value="<?php echo $CN_SVCID;?>"></td>
 	<td><input type="hidden" name="PAY_MODE" id="PAY_MODE" size="2" value="<?php echo $PAY_MODE;?>"></td>
  <td><input type="hidden" name="VER" id="VER" size="10" value="<?php echo $VER;?>"></td>
  <td><input type="hidden" name="Prdtprice" id="Prdtprice" size="10" value="<?php echo $Prdtprice;?>"></td>
 	<td><input type="hidden" name="Prdtnm" id="Prdtnm" size="50" value="<?php echo $Prdtnm;?>"></td>
  <td><input type="hidden" name="Tradeid" id="Tradeid" size="40" value="<?php echo $Tradeid;?>"></td>
  <td><input type="hidden" name="Siteurl" id="Siteurl" size="40" value="<?php echo $Siteurl;?>"></td>
  <td><input type="hidden" name="Okurl" id="Okurl" value="<?php echo $Okurl;?>"></td>
  <td><input type="hidden" name="Notiurl" id="Notiurl" value="<?php echo $Notiurl;?>"></td>
  <td><input type="hidden" name="CALL_TYPE" id="CALL_TYPE" value="<?php echo $CALL_TYPE;?>"></td>
  <td><input type="hidden" name="Failurl" id="Failurl" value="<?php echo $Failurl;?>"></td>
  <td><input type="hidden" name="Userid" id="Userid" size="30" value="<?php echo $Userid;?>"></td>
  <td><input type="hidden" name="MSTR" id="MSTR" value="<?php echo $MSTR;?>"></td>
  <td><input type="hidden" name="Payeremail" id="Payeremail" size="30" value="<?php echo $Payeremail;?>"></td>
  <td><input type="hidden" name="Cryptyn" id="Cryptyn" size="1" value="<?php echo $Cryptyn;?>"></td>
  <td><input type="hidden" name="Cryptstring" id="Cryptstring" value="<?php echo $Cryptstring;?>"></td>
  <td><input type="hidden" name="Closeurl" id="Closeurl" value="<?php echo $Closeurl;?>"></td>
  <td><input type="hidden" name="CN_BILLTYPE" id="CN_BILLTYPE" value="<?php echo $CN_BILLTYPE;?>"></td>
  <td><input type="hidden" name="tax" id="CN_TAX" value="<?php echo $CN_TAX;?>"></td>
  <td><input type="hidden" name="CN_TAXFREE" id="CN_TAXFREE" value="<?php echo $CN_TAXFREE;?>"></td>
  <td><input type="hidden" name="Username" id="Username" value="<?php echo $Username;?>"></td>
  <td><input type="hidden" name="CN_FREEINTEREST" id="CN_FREEINTEREST" value="<?php echo $CN_FREEINTEREST;?>"></td>
  <td><input type="hidden" name="CN_POINT" id="CN_POINT" value="<?php echo $CN_POINT;?>"></td>
  <td><input type="hidden" name="Termregno" id="Termregno" value="<?php echo $Termregno;?>"></td>
  <td><input type="hidden" name="APP_SCHEME" id="APP_SCHEME" value="<?php echo $APP_SCHEME;?>"></td>
  <td><input type="hidden" name="CN_FIXCARDCD" id="CN_FIXCARDCD" value="<?php echo $CN_FIXCARDCD;?>"></td>
  <td><input type="hidden" name="CN_DIRECT" id="CN_DIRECT" value="<?php echo $CN_DIRECT;?>"></td>
  <td><input type="hidden" name="CN_INSTALL" id="CN_INSTALL" value="<?php echo $CN_INSTALL;?>"></td>
  <td><input type="hidden" name="Deposit" id="Deposit" value="<?php echo $Deposit;?>"></td>
</form>
</div>

</head>

<body>
<!-- <h1 id="">Do not close the window until payment is complete</h1> -->
</body>
</html>
