<!doctype html>
<html>
	<?php
		error_reporting(E_ALL & ~E_NOTICE);
		include("header.php");
	?>
	<!--Main Block-->
		<!--Left Sidebar-->
		<?php
			include("sidebar.php");
		?>
		<!--Main Content-->
		<?php
		if(isset($_POST['submitreg'])) {
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
				if($_POST['passwd'] !== $_POST['confirmpwd']) {
					$message = "<h3 style='text-align: center;'>Пароли не совпадают!</h3>";
				}
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
				}
			}
		}
		?>
		<div id="content">
			<?php echo $message; ?>				
				<h2>Регистрация на сайте</h2>
				<div id="mandatory">
					<h4>Обязательные данные</h4>
					<ul class="main">
						<li class="field">
							<label for="login">Логин:</label>
							<input class="css-input" type="text" id="login" name="login" placeholder="prostoUser">
						</li>
						<li class="field">
							<label for="email">E-mail:</label>
							<input class="css-input" type="email" id="email" name="email" placeholder="gavgav@domain.ru">
						</li>
						<li class="field">
							<label for="gender">Пол:</label>
							<select name="gender" id="gender">
	          					<option value="Мужской">Мужской</option>
	          					<option value="Женский">Женский</option>
	          				</select>
						</li>
						<li class="field">
							<label for="passwd">Пароль:</label>
							<input class="css-input" type="password" id="passwd" name="passwd">
						</li>
						<li class="field">
							<label for="confirmpwd">Подтвердите пароль:</label>
							<input class="css-input" type="password" id="confirmpwd" name="confirmpwd">
						</li>
					</ul>
				</div>
				<div id="additional">
					<h4>Дополнительная информация</h4>
					<ul class="main">
						<li class="field">
							<label for="name">Имя:</label>
							<input class="css-input" type="text" id="name" name="name" placeholder="Андрей">
						</li>
						<li class="field">
							<label for="surname">Фамилия:</label>
							<input class="css-input" type="text" id="surname" name="surname" placeholder="Андреев">
						</li>
						<li class="field">
							<label for="nation">Гражданство:</label>
							<select name="nation" id="nation">
	          					<?php
              						$qlist_country = $DBH->prepare('SELECT id_country, name_country FROM country');
              						$qlist_country->execute();
              						$qlist_country->setFetchMode(PDO::FETCH_ASSOC);
              						while($row_list = $qlist_country->fetch()) {
              							echo "<option value=".$row_list['id_country'].">".$row_list['name_country']."</option>";
              						}
              					?>
	          				</select>
						</li>
						<li class="field">
							<label for="borndate">Дата рождения:</label>
							<input class="css-input" type="date" min="1900-01-01" id="borndate" name="borndate" placeholder="1970-01-01">
						</li>
						<li class="field">
							<label for="loveteam">Любимая команда:</label>
							<input class="css-input" type="text" id="loveteam" name="loveteam" placeholder="Реал Мадрид">
						</li>
					</ul>
				</div>
				<div id="horizontal"></div>
				<hr>
				<div id="rules">
					<a id="show-rules" style="cursor:pointer;"><h3><span style="border-bottom: 1px dotted black;">Ознакомиться с правилами пользования ресурсом</span></h3></a>
					<p>
						Уважаемые пользователи Футбольных Трансферов!
					</p>
					<p>
						Призываем Вас к уважению мнения друг друга. Будьте, пожалуйста вежливы к собеседнику. Ниже приведен свод правил сайта, незнание которых не освобождает от ответственности.
					</p>
					<p>
						ПРАВИЛА ПОВЕДЕНИЯ
					</p>
					<p>
						Администрация сайта имеет право изменять вид наказания без всяких уведомлений. В случае вынесения нарушения пользователю запрещено вступать в открытый конфликт с администрацией. Для этого стоит воспользоваться разделом "Контакты" на сайте.
					</p>
					<p>
						ЗАПРЕЩЕНО
					</p>
					<p>
						На сайте запрещены следующие моменты, за которые администрация вправе наказать пользователя:
						- Использование искаженных названий команд и игроков (например, Челски, анониры);
						- Оскорбление прямое или косвенного другого пользователя сайта;
						- Ненормативная лексика в комментариях;
						- Спам в любом его проявлении, реклама сторонних ресурсов;
						- Вступать в спор с администрацией, оспаривать предупреждения и баны;
						- Добавление не содержащих смысла комментариев. Состоящих из междометий, восклицательных фраз;
						- Оффтоп. Сообщения, отвлеченные от темы новости, наказуемы;
						- Использование CAPS LOCK;
						- Написание комментариев транслитом или на любом другом языке, отличном от русского;
						- Создание дополнительных аккаунтов (например, если вас забанили). Один пользователь - один аккаунт на сайте; При создании нескольких возможно наказание вплоть до вечного бана по IP;
						- Требование изменения логина чаще, чем раз в месяц.
					</p>
				</div>
				<hr>
				<label for="checkrules">С правилами ознкомился(-ась)</label>
				<input type="checkbox" id="checkrules" name="checkrules" required>
				<input class="btn" type="submit" id="submitreg" name="submitreg" value="Зарегистрироваться" onclick="return reg();">
	</div>
	<?php
		include("footer.php");
	?>
	</div>
	<!--Скрипт проверки данных формы-->
	<script>
		function reg() {
			var flag = true;
			//проверка на заполненность обязательных полей
			var login = document.getElementById("login").value;
			var email = document.getElementById("email").value;
			var pass = document.getElementById("passwd").value;
			var confirmPass = document.getElementById("confirmpwd").value;
			//запрещенные символы
			var string = "1234567890!@#$%^&*\(\)\"№;%:?*\'";
			if(login.length == 0) {
				alert("Поле 'Логин' не заполнено");
				flag = false;
				return false;
			}
			if(email.length == 0) {
				alert("Поле 'E-mail' не заполнено");
				flag = false;
				return false;
			}
			if(pass != confirmPass) {
				alert("Пароли не совпадают!");
				flag = false;
				return false;
			}
			//проверка логина на запрещенные символы
			var tmp;
			for(i = 0; i < string.length; i++) {
				tmp = login.indexOf(string[i]);
				if(tmp != -1) {
					alert("Логин должен состоять только из букв");
					flag = false;
					return false;
				}
			}
			//проверка пароля по регулярному выражению
			var pass = document.getElementById("passwd").value;
			if(/^[A-Za-z0-9]{6,15}$/.test(pass) == false) {
				alert("Пароль должен содержать только буквы и цифры, длина не менее 6 и не более 15 символов");
				return false;
			}
			if(flag) {
				var xhr = new XMLHttpRequest();
				if(xhr) {
					try {
						//берем данные с полей
						var login = document.getElementById("login").value;
						var email = document.getElementById("email").value;
						var gender = document.getElementById("gender").value;
						var pass = document.getElementById("passwd").value;
						var name = document.getElementById("name").value;
						var surname = document.getElementById("surname").value;
						var nation = document.getElementById("nation").value;
						var borndate = document.getElementById("borndate").value;
						var loveteam = document.getElementById("loveteam").value;
						var sendPost = "login=" + login + "&email=" + email + "&gender=" + gender + "&passwd=" + pass + "&name=" + name + "&surname=" + surname + "&nation=" + nation + "&borndate=" + borndate + "&loveteam=" + loveteam;
						xhr.open("POST", "ajax.php", true);
						xhr.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
						xhr.send(sendPost);
						//ждем ответ от сервера
						xhr.onreadystatechange = function() {
							if(xhr.readyState == 4) //ответ пришел
							{
								if(xhr.status == 200) //сервер вернул код 200
								{
									alert(xhr.responseText);
								}
							}
						}
					}
					catch (e) {
						alert("Не удалось соединиться с сервером: \n" + e.toString());
					}
				}
			}
		}
		//Jquery визуальные эффекты
		$(document).ready(function() {
			$('#rules p').hide();
			var flag = 1;
			$('#show-rules').click(function() {
				$('#rules p').hide().slideDown(1000);
				if(flag == 1) {
					$('#rules a h3').remove();
					$('#rules a').append('<h3><span style="border-bottom: 1px dotted black;">Скрыть правила пользования ресурсом</span></h3>');
					flag = 2;
				}
				else {
					$('#rules a h3').remove();
					$('#rules p').hide();
					$('#rules a').append('<h3><span style="border-bottom: 1px dotted black;">Ознакомиться с правилами пользования ресурсом</span></h3>');
					flag = 1;
				}
			});
		});
	</script>
</body>
</html>