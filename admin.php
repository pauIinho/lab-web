<!doctype html>
<html>
	<?php
		error_reporting(E_ALL & ~E_NOTICE);
		include("header.php");
	?>
		<!--Main Content-->
		**
	<?php
		include("footer.php");
	?>
	</div>
	<script>
		//ajax функция добавления трансфера
		function add() {
			var xhr = new XMLHttpRequest();
			if(xhr) {
				try {
					//берем данные с полей
					var playerName = document.getElementById("playerName").value;
					var pos = document.getElementById("pos").value;
					var oldFC = document.getElementById("oldFC").value;
					var newFC = document.getElementById("newFC").value;
					var status = document.getElementById("status").value;
					var cost = document.getElementById("cost").value;
					var sendPost = "playerName=" + playerName + "&pos=" + pos + "&oldFC=" + oldFC + "&newFC=" + newFC + "&status=" + status + "&cost=" + cost + "&add=1";
					xhr.open("POST", "db_actions.php", true);
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

		//ajax функция поиска игрока
		function find() {
			var xhr = new XMLHttpRequest();
			if(xhr) {
				try {
					//берем данные с полей
					var playerName = document.getElementById("namePlayer").value;
					var sendPost = "namePlayer=" + playerName + "&find=1";
					xhr.open("POST", "db_actions.php", true);
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

		//ajax функция удаления трансфера
		function del() {
			var xhr = new XMLHttpRequest();
			if(xhr) {
				try {
					//берем данные с полей
					var playerName = document.getElementById("namePlayer").value;
					var sendPost = "namePlayer=" + playerName + "&remove=1";
					xhr.open("POST", "db_actions.php", true);
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
	</script>
</body>
</html>