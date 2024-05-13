<?php
	/*********************************************************************************
	* ���� ������ �� ������ ��ȯ���� ȣ��Ǵ� �������� ���������� �����ؾ��� ������
	* Notiurl��� �� ���� ��� �ߺ� ó�� ����
	* �˾� ������ ����â ��� �� ������ �θ�â ��� ���� ��ũ��Ʈ ó�� �ʿ�
	*********************************************************************************/

	$CASH_GB		= $_POST["CASH_GB"];		// ��������(CN)
	$Resultcd		= $_POST["Resultcd"];		// ����ڵ�
	$Resultmsg		= $_POST["Resultmsg"];		// ����޼���
	$Svcid			= $_POST["Svcid"];			// ����ID
	$Mobilid		= $_POST["Mobilid"];		// ������� �ŷ���ȣ
	$Signdate		= $_POST["Signdate"];		// ��������
	$Tradeid		= $_POST["Tradeid"];		// �����ŷ���ȣ
	$Prdtnm			= $_POST["Prdtnm"];			// ��ǰ��
	$Prdtprice		= $_POST["Prdtprice"];		// ��ǰ����
	$Interest		= $_POST["Interest"];		// �Һΰ�����
	$Userid			= $_POST["Userid"];			// �����ID
	$Payeremail		= $_POST["Payeremail"];		// ������ �̸���
	$MSTR			= $_POST["MSTR"];			// ������ ���� �ݹ麯��
	$Apprno			= $_POST["Apprno"];			// ���ι�ȣ
	$Paymethod		= $_POST["Paymethod"];		// ���ҹ��
	$Couponprice	= $_POST["Couponprice"];	// ������ �����ݾ�

  // $Deposit		= $_POST["Deposit"];		// ��ȸ���ź�����
  $output = $_POST['Deposit'];


/*********************************************************************************
* �Ʒ��� ����� �ܼ��� ����ϴ� �����Դϴ�.
* ������������ �θ�â ��ȯ�� ��ũ��Ʈ ó������ �Ͻø� �˴ϴ�.
*********************************************************************************/
?>

<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=euc-kr" />
<title>RTCSA KG mobilians OKURL</title>
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
    form.setAttribute("action", "https://rtcsa2024.github.io/kgmob_finish.php");
    
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
