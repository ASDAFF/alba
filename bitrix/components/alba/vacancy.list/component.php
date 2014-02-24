<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
    die();

/*Подключение модуля информационных блоков*/
if (!CModule::IncludeModule("iblock"))
    return;

if (!$arParams["IBLOCK_ID"]) {$arParams["IBLOCK_ID"] = 2; }


$obCache = new CPHPCache;
$CACHE_ID = "VACANCY.LIST" . $arParams["IBLOCK_ID"] . implode('-', $arParams["ID"]);

if($obCache->InitCache($arParams["CACHE_TIME"], $CACHE_ID, "/")) {
    $cache = $obCache->GetVars();
    $arResult = $cache["arResult"];
}
else {
    $obCache->StartDataCache();

    $filter = array("IBLOCK_ID" => $arParams["IBLOCK_ID"], "ACTIVE" => "Y");

    $rsItems = CIBlockElement::GetList(
        array("DATE_CREATE" => "DESC", "SORT" => "ASC"),
        $filter,
        false,
        false,
        array("IBLOCK_ID", "ID", "CODE", "DETAIL_PAGE_URL", "PREVIEW_PICTURE", "NAME", "PREVIEW_TEXT", "PROPERTY_REGION")
        );
    while ($item = $rsItems->GetNext()) {
        $arResult["ITEMS"][$item["ID"]] = array(
            "ID" => $item["ID"],
            "PREVIEW_TEXT" => $item["PREVIEW_TEXT"],
            "NAME" => $item["NAME"],
            "CODE" => $item["CODE"],
            "REGION" => $item["PROPERTY_REGION_VALUE"]
            );
    }

    $obCache->EndDataCache(array("arResult" => $arResult));
}

$this->IncludeComponentTemplate();