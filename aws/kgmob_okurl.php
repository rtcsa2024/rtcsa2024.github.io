<?php
	/*********************************************************************************
	* ���� ������ �� ������ ��ȯ���� ȣ��Ǵ� �������� ���������� �����ؾ��� ������
	* Notiurl��� �� ���� ��� �ߺ� ó�� ����
	* �˾� ������ ����â ��� �� ������ �θ�â ��� ���� ��ũ��Ʈ ó�� �ʿ�
	*********************************************************************************/

	//header("Access-Control-Allow-Origin: http://127.0.0.1:5500"); // Allows requests from your local server
	//header("Access-Control-Allow-Origin: https://rtcsa2024.github.io/"); // Allows requests from your local server
	//header("Content-Type: application/json"); // Assuming you're serving JSON

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
	$name = $_POST["name"];
	$email = $_POST['email'];
	$affiliation = $_POST['affiliation'];
	$country = $_POST['country'];
	$ieee_type = $_POST['ieee_type'];
	$ieee_num = $_POST['ieee_num'];
   $over_page_length = $_POST['over_page_length'];
   $extra_reception_tickets = $_POST['extra_reception_tickets'];
   $extra_banquet_tickets = $_POST['extra_banquet_tickets'];
   $job_title = $_POST['job_title'];
   $manuscript_title = $_POST['manuscript_title'];
   $author_registration = $_POST['author_registration'];
   $amount = $_POST['amount'];

	$connect = mysqli_connect("localhost", "root", "RTCSA2024@pay@cau", "rtcsa2024_paymentServer");
  if (!$connect) {
    $mysql_err = "ERR_BACKEND_MYSQL_CONNECTION";
  } else {
    $query = "";
    //echo "$name $email $affiliation $country $acm_type $acm_num<br>";
    if ($Resultcd == "0000") {
      $query = "INSERT IGNORE INTO kgmob_succ_registrant (name, email, affiliation, country, ieee_type, ieee_num, amount, over_page_length, extra_reception_tickets, extra_banquet_tickets, job_title, manuscriptTitle, authorRegistration)
VALUES ('$name', '$Payeremail', '$affiliation', '$country', '$ieee_type', '$ieee_num', '$Prdtprice', '$over_page_length', '$extra_reception_tickets', '$extra_banquet_tickets', '$job_title', '$manuscript_title', '$author_registration')";
    } else {
      $query = "INSERT IGNORE INTO kgmob_failed_registrant (name, email, affiliation, country, ieee_type, ieee_num, amount, over_page_length, extra_reception_tickets, extra_banquet_tickets, job_title, manuscriptTitle, authorRegistration, rescode, resmsg)
VALUES ('$name', '$Payeremail', '$affiliation', '$country', '$ieee_type', '$ieee_num', '$Prdtprice', '$over_page_length', '$extra_reception_tickets', '$extra_banquet_tickets', '$job_title', '$manuscript_title', '$author_registration', '$Resultcd', '$Resultmsg')";
    }

    $result = mysqli_query($connect, $query);
    if ($result != 1) {
      $mysql_err = "ERR_BACKEND_MYSQL_QUERY";
    }
    mysqli_close($connect);
  }

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
	 var name = "<?php echo $name;?>";
	 var email = "<?php echo $email;?>";
	 var affiliation = "<?php echo $affiliation;?>";
	 var country = "<?php echo $country;?>";
	 var ieee_type = "<?php echo $ieee_type;?>";
	 var ieee_num = "<?php echo $ieee_num;?>";
	 var over_page_length = "<?php echo $over_page_length;?>";
	 var extra_reception_tickets = "<?php echo $extra_reception_tickets;?>";
	 var extra_banquet_tickets = "<?php echo $extra_banquet_tickets;?>";
	 var job_title = "<?php echo $job_title;?>";
	 var manuscript_title = "<?php echo $manuscript_title;?>";
	 var author_registration = "<?php echo $author_registration;?>";
	 var amount = "<?php echo $amount;?>";

    output += "&rescode=" + rescode + "&";
    output += "resmsg=" + resmsg + "&";
	 output += "name=" + name + "&";
	 output += "email=" + email + "&";
	 output += "affiliation=" + affiliation + "&";
	 output += "country=" + country + "&";
	 output += "ieee_type=" + ieee_type + "&";
	 output += "ieee_num=" + ieee_num + "&";
	 output += "over_page_length=" + over_page_length + "&";
	 output += "extra_reception_tickets=" + extra_reception_tickets + "&";
	 output += "extra_banquet_tickets=" + extra_banquet_tickets + "&";
	 output += "job_title=" + job_title + "&";
	 output += "manuscript_title=" + manuscript_title + "&";
	 output += "author_registration=" + author_registration + "&";
	 output += "amount=" + amount + "&";

    var form = document.createElement("form");
    document.documentElement.appendChild(form)
    form.setAttribute("charset", "UTF-8");
    form.setAttribute("name", "payForm");
    form.setAttribute("method", "post");
    form.setAttribute("action", "https://rtcsa2024.store/kgmob_finish.php");
    
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
      <td><?php echo $ieee_type;?></td>
    </tr>
      <td>Personal info(acm_num)</td>
      <td><?php echo $ieee_num;?></td>
    </tr>
	 </tr>
      <td>Personal info(acm_num)</td>
      <td><?php echo $over_page_length;?></td>
    </tr>
	 </tr>
      <td>Personal info(acm_num)</td>
      <td><?php echo $extra_reception_tickets;?></td>
    </tr>
	 </tr>
      <td>Personal info(acm_num)</td>
      <td><?php echo $extra_banquet_tickets;?></td>
    </tr>
	 </tr>
      <td>Personal info(acm_num)</td>
      <td><?php echo $job_title;?></td>
    </tr>
	 </tr>
      <td>Personal info(acm_num)</td>
      <td><?php echo $manuscript_title;?></td>
    </tr>
	 </tr>
      <td>Personal info(acm_num)</td>
      <td><?php echo $author_registration;?></td>
    </tr>
	 </tr>
      <td>Personal info(acm_num)</td>
      <td><?php echo $amount;?></td>
    </tr>
  </table>
  -->
</body>
</html>