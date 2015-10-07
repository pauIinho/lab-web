<!doctype html>
<html>
	<?php
		include("header.php");
		//фильтруем regexp'ом, оставляем только цифры!
		$id_champ = eregi_replace('/([^0-9])/','',$_GET['id']);
		//проверяем, есть ли в таблице champ переданный id_champ
		$qchamp = $DBH->prepare('SELECT name_champ, id_champ FROM champ WHERE id_champ=? LIMIT 1');
		$qchamp->execute(array($id_champ));
		$qchamp->setFetchMode(PDO::FETCH_ASSOC);
		$row_champ = $qchamp->fetch();
		//если совпадений не обнаружено, то редирект на главную
		if($row_champ==0) {
			header('Location: index.php');
		}
	?>
		<!--Main Block-->
		<!--Left Sidebar-->
			<!--Left Sidebar-->
		<?php
			include("sidebar.php");
		?>
		<!--Main Content-->
		<div id="content">
			<td>
				<?php 
					echo '<h2 align="center">Таблица трансферов: '.$row_champ["name_champ"].'</h2>';
				?>
				<form action="#" method="post">
					<p>
						Выберите лигу
					</p>
					<select name="league">
              			<?php
              				$qlist_league = $DBH->prepare('SELECT name_league FROM league WHERE champ_id='.$row_champ["id_champ"]);
              				$qlist_league->execute();
              				$qlist_league->setFetchMode(PDO::FETCH_ASSOC);
              				while($row_list = $qlist_league->fetch()) {
              					echo "<option value>".$row_list['name_league']."</option>";
              				}
              			?>
              		</select>
					<p>
						Фильтровать по
					</p>
					<label for="year">году:</label>					
						<select name="year">
	          				<option value="2015">2015</option>
	          				<option value="2014">2014</option>
	          				<option value="2013">2013</option>
	          				<option value="2012">2012</option>
	          				<option value="2011">2011</option>
	          				<option value="2010">2010</option>
	          			</select>
              		<label for="yseason">времени года:</label>
              		<select name="yseason">
              					<option value="Зима">Зимнее окно</option>
              					<option value="Лето">Летнее окно</option>
              		</select>
					<input class="btn" type="submit" name="filter" value="Фильтровать">
				</form>
				<?php
					if(isset($_POST['filter'])) {
						# выдача результата по фильтру
					}
					else {
						$qleague_id = $DBH->prepare('SELECT id_league FROM league WHERE champ_id=? LIMIT 1');
						$qleague_id->execute(array($id_champ));
						$qleague_id->setFetchMode(PDO::FETCH_ASSOC);
						$row_league_id = $qleague_id->fetch();
					}
					$qfc = $DBH->prepare('SELECT name_fc, id_fc FROM fc WHERE league_id='.$row_league_id["id_league"]." ORDER BY name_fc ASC");
					$qfc->execute();
					$qfc->setFetchMode(PDO::FETCH_ASSOC);
					while($row_fc = $qfc->fetch()){
						echo "<h3>".$row_fc["name_fc"]."</h3>";
						echo "<table style='width: 99%;'>";
						echo "<tr>";
						echo "<th class='in'>Пришли</th>";
						echo "<th class='out'>Ушли</th>";
						echo "</tr>";
						echo "<tr>";
						echo "<td style='width: 49%;'>";
						//Списк игроков, кто пришел в текущий клуб
						echo "<table>";
						echo "<tr>";
						echo "</tr>";
						echo "<tr>
						<td style='font-weight: bold;'>Позиция</td>
						<td style='font-weight: bold;'>Имя игрока</td>
						<td style='font-weight: bold;'>Откуда</td>
						<td style='font-weight: bold;'>Стоимость</td>
						</tr>
						";
						$qin = $DBH->prepare('SELECT name_pos, name_player, name_fc, cost FROM transf, position, player, fc WHERE player.id_player=transf.player_id and position.id_pos=player.id_pos and fc.id_fc=transf.old_fc_id and transf.new_fc_id='.$row_fc["id_fc"].' ORDER BY id_transf');
						$qin->execute();
						$qin->setFetchMode(PDO::FETCH_ASSOC);
						while($row_in = $qin->fetch()) {
							echo "<tr>";
							echo "<td>".$row_in['name_pos']."</td>";
							echo "<td>".$row_in['name_player']."</td>";
							echo "<td>".$row_in['name_fc']."</td>";
							echo "<td>".$row_in['cost']." евро</td>";
							echo "</tr>";	
						}
						echo "</table>";
						echo "</td>";
						echo "<td style='width: 49%;'>";
						//Списк игроков, кто ушел из текущего клуба
						echo "<table>";
						echo "<tr>";
						echo "</tr>";
						echo "<tr>
						<td style='font-weight: bold;'>Позиция</td>
						<td style='font-weight: bold;'>Имя игрока</td>
						<td style='font-weight: bold;'>Куда</td>
						<td style='font-weight: bold;'>Стоимость</td>
						</tr>
						";
						$qout = $DBH->prepare('SELECT name_pos, name_player, name_fc, cost FROM transf, position, player, fc WHERE player.id_player=transf.player_id and position.id_pos=player.id_pos and fc.id_fc=transf.new_fc_id and transf.old_fc_id='.$row_fc["id_fc"].' ORDER BY id_transf');
						$qout->execute();
						$qout->setFetchMode(PDO::FETCH_ASSOC);
						while($row_out = $qout->fetch()) {
							echo "<tr>";
							echo "<td>".$row_out['name_pos']."</td>";
							echo "<td>".$row_out['name_player']."</td>";
							echo "<td>".$row_out['name_fc']."</td>";
							echo "<td>".$row_out['cost']." евро</td>";
							echo "</tr>";	
						}		
						echo "</table>";
						echo "</td>";
						echo "</tr>";
						echo "</table>";
					}
				?>
		</tr>
	</div>
		<?php
			include("footer.php");
		?>
	</div>	
</body>