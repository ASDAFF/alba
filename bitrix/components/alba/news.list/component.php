<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
    die();

/*Подключение модуля информационных блоков*/
if (!CModule::IncludeModule("iblock"))
    return;

if (!$arParams["IBLOCK_ID"]) {$arParams["IBLOCK_ID"] = 1; }


$obCache = new CPHPCache;
$CACHE_ID = "NEWS.LIST" . $APPLICATION->GetCurDir() . $arParams["IBLOCK_ID"] . implode('-', $arParams["ID"]) . implode('-', $_GET);

if($obCache->InitCache($arParams["CACHE_TIME"], $CACHE_ID, "/")) {
    $cache = $obCache->GetVars();
    $arResult = $cache["arResult"];
}
else {
    $obCache->StartDataCache();

    $filter = array("IBLOCK_ID" => $arParams["IBLOCK_ID"], "ACTIVE" => "Y");
    if (isset($_GET["YEAR"])) {
        $now = date("Y");
        $filter["><DATE_CREATE"] = array("01.01." .$_GET["YEAR"], "31.12." . $_GET["YEAR"]);
    } else {
        $filter[">=DATE_CREATE"] = "01.01." . date('Y');
    }

    $rsItems = CIBlockElement::GetList(
        array("DATE_CREATE" => "DESC", "SORT" => "ASC"),
        $filter,
        false,
        array("iNumPage" => ($_GET["page"]) ? $_GET["page"] : 1, "nPageSize" => DEFAULT_PAGE_SIZE),
        array("IBLOCK_ID", "ID", "CODE", "DETAIL_PAGE_URL", "PREVIEW_PICTURE", "NAME", "PREVIEW_TEXT", "DATE_CREATE")
        );
    while ($item = $rsItems->GetNext()) {
        $arResult["ITEMS"][$item["ID"]] = array(
            "ID" => $item["ID"],
            "PREVIEW_PICTURE" => CFile::GetPath($item["PREVIEW_PICTURE"]),
            "PREVIEW_TEXT" => $item["PREVIEW_TEXT"],
            "NAME" => $item["NAME"],
            "DETAIL_PAGE_URL" => $item["DETAIL_PAGE_URL"],
            "CODE" => $item["CODE"],
            "DATE_CREATE" => FormatDate("j F Y", MakeTimeStamp($item["DATE_CREATE"]), time())
            );
    }

    $obCache->EndDataCache(array("arResult" => $arResult));
}

$this->IncludeComponentTemplate();