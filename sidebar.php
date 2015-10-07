<div id="sidebar">
	<p><span style='font-weight: bold; margin-left: 5px;'>Последние новости</span>
	<ul style='padding: 0px 5px;'>
	<?php
		//выборка названия и ссылки на пост
		$QPOST = $DBH->prepare('SELECT name_post, content_post, id_post FROM post WHERE user_id=4 and type_post="Новость" LIMIT 10');
		$QPOST->execute();
		$QPOST->setFetchMode(PDO::FETCH_ASSOC);
		while($row = $QPOST->fetch()) {
			echo "<li><a href=post.php?id=".$row['id_post'].">".$row['name_post']."</a></li>";
			echo "<hr align='center' width='150px'>";
		}
	?>
	</ul>
	<span style='font-weight: bold; margin-left: 5px;'>Новости от пользователей</span>
	<ul style='padding: 0px 5px;'>
	<?php
		//выборка названия и ссылки на пост
		$QPOST = $DBH->prepare('SELECT name_post, id_post FROM post WHERE user_id!=4 and type_post="Новость" LIMIT 5');
		$QPOST->execute();
		$QPOST->setFetchMode(PDO::FETCH_ASSOC);
		while($row = $QPOST->fetch()) {
			echo "<li><a href=post.php?id=".$row['id_post'].">".$row['name_post']."</a></li>";
			echo "<hr align='center' width='150px'>";
		}
	?>
	</ul>
	</p>
</div>