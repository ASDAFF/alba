<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
    die();

/*Подключение модуля информационных блоков*/
if (!CModule::IncludeModule("iblock"))
    return;

if (!$arParams["IBLOCK_ID"]) {$arParams["IBLOCK_ID"] = 35; }

$obCache = new CPHPCache;
$CACHE_ID = "TRENDS.LIST" . $arParams["IBLOCK_ID"] . implode('-', $arParams["ID"]);

if($obCache->InitCache($arParams["CACHE_TIME"], $CACHE_ID, "/")) {
    $cache = $obCache->GetVars();
    $arResult = $cache["arResult"];
}
else {
    $obCache->StartDataCache();

    $filter = array("IBLOCK_ID" => $arParams["IBLOCK_ID"], "ACTIVE" => "Y");


    $rsItems = CIBlockElement::GetList(
        array("SORT" => "ASC"),
        $filter,
        false,
        false,
        array("IBLOCK_ID", "ID", "CODE", "DETAIL_PAGE_URL", "DETAIL_TEXT", "NAME", "DETAIL_PICTURE")
        );

    $arResult["ALL_ITEMS"] = $rsItems->SelectedRowsCount();

    $index = 0;
    while ($item = $rsItems->GetNext()) {
        $item["DETAIL_PICTURE"] = CFile::GetPath($item["DETAIL_PICTURE"]);
        $arResult["ITEMS"][] = $item;
    }
    if (!$arResult["CURRENT"]) {
        $arResult["CURRENT"] = $arResult["ITEMS"][0];
    }

    /**
    Pagination
    */
    $tmp1 = $arResult["ITEMS"];
    $tmp = array();
    foreach ($tmp1 as $k => $item) {
        if ($k % 2 == 0) {
            $tmp[] = $tmp1[$k]; unset($tmp1[$k]);
        }
    }
    $arResult["ITEMS"] = array(0 => $tmp1, 1 => $tmp);

    if ($currentPage === 0 || $currentPage) {
        if ($arResult["ITEMS"][$currentPage+1]) {
            $arResult["PAGINATION"]["NEXT_ITEM"] = $arResult["ITEMS"][$currentPage+1]["CODE"];
        }
        if ($arResult["ITEMS"][$currentPage-1]) {
            $arResult["PAGINATION"]["PREV_ITEM"] = $arResult["ITEMS"][$currentPage-1]["CODE"];
        }
    }

    $obCache->EndDataCache(array("arResult" => $arResult));
}

$this->IncludeComponentTemplate();