<?php
require_once "config.php";
#проверка, есть ли пользователи базе с таким email'ом
$qmail_exist = $DBH->prepare("SELECT COUNT(id_user) FROM user WHERE email=?");
$qmail_exist->bindParam(1, $_POST['email']);
$qmail_exist->execute();
$qmail_exist->setFetchMode(PDO::FETCH_LAZY);
$row_mail = $qmail_exist->fetch();
#если совпадение имеет место быть, выводим предупреждение
if($row_mail[0] > 0) {
	$message = "<h3 style='text-align: center;'>Пользователь с таким email уже существует!</h3>";
}
#иначе регистрируем пользователя
else {
	$qreg = $DBH->prepare('INSERT INTO user(fc_favorite, country_id, login, pass, email, gender, name_user, fam_user, date_born, user_status, secretkey) VALUES(?,?,?,?,?,?,?,?,?,?,?)');
	$qreg->bindParam(1, $fc_favorite);
	$qreg->bindParam(2, $country_id);
	$qreg->bindParam(3, $login);
	$qreg->bindParam(4, $pass);
	$qreg->bindParam(5, $email);
	$qreg->bindParam(6, $gender);
	$qreg->bindParam(7, $name_user);
	$qreg->bindParam(8, $fam_user);
	$qreg->bindParam(9, $date_born);
	$qreg->bindParam(10, $user_status);
	$qreg->bindParam(11, $secret_key);
	$secret_key = uniqid();
	$fc_favorite = $_POST['loveteam'];
	$country_id = $_POST['nation'];
	$login = $_POST['login'];
	$pass = md5($_POST['passwd'].":".$secret_key);
	$email = $_POST['email'];
	$gender = $_POST['gender'];
	$name_user = $_POST['name'];
	$fam_user = $_POST['surname'];
	$date_born = $_POST['borndate'];
	$user_status = 'Обычный';
	$qreg->execute();
	echo "Регистрация произведена успешно!";
}
?>