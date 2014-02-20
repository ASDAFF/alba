<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();?>
<!-- Toggle Menu -->
<section class="toggle_menu">
	<div class="or toggle_menu__top">
		<a href="#" class="toggle_link" data-show=".toggle_menu_list">Осень-Зима 13/14</a>
	</div>
	<ul class="toggle_menu_list">
		<li class="toggle_menu__item"><a href="#">Осень-зима 13/14</a></li>
		<li class="toggle_menu__item"><a href="#">Осень-зима 12/13</a></li>
		<li class="toggle_menu__item"><a href="#">весна-лето 12</a></li>
	</ul>
</section>

<?$APPLICATION->IncludeComponent(
    "bitrix:menu",
    "collections.sections",
    Array(
        "ROOT_MENU_TYPE" => "collections_menu",
        "MAX_LEVEL" => "1",
        "CHILD_MENU_TYPE" => "left",
        "USE_EXT" => "N",
        "DELAY" => "N",
        "ALLOW_MULTI_SELECT" => "N",
        "MENU_CACHE_TYPE" => "N",
        "MENU_CACHE_TIME" => "3600",
        "MENU_CACHE_USE_GROUPS" => "Y",
        "MENU_CACHE_GET_VARS" => array(),
        "SUBMENU" => $arResult["MENU"]["SECTIONS"]
    ),
    false
);?>
