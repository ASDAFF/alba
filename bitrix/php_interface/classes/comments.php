<?
/**
 * 
 * @author voitenko
 *
 */
class WICatalogComments
{
	public static $IBLOCK_ID = "8";
	public static $PROPERTY_COUNT = "VOTE_COUNT";
	public static $PROPERTY_RATING = "RATING";
	private static $IBLOCK_TYPE_COMMENT = "INTERACTIVE";
		
	/**
	 * Пересчитывает рейтинг позиции к которой был добавлен комментарий
	 * 
	 * @param array $arFields
	 */
	public static function OnAfterElementAdd(&$arFields)
	{
		if(!self::CheckIBlock($arFields))
			return;
			
		$ID = $arFields["ID"];
		
		if(!$ID) return;
			
		$obElement = CIBlockElement::GetByID($ID) -> GetNextElement();
		$arProps = $obElement -> GetProperties();
		
		if($arProps["ELEMENT_ID"]["VALUE"])
			self::ReIndexElement($arProps["ELEMENT_ID"]["VALUE"]);
	}
	
	public static function OnBeforeElementUpdate(&$arFields)
	{
		global $APPLICATION;

		if(self::CheckIBlock($arFields))
		{
			$APPLICATION -> throwException("Редактирование комментариев запрещенно");
			return false;
		}
	}
	
	/**
	 * Пересчитывает рейтинг позиции после обновления комментария
	 * 
	 * на самом деле редактирование должно быть запрещенно
	 * 
	 * @param array $arFields
	 */
	public static function OnAfterElementUpdate(&$arFields)
	{
		if(!self::CheckIBlock($arFields))
			return;
			
		$ID = $arFields["ID"];
		if(!$ID) return;
		
		$obElement = CIBlockElement::GetByID($ID) -> GetNextElement();
		$arProps = $obElement -> GetProperties();
		
		if($arProps["ELEMENT_ID"]["VALUE"])
			self::ReIndexElement($arProps["ELEMENT_ID"]["VALUE"]);
	}
	
	/**
	 * Пересчитывает рейтинг элемента привязанного к комментарию перед удалением комментария
	 * 
	 * @param int $ID - ид комментария который будет удален
	 */
	public static function OnBeforeElementDelete($ID)
	{
		$ID = intval($ID);
		if(!$ID) return false;
			
		$obElement = CIBlockElement::GetByID($ID) -> GetNextElement();
		
		$arProps = $obElement -> GetProperties();
		$arItem = $obElement -> GetFields();
			
		if(!self::CheckIBlock($arItem["IBLOCK_ID"]))
			return;
		
		if($arProps["ELEMENT_ID"]["VALUE"])
			self::ReIndexElement($arProps["ELEMENT_ID"]["VALUE"], $ID);
	}
	
	/**
	 * Проверяет нужный ли инфоблок для работы
	 * также подключает модуль инфоблоков
	 * 
	 * @param mixed $arFields - массив полей или идентификатор инфоблока
	 */
	protected function CheckIBlock($var)
	{
		if(!CModule::IncludeModule("iblock"))
			return false;
			
		if(is_array($var))
			return ($var["IBLOCK_ID"] == self::$IBLOCK_ID);
		else 
			return ($var == self::$IBLOCK_ID);
			
		return false;
	}
	
	/**
	 * Пересчитывает кол-во комментариев к позиции и ее рейинг
	 * 
	 * @param int $ELEMENT_ID - идентификатор элемента информационного блока
	 */
	protected function ReIndexElement($ELEMENT_ID, $EXCLUDE_ID = false)
	{
		$ELEMENT_ID = intval($ELEMENT_ID);
		$EXCLUDE_ID = intval($EXCLUDE_ID);
		
		if(!$ELEMENT_ID)
			return;
			
		$arFilter = array(
			"IBLOCK_ID" => self::$IBLOCK_ID,
			"ACTIVE" => "Y",
			"PROPERTY_ELEMENT_ID" => $ELEMENT_ID,
		);
		
		if($EXCLUDE_ID)
			$arFilter["!ID"] = $EXCLUDE_ID;
		
		$rsElement = CIBlockElement::GetList(array(), $arFilter);
		
		$arResult = array(
			"COUNT" => 0,
			"VOTES_COUNT" => 0,
			"RATING" => 0,
		);
		if($rsElement -> SelectedRowsCount())
		{
			while($obElement = $rsElement -> GetNextElement())
			{
				$arFields = $obElement -> GetFields();
								
				$rating = 0;
				$arProp = $obElement -> GetProperties();
				
				if(floatval($arProp["RATING"]["VALUE"]) > 0)
					$arResult["RATING"] += floatval($arProp["RATING"]["VALUE"]);
					
				$arResult["VOTES_COUNT"] ++;		
			}
			$arResult["RATING"] = round(($arResult["RATING"] / $arResult["VOTES_COUNT"]), 1);
		}
		CIBlockElement::SetPropertyValueCode($ELEMENT_ID, self::$PROPERTY_COUNT, $arResult["VOTES_COUNT"]);
		CIBlockElement::SetPropertyValueCode($ELEMENT_ID, self::$PROPERTY_RATING, $arResult["RATING"]);
	}
	
	/**
	 * Проверяет оставлял ли пользователь комментарий к позиции каталога
	 * 
	 * @param int $ELEMENT_ID - идентфикатор позиции каталога
	 * @param int $USER_ID - идентификатор пользователя, если не задан = текущему пользователю
	 */
	public static function IsUserComment($ELEMENT_ID, $USER_ID = false)
	{
		global $USER;
		
		if(!CModule::IncludeModule("iblock"))
			return false;
		
		$ELEMENT_ID = intval($ELEMENT_ID);
		$USER_ID = intval($USER_ID);
		
		if(!$USER_ID)
			$USER_ID = $USER -> GetID();
			
		if(!$ELEMENT_ID)
			return;
			
		$arFilter = array(
			"IBLOCK_ID" => self::$IBLOCK_ID,
			"CREATED_BY" => $USER_ID,
			"PROPERTY_ELEMENT_ID" => $ELEMENT_ID
		);
		
		$rs = CIBlockElement::GetList(array(), $arFilter);
		
		return $rs -> SelectedRowsCount();
	}
	
	public static function ElementAllowComment($ELEMENT_ID)
	{
		$ELEMENT_ID = intval($ELEMENT_ID);
		if(!$ELEMENT_ID || !CModule::IncludeModule("iblock"))
			return false;
			
		$rs = CIBlockElement::GetByID($ELEMENT_ID);
		if(!$rs -> SelectedRowsCount())
			return false;
			
		$ar = $rs -> Fetch();
		if($ar["IBLOCK_TYPE_ID"] !== self::$IBLOCK_TYPE_COMMENT)
			return false;
		
		return true;
	}
}
?>