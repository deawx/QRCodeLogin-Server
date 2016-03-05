<?php
// A demo to get ukey by username and password.
// Just for testing purpose, pls don't use these code in your site!
if (! isset ( $_GET ["user"] ) | ! isset ( $_POST ["passwd"] )) {
	die ( json_encode ( array (
			'error' => 'Invalid params' 
	) ) );
}
require 'config.php';
require 'function.php';
$user_info = array (
		'user' => $_GET ["user"],
		'ukey' => authcode ( $_GET ["user"] . ',' . md5 ( $_POST ["passwd"] ), '', $user_key ) 
);
echo json_encode ( $user_info );
function getUserInfo($ukey) {
	return explode ( ',', authcode ( $ukey, 'DECODE', $user_key ) );
}