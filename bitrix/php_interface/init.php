<?
/**
 * Проверяет является ли страница главной на сайте
 */
function IsMainPage()
{
	global $APPLICATION;
	if($APPLICATION -> GetCurPage() !== "/" && $APPLICATION -> GetCurPage() !== "/index.php")
		return false;
		
	return true;
}

define("REMAINS_IBLOCK_ID", "10");
define("MARKET_IBLOCK_ID", "11");
define("BASKET_CACHE_PATH", "/custom/basket/");

require_once $_SERVER["DOCUMENT_ROOT"] . "/bitrix/php_interface/jscache.php";
// вспомогательная библиотека для работы с инфоблоками
require_once $_SERVER["DOCUMENT_ROOT"] . "/bitrix/php_interface/classes/iblock_tools.php";
// комментарии
require_once $_SERVER["DOCUMENT_ROOT"] . "/bitrix/php_interface/classes/comments.php";
// корзина
require_once $_SERVER["DOCUMENT_ROOT"] . "/bitrix/php_interface/include/basket.php";

// накопительные скидки
require_once $_SERVER["DOCUMENT_ROOT"] . "/bitrix/php_interface/include/cumulative_discount.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/bitrix/php_interface/include/tools_new.php";

AddEventHandler("iblock", "OnBeforeIBlockElementAdd", Array("AEvents", "OnBeforeIBlockElementAdd"));
AddEventHandler("iblock", "OnBeforeIBlockElementDelete", Array("AEvents", "OnIBlockElementDelete"));
// оценки для конкурсов
AddEventHandler("iblock", "OnAfterIBlockElementAdd", 		Array("WICatalogComments", "OnAfterElementAdd"));
AddEventHandler("iblock", "OnBeforeIBlockElementUpdate", 	Array("WICatalogComments", "OnBeforeElementUpdate"));
AddEventHandler("iblock", "OnAfterIBlockElementUpdate", 	Array("WICatalogComments", "OnAfterElementUpdate"));
// по идее должен выполняться последним
AddEventHandler("iblock", "OnBeforeIBlockElementDelete", 	Array("WICatalogComments", "OnBeforeElementDelete"), 1000);

class AEvents
{
	public function OnBeforeIBlockElementAdd(&$arFields)
	{
		/**
		 * Добавляем идентификатор пользователя в элемент
		 */
		if($arFields["IBLOCK_ID"] == 4)
		{
			global $USER;
			if(!isset($arFields["PROPERTY_VALUES"]["2"]["n0"]["VALUE"]) || !$arFields["PROPERTY_VALUES"]["2"]["n0"]["VALUE"])
			{
				$arFields["PROPERTY_VALUES"]["2"]["n0"]["VALUE"] = $USER -> GetID();
			}
		}
	}
	
	/**
	 * Удаление остатков привязанных к каталогу
	 * 
	 * @param int $ID - идентификатор удаляемого элемента
	 */
	public function OnIBlockElementDelete($ID)
	{
		global $APPLICATION;

		if(!CModule::IncludeModule("iblock"))
			return;
			
		$rs = CIBlockElement::GetList(
			array(),
			array("IBLOCK_ID" => REMAINS_IBLOCK_ID, "PROPERTY_ELEMENT_ID" => $ID),
			false,
			false,
			array("ID", "IBLOCK_ID"));
		
		while($ar = $rs -> Fetch())
			CIBlockElement::Delete($ar["ID"]);
			
		$rs = CIBlockElement::GetList(
			array(),
			array("IBLOCK_ID" => REMAINS_IBLOCK_ID, "PROPERTY_ELEMENT_ID" => $ID),
			false,
			false,
			array("ID", "IBLOCK_ID"));
			
		if($rs -> SelectedRowsCount())
			return false;
		
		return true;
	}
}

/**
 * 
 */
function ClearUserBasket()
{
	if(!CModule::IncludeModule("sale"))
		return;
		
	if(!defined("BASKET_CLEAR"))
		define("BASKET_CLEAR", true);
				
	$PATH = BASKET_CACHE_PATH . CSaleBasket::GetBasketUserID();
	
	BxClearCache(true, $PATH);
}

function pluralForm($n, $form1, $form2, $form5)
{
    $n = abs($n) % 100;
  
    $n1 = $n % 10;

    if($n > 10 && $n < 20)
    	return $form5;
    if($n1 > 1 && $n1 < 5)
    	return $form2;
       
    if($n1 == 1) 
    	return $form1;
    
    return $form5;
}

/**
 * Сохраняет город выбранный пользователем в куки
 * и задает константу IS_MARKET
 */
function SetCity()
{
	global $APPLICATION, $CITY_ID;
	
	if(!CModule::IncludeModule("iblock"))
		return;
	
	if(isset($_GET["CITY"]) && isset($_GET["set_city"]))
	{
		$CITY_ID = CheckCity($_GET["CITY"]);
		
		if($CITY_ID)
		{
			define("CITY_ID", $CITY_ID);
			$APPLICATION -> set_cookie("ALBA_CITY", $CITY_ID);
			
		}
	} else if(!defined("CITY_ID"))
	{
		$CITY_ID = $APPLICATION -> get_cookie("ALBA_CITY");
		$CITY_ID = CheckCity($CITY_ID);
		
		if($CITY_ID)
		{
			define("CITY_ID", $CITY_ID);
			$APPLICATION -> set_cookie("ALBA_CITY", $CITY_ID);
		}
	}
}

/**
 * Вернет город выбранный пользователем
 */
function GetUserCity()
{
	if(defined("CITY_ID"))
		return CITY_ID;
		
	return 0;
}

/**
 * Проверяет существует ли город с заданным идентификатором на сайте
 * @param $CITY_ID - идентификатор города
 */
function CheckCity($CITY_ID)
{
	$CITY_ID = intval($CITY_ID);
	if(CModule::IncludeModule("iblock"))
	{
		$rs = CIBlockElement::GetList(array(), array("IBLOCK_ID" => "6", "ID" => $CITY_ID));
		
		if($rs -> SelectedRowsCount())
			return $CITY_ID;
	}
	
	return false;
}

/**
 * Функция вставит в страницу код вызова выбора города
 */
function ShowCitySelect()
{
	if(in_array("catalog", GetPathComponents()) && !GetUserCity()){?>
	<script type="text/javascript">
		ShowCitySelect();
	</script>
	<?}
}

/**
 * Вернет массив компонентов текущего пути по сайту
 */
function GetPathComponents()
{
	global $APPLICATION;
	static $arPath = array();
	
	if(count($arPath))
		return $arPath;
		
	$path = $APPLICATION -> GetCurDir();
	$ar = explode("/", $path);
	
	foreach($ar as $s)
	{
		$s = trim($s);
		if($s !== "/" && !empty($s))
			$arPath[] = $s;
	}

	return $arPath;
}

/**
 * Вернет название текущего города (если выбран)
 */
function GetCurCityName()
{
	$ID = GetUserCity();
	
	if($ID)
		return WIBlockTools::GetElementName($ID);
	
	return;
}

/**
 * Получение текущего местоположения по текущему городу
 */
function GetCurrentLocation()
{
	return 537;	//
	static $LOCATION_ID = 0;

	if(!$LOCATION_ID)
	{
		if(!CModule::IncludeModule("iblock") || !CModule::IncludeModule("sale"))
			return;

		$rs = CSaleLocation::GetList(
			array(),
			array("CITY_NAME" => GetCurCityName(), "LID" => LANGUAGE_ID),
			false,
			false
		);

		if($rs -> SelectedRowsCount())
		{
			$ar = $rs -> Fetch();
			
			$LOCATION_ID = $ar["ID"];
		}
	}
	
	return $LOCATION_ID;
}

/**
 * Возвращает код типа цены подходящей для выбранного города
 */
function GetCityPrice()
{
	static $PRICE_CODE = "";
	
	if(!$PRICE_CODE)
	{
		$CITY_ID = GetUserCity();
		
		if($CITY_ID)
		{
			$rs = CIBlockElement::GetList(array(), array("IBLOCK_ID" => 11, "PROPERTY_CITY_ID" => $CITY_ID), false, false, array("ID", "IBLOCK_ID", "PROPERTY_PRICE_CODE"));
			
			while($ar = $rs -> Fetch())
			{
				$PRICE_CODE = $ar["PROPERTY_PRICE_CODE_VALUE"];
				break;
			}
		}
	} 
	return $PRICE_CODE;
}

/**
 * Функция проверяет возможностсь работы каталога как интернет магазина
 */
function SetMarket()
{
	if(!defined("CITY_ID"))
	{
		define("IS_MARKET", false);
		define("HOUSE_ID", 0);
		return;
	}
	
	$rs = CIBlockElement::GetList(
		array(),
		array("IBLOCK_ID" => "6", "ID" => CITY_ID),
		false,
		false,
		array("ID", "IBLOCK_ID", "PROPERTY_MARKET")
	);
	
	$ar = $rs -> Fetch();
	
	if($ar["PROPERTY_MARKET_VALUE"] !== "Y")
	{
		define("IS_MARKET", false);
		define("HOUSE_ID", 0);
		
		return;
	}
	
	$rs = CIBlockElement::GetList(
		array(),
		array("IBLOCK_ID" => "11", "PROPERTY_WAREHOUSE_VALUE" => "Y"),
		false,
		false,
		array("ID", "IBLOCK_ID")
	);
	
	$ar = $rs -> Fetch();
	
	if(!$ar)
	{
		define("IS_MARKET", false);
		define("HOUSE_ID", 0);
	} else
	{
		define("IS_MARKET", true);
		define("HOUSE_ID", $ar["ID"]);
	}
}

/**
 * Проверка возможно ли бронирование позиции вв каком либо магазине и с каким либо размером
 * 
 * @param $ELEMENT_ID - идентификатор позиции каталога
 */
function IsAllowReserve($ELEMENT_ID)
{
	$ELEMENT_ID = intval($ELEMENT_ID);
	$bAllow = 0;
	if(!$ELEMENT_ID)
		return $bAllow;
	
	$cache = new CPHPCache;
	$CACHE_ID = CITY_ID . $ELEMENT_ID;
	$CACHE_TIME = 36000;
	
	if($cache -> StartDataCache($CACHE_TIME, $CACHE_ID, "/remains/"))
	{
		$rs = CIBlockElement::GetList(
			array(),
			array("IBLOCK_ID" => MARKET_IBLOCK_ID, "PROPERTY_CITY_ID" => CITY_ID),
			false,
			false,
			array("ID")
		);
		
		$arStack = array();
		while($ar = $rs -> Fetch())
			$arStack[] = $ar["ID"];

		$arFilter = array(
			"IBLOCK_ID" => REMAINS_IBLOCK_ID,
			"PROPERTY_ELEMENT_ID" => $ELEMENT_ID,
			"PROPERTY_MARKET_ID" => $arStack,
			"ACTIVE" => "Y",
			">PROPERTY_QUANTITY" => 0
		);
	
		$rs = CIBlockElement::GetList(
			array("PROPERTY_SIZE" => "ASC"),
			$arFilter,
			array("PROPERTY_SIZE_VALUE"),
			false,
			array("ID", "IBLOCK_ID", "PROPERTY_SIZE")
		);
			
		if($rs -> SelectedRowsCount())
			$bAllow = 1;
			
		$cache -> EndDataCache(array("bAllow" => $bAllow));
	} else
		extract($cache -> GetVars());
		
	return $bAllow;	
}

/**
 * Генератор паролей
 * 
 * @param $len - длина пароля который необходимо сгенерировать
 */
function GenPassword($len = 10)
{
	$len = intval($len);
	if(!$len)
		$len = 10;
	
	$sStr = 'zxcvbnmasdfghjklqwertyuiopZXCVBNMASDFGHJKLQWERTYUIOP1234567890';
	$sLen = strlen($sStr) - 1;
	$sPass = "";
	for($i = 0; $i < $len; $i ++)
	{
		$sRand = rand(0, $sLen);
		$sPass .= $sStr{$sRand};
	}
	
	return $sPass;
}

SetCity();
SetMarket();
?>