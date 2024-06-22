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

  $connect = mysqli_connect("localhost", "root", "RTCSA2024@pay@cau", "rtcsa2024_paymentServer");

  if (!$connect) {
      die("Connection failed: " . mysqli_connect_error());
  }

  $email = $_POST['email']; // Assuming email is being posted to this script

  // Query for the kgmob_auth_registrant table
  $auth_query = "SELECT stat FROM kgmob_auth_registrant WHERE email = '$email'";
  $auth_result = mysqli_query($connect, $auth_query);

  if (mysqli_num_rows($auth_result) > 0) {
    $auth_row = mysqli_fetch_assoc($auth_result);
    $stat = $auth_row['stat'];

    // Query for the kgmob_try_registrant table
    $kgmob_result = "SELECT name, email, affiliation, country, ieee_type, ieee_num, amount, over_page_length, extra_reception_tickets, extra_banquet_tickets, job_title, manuscriptTitle, authorRegistration 
                      FROM kgmob_try_registrant 
                      WHERE email = '$email' 
                      ORDER BY id DESC LIMIT 1";
    $kgmob_result = mysqli_query($connect, $kgmob_result);

    if (mysqli_num_rows($kgmob_result) > 0) {
        $kgmob_row = mysqli_fetch_assoc($kgmob_result);

        // Building the HTML table
        // Building the HTML table
        $table = "<table border='1'>
                    <tr><th>Field</th><th>Value</th></tr>
                    <tr><td>Name</td><td>{$kgmob_row['name']}</td></tr>
                    <tr><td>Email</td><td>{$kgmob_row['email']}</td></tr>
                    <tr><td>Affiliation</td><td>{$kgmob_row['affiliation']}</td></tr>
                    <tr><td>Country</td><td>{$kgmob_row['country']}</td></tr>
                    <tr><td>IEEE Type</td><td>{$kgmob_row['ieee_type']}</td></tr>
                    <tr><td>IEEE Number</td><td>{$kgmob_row['ieee_num']}</td></tr>
                    <tr><td>Amount</td><td>{$kgmob_row['amount']}</td></tr>
                    <tr><td>Over Page Length</td><td>{$kgmob_row['over_page_length']}</td></tr>
                    <tr><td>Extra Reception Tickets</td><td>{$kgmob_row['extra_reception_tickets']}</td></tr>
                    <tr><td>Extra Banquet Tickets</td><td>{$kgmob_row['extra_banquet_tickets']}</td></tr>
                    <tr><td>Job Title</td><td>{$kgmob_row['job_title']}</td></tr>
                    <tr><td>Manuscript Title</td><td>{$kgmob_row['manuscriptTitle']}</td></tr>
                    <tr><td>Author Registration</td><td>{$kgmob_row['authorRegistration']}</td></tr>
                  </table>";

        // Check the status and set the appropriate message
        if ($stat == 'succ') {
            echo "<h2>Payment successful</h2>";
        } else {
            echo "<h2>Payment failed</h2>";
        }
        echo $table;
    } else {
        echo "No matching records found in kgmob_try_registrant table.";
    }
} else {
    echo "No matching records found in kgmob_auth_registrant table.";
}

mysqli_close($connect);
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
