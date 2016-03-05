<?php
require 'config.php';
require 'function.php';
if (!isAuth ()) {
	require_once './lib/phpqrcode.php';
	require_once './lib/xajax_core/xajax.inc.php';
	$authkey = getRandChar ( 16 );
	$qrencoded = authcode ( $qrdomain . '@' . $authkey, '', $encode_key, $qrtime );
	QRcode::png ( $qrencoded, "qrcode.png", 'L', 4, 3 );
	$xajax = new xajax();
	$xajax->configure('javascript URI', './lib/');
	$xajax->register(XAJAX_FUNCTION, "haslogin");
	function haslogin() {
		$obj = new xajaxResponse();
		$obj->assign("status", "innerHTML", "Posting...time()");
		return $obj;
	}
}
function isAuth() {
	// return isset ( $_GET ["akey"] ) & isset ( $_GET ["ukey"] ) & isset ( $_GET ["code"] );
	return isset ( $_POST ["akey"] );
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Login</title>
<?php
if (!isAuth ()) {
	$xajax->printJavascript();
	echo '<script type="text/javascript" charset="UTF-8">window.setInterval(xajax_haslogin(), 5000);</script>';
}
?>
</head>
<body>
<?php
if (isAuth ()) {
	echo '<p>'.authcode ( $_POST ["akey"], 'DECODE', $encode_key ).'</p>';
} else {
	echo '<img src="qrcode.png">';
	echo "<p>$qrencoded</p>";
}
?>
<span id="status">Waiting...</span>
</body>
</html>