<?php
require 'config.php';
require 'function.php';
if (isset ( $_POST ["check"] )) {
	if ($_POST ["check"] = 'true') {
		echo 'Checking...'.time();
		exit();
	}
}
if (! isAuth ()) {
	require_once './lib/phpqrcode.php';
	$authkey = getRandChar ( 16 );
	$qrencoded = authcode ( $qrdomain . '@' . $authkey, '', $encode_key, $qrtime );
	QRcode::png ( $qrencoded, "qrcode.png", 'L', 4, 3 );
} else {
	echo '<p>' . authcode ( $_POST ["akey"], 'DECODE', $encode_key ) . '</p>';
	exit();
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
<script src="http://code.jquery.com/jquery-2.1.4.min.js"></script>
<script type="text/javascript" charset="UTF-8">
	$(document).ready(function(){  
		setInterval(function(){
			$.post("<?php echo $_SERVER['PHP_SELF']; ?>","check=true",function(result){
				var a=document.getElementById ("status");
		        a.innerHTML = result;
			});
		}, 5000);  
	});  
</script>
</head>
<body>
<?php
	echo '<img src="qrcode.png">';
	echo "<p>$qrencoded</p>";
?>
<span id="status">Waiting...</span>
</body>
</html>