<?php
	/*********************************************************************************
	* 결제 성공시 웹 페이지 전환으로 호출되는 페이지로 가맹점에서 구현해야할 페이지
	* Notiurl사용 시 결제 결과 중복 처리 주의
	* 팝업 형식의 결제창 사용 시 가맹점 부모창 제어를 위한 스크립트 처리 필요
	*********************************************************************************/

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
	$Userid			= $_POST["Userid"];			// 사용자ID
	$Payeremail		= $_POST["Payeremail"];		// 결제자 이메일
	$MSTR			= $_POST["MSTR"];			// 가맹점 전달 콜백변수
	$Apprno			= $_POST["Apprno"];			// 승인번호
	$Paymethod		= $_POST["Paymethod"];		// 지불방법
	$Couponprice	= $_POST["Couponprice"];	// 결제된 쿠폰금액

  // $Deposit		= $_POST["Deposit"];		// 일회용컵보증금
  $output = $_POST['Deposit'];


/*********************************************************************************
* 아래는 결과를 단순히 출력하는 샘플입니다.
* 가맹점에서는 부모창 전환등 스크립트 처리등을 하시면 됩니다.
*********************************************************************************/
?>

<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=euc-kr" />
<title>Apsys23 KG mobilians OKURL</title>
<script type ="text/javascript">
  /* post to finish.php and close its window */
  function loadForm() {
    var output = "<?php echo $output;?>";
    var rescode = "<?php echo $Resultcd;?>";
    var resmsg = "<?php echo $Resultmsg;?>";
    output += "&rescode=" + rescode + "&";
    output += "resmsg=" + resmsg + "&";

    var form = document.createElement("form");
    document.documentElement.appendChild(form)
    form.setAttribute("charset", "UTF-8");
    form.setAttribute("name", "payForm");
    form.setAttribute("method", "post");
    form.setAttribute("action", "https://apsys23.skku.edu/kgmob_finish.php");
    
    var hiddenField = document.createElement("input");
    hiddenField.setAttribute("type", "hidden");
    hiddenField.setAttribute("name", "output");
    hiddenField.setAttribute("value", output);
    form.appendChild(hiddenField);
    
    //alert(output);
    form.submit();
	}
</script>
</head>

<body onload="javascript:loadForm();">
  <!-- input user information# -->
  <!--
	<table border ="1" width="100%">
		<tr>
			<td width="25%">CASH_GB</td>
			<td width="75%"><?php echo $CASH_GB;?></td>
		</tr>
		<tr>
			<td>Svcid</td>
			<td><?php echo $Svcid;?></td>
		</tr>
		<tr>
			<td>Mobilid</td>
			<td><?php echo $Mobilid;?></td>
		</tr>
		<tr>
			<td>Signdate</td>
			<td><?php echo $Signdate;?></td>
		</tr>
		<tr>
			<td>Tradeid</td>
			<td><?php echo $Tradeid;?></td>
		</tr>
		<tr>
			<td>Prdtnm</td>
			<td><?php echo $Prdtnm;?></td>
		</tr>
		<tr>
			<td>Prdtprice</td>
			<td><?php echo $Prdtprice;?></td>
		</tr>
		<tr>
			<td>Interest</td>
			<td><?php echo $Interest;?></td>
		</tr>
		<tr>
			<td>Userid</td>
			<td><?php echo $Userid;?></td>
		</tr>
		<tr>
			<td>Resultcd</td>
			<td><?php echo $Resultcd;?></td>
		</tr>
		<tr>
			<td>Resultmsg</td>
			<td><?php echo $Resultmsg;?></td>
		</tr>
		<tr>
			<td>Payeremail</td>
			<td><?php echo $Payeremail;?></td>
		</tr>
		<tr>
			<td>MSTR</td>
			<td><?php echo $MSTR;?></td>
		</tr>
		<tr>
			<td>Apprno</td>
			<td><?php echo $Apprno;?></td>
		</tr>
    <tr>
      <td>Paymethod</td>
      <td><?php echo $Paymethod;?></td>
    </tr>
    <tr>
      <td>Couponprice</td>
      <td><?php echo $Couponprice;?></td>
    </tr>
    <tr>
      <td>Deposit</td>
      <td><?php echo $Deposit;?></td>
    </tr>
    <tr>
      <td>Personal info(buyer)</td>
      <td><?php echo $name;?></td>
    </tr>
    <tr>
      <td>Personal info(email)</td>
      <td><?php echo $email;?></td>
    </tr>
    <tr>
      <td>Personal info(affiliation)</td>
      <td><?php echo $affiliation;?></td>
    </tr>
    <tr>
      <td>Personal info(country)</td>
      <td><?php echo $country;?></td>
    </tr>
    <tr>
      <td>Personal info(acm_type)</td>
      <td><?php echo $acm_type;?></td>
    </tr>
      <td>Personal info(acm_num)</td>
      <td><?php echo $acm_num;?></td>
    </tr>
  </table>
  -->
</body>
</html>
