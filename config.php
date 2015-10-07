<?php
# Переменные подключения
$host ='localhost';
$dbname = 'transfers';
$user = 'root';
$pass = '';
 $options = array(PDO:: MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8');
try {
	# Создаем объект подлкючения к БД
	$DBH = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass, $options);
}
catch(PDOException $e) {
	echo $e->getMessage();
}
?>