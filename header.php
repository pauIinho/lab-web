<?php
include("config.php");
if(isset($_POST['login']) && isset($_POST['pass']) && $_POST['login'] !== '' && $_POST['pass'] !== '') {
	if(preg_match("/^[a-zA-Z0-9]{3,30}$/", $_POST['login'])) {
		$quser_cnt = $DBH->prepare('SELECT COUNT(id_user) FROM user WHERE login=? LIMIT 1');
		$quser_cnt->bindParam(1, $_POST['login']);
		$quser_cnt->execute();
		$quser_cnt->setFetchMode(PDO::FETCH_LAZY);
		$row_user = $quser_cnt->fetch();
		if($row_user[0] == 1){
			$quser = $DBH->prepare('SELECT * FROM user WHERE login=? LIMIT 1');
			$quser->bindParam(1, $_POST['login']);
			$quser->execute();
			$quser->setFetchMode(PDO::FETCH_ASSOC);
			$row_user = $quser->fetch();
			$pass_hash = md5($_POST['pass'].":".$row_user['secretkey']);
			if($pass_hash == $row_user['pass']) {
				$secret_key = uniqid();
				$new_pass_hash = md5($_POST['pass'].":".$secret_key);
				$curr_date = date("Y-m-d H:i:s");
				$user_update = $DBH->prepare("UPDATE user SET pass='".$new_pass_hash."', secretkey ='".$secret_key."', last_login_datetime='".$curr_date."' WHERE login='".$_POST['login']."'");
				$user_update->execute();
				if($user_update) {
					setcookie("restrictedArea", $_POST['login'].":".md5($secret_key.':'.$_SERVER['REMOTE_ADDR'].':'.$curr_date), time()+60*60*24);
					header('Location: '.$_SERVER['PHP_SELF']);
					exit();
				}
				else {
					$update_error = TRUE;
				}
			}
			else {
				$error_pass = TRUE;
			}
		}
		else {
			$error_login = TRUE;
		}
	}
	$error_syntax = TRUE;
}
if(isset($_POST["logout"]))
  {
    setcookie("restrictedArea", "", time()-60*60*24); 
    header ("Location: ".$_SERVER["PHP_SELF"]);
    exit();
  }
?>
<head>
	<meta charset="utf-8">
	<meta name="Keywords" content="Трансферы, Футбольные трансферы, Трансферы футбол, Новости трансферов, Сайт о футбольных трансферах, Переходы игроков, Мировые трансферы, Трансферы Европа, Трансферы Россия, Трансферы слухи, Возможные трансферы, Таблица трансферов, Новости футбола">
	<title>Футбольные Трансферы</title>
	<link rel="icon" href="images/favicon.png">
	<style media="all">@import url(css/style.css);</style>
	<link rel="stylesheet" type="text/css" href="css/post.css">
	<link rel="stylesheet" type="text/css" href="css/signup.css">
	<link rel="stylesheet" type="text/css" href="css/transf.css">
	<link rel="stylesheet" type="text/css" href="fonts/b20sans.css">
	<link rel="stylesheet" type="text/css" href="css/modal.css">
	<script type="text/javascript" src="js/jquery-1.11.3.min.js"></script>
</head>
<body>
	<div id="modal" class="modal">
		<div>
			<div class="text">
				<h3 style="text-align: center; padding-left: 0px;">Вход на сайт</h3>
				<form method="post" action="<?php echo $_SERVER['PHP_SELF'];?>">
					<p align="center">
						<input type="text" class="css-input" name="login" id="log-in" placeholder="Введите логин..." style="width: 250px;">
					</p>
					<p align="center">
						<input type="password" class="css-input" name="pass" id="pass" placeholder="Введите пароль..." style="width: 250px;">
					</p>
					<p align="center">
						<input type="submit" class="btn" name="signin" id="signin" value="Войти">
					</p>
				</form>
			</div>
			<a href="#close" title="Закрыть"></a>
		</div>        
	</div>
	<div id="allcontent">
		<!--Header-->
		<header>
			<!--Logo-->
			<div id="logo">
				<p align="center">
					<a href="index.php"><img class="rotated" src="images/logo_final.png" alt="Футбольные Трансферы" width="90%" height="90%"></a>
				</p>
			</div>
			<!--Menu-->
			<div id="menu">
				<ul id="nav">
					<li>
						<a href="#">Новости</a>
						<ul>
							<li><a href="#">Последние</a></li>
							<li><a href="#">Новости от пользователей</a></li>
						</ul>
					</li>
					<li>
						<a href="#">Статьи</a>
						<ul>
							<li><a href="#">Свежее</a></li>
							<li><a href="#">Лучшее</a></li>
						</ul>
					</li>
					<li>
						<a href="#">Таблицы трансферов</a>
						<ul>
							<?php
							$qchamp = $DBH->prepare('SELECT id_champ, name_champ FROM champ');
							$qchamp->execute();
							$qchamp->setFetchMode(PDO::FETCH_ASSOC);
							while($row_champ = $qchamp->fetch()) {
								echo "<li><a href='transfers.php?id=".$row_champ['id_champ']."'>".$row_champ['name_champ']."</a></li>";
							}
							?>
						</ul>
					</li>
					<li>
						<a href="#">О сайте</a>
						<ul>
							<li><a href="#">Общая информация</a></li>
							<li><a href="#">Обратная связь</a></li>
						</ul>
					</li>
				</ul>
			</div>
			<!--Social Buttons-->
			<div id="social">
				<p align="center">
					<a href="#"><img src="images/icons/facebook.png" width="10%" height="10%" alt="Facebook"></a>
					<a href="#"><img src="images/icons/googleplus.png" width="10%" height="10%" alt="Google+"></a>
					<a href="#"><img src="images/icons/blogger.png" width="10%" height="10%" alt="Blogger"></a>
					<a href="#"><img src="images/icons/digg.png" width="10%" height="10%" alt="Digg"></a><br>
					<a href="#"><img src="images/icons/twitter.png" width="10%" height="10%" alt="Twitter"></a>
					<a href="#"><img src="images/icons/youtube.png" width="10%" height="10%" alt="YouTube"></a>
					<a href="#"><img src="images/icons/vimeo.png" width="10%" height="10%" alt="Vimeo"></a>
					<a href="#"><img src="images/icons/linkedin.png" width="10%" height="10%" alt="LinkedIn"></a><br>
					Присоединяйтесь к нам!</p>
				</div>
				<!--Search-->
				<div id="Search">
					<p align="center">
						<form action="#" method="post">
							<input class="css-input" type="search" name="search" id="search" value="" size="25px">
							<input class="btn" type="submit" name="search_button" value="Поиск">
						</form>
					</p>
				</div>
				<!--Auth-->
				<?php
				# если установлена кука
				if(isset($_COOKIE['restrictedArea'])) {
					$data_array = explode(":", $_COOKIE["restrictedArea"]);
					if(preg_match("/^[a-zA-Z0-9]{3,30}$/", $data_array[0])) {
						$quser_cnt = $DBH->prepare('SELECT COUNT(id_user) FROM user WHERE login=? LIMIT 1');
						$quser_cnt->bindParam(1, $data_array[0]);
						$quser_cnt->execute();
						$quser_cnt->setFetchMode(PDO::FETCH_LAZY);
						$row_user = $quser_cnt->fetch();
						if($row_user[0] == 1){
							$cookies_hash = $data_array[1];
							$quser = $DBH->prepare('SELECT * FROM user WHERE login=? LIMIT 1');
							$quser->bindParam(1, $data_array[0]);
							$quser->execute();
							$quser->setFetchMode(PDO::FETCH_ASSOC);
							$row_user = $quser->fetch();
							$evaluate_hash = md5($row_user['secretkey'].":".$_SERVER['REMOTE_ADDR'].":".$row_user['last_login_datetime']);
							if ($cookies_hash == $evaluate_hash) {
        						$access = TRUE;
      						} 
    					} 
  					} else {
						$access = FALSE;
  					}
				}
				if(isset($access) && $access==TRUE) {
					echo '<div id="auth" style="width: 220px; padding: 5px;">';
					echo '<form action="'.$_SERVER["PHP_SELF"].'" method="post"><span>Вы вошли, как '.$row_user["login"].'</span><span style="margin-left: 20px;"><input type="submit" class="btn" name="logout" id="logout" value="Выйти"></span></form>';
					echo '</div>';
				}
				else {
					echo '<div id="auth" >';
					echo "<p align='center'><a href='#modal' class='button openModal'>Авторизация</a> &nbsp;&nbsp; <a href='signup.php'>Регистрация</a></p>";
					echo '</div>';
				}
				?>
				<div id="horiz"></div>
				<script type="text/javascript">
					$(document).ready(function() {
						//поворот лого при наведении
						$('#logo img').on('mouseover', function() {
							$(this).toggleClass("rotated"); 
						});
					});
				</script>
			</header>