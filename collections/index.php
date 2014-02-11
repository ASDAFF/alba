<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Коллекции");
?><!-- Toggle Menu -->
		<section class="toggle_menu">
			<div class="or toggle_menu__top">
				<a href="#" class="toggle_link" data-show=".toggle_menu_list">Весна-лето 13</a>
			</div>
			<ul class="toggle_menu_list">
				<li class="toggle_menu__item"><a href="#">Осень-зима 13/14</a></li>
				<li class="toggle_menu__item"><a href="#">Осень-зима 12/13</a></li>
				<li class="toggle_menu__item"><a href="#">весна-лето 12</a></li>
			</ul>
		</section>

		<!-- ... -->
		
		<!-- Secondary Menu -->
		<section class="secondary_nav">
			<div class="container">
				<nav role="secondary_navigation">
					<ul class="secondary_menu clearfix">
						<li class="current"><a href="#">женские</a>
							<ul>
								<li><a href="#">Морская богиня</a></li>
								<li><a href="#">Возвращение в эдем</a></li>
								<li class="current"><a href="#">Nude</a></li>
								<li><a href="#">Жемчуг</a></li>
								<li><a href="#">Geo-Safari</a></li>
								<li><a href="#">Позитив-негатив</a></li>
							</ul>
						</li>
						<li><a href="#">Мужские</a></li>
						<li><a href="#">аксессуары</a></li>
					</ul>
				</nav>
			</div>
		</section>
		<!-- ... -->
		<!-- Content -->
		<section class="gradient_box">
			<div class="container">
				<h1 class="collection_title">Nude</h1>
				<ul class="collection_list">
					<li class="collection_row">
						<div class="collection_item">
							<figure>
								<img src="/images/collection_img1.jpg" alt="">
							</figure>
							<div class="collection_item__title">
								<a href="single_collection.html" class="collection_btn">подробнее</a>
							</div>
						</div>
						<div class="collection_item">
							<figure>
								<img src="/images/collection_img2.jpg" alt="">
							</figure>
							<div class="collection_item__title">
								<a href="single_collection.html" class="collection_btn">подробнее</a>
							</div>
						</div>
						<div class="collection_item">
							<figure>
								<img src="/images/collection_img3.jpg" alt="">
							</figure>
							<div class="collection_item__title">
								<a href="single_collection.html" class="collection_btn">подробнее</a>
							</div>
						</div>
					</li>
					<li class="collection_row">
						<div class="collection_item">
							<figure>
								<img src="/images/collection_img4.jpg" alt="">
							</figure>
							<div class="collection_item__title">
								<a href="single_collection.html" class="collection_btn">подробнее</a>
							</div>
						</div>
						<div class="collection_item">
							<figure>
								<img src="/images/collection_img5.jpg" alt="">
							</figure>
							<div class="collection_item__title">
								<a href="single_collection.html" class="collection_btn">подробнее</a>
							</div>
						</div>
						<div class="collection_item">
							<figure>
								<img src="/images/collection_img6.jpg" alt="">
							</figure>
							<div class="collection_item__title">
								<a href="single_collection.html" class="collection_btn">подробнее</a>
							</div>
						</div>
					</li>
				</ul>
			</div>
		</section>
		<!-- ... --><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>