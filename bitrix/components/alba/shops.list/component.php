<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
    die();

define("DEFAULT_CITY", 6264);
$arResult["DEFAULT_COORD"] = array("LNG" => 37.945661, "LAT" => 56.009657);
/*Подключение модуля информационных блоков*/
if (!CModule::IncludeModule("iblock"))
    return;

if (!$arParams["IBLOCK_ID_CITY"]) {$arParams["IBLOCK_ID_CITY"] = 6; }
if (!$arParams["IBLOCK_ID_SHOPS"]) {$arParams["IBLOCK_ID_SHOPS"] = 11; }

$obCache = new CPHPCache;
$CACHE_ID = "SHOPS.LIST" . $arParams["IBLOCK_ID"] . implode('-', $arParams["ID"]) . $_GET["CITY"];

if($obCache->InitCache($arParams["CACHE_TIME"], $CACHE_ID, "/")) {
    $cache = $obCache->GetVars();
    $arResult = $cache["arResult"];
}
else {
    $obCache->StartDataCache();

    $rsCities = CIBlockElement::GetList(
        array("SORT" => "ASC"),
        array("IBLOCK_ID" => $arParams["IBLOCK_ID_CITY"], "ACTIVE" => "Y"),
        false,
        false,
        array("NAME", "CODE", "ID")
    );
    while ($item = $rsCities->Fetch()) {
        $arResult["CITIES"][] = $item;
        if (isset($_GET["CITY"]) && $_GET["CITY"] == $item["ID"]) {
            $link = str_replace(" ", "%20",'http://maps.google.com/maps/api/geocode/json?address=' . $item["NAME"] . '&sensor=false');
            $mapInfo = json_decode(file_get_contents($link));
            $arResult["DEFAULT_COORD"]["LNG"] = $mapInfo->results[0]->geometry->location->lng;
            $arResult["DEFAULT_COORD"]["LAT"] = $mapInfo->results[0]->geometry->location->lat;
        }
    }

    $filter = array("IBLOCK_ID" => $arParams["IBLOCK_ID_SHOPS"], "ACTIVE" => "Y");
    $filter["PROPERTY_CITY_ID"] = (isset($_GET["CITY"])) ? $_GET["CITY"] : DEFAULT_CITY;

    $rsItems = CIBlockElement::GetList(
        array("SORT" => "ASC"),
        $filter,
        false,
        false,
        array("ID", "CODE", "NAME", "PROPERTY_ADDRESS")
    );
    while ($item = $rsItems->Fetch()) {
        $link = str_replace(" ", "%20",'http://maps.google.com/maps/api/geocode/json?address=' . $item["PROPERTY_ADDRESS_VALUE"] . '&sensor=false');
        $mapInfo = json_decode(file_get_contents($link));
        $arResult["MARKS"][] = array(
            'TEXT' => $item["NAME"],
            'LON' => $mapInfo->results[0]->geometry->location->lng,
            'LAT' => $mapInfo->results[0]->geometry->location->lat
        );
        $arResult["SHOPS"][] = $item;
    }
    $arResult["SHOPS"] = array_chunk($arResult["SHOPS"], 2);

    $obCache->EndDataCache(array("arResult" => $arResult));
}

$this->IncludeComponentTemplate();