<?php
	echo $sortingParams;

	require("eximbay_config.php");
  
  $fgkey = "";
	$sortingParams = "";

	foreach($_POST as $Key=>$value) {
		$hashMap[$Key]  = $value;
	}
	$size = count($hashMap);
	ksort($hashMap);
	$counter = 0;
	foreach ($hashMap as $key => $val) {
		if ($counter == $size-1){
			$sortingParams .= $key."=" .$val;
		}else{
			$sortingParams .= $key."=" .$val."&";
		}
		++$counter;
	}
	
	$linkBuf = $secretKey. "?".$sortingParams;
  $fgkey = hash("sha256", $linkBuf);

  //echo "$sortingParams</br></br> $linkBuf</br></br> $fgkey</br></br>";
  
  $mysql_err = "";
  $result = 1;

  $connect = mysqli_connect("localhost", "root", "RTCSA2024@pay@cau", "rtcsa2024_paymentServer");
  if (!$connect) {
    $mysql_err = "ERR_BACKEND_MYSQL_CONNECTION";
  } else {
    $name = $_POST['buyer'];
    $email = $_POST['email'];
    parse_str($_POST['param3'], $output);
    $affiliation = $output['affiliation'];
    $country = $output['country'];
    $acm_type = $output['acm_type'];
    $acm_num = $output['acm_num'];
     
    $query = "INSERT IGNORE INTO eximbay_try_registrant (name, email, affiliation, country, acm_type, acm_num)
        VALUES ('$name', '$email', '$affiliation', '$country', '$acm_type', '$acm_num')";
  
    $result = mysqli_query($connect, $query);
    if ($result != 1) {
      $mysql_err = "ERR_BACKEND_MYSQL_QUERY";
    }
    mysqli_close($connect);
  }
  
?>

<!DOCTYPE html>
<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>
<body leftmargin="0" topmargin="0" align="center" onload="javascript:document.regForm.submit();">
<form name="regForm" method="post" action="<?php echo $reqURL; ?>">
<input type="hidden" name="fgkey" value="<?php echo $fgkey; ?>" />	<!-- requried -->

<?php
  foreach($_POST as $Key=>$value) {
?>
<input type="hidden" name="<?php echo $Key;?>" value="<?php echo $value;?>">
<?php } ?>
</form>
</body>
</html>
