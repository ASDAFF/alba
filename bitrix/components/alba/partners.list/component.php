<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
    die();

/*Подключение модуля информационных блоков*/
if (!CModule::IncludeModule("iblock"))
    return;

if (!$arParams["IBLOCK_ID"]) {$arParams["IBLOCK_ID"] = 34; }

$obCache = new CPHPCache;
$CACHE_ID = "PARTNER.LIST" . $arParams["IBLOCK_ID"] . implode('-', $arParams["ID"]).$_GET["partner"];

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
        array("IBLOCK_ID", "ID", "CODE", "DETAIL_PAGE_URL", "DETAIL_TEXT", "NAME",)
        );

    $arResult["ALL_ITEMS"] = $rsItems->SelectedRowsCount();

    $index = 0;
    while ($item = $rsItems->GetNext()) {
        $arResult["ITEMS"][] = $item;
        if (isset($_GET["partner"])) {
            if ($_GET["partner"] == $item["CODE"]) {
                $arResult["CURRENT"] = $item;
                $currentPage = $index;
            }
        }
        ++$index;
    }
    if (!$arResult["CURRENT"]) {
        $arResult["CURRENT"] = $arResult["ITEMS"][0];
    }

    /**
    Pagination
    */

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