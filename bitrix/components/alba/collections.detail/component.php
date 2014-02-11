<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
    die();
/*Подключение модуля информационных блоков*/
if (!CModule::IncludeModule("iblock"))
    return;

if (!$arParams["IBLOCK_ID"]) {$arParams["IBLOCK_ID"] = 32; }

$obCache = new CPHPCache;
$CACHE_ID = "COLLECTIONS.LIST" . $arParams["IBLOCK_ID"] . implode('-', $arParams["ID"]);

if($obCache->InitCache($arParams["CACHE_TIME"], $CACHE_ID, "/")) {
    $cache = $obCache->GetVars();
    $arResult = $cache["arResult"];
}
else {
    $obCache->StartDataCache();

    $rsSections = CIBlockSection::GetList(
        false, 
        array(
            "IBLOCK_ID" => $arParams["IBLOCK_ID"], 
            "CODE" => array($_GET["SECTION_CODE"], $_GET["COLLECTION_CODE"]), 
            "ACTIVE" => "Y"
            ), 
        false, 
        array("ID")
        );
    while ($section = $rsSections->Fetch()) {
        $menuSections[$section["CODE"]] = $section["ID"];
    }
    
    $rsSections = CIBlockSection::GetList(
        array("SORT" => "ASC"), 
        array(
            "IBLOCK_ID" => $arParams["IBLOCK_ID"], 
            "SECTION_ID" => $mainSection["ID"], 
            "ACTIVE" => "Y"
            ), 
        false, 
        array("ID", "SECTION_PAGE_URL")
        );
    while ($section = $rsSections->GetNext()) {
        $arResult["MENU"]["SECTIONS"][$section["ID"]] = $section;
    }

    $rsItems = CIBlockElement::GetList(
        array("SORT" => "ASC"), 
        array(
            "IBLOCK_ID" => $arParams["IBLOCK_ID"], 
            "IBLOCK_SECTION_ID" => $menuSections[$_GET["COLLECTION_CODE"]]
            ), 
        false, 
        false, 
        array("PREVIEW_PICTURE", "DETAIL_PAGE_URL", "CODE")
        );
    while ($item = $rsItems->GetNext()) {
        $arResult["ITEMS"][$item["ID"]] = array(
            "PREVIEW_PICTURE" => CFile::GetPath($item["PREVIEW_PICTURE"]),
            "DETAIL_PAGE_URL" => $item["DETAIL_PAGE_URL"],
            "CODE" => $item["CODE"]
            );
    }


    $obCache->EndDataCache(array("arResult" => $arResult));
}

$this->IncludeComponentTemplate();