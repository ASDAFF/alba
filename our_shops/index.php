<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Наши Салоны");
?><!-- ... -->
<?$APPLICATION->IncludeComponent("bitrix:map.google.view", ".default", array(
	"INIT_MAP_TYPE" => "ROADMAP",
	"MAP_DATA" => serialize(
        array(
            'google_lat' => 54.70803636999584,
            'google_lon' => 20.582714080810547,
            'google_scale' => 16,
            'PLACEMARKS' => array(
                array(
                    'TEXT' => "ООО\"1С-Битрикс\", офис,  Московский проспект, 261.",
                    'LON' => 20.582714080810547,
                    'LAT' => 54.70803636999584
                ),
            ),
        )
    ),
	"MAP_WIDTH" => "600",
	"MAP_HEIGHT" => "500",
	"CONTROLS" => array(
		0 => "SMALL_ZOOM_CONTROL",
		1 => "TYPECONTROL",
		2 => "SCALELINE",
	),
	"OPTIONS" => array(
		0 => "ENABLE_SCROLL_ZOOM",
		1 => "ENABLE_DBLCLICK_ZOOM",
		2 => "ENABLE_DRAGGING",
		3 => "ENABLE_KEYBOARD",
	),
	"MAP_ID" => ""
	),
	false
);?>
<!-- Content -->
    <?$APPLICATION->IncludeComponent(
    "bitrix:map.google.search",
    "",
    Array(
        "INIT_MAP_TYPE" => "MAP",
        "MAP_DATA" => "a:3:{s:10:\"google_lat\";s:7:\"55.7383\";s:10:\"google_lon\";s:7:\"37.5946\";s:12:\"google_scale\";i:13;}",
        "MAP_WIDTH" => "600",
        "MAP_HEIGHT" => "500",
        "CONTROLS" => array("SMALL_ZOOM_CONTROL","TYPECONTROL","SCALELINE"),
        "OPTIONS" => array("ENABLE_SCROLL_ZOOM","ENABLE_DBLCLICK_ZOOM","ENABLE_DRAGGING","ENABLE_KEYBOARD"),
        "MAP_ID" => ""
    ),
    false
);?>
		<!-- Content -->
<!--		<section class="gradient_box">-->
<!--			<div class="container font1">-->
<!--				-->
<!--				<div class="wrapper map_box">-->
<!--					<ul class="maps_list">-->
<!--						<li><a class="active" href="#">Москва</a></li>-->
<!--						<li><a href="#">Санкт-Петербург</a></li>-->
<!--						<li><a href="#">Воронеж</a></li>-->
<!--						<li><a href="#">Екатеринбург</a></li>-->
<!--						<li><a href="#">Казань</a></li>-->
<!--						<li><a href="#">Краснодар</a></li>-->
<!--						<li><a href="#">Красноярск</a></li>-->
<!--						<li><a href="#">Нижний Новгород</a></li>-->
<!--						<li><a href="#">Новосибирск</a></li>-->
<!--						<li><a href="#">Оренбург</a></li>-->
<!--						<li><a href="#">Ростов-на-Дону</a></li>-->
<!--						<li><a href="#">Самара</a></li>-->
<!--						<li><a href="#">Сыктывкар</a></li>-->
<!--						<li><a href="#">Тольятти</a></li>-->
<!--						<li><a href="#">Уфа</a></li>-->
<!--						<li><a href="#">Челябинск</a></li>-->
<!--						<li><a href="#">Ярославль</a></li>-->
<!--					</ul>-->
<!--					<div class="wrapper map">-->
<!--						<div class="map_filter">-->
<!--							<a href="#" class="active">карта</a>-->
<!--							<a href="#">метро</a>-->
<!--						</div>-->
<!--						<figure class="map_wrap">-->
<!--							<img src="/images/map_img.jpg" alt="">-->
<!--						</figure>-->
<!--					</div>-->
<!--				</div>-->
<!--				<!-- Adress Box END -->-->
<!---->
<!--				<ul class="address_list">-->
<!--					<li class="wrapper address_list__item">-->
<!--						<div class="address_list___left_col">-->
<!--							<h2 class="address_title">ТРЦ "Золотой Вавилон"</h2>-->
<!--							<dl class="address">-->
<!--								<dd>Станция метро: Проспект мира</dd>-->
<!--								<dd>Проспект Мира, д. 211, кор. 2</dd>-->
<!--								<dd>Тел. (495) 649 70 82</dd>-->
<!--								<dd>Режим работы: с 10:00 до 22:00</dd>-->
<!--							</dl>-->
<!--							<a href="#" class="map_link">на карте</a>-->
<!--						</div>-->
<!--						<div class="address_list___right_col">-->
<!--							<h2 class="address_title">ТРЦ "Золотой Вавилон"</h2>-->
<!--							<dl class="address">-->
<!--								<dd>Станция метро: Проспект мира</dd>-->
<!--								<dd>Проспект Мира, д. 211, кор. 2</dd>-->
<!--								<dd>Тел. (495) 649 70 82</dd>-->
<!--								<dd>Режим работы: с 10:00 до 22:00</dd>-->
<!--							</dl>-->
<!--							<a href="#" class="map_link">на карте</a>-->
<!--						</div>-->
<!--					</li>-->
<!--					<li class="wrapper address_list__item">-->
<!--						<div class="address_list___left_col">-->
<!--							<h2 class="address_title">ТРЦ "Золотой Вавилон"</h2>-->
<!--							<dl class="address">-->
<!--								<dd>Станция метро: Проспект мира</dd>-->
<!--								<dd>Проспект Мира, д. 211, кор. 2</dd>-->
<!--								<dd>Тел. (495) 649 70 82</dd>-->
<!--								<dd>Режим работы: с 10:00 до 22:00</dd>-->
<!--							</dl>-->
<!--							<a href="#" class="map_link">на карте</a>-->
<!--						</div>-->
<!--						<div class="address_list___right_col">-->
<!--							<h2 class="address_title">ТРЦ "Золотой Вавилон"</h2>-->
<!--							<dl class="address">-->
<!--								<dd>Станция метро: Проспект мира</dd>-->
<!--								<dd>Проспект Мира, д. 211, кор. 2</dd>-->
<!--								<dd>Тел. (495) 649 70 82</dd>-->
<!--								<dd>Режим работы: с 10:00 до 22:00</dd>-->
<!--							</dl>-->
<!--							<a href="#" class="map_link">на карте</a>-->
<!--						</div>-->
<!--					</li>-->
<!--					<li class="wrapper address_list__item">-->
<!--						<div class="address_list___left_col">-->
<!--							<h2 class="address_title">ТРЦ "Золотой Вавилон"</h2>-->
<!--							<dl class="address">-->
<!--								<dd>Станция метро: Проспект мира</dd>-->
<!--								<dd>Проспект Мира, д. 211, кор. 2</dd>-->
<!--								<dd>Тел. (495) 649 70 82</dd>-->
<!--								<dd>Режим работы: с 10:00 до 22:00</dd>-->
<!--							</dl>-->
<!--							<a href="#" class="map_link">на карте</a>-->
<!--						</div>-->
<!--						<div class="address_list___right_col">-->
<!--							<h2 class="address_title">ТРЦ "Золотой Вавилон"</h2>-->
<!--							<dl class="address">-->
<!--								<dd>Станция метро: Проспект мира</dd>-->
<!--								<dd>Проспект Мира, д. 211, кор. 2</dd>-->
<!--								<dd>Тел. (495) 649 70 82</dd>-->
<!--								<dd>Режим работы: с 10:00 до 22:00</dd>-->
<!--							</dl>-->
<!--							<a href="#" class="map_link">на карте</a>-->
<!--						</div>-->
<!--					</li>-->
<!--				</ul>-->
<!--			</div>-->
<!--		</section>-->
		<!-- ... --><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>