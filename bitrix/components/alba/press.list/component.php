<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
    die();

/*Подключение модуля информационных блоков*/
if (!CModule::IncludeModule("iblock"))
    return;

if (!$arParams["IBLOCK_ID"]) {$arParams["IBLOCK_ID"] = 31; }


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
        array("nTopCount" => 10)
        );
    while ($item = $rsItems->GetNextElement()) {
        $fields = $item->GetFields();
        $props = $item->GetProperties();
        foreach ($props["PRESS_SCAN"]["VALUE"] as $picture) {
            $fields["PHOTO"][] = CFile::GetPath($picture);
        }
        $arResult["ITEMS"][] = $fields;
    }

    $obCache->EndDataCache(array("arResult" => $arResult));
}

$this->IncludeComponentTemplate();