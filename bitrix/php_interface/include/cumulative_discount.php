<?

class CumulativeDiscount
{
	private static $IBLOCK_ID = "12";
	private static $PROPERTY_SUMM = "FROM_SUMM";
	private static $PROPERTY_GROUP = "GROUP_ID";
	
	public static function OnStatus($ID, $val)
	{			
		$USER_ID = self::GetUserIDByOrder($ID);
		
		$arDiscount = self::GetDiscountList();
		if(!$arDiscount)
			return true;
				
		$iSumm = self::CountOrderSumm($USER_ID);
		
		self::SetDiscount($USER_ID, $iSumm, $arDiscount);
	}
	
	public static function OnDelete($ID)
	{			
		$USER_ID = self::GetUserIDByOrder($ID);
		
		$arDiscount = self::GetDiscountList();
		if(!$arDiscount)
			return true;
				
		$iSumm = self::CountOrderSumm($USER_ID);
		self::SetDiscount($USER_ID, $iSumm, $arDiscount);
	}
	
	private static function SetDiscount($USER_ID, $iSumm, $arDiscount)
	{
		$GROUP_ID = 0;
		$arGroups = array();
		
		foreach($arDiscount as $ar)
		{
			if($iSumm >= $ar["PROPERTY_" . self::$PROPERTY_SUMM . "_VALUE"])
				$GROUP_ID = $ar["PROPERTY_" . self::$PROPERTY_GROUP . "_VALUE"];
			$arGroups[$ar["PROPERTY_" . self::$PROPERTY_GROUP . "_VALUE"]] = $ar["PROPERTY_" . self::$PROPERTY_GROUP . "_VALUE"];
		}
		
		$arUserGroups = CUser::GetUserGroup($USER_ID);
		
		foreach($arUserGroups as $k => $ID)
		{
			if($GROUP_ID !== $ID && isset($arGroups[$ID]))
				unset($arUserGroups[$k]);
		}
		
		if($GROUP_ID)
		{
			$arUserGroups[] = $GROUP_ID;
		}
		
		CUser::SetUserGroup($USER_ID, $arUserGroups);
	}
	
	private static function CountOrderSumm($USER_ID)
	{
		if(!CModule::IncludeModule("sale"))
			return false;
			
		$rs = CSaleOrder::GetList(
			array(),
			array(
				"USER_ID" => $USER_ID,
				"STATUS_ID" => "F"
			),
			false,
			false,
			array()
		);
		
		$iSumm = 0;
		while($ar = $rs -> Fetch())
		{
			if($ar["CURRENCY"] !== "RUB") continue;
			$iSumm += ($ar["PRICE"] - $ar["PRICE_DELIVERY"]);
		}
				
		return $iSumm;
	}
	
	/**
	 * Получение идентификатора пользователя по идентификатору его заказа
	 * 
	 * @param int $ID - идентфикатор заказа
	 */
	private static function GetUserIDByOrder($ID)
	{
		$ID = intval($ID);
		if(!CModule::IncludeModule("sale") || !$ID)
			return false;
			
		$ar = CSaleOrder::GetByID($ID);
		
		if($ar)
		{
			return $ar["USER_ID"];
		}
		
		return false;
	}
	
	/**
	 * Получение массива скидок
	 */
	private static function GetDiscountList()
	{
		if(!CModule::IncludeModule("iblock"))
			return false;
			
		$rs = CIBlockElement::GetList(
			array("PROPERTY_" . self::$PROPERTY_SUMM => "ASC"),
			array(
				"IBLOCK_ID" => self::$IBLOCK_ID,
				">PROPERTY_" . self::$PROPERTY_SUMM => "0",
				">PROPERTY_" . self::$PROPERTY_GROUP => "0"
			),
			false,
			false,
			array(
				"ID", "IBLOCK_ID", "PROEPRTY_" . self::$PROPERTY_SUMM, "PROPERTY_" . self::$PROPERTY_GROUP
			)
		);
		
		if($rs -> SelectedRowsCount())
		{
			$arResult = array();
			while($ar = $rs -> Fetch())
				$arResult[] = $ar;
			
			return $arResult;
		}
		
		return false;
	}

	/**
	 * Получение текущей скидки пользователя
	 * 
	 * @param int $USER_ID - идентификатор пользователя
	 */
	public static function GetUserDiscount($USER_ID)
	{
		global $USER;
		
		$arGroups = $USER -> GetUserGroup($USER_ID);
		$arDiscount = self::GetDiscountList();
		
		$iDiscount = 0;
		$GROUP_ID = "";
		
		foreach($arDiscount as $arItem)
		{
			if(in_array($arItem["PROPERTY_GROUP_ID_VALUE"], $arGroups))
				$GROUP_ID = $arItem["PROPERTY_GROUP_ID_VALUE"];
		}
		
		if($GROUP_ID && CModule::IncludeModule("catalog"))
		{
			$rs = CCatalogDiscount::GetDiscountGroupsList(array(), array("GROUP_ID" => $GROUP_ID));
			
			if($rs -> SelectedRowsCount())
			{
				$ar = $rs -> Fetch();
				
				$ar = CCatalogDiscount::GetByID($ar["DISCOUNT_ID"]);
				if($ar["VALUE_TYPE"] == "P")
					$iDiscount = intval($ar["VALUE"]);
			}
		}
		
		return $iDiscount;
	}
}

/**
 * Пользовательское свойство инфоблоков для привязки кода ссвойства к элементу
 * 
 * @author voitenko
 *
 */
class CUserPropertyGroupLink
{
	function GetUserTypeDescription()
	{
		return array(
			"PROPERTY_TYPE"	=> "S",
			"USER_TYPE"		=> "GROUP_LINK",
			"DESCRIPTION"	=> "Привязка к группе пользователей",
			//optional handlers
			//"CheckFields"	=> array("CUserPropertyLink","CheckFields"),
			//"GetLength"		=> array("CUserPropertyLink","GetLength"),
			//"ConvertToDB"	=> array("CIBlockPropertyMyDateTime","ConvertToDB"),
			//"ConvertFromDB"	=> array("CIBlockPropertyMyDateTime","ConvertFromDB"),
			"GetPropertyFieldHtml" => array("CUserPropertyGroupLink","GetPropertyFieldHtml"),
			//"GetAdminListViewHTML" => array("CUserPropertyLink","GetAdminListViewHTML"),
			//"GetPublicViewHTML"	=> array("CUserPropertyYn","GetPublicViewHTML"),
			//"GetPublicEditHTML"	=> array("CIBlockPropertyMyDateTime","GetPublicEditHTML"),
		);	
	}
	
	function GetPropertyFieldHtml($arProperty, $value, $strHTMLControlName)
	{

		if(!CModule::IncludeModule("iblock"))
			return;
		
		ob_start();
		$by = "sort";
		$order = "asc";
		
		$rs = CGroup::GetList($by, $order, array());
		?>
		<select name="<?=$strHTMLControlName["VALUE"];?>">
			<?while($ar = $rs -> Fetch()){?>
			<option value="<?=$ar["ID"];?>"<?if($ar["ID"] == $value["VALUE"]){?> selected<?}?>><?=$ar["NAME"];?></option>
			<?}?>
		</select>
		<?
		$return = ob_get_contents();
		ob_end_clean();

		return $return;
	}
}

// 
AddEventHandler("sale", "OnSaleStatusOrder", Array("CumulativeDiscount", "OnStatus"));
AddEventHandler("sale", "OnOrderDelete", Array("CumulativeDiscount", "OnDelete"));
AddEventHandler("iblock", "OnIBlockPropertyBuildList", 	Array("CUserPropertyGroupLink", "GetUserTypeDescription"));

?>