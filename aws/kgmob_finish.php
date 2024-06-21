<?php
?>

<!DOCTYPE html>
<html>
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>IEEE RTCSA 2024</title>
    <meta name="description" content="NOTICE : RTCSA 2024 description needed">

    <link rel="stylesheet" href="./main.css">
    <link rel="canonical" href="https://rtcsa2024.github.io">
    <link rel="alternate" type="application/rss+xml" title="The 30th IEEE International Conference on Embedded and Real-Time Computing Systems and Applications (RTCSA 2024)">
  </head>

  <body>
    <script src=approval.js></script>

    <header class="site-header">
      <a class="site-title" href="https://rtcsa2024.github.io/">The 30th IEEE International Conference on Embedded and Real-Time Computing Systems and Applications (RTCSA 2024)</a>
      <p style="text-align:center"><font size="4">August 21~23, 2024<br>Lotte Resort, Sokcho, South Korea</font></p>
    </header>

    <div class="page-content">
      <div class="wrapper">

  <div class="wrapper-main">

<h1 id="registration">Payment Result</h1>

<?php
  error_reporting(E_ALL);
  ini_set('display_errors', '1');

  $infos= $_POST['output'];
  parse_str($infos, $output);

  $name = $output['name'];
$email = $output['email'];
$affiliation = $output['affiliation'];
$country = $output['country'];
$ieee_type = $output['ieee_type'];
$ieee_num = $output['ieee_num'];
    $over_page_length = $output['over_page_length'];
    $extra_reception_tickets = $output['extra_reception_tickets'];
    $extra_banquet_tickets = $output['extra_banquet_tickets'];
    $job_title = $output['job_title'];
    $manuscript_title = $output['manuscript_title'];
    $author_registration = $output['author_registration'];
    $amount = $output['amount'];
  
  $rescode = $output['rescode'];
  $resmsg_euckr = $output['resmsg'];
  $resmsg = iconv("euc-kr", "utf-8", $resmsg_euckr); // kg mobilians encoding feature

  $mysql_err = "";

  $connect = mysqli_connect("localhost", "root", "RTCSA2024@pay@cau", "rtcsa2024_paymentServer");
  if (!$connect) {
    $mysql_err = "ERR_BACKEND_MYSQL_CONNECTION";
  } else {
    $query = "";
    //echo "$name $email $affiliation $country $acm_type $acm_num<br>";
    if ($rescode == "0000") {
      $query = "INSERT IGNORE INTO kgmob_succ_registrant (name, email, affiliation, country, ieee_type, ieee_num, amount, over_page_length, extra_reception_tickets, extra_banquet_tickets, job_title, manuscriptTitle, authorRegistration)
VALUES ('$name', '$email', '$affiliation', '$country', '$ieee_type', '$ieee_num', '$amount', '$over_page_length', '$extra_reception_tickets', '$extra_banquet_tickets', '$job_title', '$manuscript_title', '$author_registration')";
    } else {
      $query = "INSERT IGNORE INTO kgmob_failed_registrant (name, email, affiliation, country, ieee_type, ieee_num, amount, over_page_length, extra_reception_tickets, extra_banquet_tickets, job_title, manuscriptTitle, authorRegistration, rescode, resmsg)
VALUES ('$name', '$email', '$affiliation', '$country', '$ieee_type', '$ieee_num', '$amount', '$over_page_length', '$extra_reception_tickets', '$extra_banquet_tickets', '$job_title', '$manuscript_title', '$author_registration', '$rescode', '$resmsg')";
    }

    $result = mysqli_query($connect, $query);
    if ($result != 1) {
      $mysql_err = "ERR_BACKEND_MYSQL_QUERY";
    }
    mysqli_close($connect);
  }
  if ($rescode == "0000") {
    echo "Payment is made successfully. The receipt will be sent to your email address soon.<br>
      If you have a problem or want any change (including cancellation) with your registration, 
      please contact our Web Chair.<br>";
  } else {
    // if (strpos($resmsg, "Cancellation") !== false)
    echo "Payment failed (code: ".$resmsg."). If you are facing some problem, please contact our Web Chair.<br>";
  }
  /*
  echo "<b>Page will be redirected in 5 seconds...<b><br>";
  echo "<meta http-equiv='refresh' content='5; url=https://rtcsa2024.github.io'>";
  */
?>

<!--
name= <?php echo $name;?><br>
email= <?php echo $email;?><br>
affiliation= <?php echo $affiliation;?><br>
country= <?php echo $country;?><br>
acm_type= <?php echo $ieee_type;?><br>
acm_num= <?php echo $ieee_num;?><br>
rescode= <?php echo $rescode;?><br>
resmsg= <?php echo $resmsg;?><br>
-->

</body>
</html>
