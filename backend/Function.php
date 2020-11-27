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