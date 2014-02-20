<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("women");
?><?$APPLICATION->IncludeComponent(
	"alba:collections.detail",
	"",
	Array(
		"IBLOCK_TYPE" => "CATALOG",
		"IBLOCK_ID" => "32",
		"CACHE_TYPE" => "A",
		"CACHE_TIME" => "3600",
		"CACHE_NOTES" => ""
	)
);?><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>