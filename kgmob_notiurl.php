<?
	/****************************************************************************************
	* 결제 성공시 시스템 백단으로 호출되는 페이지로 결제처리(서비스제공) 용도
	* 결제처리(서비스제공) 성공 시 'SUCCESS' 실패 시 'FAIL' 출력
	* Okurl과 결제 결과 중복 처리 주의
	****************************************************************************************/

	include "inc/seed.php";		// 좌측의 경로는 가맹점 서버에 설치한 seed파일의 절대경로로 수정 필수

	$CASH_GB		= $_POST["CASH_GB"];		// 결제수단(CN)
	$Resultcd		= $_POST["Resultcd"];		// 결과코드
	$Resultmsg		= $_POST["Resultmsg"];		// 결과메세지
	$Svcid			= $_POST["Svcid"];			// 서비스ID
	$Mobilid		= $_POST["Mobilid"];		// 모빌리언스 거래번호
	$Signdate		= $_POST["Signdate"];		// 결제일자
	$Tradeid		= $_POST["Tradeid"];		// 상점거래번호
	$Prdtnm			= $_POST["Prdtnm"];			// 상품명
	$Prdtprice		= $_POST["Prdtprice"];		// 상품가격
	$Interest		= $_POST["Interest"];		// 할부개월수
	$Payeremail		= $_POST["Payeremail"];		// 결제자이메일
	$Userid			= $_POST["Userid"];			// 사용자ID
	$Username		= $_POST["Username"];		// 결제자명
	$MSTR			= $_POST["MSTR"];			// 가맹점 전달 콜백변수
	$Cardnum		= $_POST["Cardnum"];		// 결제 카드번호
	$Cardcode		= $_POST["Cardcode"];		// 결제 카드코드
	$Cardname		= $_POST["Cardname"];		// 결제 카드사명
	$Apprno			= $_POST["Apprno"];			// 승인번호
	$Paymethod		= $_POST["Paymethod"];		// 지불방법
	$Couponprice	= $_POST["Couponprice"];	// 결제된 쿠폰금액
	$chkValue		= $_POST["chkValue"];		// 결과값 검증 hash데이터
	$Deposit		= $_POST["Deposit"];		// 일회용컵보증금

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
		for($i = 0; $i < 16; $i++) {
			$result = $result.chr(ord(substr($tmpKey, $i, 1))^($i+1));
		}
		return $result;
	}

	/*
	 * 결제 정보의 위·변조 여부 확인 용도
	 * 주요 결제 정보를 HASH 처리한 chkValue 값을 받아
	 * 동일한 규칙으로 Notiurl에서 생성한 값(output)과 비교합니다.
	 */

	$returnMsg = "";
	$cpChkValue = "Mobilid=".$Mobilid."&Mrchid=null&Svcid=".$Svcid."&Tradeid=".$Tradeid."&Signdate=".$Signdate."&Prdtprice=".$Prdtprice;

	$encChkValue = cipher($cpChkValue, $Tradeid);

	// 값 비교
	if ($encChkValue == $chkValue) {
		// 동일 시 결제처리(서비스제공)
		$returnMsg = "SUCCESS";
	} else {
		// 일치하지 않을 경우 데이터 위·변조 가능성 높으니 FAIL 처리
		$returnMsg = "FAIL";
	}

?>

<? echo $returnMsg; ?>
