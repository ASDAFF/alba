<!-- Content -->
<section class="gradient_box">
	<div class="container secondary">
		<div class="clearfix">
			<div class="f_left trend_column">
				<?foreach ($arResult["ITEMS"] as $id => $item) :?>
				<!--trend item-->
				<figure class="trend_item">
					<figcaption class="color_white">
						<p class="p_bottom_0"><?=$item["DATE_CREATE"]?></p>
						<h3 class="color_white"><?=$item["NAME"]?></h3>
					</figcaption>
					<div class="relative trend_item_img">
						<img src="<?=$item["DETAIL_PICTURE"]?>" alt="">
						<a href="#" role="button" class="button_type_1"><?=GetMessage("MORE_LINK");?></a>
					</div>
				</figure>
				<!--trend item-->
				<?endforeach;?>
			</div>
		</div>
		<div class="clearfix pages_nav">
			<a href="#" class="f_left prev_page">Позже</a>
			<a href="#" class="f_right next_page">Раньше</a>
		</div>
	</div>
</section>
<!-- ... -->