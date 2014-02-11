<?
class WIBlockTools
{
	public static $CACHE_TIME = 10800;
	public static $CACHE_DIR = "tools";
	
	/**
	 * Получение идентификатора информационного блока по его коду
	 * для нормальной работы необходимо чтобы у информационных блоков были уникальные коды
	 * 
	 * @param string $CODE - код иформационного блока
	 * @param string $TYPE_ID - тип информационных блоков в котором будет выполнятся поиск, необязательное по умолчани false - все типы
	 */
	public static function GetIBlockIdByCode($CODE, $TYPE_ID = false)
	{
		static $arCache;
		
		$CACHE_ID = "iblock";
		if($TYPE_ID)
			$CACHE_ID .= $TYPE_ID;

		if(isset($arCache[$CACHE_ID][$CODE]))
			return $arCache[$CACHE_ID][$CODE];
				
		if(!$CODE || !CModule::IncludeModule("iblock"))
			return false;
			
		$cache = new CPHPCache;
		if($cache -> StartDataCache(self::$CACHE_TIME, $CACHE_ID, self::$CACHE_DIR . '/' . SITE_ID))
		{
			$arIds = array();
			$arFilter = array("ACTIVE" => "Y", "CHECK_PERMISSIONS" => "Y");
			if($TYPE_ID)
				$arFilter["TYPE"] = $TYPE_ID;
				
			$rsIBlock = CIBlock::GetList(array(), $arFilter);
			while($arr = $rsIBlock -> Fetch())
				$arIds[$arr["CODE"]] = $arr["ID"];
				
			$cache -> EndDataCache(array("arIds" => $arIds));
		} else 
			extract($cache -> GetVars());
		
		$arCache[$CACHE_ID] = $arIds;
			
		if(isset($arIds[$CODE]))
			return $arIds[$CODE];
			
		return false;
	}
	
	/**
	 * Функция проверяет есть ли у такого раздела подразделы
	 * 
	 * @param int $SECTION_ID - идентификатор раздела информационного блока
	 * @return bool - false если нет подразделов и true если они есть
	 **/
	public static function IsCategory($SECTION_ID)
	{
		static $arCache;
		
		$SECTION_ID = intval($SECTION_ID);
		if(!$SECTION_ID || !CModule::IncludeModule("iblock"))
			return false;
			
		if(isset($arCache[$SECTION_ID]))
			return $arCache[$SECTION_ID];

		$arFilter = array(
			"ACTIVE" => "Y",
			"GLOBAL_ACTIVE" => "Y",
			"SECTION_ID" => $SECTION_ID
		);
		
		$rsSection = CIBlockSection::GetList(array(), $arFilter);
		$arCache[$SECTION_ID] = ($rsSection -> SelectedRowsCount() > 0);
		
		return $arCache[$SECTION_ID];
	}
	
	public static function MakeIBlockUrl(&$arIblock)
	{		
		$arIblock["LIST_PAGE_URL"] = str_replace(
			array("#IBLOCK_CODE#", "#ID#"),
			array($arIblock["CODE"], $arIblock["ID"]),
			$arIblock["LIST_PAGE_URL"]
		);
	}
	
	/**
	 * Функция вернет кол-во сввязанных элементов
	 * 
	 * @param int $ELEMENT_ID - идентификатор элемента
	 * @param int $IBLOCK_ID - идентификатор инфоблока не обязательный, по умолчанию все
	 * @param string $PROPERTY_NAME - код свойства в котором должен хранится идентфикатор элемента
	 */
	public static function GetLinkedCount($ELEMENT_ID, $IBLOCK_ID = false, $PROPERTY_NAME = "ELEMENT_ID")
	{
		if(!CModule::IncludeModule("iblock"))
			return 0;
			
		$IBLOCK_ID = intval($IBLOCK_ID);
		$ELEMENT_ID = intval($ELEMENT_ID);
		$PROPERTY_NAME = trim($PROPERTY_NAME);
		
		if(!$ELEMENT_ID || !$PROPERTY_NAME)
			return 0;
			
		$arFilter = array(
			"PROPERTY_" . $PROPERTY_NAME => $ELEMENT_ID
		);
		
		if($IBLOCK_ID)
			$arFilter["IBLOCK_ID"] = $IBLOCK_ID;
		
		$rs = CIBlockElement::GetList(array(), $arFilter);
		
		return $rs -> SelectedRowsCount();
	}
	
	public static function GetElementName($ID)
	{
		if(!CModule::IncludeModule("iblock") || !intval($ID))
			return;
			
		$rs = CIBlockElement::GetByID($ID);
		if($rs -> SelectedRowsCount())
		{
			$ar = $rs -> Fetch();
			
			return $ar["NAME"];
		}
		return;
	}
}
?>