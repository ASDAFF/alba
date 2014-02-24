<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
    die();

/*Подключение модуля информационных блоков*/
if (!CModule::IncludeModule("iblock"))
    return;

if (!$arParams["IBLOCK_ID"]) { $arParams["IBLOCK_ID"] = 36; }

$obCache = new CPHPCache;
$CACHE_ID = "HISTORY.LIST" . $arParams["IBLOCK_ID"] . implode('-', $arParams["ID"]);

if($obCache->InitCache($arParams["CACHE_TIME"], $CACHE_ID, "/")) {
    $cache = $obCache->GetVars();
    $arResult = $cache["arResult"];
}
else {
    $obCache->StartDataCache();

    $rsItems = CIBlockElement::GetList(
        false,
        array("IBLOCK_ID" => $arParams["IBLOCK_ID"], "ACTIVE" => "Y"),
        false,
        false,
        array("NAME", "PREVIEW_TEXT")
    );

    while ($item = $rsItems->Fetch()) {
        $arResult["ITEMS"][$item["NAME"]] = $item;
    }

    $obCache->EndDataCache(array("arResult" => $arResult));
}

$this->IncludeComponentTemplate();