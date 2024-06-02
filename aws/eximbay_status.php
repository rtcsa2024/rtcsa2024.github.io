<?php
	require("eximbay_config.php");
	
	foreach($_POST as $Key=>$value) {

		if($Key == "fgkey"){
			continue;
		}
		$hashMap[$Key]  = $value;
	}

	$rescode = $_POST['rescode']; //0000 : 정상 
	$resmsg = $_POST['resmsg']; //결제 결과 메세지
	$fgkey = $_POST['fgkey']; //검증 fgkey
	
	//rescode=0000 일때 fgkey 확인
	if ($rescode == "0000") {
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
		echo $sortingParams;
		
		$linkBuf = $secretKey. "?".$sortingParams;
		$newFgkey = hash("sha256", $linkBuf);
		
		//fgkey 검증 실패 시 에러 처리
		if(strtolower($fgkey) != $newFgkey){
			$rescode = "ERROR";
			$resmsg = "Invalid transaction";
		}
	}
	
	if ($rescode == "0000") {
		echo "[SUCCESS] rescode:0000<br/>";
		//가맹점 측 DB 처리하는 부분
		//해당 페이지는 Back-End로 처리되기 때문에 스크립트, 세션, 쿠키 사용이 불가능 합니다.
	} else {
		echo "[ERROR] rescode:$rescode<br/>";
	}
?>
