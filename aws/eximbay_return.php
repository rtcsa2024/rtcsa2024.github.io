<?php
	require("eximbay_config.php");
	
	foreach($_POST as $Key=>$value) {

		if($Key == "fgkey"){
			continue;
		}
		$hashMap[$Key]  = $value;
	}

	$rescode = $_POST['rescode'];//0000 : ���� 
	$resmsg = $_POST['resmsg'];//���� ��� �޼���
	$fgkey = $_POST['fgkey'];//���� fgkey

	//rescode=0000 �϶� fgkey Ȯ��
	if($rescode == "0000"){
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
		// echo $sortingParams;
		
		$linkBuf = $secretKey. "?".$sortingParams;
		$newFgkey = hash("sha256", $linkBuf);
		
		//fgkey ���� ���� �� ���� ó��
		if(strtolower($fgkey) != $newFgkey){
			$rescode = "ERROR";
			$resmsg = "Invalid transaction";
		}
  } else {
    echo "[ERROR]: $rescode, $resmsg, Refresh and try it again<br>";
  }
?>

<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<script type ="text/javascript">
	
	function loadForm(){
    if(opener && opener.document.regForm){
			var frm = opener.document.regForm;
			frm.rescode.value = "<?php echo $rescode; ?>";
			frm.resmsg.value = "<?php echo $resmsg; ?>";			
			frm.target = "";
			frm.action = "eximbay_finish.php";
			frm.submit();
		}
		self.close();
	}
</script>
</head>
<body onload="javascript:loadForm();">
<?php
  //��ü �Ķ���� ���
  /*
	echo "--------all return parameter-------------<br/>";
	foreach($_POST as $Key=>$value) {
		echo $Key." : ".$value."<br/>" ; 
	}
  echo "----------------------------------------<br/>";
  */
?>
</body>
</html>
