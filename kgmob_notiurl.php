<?
	/****************************************************************************************
	* ���� ������ �ý��� ������� ȣ��Ǵ� �������� ����ó��(��������) �뵵
	* ����ó��(��������) ���� �� 'SUCCESS' ���� �� 'FAIL' ���
	* Okurl�� ���� ��� �ߺ� ó�� ����
	****************************************************************************************/

	include "inc/seed.php";		// ������ ��δ� ������ ������ ��ġ�� seed������ �����η� ���� �ʼ�

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
	$Payeremail		= $_POST["Payeremail"];		// �������̸���
	$Userid			= $_POST["Userid"];			// �����ID
	$Username		= $_POST["Username"];		// �����ڸ�
	$MSTR			= $_POST["MSTR"];			// ������ ���� �ݹ麯��
	$Cardnum		= $_POST["Cardnum"];		// ���� ī���ȣ
	$Cardcode		= $_POST["Cardcode"];		// ���� ī���ڵ�
	$Cardname		= $_POST["Cardname"];		// ���� ī����
	$Apprno			= $_POST["Apprno"];			// ���ι�ȣ
	$Paymethod		= $_POST["Paymethod"];		// ���ҹ��
	$Couponprice	= $_POST["Couponprice"];	// ������ �����ݾ�
	$chkValue		= $_POST["chkValue"];		// ����� ���� hash������
	$Deposit		= $_POST["Deposit"];		// ��ȸ���ź�����

	/*****************************************************************
	�Լ��� : cipher ��ȣȭ ����
	���� : cipher ("��ȣȭ�ҵ�����", "�������ŷ���ȣ")
	���ǻ��� : �����������
	*****************************************************************/
	function cipher($seedStr, $seedKey) {
		return encodeString($seedStr, getKey($seedKey));
	}

	function getKey($value) {
		$padding = "123456789123456789";
		$tmpKey = $value;
		$keyLength = strlen($value);
		if($keyLength < 16) $tmpKey = $tmpKey.substr($padding, 0, 16-$keyLength);
		else $tmpKey = substr($tmpKey, strlen($tmpKey)-16,  strlen($tmpKey));
		for($i = 0; $i < 16; $i++) {
			$result = $result.chr(ord(substr($tmpKey, $i, 1))^($i+1));
		}
		return $result;
	}

	/*
	 * ���� ������ �������� ���� Ȯ�� �뵵
	 * �ֿ� ���� ������ HASH ó���� chkValue ���� �޾�
	 * ������ ��Ģ���� Notiurl���� ������ ��(output)�� ���մϴ�.
	 */

	$returnMsg = "";
	$cpChkValue = "Mobilid=".$Mobilid."&Mrchid=null&Svcid=".$Svcid."&Tradeid=".$Tradeid."&Signdate=".$Signdate."&Prdtprice=".$Prdtprice;

	$encChkValue = cipher($cpChkValue, $Tradeid);

	// �� ��
	if ($encChkValue == $chkValue) {
		// ���� �� ����ó��(��������)
		$returnMsg = "SUCCESS";
	} else {
		// ��ġ���� ���� ��� ������ �������� ���ɼ� ������ FAIL ó��
		$returnMsg = "FAIL";
	}

?>

<? echo $returnMsg; ?>
