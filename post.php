<!doctype html>
<html>
	<?php
		include("header.php");
	?>
	<!--Main Block-->
		<!--Left Sidebar-->
		<?php
			include("sidebar.php");
		?>
		<!--Main Content-->
		<div id="content">				
			<h2>Новость дня: "Куадрадо перешел в Челси"</h2>
			<img src="images/news/cuadrado.png" alt="Хуан Куадрадо" width="30%" height="30%" class="leftimg">
			<p id="annotation" align="justify">
				Колумбийский полузащитник "Фиорентины" Хуан Куадрадо подписал с "Челси" долгосрочный контракт и в ближайшее время приступит к тренировочным занятиям вместе с основным составом клуба.
			</p>
			<p align="justify">
				"Я очень счастлив, что мой трансфер улажен, и я могу подписать контракт с "Челси". Сбылась моя мечта, ведь я всегда хотел играть в большом клубе и бороться за титулы. Сейчас я еще до конца не осознал, в какой клуб я перешел, но уже сейчас ощутил на себе то давление, которое меня ждет в клубе. Это большая ответственность и фантастическая мотивация. Очень счастлив, что теперь я могу успокоиться и готовиться к следующему матчу, в составе "Челси" под руководством Жозе Моуринью", - заявил Хуан Куадрадо.
			</p>
			<p style="font-weight: bold;"id="share">
				Поделиться новостью<br>
				<a href="#"><img src="images/icons/facebook.png" width="30px" height="30px" alt="Facebook"></a>
				<a href="#"><img src="images/icons/googleplus.png" width="30px" height="30px" alt="Google+"></a>
				<a href="#"><img src="images/icons/blogger.png" width="30px" height="30px" alt="Blogger"></a>
				<a href="#"><img src="images/icons/twitter.png" width="30px" height="30px" alt="Twitter"></a>
				<a href="#"><img src="images/icons/youtube.png" width="30px" height="30px" alt="YouTube"></a>
				<a href="#"><img src="images/icons/vimeo.png" width="30px" height="30px" alt="Vimeo"></a>
			</p>
			<h3>Комментарии</h3>
			<p class="comment">
				<b>adriano81</b> (01.02.2015)<br>
				Всех поздравляю с трансфером сильного и нужного игрока! Наконец наш правый фланг не будет уступать левому! Челси форево!
			</p>
			<p class="comment">
				<b>chelsea99</b> (04.02.2015)<br>
				Всех с трансфером,удачи Хуану,она ему понадобиться,в соперничестве с Виллианом 
			</p>
			<p class="comment">
				<b>drogba</b> (04.02.2015)<br>
				ПО сравнению с Виллианом быстрее, техничнее, вариативнее. Достойный ему конкурент. Добро пожаловать! 
			</p>
			<h3>
				Добавить комментарий
			</h3>
			<form action="#" method="post" name="commentform" id="commentform">
				<p><input type="text" name="author" id="author" value="" size="25" placeholder="user007">
				<small> Имя</small>
				</p>
				<p><input type="text" name="email" id="email" value="" size="25" placeholder="user007@domain.su">
				<small> Mail</small>
				</p>
				<p><textarea name="comment" id="comment" cols="48" rows="8" placeholder="Текст комментария..."> </textarea>
				</p>
				<p><input class="btn" name="submit" type="submit" id="submit" value="Отправить">
				</p>
			</form>
		</div>
		<!--Footer-->
		<?php
			include("footer.php");
		?>
	</div>		
</body>
</html>