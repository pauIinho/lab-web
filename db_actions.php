<?php
require_once 'config.php';

# Добавление трансфера
if(isset($_POST['add'])) {
	# Ищем, есть ли такой игрок в базе
	$qplayer_exist = $DBH->prepare("SELECT COUNT(id_player) FROM player WHERE name_player = ? LIMIT 1");
	$qplayer_exist->bindParam(1, $_POST['playerName']);
	$qplayer_exist->execute();
	$qplayer_exist->setFetchMode(PDO::FETCH_LAZY);
	$player_exist = $qplayer_exist->fetch();
	# если совпадение имеет место быть
	if($player_exist[0] > 0) {
		# берем id игрока
		$qid_player = $DBH->prepare("SELECT id_player FROM player WHERE name_player = ? LIMIT 1");
		$qid_player->bindParam(1, $_POST['playerName']);
		$qid_player->execute();
		$qid_player->setFetchMode(PDO::FETCH_ASSOC);
		$id_player = $qid_player->fetch();
	}
	# если такого игрока в базе нет
	else {
		# берем id позиции
		$qid_pos = $DBH->prepare("SELECT id_pos FROM position WHERE name_pos = ? LIMIT 1");
		$qid_pos->bindParam(1, $_POST['pos']);
		$qid_pos->execute();
		$qid_pos->setFetchMode(PDO::FETCH_ASSOC);
		$id_pos = $qid_pos->fetch();
		# добавляем игрока в базу
		$add_player = $DBH->prepare("INSERT INTO player (id_pos, name_player) VALUES(".$id_pos["id_pos"].", '".$_POST['playerName']."')");
		$add_player->execute();
		# берем id_игрока
		$qid_player = $DBH->prepare("SELECT id_player FROM player WHERE name_player = ? LIMIT 1");
		$qid_player->bindParam(1, $_POST['playerName']);
		$qid_player->execute();
		$qid_player->setFetchMode(PDO::FETCH_ASSOC);
		$id_player = $qid_player->fetch();
	}
	# берем id футбольных клубов
	$qid_oldfc = $DBH->prepare("SELECT id_fc FROM fc WHERE name_fc = ? LIMIT 1");
	$qid_oldfc->bindParam(1, $_POST['oldFC']);
	$qid_oldfc->execute();
	$qid_oldfc->setFetchMode(PDO::FETCH_ASSOC);
	$id_oldfc = $qid_oldfc->fetch();
	$qid_newfc = $DBH->prepare("SELECT id_fc FROM fc WHERE name_fc = ? LIMIT 1");
	$qid_newfc->bindParam(1, $_POST['newFC']);
	$qid_newfc->execute();
	$qid_newfc->setFetchMode(PDO::FETCH_ASSOC);
	$id_newfc = $qid_newfc->fetch();
	# Добавляем новый трансфер
	$new_transf = $DBH->prepare("INSERT INTO transf (player_id, old_fc_id, new_fc_id, user_id, transf_status, transf_year, time_year, cost) VALUES (?,?,?,?,?,?,?,?)");
	$new_transf->bindParam(1, $id_player["id_player"]);
	$new_transf->bindParam(2, $id_oldfc["id_fc"]);
	$new_transf->bindParam(3, $id_newfc["id_fc"]);
	$user = '3';
	$new_transf->bindParam(4, $user);
	$new_transf->bindParam(5, $_POST["status"]);
	$year = '2015';
	$new_transf->bindParam(6, $year);
	$season = 'Зима';
	$new_transf->bindParam(7, $season);
	$new_transf->bindParam(8, $_POST["cost"]);
	$new_transf->execute();
	echo "Трансфер игрока '".$_POST['playerName']."' добавлен в базу!";
}

# Поиск игрока
if(isset($_POST['find'])) {
	# берем id игрока
	$qid_player = $DBH->prepare("SELECT id_player FROM player WHERE name_player = ? LIMIT 1");
	$qid_player->bindParam(1, $_POST['namePlayer']);
	$qid_player->execute();
	$qid_player->setFetchMode(PDO::FETCH_ASSOC);
	$id_player = $qid_player->fetch();
	# берем трансферные данные по id игрока
	$qtransf_data = $DBH->prepare("SELECT * FROM transf WHERE player_id=".$id_player["id_player"]." LIMIT 1");
	# если трансфер с участием игрока существует
	if($qtransf_data->execute()) {
		$qtransf_data->setFetchMode(PDO::FETCH_ASSOC);
		$transf_data = $qtransf_data->fetch();
		# выбираем названия футбольных клубов
		$qoldfc_name = $DBH->prepare("SELECT name_fc FROM fc WHERE id_fc=".$transf_data["old_fc_id"]." LIMIT 1");
		$qoldfc_name->execute();
		$qoldfc_name->setFetchMode(PDO::FETCH_ASSOC);
		$oldfc_name = $qoldfc_name->fetch();
		$qnewfc_name = $DBH->prepare("SELECT name_fc FROM fc WHERE id_fc=".$transf_data["new_fc_id"]." LIMIT 1");
		$qnewfc_name->execute();
		$qnewfc_name->setFetchMode(PDO::FETCH_ASSOC);
		$newfc_name = $qnewfc_name->fetch();
		echo "Данные о трансфере:\nОткуда: ".$oldfc_name['name_fc']."\nКуда: ".$newfc_name['name_fc']."\nКогда: ".$transf_data['time_year']." ".$transf_data['transf_year']."\nСтоимость: ".$transf_data['cost']." евро";
	}
	else {
		echo "Трансфера с участием данного игрока не было.";
	}
}

# Удаление трансфера
if(isset($_POST['remove'])) {
	# берем id игрока
	$qid_player = $DBH->prepare("SELECT id_player FROM player WHERE name_player = ? LIMIT 1");
	$qid_player->bindParam(1, $_POST['namePlayer']);
	$qid_player->execute();
	$qid_player->setFetchMode(PDO::FETCH_ASSOC);
	$id_player = $qid_player->fetch();
	# берем трансферные данные по id игрока
	$qtransf_data = $DBH->prepare("SELECT id_transf FROM transf WHERE player_id=".$id_player["id_player"]." LIMIT 1");
	# если трансфер с участием игрока существует
	if($qtransf_data->execute()) {
		$qtransf_data->setFetchMode(PDO::FETCH_ASSOC);
		$transf_data = $qtransf_data->fetch();
		$del_transf = $DBH->prepare("DELETE FROM transf WHERE id_transf=".$transf_data['id_transf']);
		$del_transf->execute();
		echo "Трансфер с участием игрока '".$_POST['namePlayer']."' удален из базы!";
	}
	else {
		echo "Трансфера с участием данного игрока не было.";
	}
}
?>