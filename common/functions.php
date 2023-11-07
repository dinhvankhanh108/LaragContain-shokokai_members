<?php

use function Complex\divideby;

require_once $_SERVER['DOCUMENT_ROOT'] . "/common/database/db_Mysql.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/common/security/core/init.php";

if (session_id() == '')
	session_start();

date_default_timezone_set("Asia/Tokyo");

function redirect($link)
{
	echo "<script>location.href='" . $link . "'</script>";
}

function login($type)
{
	switch ($type) {
		case 'member':
			if (!empty($_POST["email"]) && !empty($_POST["password"])) {
				$Wk_id_c   = $_POST["email"];
				$Wk_pass_c = $_POST["password"];
				$Wk_pass_cen = EncryptData($Wk_pass_c);

				// 認証チェック
				// $sql = "select * from id_{$typePage} where ({$typePage}_id='{$Wk_id_c}' OR {$typePage}_id_old1='{$Wk_id_c}') AND passwords='{$Wk_pass_c}'";
				$sql = "SELECT * FROM skkstaff_member WHERE `member-id` = '{$Wk_id_c}' AND `member-pw` = '{$Wk_pass_cen}'";
				$conn = ConnectPartner();
				$objRS = getRow($conn, $sql);

				if ($objRS === false) {
					$classError = array('input' => 'style="margin-bottom:0px"', 'text' => 'ログインでエラーが発生しました。会員IDとパスワードを再度ご確認ください。');
					$_SESSION["member"]["classError"] = $classError;
					$_SESSION["member"]["id"] = $Wk_id_c;
					$_SESSION["member"]["login"] = false;
					$_SESSION["member"]["affiliationclss"] = '';
					// writeLogJsonTFP($Wk_id_c, $_SESSION["member"]["login"], $_SESSION["member"]["status"]);
					writeLogRequest('', '', $Wk_id_c, $_SESSION["member"]["affiliationclss"], $_SESSION["member"]["login"]);
					redirect("/");
					exit();
				} else {
					// ↓↓　<2022/04/06> <KhanhDinh> <insert session, write log and redirect when login false>
					$_SESSION["member"]["id"] = $Wk_id_c;
					// $_SESSION["member"]["name"] = $objRS["member-id"];
					// $_SESSION["member"]["pass"] = $objRS["member-pw"];
					$_SESSION["member"]["affiliationclss"] = $objRS["member-status"];
					$_SESSION["member"]["kiknm"] = $objRS["member-comment"];
					$_SESSION["member"]["kikcd"] = "no-data";
					$_SESSION["member"]["domain"] = "shoukoukai-sorimachi.jp";
					// $_SESSION["user-ﬂag"] = $typePage;
					$_SESSION["member"]["timeout"] = time() + 3600;
					$_SESSION["member"]["login"] = true;

					//write log
					// writeLogJsonTFP($Wk_id_c, $_SESSION["member"]["login"], $_SESSION["member"]["status"]);
					writeLogRequest($_SESSION["member"]["kikcd"], $_SESSION["member"]["kiknm"], $Wk_id_c, $_SESSION["member"]["affiliationclss"], $_SESSION["member"]["login"]);
					redirect("/member/");
					exit();
					// ↑↑　<2022/04/06> <KhanhDinh> <insert session, write log and redirect when login false>
				}
			}
			break;
		case 'admin':
			if (!empty($_POST["email"]) && !empty($_POST["password"])) {
				// redirect("/admin/content.php");
				$Wk_id_c   = $_POST["email"];
				$Wk_pass_c = $_POST["password"];
				$Wk_pass_cen = EncryptData($Wk_pass_c);

				// // 認証チェック
				// $sql = "select * from id_{$typePage} where ({$typePage}_id='{$Wk_id_c}' OR {$typePage}_id_old1='{$Wk_id_c}') AND passwords='{$Wk_pass_c}'";
				// $sql = "SELECT * FROM skkstaff_member WHERE `member-id` = '{$Wk_id_c}' AND `member-pw` = '{$Wk_pass_cen}'";

				$sql = "SELECT * FROM skkstaff_admin WHERE `admin-id` = '{$Wk_id_c}' AND `admin-pw` = '{$Wk_pass_cen}'";
				// $sql = "SELECT * FROM skkstaff_admin WHERE `admin-id` = 'admin1' AND `admin-pw` = '5oNjgzBDI3IP5Q3qaHl42w=='";
				$conn = ConnectPartner();
				$row = getRow($conn, $sql);

				if ($row === false) {
					$classError = array('input' => 'style="margin-bottom:0px"', 'text' => 'ログインでエラーが発生しました。会員IDとパスワードを再度ご確認ください。');
					$_SESSION["admin"]["classError"] = $classError;
					$_SESSION["admin"]["ID"] = $Wk_id_c;
					$_SESSION["admin"]["login"] = false;
					$_SESSION["member"]["status"] = '';
					// ↓↓　<2022/04/06> <KhanhDinh> <insert redirect when login false >
					redirect("/admin/login.php");
					// ↑↑　<2022/04/06> <KhanhDinh> <insert redirect when login false >
					exit();
				} else {
					$_SESSION["admin"]["id"] = $row["ID"];
					$_SESSION["admin"]["name"] = $row["admin-id"];
					$_SESSION["admin"]["pass"] = $row["admin-pw"];
					$_SESSION["admin"]["comment"] = $row["admin-comment"];
					// $_SESSION["user-ﬂag"] = $typePage;
					$_SESSION["admin"]["login"] = true;
					$_SESSION["admin"]["timeout"] = time() + 3600;
					//write log
					redirect("/admin/content.php");
					exit();
				}
			}
			break;
		default:
			# code...
			break;
	}
}

function checkLogin($type)
{
	if (@$_SESSION[$type]["login"] !== true)
		return false;
	if (time() - @$_SESSION[$type]["timeout"] >= 0)
		return false;
	return true;
}

function saveData($pData)
{
	if (session_id() == "") {
		session_start();
	}

	foreach ($pData as $key => $value) {
		$_SESSION[$key] = $value;
	}
	// $_SESSION['b'] = "b";

}

/**
 * Function to get the client IP address
        @return string
 **/
function getClientIP()
{
	$ipaddress = '';
	if (isset($_SERVER['HTTP_CLIENT_IP']))
		$ipaddress = $_SERVER['HTTP_CLIENT_IP'];
	else if (isset($_SERVER['HTTP_X_FORWARDED_FOR']))
		$ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
	else if (isset($_SERVER['HTTP_X_FORWARDED']))
		$ipaddress = $_SERVER['HTTP_X_FORWARDED'];
	else if (isset($_SERVER['HTTP_FORWARDED_FOR']))
		$ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
	else if (isset($_SERVER['HTTP_FORWARDED']))
		$ipaddress = $_SERVER['HTTP_FORWARDED'];
	else if (isset($_SERVER['REMOTE_ADDR']))
		$ipaddress = $_SERVER['REMOTE_ADDR'];
	else
		$ipaddress = 'UNKNOWN';
	return $ipaddress;
}
/**
 * write log login member
 */
function writeLogJsonTFP($ID, $login, $status)
{
	if ($login ===  true)
		$login = "OK";
	else
		$login = "NG";

	$content = [
		"date"  => date("Y/m/d\,"),
		"time"  => date("H:i:s\,"),
		"ip"    => getClientIP() . ",",
		"ID"	=> $ID . ",",
		"login" => $login . ",",
		"status" => $status . PHP_EOL
	];

	// Save file
	$save = file_put_contents(
		__DIR__ . '/../logs/' . date('\l\o\g\i\n\m\e\m\b\e\r\-Y-m\.\t\x\t'),
		$content,
		FILE_APPEND | LOCK_EX
	);

	return $save === false ? false : true;
}

function writeLogRequest($kikcd = '', $kiknm = '', $userid = '', $affiliationclss = '', $login = '')
{
	if ($login ===  true)
		$login = "OK";
	else
		$login = "NG";

	$content = [
		"date"  => date("Y/m/d\,"),
		"time"  => date("H:i:s\,"),
		"ip"    => getClientIP() . ",",
		"kikcd"	=> $kikcd . ",",
		"kiknm"	=> $kiknm . ",",
		"userid"	=> $userid . ",",
		"affiliationclss" => $affiliationclss . ",",
		"login" => $login . PHP_EOL
	];

	// Save file
	$save = file_put_contents(
		__DIR__ . '/../logs/' . date('\l\o\g\i\n\m\e\m\b\e\r\-Y-m\.\t\x\t'),
		$content,
		FILE_APPEND | LOCK_EX
	);

	return $save === false ? false : true;
}
