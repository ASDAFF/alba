<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Вакансии");
?>
<?$APPLICATION->IncludeComponent(
    "bitrix:menu",
    "submenu",
    Array(
        "ROOT_MENU_TYPE" => "submenu",
        "MAX_LEVEL" => "1",
        "CHILD_MENU_TYPE" => "left",
        "USE_EXT" => "N",
        "DELAY" => "N",
        "ALLOW_MULTI_SELECT" => "N",
        "MENU_CACHE_TYPE" => "N",
        "MENU_CACHE_TIME" => "3600",
        "MENU_CACHE_USE_GROUPS" => "Y",
        "MENU_CACHE_GET_VARS" => array()
    ),
    false
);?>
<?$APPLICATION->IncludeComponent(
	"alba:vacancy.list",
	"",
	Array(
		"IBLOCK_TYPE" => "PUBLICS",
		"IBLOCK_ID" => "2",
		"CACHE_TYPE" => "A",
		"CACHE_TIME" => "3600",
		"CACHE_NOTES" => ""
	),
false
);?> <?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>