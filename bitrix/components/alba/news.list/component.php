<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
    die();

/*Подключение модуля информационных блоков*/
if (!CModule::IncludeModule("iblock"))
    return;

if (!$arParams["IBLOCK_ID"]) {$arParams["IBLOCK_ID"] = 1; }
if (isset($_GET["NEWS_ACTION"])) {
    switch ($_GET["NEWS_ACTION"]) {
        case 'discount':
            $arParams["IBLOCK_ID"] = DISCOUNT_IBLOCK_ID;
            break;
        case 'actions':
            $arParams["IBLOCK_ID"] = ACTIONS_IBLOCK_ID;
            break;
        default:
            $arParams["IBLOCK_ID"] = NEWS_IBLOCK_ID;
            break;
    }
}

$obCache = new CPHPCache;
$CACHE_ID = "NEWS.LIST" . $arParams["IBLOCK_ID"] . implode('-', $arParams["ID"]);

if($obCache->InitCache($arParams["CACHE_TIME"], $CACHE_ID, "/")) {
    $cache = $obCache->GetVars();
    $arResult = $cache["arResult"];
}
else {
    $obCache->StartDataCache();

    $filter = array("IBLOCK_ID" => $arParams["IBLOCK_ID"], "ACTIVE" => "Y");
    if (isset($_GET["YEAR"])) {
        $now = date("Y");
        $filter["><DATE_CREATE"] = array($_GET["YEAR"], 1 + $_GET["YEAR"]);
    } else {
        $filter[">=DATE_CREATE"] = "01.01." . date('Y');
    }

    $rsItems = CIBlockElement::GetList(
        array("DATE_CREATE" => "DESC", "SORT" => "ASC"),
        $filter,
        false,
        array("iNumPage" => ($_GET["page"]) ? $_GET["page"] : 1, "nPageSize" => DEFAULT_PAGE_SIZE),
        array("IBLOCK_ID", "ID", "CODE", "DETAIL_PAGE_URL", "PREVIEW_PICTURE", "NAME", "PREVIEW_TEXT")
        );
    while ($item = $rsItems->GetNext()) {
        $arResult["ITEMS"][$item["ID"]] = array(
            "ID" => $item["ID"],
            "PREVIEW_PICTURE" => CFile::GetPath($item["PREVIEW_PICTURE"]),
            "PREVIEW_TEXT" => $item["PREVIEW_TEXT"],
            "NAME" => $item["NAME"],
            "DETAIL_PAGE_URL" => $item["DETAIL_PAGE_URL"],
            "CODE" => $item["CODE"]
            );
    }

    $obCache->EndDataCache(array("arResult" => $arResult));
}

$this->IncludeComponentTemplate();