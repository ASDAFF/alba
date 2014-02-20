<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Тренды");
?>

<?$APPLICATION->IncludeComponent(
    "alba:trends.detail",
    "",
    Array(
        "IBLOCK_TYPE" => "PUBLICS",
        "IBLOCK_ID" => "35",
        "CACHE_TYPE" => "A",
        "CACHE_TIME" => "3600",
        "CACHE_NOTES" => ""
    ),
    false
);?>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>