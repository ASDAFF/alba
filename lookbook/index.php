<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Lookbook");
?>
<div id="preloader" style="position: absolute; width: 100%; height: 100%; background: #ccc url(/images/ajax-loader.gif) no-repeat center; z-index: 999; opacity: 0.7; "></div>
<?$APPLICATION->IncludeComponent("alba:lookbook.list", ".default", array(
	"IBLOCK_TYPE" => "CATALOG",
	"IBLOCK_ID" => "33",
	"CACHE_TYPE" => "A",
	"CACHE_TIME" => "3600"
	),
	false
);?>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>