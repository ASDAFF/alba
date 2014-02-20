<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
    die();
/*Подключение модуля информационных блоков*/
if (!CModule::IncludeModule("iblock"))
    return;

if (!$arParams["IBLOCK_ID"]) {$arParams["IBLOCK_ID"] = 32; }

$obCache = new CPHPCache;
$CACHE_ID = "COLLECTIONS.DETAIL" . $arParams["IBLOCK_ID"] . $arParams["CODE"] . $_GET["ELEMENT_CODE"];

if($obCache->InitCache($arParams["CACHE_TIME"], $CACHE_ID, "/")) {
    $cache = $obCache->GetVars();
    $arResult = $cache["arResult"];
}
else {
    $obCache->StartDataCache();

    /**
     * Get collection name
     */
    $section = CIBlockSection::GetList(false, array("CODE" => $_GET["SECTION_CODE"], "IBLOCK_ID" => $arParams["IBLOCK_ID"]), false, array("NAME", "IBLOCK_SECTION_ID"))->Fetch();
    /**
     * Get info about main sections
     */
    $mainSectionFilter = array("IBLOCK_ID" => $arParams["IBLOCK_ID"]);
    if (!$arParams["SECTION_NAME"]) {
        $mainSection["ID"] = $section["IBLOCK_SECTION_ID"];
    } else {
        $mainSectionFilter["CODE"] = $arParams["SECTION_NAME"];
        $mainSection = CIBlockSection::GetList(false, $mainSectionFilter, false, array("ID"))->Fetch();
    }
    /**
     * Get all collections from section
     */
    $rsSections = CIBlockSection::GetList(
        array("SORT" => "ASC"),
        array(
            "IBLOCK_ID" => $arParams["IBLOCK_ID"],
            "SECTION_ID" =>  $mainSection["ID"],
            "ACTIVE" => "Y"
        ),
        false,
        array("ID", "SECTION_PAGE_URL", "NAME", "CODE")
    );
    while ($sec = $rsSections->GetNext()) {
        $arResult["MENU"]["SECTIONS"][$sec["ID"]] = $sec;
    }

    /**
     * Get collection items
     */
    $rsItems = CIBlockElement::GetList(
        false,
        array("IBLOCK_ID" => $arParams["IBLOCK_ID"], "CODE" => $_GET["ELEMENT_CODE"], "ACTIVE" => "Y"),
        false,
        array("nTopCount" => 1)
        );

    if ($objItem = $rsItems->GetNextElement()) {
        $fields = $objItem->GetFields();
        $arResult["ITEM"] = array(
            "NAME" => $fields["NAME"],
            "COLLECTION" => $section["NAME"]
            );
        $properties = $objItem->GetProperties();

        foreach ($properties as $id => $prop) {
            if ($prop["CODE"] == "PHOTO") {
                foreach ($prop["VALUE"] as $id) {
                    $arResult["ITEM"]["PHOTO"][$id] = CFile::GetPath($id);
                }
            } elseif ($prop["VALUE"]) {
                $arResult["PROPERTIES"][$prop["CODE"]] = array(
                    "NAME" => $prop["NAME"],
                    "VALUE" => $prop["VALUE"]
                    );
            }
        }
    }

    $obCache->EndDataCache(array("arResult" => $arResult));
}

$APPLICATION->SetTitle($arResult["ITEM"]["NAME"]);

$this->IncludeComponentTemplate();