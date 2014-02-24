<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();?>
<!-- Toggle Menu -->
<section class="toggle_menu">
    <?$APPLICATION->IncludeComponent(
        "bitrix:menu",
        "collections.season",
        Array(
            "ROOT_MENU_TYPE" => "collections_seasons",
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
