<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">

		<title>APSys 2023</title>
		<meta name="description" content="APSys 2023 is a lively forum for systems researchers and practitioners across the world to meet, interact, and collaborate with their peers from the Asia/Pacific region.">

		<link rel="stylesheet" href="./main.css">
		<link rel="canonical" href="https://rtcsa2024.github.io/">
		<link rel="alternate" type="application/rss+xml" title="14th ACM SIGOPS Asia-Pacific Workshop on Systems (APSys 2023)">
	</head>

	<body>
    <script src=approval.js></script>
		
    <header class="site-header">

			<a class="site-title" href="https://rtcsa2024.github.io/">14th ACM SIGOPS Asia-Pacific Workshop on Systems (APSys 2023)</a>
			<p style="text-align:center"><font size="4">August 24-25, 2023<br>Seoul, South Korea</font></p>

			<nav class="site-nav">
				<div class="trigger">
					<!--a class="page-link" href="./program.html">Program</a-->
					<a class="page-link" href="./call_for_papers.html">Call For Papers</a>
					<a class="page-link" href="./organization.html">Organization</a>
					<a class="page-link" href="./registration.html">Registration</a>
					<a class="page-link" href="./venues.html">Venue & Visa</a>
					<!--a class="page-link" href="./grants.html">Grants</a-->
					<!--a class="page-link" href="./instructions.html">Instructions for Authors</a-->

					<!--<a class="page-link" href="./keynote.html">Keynote</a> -->

				</div>
			</nav>
			<!--  <div id="banner"></div> -->
		</header>

<!---
Date: 16 July 2018
Author: Changho Hwang
Purpose: To build a website for APSys 2018
Copy From: APSys 2016 website
--->

    <div class="page-content">
      <div class="wrapper">

  <div class="wrapper-main">

<h1 id="registration">Payment Result</h1>

<?php
  //error_reporting(E_ALL);
  //ini_set('display_errors', '1');

  $result = 0;
  $rescode = $_POST['rescode'];
  $resmsg = $_POST['resmsg'];
  $mysql_err = "";
  $skip_query = 0;

  $connect = mysqli_connect("localhost", "root", "RTCSA2024@pay@cau", "rtcsa2024_paymentServer");
  if (!$connect) {
    $result  = 0;
    $mysql_err = "ERR_BACKEND_MYSQL_CONNECTION";
  } else {
    $name = $_POST['name'];
    $email = $_POST['email'];
    parse_str($_POST['param3'], $output);
    $affiliation = $output['affiliation'];
    $country = $output['country'];
    $ieee_type = $output['ieee_type'];
    $ieee_num = $output['ieee_num'];
    $over_page_length = $_POST['overPageLength'];
    $extra_reception_tickets = $_POST['extraReceptionTickets'];
    $extra_banquet_tickets = $_POST['extraBanquetTickets'];
    $job_title = $_POST['jobTitle'];
    $manuscript_title = $_POST['manuscriptTitle'];
    $author_registration = $_POST['authorRegistration'];
    $amount = $_POST['amount'];
    
    $query = "";
    //echo "$name $email $affiliation $country $acm_type $acm_num<br>";
    if ($rescode == "0000") {

$query = "INSERT IGNORE INTO eximbay_succ_registrant (name, email, affiliation, country, ieee_type, ieee_num, amount, over_page_length, extra_reception_tickets, extra_banquet_tickets, job_title, manuscriptTitle, authorRegistration)
VALUES ('$name', '$email', '$affiliation', '$country', '$ieee_type', '$ieee_num', '$amount', '$over_page_length', '$extra_reception_tickets', '$extra_banquet_tickets', '$job_title', '$manuscript_title', '$author_registration')";
    } else {
      if (strpos($resmsg, "Cancellation") !== false) {
        // cancelled transaction
        $skip_query = 1;
      } else {
        $query = "INSERT IGNORE INTO eximbay_succ_registrant (name, email, affiliation, country, ieee_type, ieee_num, amount, over_page_length, extra_reception_tickets, extra_banquet_tickets, job_title, manuscriptTitle, authorRegistration, rescode, resmsg)
VALUES ('$name', '$email', '$affiliation', '$country', '$ieee_type', '$ieee_num', '$amount', '$over_page_length', '$extra_reception_tickets', '$extra_banquet_tickets', '$job_title', '$manuscript_title', '$author_registration', '$rescode', '$resmsg')";
      }
    }
    
    if ($skip_query == 0) {
      $result = mysqli_query($connect, $query);
      if ($result != 1) {
        $mysql_err = "ERR_BACKEND_MYSQL_QUERY";
      }
    }
    mysqli_close($connect);
  }

  // echo "********* rescode=$rescode, resmsg=$resmsg *******<br>";
  if ($rescode == "0000") {
    echo "Payment is made successfully. The receipt will be sent to your email address soon.<br>
      If you have a problem or want any change (including cancellation) with your registration, 
      please contact our Web Chair.<br>";
  } else {
    if (strpos($resmsg, "Cancellation") !== false) {
      echo "$resmsg<br>";
    } else {
      echo "Payment failed (code: ".$resmsg."). If you are facing some problem, please contact our Web Chair.<br>";
    }
  }
  echo "<b>Page will be redirected in 5 seconds...<b><br>";
  echo "<meta http-equiv='refresh' content='5; url=https://rtcsa2024.github.io/'>";
?>
</body></html>
