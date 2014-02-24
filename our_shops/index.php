<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Наши Салоны");
?>
<!-- ... -->

<?$APPLICATION->IncludeComponent(
    "alba:shops.list",
    "",
    Array(
        "IBLOCK_TYPE" => "",
        "IBLOCK_ID" => "",
        "CACHE_TYPE" => "A",
        "CACHE_TIME" => "3600",
        "CACHE_NOTES" => ""
    )
);?>
<!-- ... -->
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>