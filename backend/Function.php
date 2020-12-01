<?php
function dump($variable)
{
	echo "<pre>";
	var_dump($variable);
	echo "<pre>";
	exit();
}

function redirect($path)
{
	header("location: $path");
	exit();
}

//encrypt data so its not as visible to users
function encrypt($data){
	$encrypted = openssl_encrypt($data, "AES-256-CBC", "The goodest key", 0, "The bestest 1key");
	return $encrypted;
}
function decrypt($data){
	$decrypted = openssl_decrypt($data, "AES-256-CBC", "The goodest key", 0 , "The bestest 1key");
	return $decrypted;
}

//encrypt so that its less vulnerable
function encryptUser($userId){
	$encrypted = openssl_encrypt($userId, "AES-256-CBC", "The goodest user", 0, "The bestest user");
	return $encrypted;
}
function decryptUser($userId){
	$decrypted = openssl_decrypt($userId, "AES-256-CBC", "The goodest user", 0 , "The bestest user");
	return $decrypted;
}
