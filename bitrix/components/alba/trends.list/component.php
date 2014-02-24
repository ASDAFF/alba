<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
    die();



/*Подключение модуля информационных блоков*/
if (!CModule::IncludeModule("iblock"))
    return;

if (!$arParams["IBLOCK_ID"]) {$arParams["IBLOCK_ID"] = 35; }

$obCache = new CPHPCache;
$CACHE_ID = "TRENDS.LIST" . $arParams["IBLOCK_ID"] . implode('-', $arParams["ID"] . "PAGE" . $_GET["PAGE"]);

if (false) {
//if($obCache->InitCache($arParams["CACHE_TIME"], $CACHE_ID, "/")) {
    $cache = $obCache->GetVars();
    $arResult = $cache["arResult"];
}
else {
    $obCache->StartDataCache();

    $filter = array("IBLOCK_ID" => $arParams["IBLOCK_ID"], "ACTIVE" => "Y");
    $filter = array("IBLOCK_ID" => $arParams["IBLOCK_ID"], "ACTIVE" => "Y");
    if (isset($_GET["YEAR"])) {
        $now = date("Y");
        $filter["><DATE_CREATE"] = array("01.01." .$_GET["YEAR"], "31.12." . $_GET["YEAR"]);
    } else {
        $filter[">=DATE_CREATE"] = "01.01." . date('Y');
    }

    $rsItems = CIBlockElement::GetList(
        array("SORT" => "ASC"),
        $filter,
        false,
        array("nPageSize" => DEFAULT_PAGE_SIZE_TREND, "iNumPage" => ($_GET["PAGE"]) ? $_GET["PAGE"] : 1),
        array("IBLOCK_ID", "ID", "CODE", "DETAIL_PAGE_URL", "DETAIL_TEXT", "NAME", "DETAIL_PICTURE", "DATE_CREATE")
        );

    $index = 0;
    while ($item = $rsItems->GetNext()) {
        $item["DETAIL_PICTURE"] = CFile::GetPath($item["DETAIL_PICTURE"]);
        $item["DATE_CREATE"] = FormatDate("j F Y", MakeTimeStamp($item["DATE_CREATE"]), time());
        $arResult["ITEMS"][] = $item;
    }
    if (!$arResult["CURRENT"]) {
        $arResult["CURRENT"] = $arResult["ITEMS"][0];
    }

    /**
    Pagination
    */
    $nextItemsValue = CIBlockElement::GetList(
        array("SORT" => "ASC"),
        $filter,
        false,
        false,
        array("ID")
    )->SelectedRowsCount();
    if (!isset($_GET["PAGE"]) || $_GET["PAGE"] == 1) {
        $arResult["PAGINATION"]["PREV"] = false;
        if ($nextItemsValue > DEFAULT_PAGE_SIZE_TREND*$_GET["PAGE"]) {
            $arResult["PAGINATION"]["NEXT"] = $APPLICATION->GetCurPageParam("PAGE=2", array("PAGE"));
        }
    } else {
        if ($nextItemsValue > DEFAULT_PAGE_SIZE_TREND*$_GET["PAGE"]) {
            $arResult["PAGINATION"]["NEXT"] = $APPLICATION->GetCurPageParam("PAGE=" . ($_GET["PAGE"] + 1), array("PAGE"));
        }
        $arResult["PAGINATION"]["PREV"] = $APPLICATION->GetCurPageParam("PAGE=" . ($_GET["PAGE"] - 1), array("PAGE"));
    }


    $tmp1 = $arResult["ITEMS"];
    $tmp = array();
    foreach ($tmp1 as $k => $item) {
        if ($k % 2 == 0) {
            $tmp[] = $tmp1[$k]; unset($tmp1[$k]);
        }
    }
    $arResult["ITEMS"] = array(0 => $tmp1, 1 => $tmp);

    $obCache->EndDataCache(array("arResult" => $arResult));
}

$this->IncludeComponentTemplate();