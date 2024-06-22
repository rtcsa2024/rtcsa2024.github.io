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

  $email = $_POST['email'];

  echo "name= $email<br>";
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
