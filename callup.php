<?php
if (session_id() == '')
	session_start();
// echo php_uname() . '<br/>';
// echo $_SERVER['HTTP_USER_AGENT'];
// $output = shell_exec('systeminfo | findstr /C:"OS"');
// print_r($output);
// die();
require_once $_SERVER['DOCUMENT_ROOT'] . "/common/functions.php";
// ↓↓　<2022/04/06> <KhanhDinh> <insert function check login>
if (!empty($_POST['next'])) {
	login("member");
}
// ↑↑　<2022/04/06> <KhanhDinh> <insert function check login>

$domain = "";
$kikcd = $_POST["kikcd"] ?? "";
$kiknm = $_POST["kiknm"] ?? "";
$userid = $_POST["userid"] ?? "";
$affiliationclss = $_POST["affiliationclss"] ?? "";
// ↓↓　<2022/04/27> <KhanhDinh> <update 【HP合同PRJ】 SKK-Members-Site_LogOutFunction_211027.pptx>
$usernm = $_POST["usernm"] ?? "";
$email = $_POST["email"] ?? "";
// ↑↑　<2022/04/27> <KhanhDinh> <update 【HP合同PRJ】 SKK-Members-Site_LogOutFunction_211027.pptx>

if (!empty($_SERVER['HTTP_REFERER'])) {
	$domain = parse_url($_SERVER['HTTP_REFERER'])['host'] ?? "";
}

//check diff domain
// if(!in_array($domain, ["portal.shoko-kai.com","192.168.3.214"])){
if (!in_array($domain, ["portal.shoko-kai.com", "192.168.3.214", "www.sorimachi.co.jp"])) {
	echo "<script>location.href='" . "/err.php" . "'</script>";
	exit();
}

//save session
$_SESSION["member"]["kikcd"]  = $kikcd;
$_SESSION["member"]["kiknm"]  = $kiknm;
$_SESSION["member"]["userid"] = $userid;
$_SESSION["member"]["affiliationclss"] = in_array($affiliationclss, ["0", "1"]) ? $affiliationclss : "";
// ↓↓　<2022/27/04> <KhanhDinh> <save usernm and email in session>
$_SESSION["member"]["usernm"] = $usernm;
$_SESSION["member"]["email"] = $email;
// ↑↑　<2022/27/04> <KhanhDinh> <save usernm and email in session>
$_SESSION["member"]["domain"] = $domain;
$_SESSION["member"]["login"]  = false;

if (
	// ↓↓　<2022/27/04> <KhanhDinh> <insert check SESSION usernm>
	!empty($_SESSION["member"]["kikcd"]) && !empty($_SESSION["member"]["kiknm"]) && !empty($_SESSION["member"]["userid"]) &&
	strlen($_SESSION["member"]["affiliationclss"]) != 0 && !empty($_SESSION["member"]["usernm"]) && !empty($_SESSION["member"]["domain"])
	// ↑↑　<2022/27/04> <KhanhDinh> <insert check SESSION usernm>
) {
	//if OK
	$_SESSION["member"]["login"] = true;
	$_SESSION["member"]["timeout"] = time() + 3600;
	writeLogRequest($kikcd, $kiknm, $userid, $affiliationclss, $_SESSION["member"]["login"]);
	echo "<script>location.href='" . "/member/" . "'</script>";
	exit();
} else {
	//if NG
	writeLogRequest($kikcd, $kiknm, $userid, $affiliationclss, $_SESSION["member"]["login"]);
	echo "<script>location.href='" . "/err.php" . "'</script>";
	exit();
}
