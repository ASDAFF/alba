<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
    die();
/*Подключение модуля информационных блоков*/
if (!CModule::IncludeModule("iblock"))
    return;

if (!$arParams["IBLOCK_ID"]) {$arParams["IBLOCK_ID"] = 32; }
if (!$arParams["SECTION_NAME"]) { $arParams["SECTION_NAME"] = 'women'; }

$obCache = new CPHPCache;
$CACHE_ID = "COLLECTIONS.LIST" . $arParams["IBLOCK_ID"] . implode('-', $arParams["ID"]) . $arParams["SECTION_NAME"] . $_GET["COLLECTION_CODE"] . implode('-', $_GET);
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
            "CODE" => $arParams["SECTION_NAME"], 
            "ACTIVE" => "Y"
            ), 
        false, 
        array("ID", "CODE")
        );
    while ($section = $rsSections->Fetch()) {
        $menuSections[$section["CODE"]] = $section["ID"];
    }
    
    $mainSection = array_shift($menuSections);
    $rsSections = CIBlockSection::GetList(
        array("SORT" => "ASC"), 
        array(
            "IBLOCK_ID" => $arParams["IBLOCK_ID"], 
            "SECTION_ID" =>  $mainSection, 
            "ACTIVE" => "Y"
            ), 
        false, 
        array("ID", "SECTION_PAGE_URL", "NAME")
        );
    while ($section = $rsSections->GetNext()) {
        $arResult["MENU"]["SECTIONS"][$section["ID"]] = $section;
    }
    $filter = array(
        "IBLOCK_ID" => $arParams["IBLOCK_ID"],
        "INCLUDE_SUBSECTIONS" => "Y"
    );
    if (!isset($_GET["SHOW"]) || $_GET["SHOW"] != "ALL") {
        $filter["SECTION_CODE"] = ($_GET["COLLECTION_CODE"]) ? $_GET["COLLECTION_CODE"] : $arParams["SECTION_NAME"];
    }
    $rsItems = CIBlockElement::GetList(
        array("SORT" => "ASC"), 
        $filter,
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