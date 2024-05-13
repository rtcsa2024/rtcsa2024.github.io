<html>
<?php
  $connect = mysqli_connect("localhost", "root", "RTCSA2024@pay@cau", "rtcsa2024_paymentServer");
  if (!$connect) {
    die(mysqli_connect_errno());
  }
  
  $ret = $_POST[key($_POST)];

  $query = "SELECT * FROM eximbay_succ_registrant WHERE email='$ret'";
  $result = mysqli_query($connect, $query);
  $count = mysqli_num_rows($result);
   
  mysqli_close($connect);
  
  if ($count) {
    echo "<script>parent.document.getElementById('personal_infos_tbody').getElementsByTagName('input')[4].value = ''</script>";
    echo "<script>alert(`The email address is already registered. 
    If you want to change your previous registration,
    please contact to the web chair.`)</script>";
  }
?>
</html>
