<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

/**
 * Функции для работы с корзиной
 */


/**
 * Добавление в корзину
 * аналогично системной функции Add2Basket за исключением использования кастомизированных функций обратного вызова
 * также в функции отключена статистика
 * 
 * @param $PRICE_ID
 * @param $QUANTITY
 * @param $arRewriteFields
 * @param $arProductParams
 */
function Add2BasketCustom($PRICE_ID, $QUANTITY = 1, $arRewriteFields=array(), $arProductParams = array())
{
	$PRICE_ID = IntVal($PRICE_ID);
	if ($PRICE_ID<=0) return false;
	$QUANTITY = DoubleVal($QUANTITY);
	if ($QUANTITY<=0) $QUANTITY = 1;

	if (!CModule::IncludeModule("sale"))
		return false;

	$arPrice = CPrice::GetByID($PRICE_ID);
	if ($arPrice===false) return false;

	$arCatalogProduct = CCatalogProduct::GetByID($arPrice["PRODUCT_ID"]);
	if ($arCatalogProduct["QUANTITY_TRACE"]=="Y" && DoubleVal($arCatalogProduct["QUANTITY"])<=0)
		return false;

//	$arProduct = GetIBlockElement($arPrice["PRODUCT_ID"]);
	$dbIBlockElement = CIBlockElement::GetList(
			array(),
			array(
					"ID" => $arPrice["PRODUCT_ID"],
					"ACTIVE_DATE" => "Y",
					"ACTIVE" => "Y",
					"CHECK_PERMISSIONS" => "Y"
				)
		);
	$arProduct = $dbIBlockElement->GetNext();

	$arProps = array();

	$dbIBlock = CIBlock::GetList(
			array(),
			array("ID" => $arProduct["IBLOCK_ID"])
		);
	if ($arIBlock = $dbIBlock->Fetch())
	{
		$arProps[] = array(
				"NAME" => "Catalog XML_ID",
				"CODE" => "CATALOG.XML_ID",
				"VALUE" => $arIBlock["XML_ID"]
			);
	}

	$arProps[] = array(
			"NAME" => "Product XML_ID",
			"CODE" => "PRODUCT.XML_ID",
			"VALUE" => $arProduct["XML_ID"]
		);
		
	$arFields = array(
			"PRODUCT_ID" => $arPrice["PRODUCT_ID"],
			"PRODUCT_PRICE_ID" => $PRICE_ID,
			"PRICE" => $arPrice["PRICE"],
			"CURRENCY" => $arPrice["CURRENCY"],
			"WEIGHT" => $arCatalogProduct["WEIGHT"],
			"QUANTITY" => $QUANTITY,
			"LID" => LANG,
			"DELAY" => "N",
			"CAN_BUY" => "Y",
			"NAME" => $arProduct["~NAME"],
			"CALLBACK_FUNC" => "CatalogBasketCustomCallback",
			"MODULE" => "catalog",
			"NOTES" => $arPrice["CATALOG_GROUP_NAME"],
			"ORDER_CALLBACK_FUNC" => "CatalogBasketOrderCustomCallback",
			"CANCEL_CALLBACK_FUNC" => "CatalogBasketCancelCallback",
			"PAY_CALLBACK_FUNC" => "CatalogPayOrderCallback",
			"DETAIL_PAGE_URL" => $arProduct["DETAIL_PAGE_URL"],
			"CATALOG_XML_ID" => $arIBlock["XML_ID"],
			"PRODUCT_XML_ID" => $arProduct["XML_ID"]
		);
		
	if ($arCatalogProduct["QUANTITY_TRACE"]=="Y")
	{
		if (DoubleVal($arCatalogProduct["QUANTITY"])-$QUANTITY<0)
			$arFields["QUANTITY"] = DoubleVal($arCatalogProduct["QUANTITY"]);
	}

	if (is_array($arProductParams) && count($arProductParams) > 0)
	{
		for ($i = 0; $i < count($arProductParams); $i++)
		{
			$arProps[] = array(
					"NAME" => $arProductParams[$i]["NAME"],
					"CODE" => $arProductParams[$i]["CODE"],
					"VALUE" => $arProductParams[$i]["VALUE"]
				);
		}
	}
	$arFields["PROPS"] = $arProps;

	if (is_array($arRewriteFields) && count($arRewriteFields)>0)
	{
		while(list($key, $value)=each($arRewriteFields)) $arFields[$key] = $value;
	}
	$addres = CSaleBasket::Add($arFields);

	return $addres;
}

/**
 * 
 * @param $productID
 * @param $quantity
 * @param $renewal
 */
function CatalogBasketOrderCustomCallback($productID, $quantity, $renewal = "N")
{
	$productID = IntVal($productID);
	$quantity = DoubleVal($quantity);
	$renewal = (($renewal == "Y") ? "Y" : "N");
	$arResult = array();

	if ($arCatalogProduct = CCatalogProduct::GetByID($productID))
	{
		if ($arCatalogProduct["QUANTITY_TRACE"]=="Y" && DoubleVal($arCatalogProduct["QUANTITY"])<doubleVal($quantity))
			return $arResult;
	}
	
	$rs = CPrice::GetList(array(), array("CATALOG_GROUP_NAME" => GetCityPrice(), "PRODUCT_ID" => $productID), false, false);
	
	$ar = $rs -> Fetch();
	
	$arPrice = array();
	$arPrice[] = array(
		"ID" => $ar["ID"],
		"PRICE" => $ar["PRICE"],
		"CURRENCY" => $ar["CURRENCY"],
		"CATALOG_GROUP_ID" => $ar["CATALOG_GROUP_ID"]
	);
	
	$arPrice = CCatalogProduct::GetOptimalPrice($productID, $quantity, $GLOBALS["USER"]->GetUserGroupArray(), $renewal, $arPrice);
	if (!$arPrice || count($arPrice) <= 0)
	{
		if ($nearestQuantity = CCatalogProduct::GetNearestQuantityPrice($productID, $quantity, $GLOBALS["USER"]->GetUserGroupArray()))
		{
			$quantity = $nearestQuantity;
			$arPrice = CCatalogProduct::GetOptimalPrice($productID, $quantity, $GLOBALS["USER"]->GetUserGroupArray(), $renewal);
		}
	}
	if (!$arPrice || count($arPrice) <= 0)
	{
		return $arResult;
	}

	$dbIBlockElement = CIBlockElement::GetList(
			array(),
			array(
					"ID" => $productID,
					"ACTIVE_DATE" => "Y",
					"ACTIVE" => "Y",
					"CHECK_PERMISSIONS" => "Y"
				)
		);
	$arProduct = $dbIBlockElement->GetNext();

	$currentPrice = $arPrice["PRICE"]["PRICE"];
	$currentDiscount = 0.0;
	
	//SIGURD: logic change. see mantiss 5036.
	// discount applied to a final price with VAT already included.
	if ($arPrice['PRICE']['VAT_INCLUDED'] == 'N')
	{
		if(DoubleVal($arPrice['PRICE']['VAT_RATE']) > 0)
		{
			$currentPrice *= (1 + $arPrice['PRICE']['VAT_RATE']);
			$arPrice['PRICE']['VAT_INCLUDED'] = 'Y';
		}
	}

	if (isset($arPrice["DISCOUNT"]) && count($arPrice["DISCOUNT"]) > 0)
	{
		if ($arPrice["DISCOUNT"]["VALUE_TYPE"]=="F")
		{
			if ($arPrice["DISCOUNT"]["CURRENCY"] == $arPrice["PRICE"]["CURRENCY"])
				$currentDiscount = $arPrice["DISCOUNT"]["VALUE"];
			else
				$currentDiscount = CCurrencyRates::ConvertCurrency($arPrice["DISCOUNT"]["VALUE"], $arPrice["DISCOUNT"]["CURRENCY"], $arPrice["PRICE"]["CURRENCY"]);
		}
		else
			$currentDiscount = $currentPrice * $arPrice["DISCOUNT"]["VALUE"] / 100.0;

		$currentDiscount = roundEx($currentDiscount, SALE_VALUE_PRECISION);

		if (DoubleVal($arPrice["DISCOUNT"]["MAX_DISCOUNT"]) > 0)
		{
			if ($arPrice["DISCOUNT"]["CURRENCY"] == $baseCurrency)
				$maxDiscount = $arPrice["DISCOUNT"]["MAX_DISCOUNT"];
			else
				$maxDiscount = CCurrencyRates::ConvertCurrency($arPrice["DISCOUNT"]["MAX_DISCOUNT"], $arPrice["DISCOUNT"]["CURRENCY"], $arPrice["PRICE"]["CURRENCY"]);
			$maxDiscount = roundEx($maxDiscount, CATALOG_VALUE_PRECISION);

			if ($currentDiscount > $maxDiscount)
				$currentDiscount = $maxDiscount;
		}
		
		$currentPrice = $currentPrice - $currentDiscount;
	}
	
	$arResult = array(
			"PRODUCT_PRICE_ID" => $arPrice["PRICE"]["ID"],
			"PRICE" => $currentPrice,
			"VAT_RATE" => $arPrice['PRICE']['VAT_RATE'],
			"CURRENCY" => $arPrice["PRICE"]["CURRENCY"],
			"QUANTITY" => $quantity,
			"WEIGHT" => 0,
			"NAME" => $arProduct["~NAME"],
			"CAN_BUY" => "Y",
			"NOTES" => $arPrice["PRICE"]["CATALOG_GROUP_NAME"],
			"DISCOUNT_PRICE" => $currentDiscount,
		);
	if(!empty($arPrice["DISCOUNT"]))
	{
		if(strlen($arPrice["DISCOUNT"]["COUPON"])>0)
			$arResult["DISCOUNT_COUPON"] = $arPrice["DISCOUNT"]["COUPON"];
			if($arPrice["DISCOUNT"]["VALUE_TYPE"]=="P")
				$arResult["DISCOUNT_VALUE"] = $arPrice["DISCOUNT"]["VALUE"]."%";
			else
				$arResult["DISCOUNT_VALUE"] = SaleFormatCurrency($arPrice["DISCOUNT"]["VALUE"], $arPrice["DISCOUNT"]["CURRENCY"]);
			$arResult["DISCOUNT_NAME"] = "[".$arPrice["DISCOUNT"]["ID"]."] ".$arPrice["DISCOUNT"]["NAME"];
			
		$dbCoupon = CCatalogDiscountCoupon::GetList(
			array(),
			array("COUPON" => $arPrice["DISCOUNT"]["COUPON"]),
			false,
			false,
			array("ID", "ONE_TIME")
		);
		if ($arCoupon = $dbCoupon->Fetch())
		{
			$arFieldsCoupon = Array("DATE_APPLY" => Date($GLOBALS["DB"]->DateFormatToPHP(CSite::GetDateFormat("FULL", SITE_ID))));

			if ($arCoupon["ONE_TIME"] == "Y")
			{
				$arFieldsCoupon["ACTIVE"] = "N";

				foreach($_SESSION["CATALOG_USER_COUPONS"] as $k => $v)
				{
					if(trim($v) == trim($arPrice["DISCOUNT"]["COUPON"]))
					{
						unset($_SESSION["CATALOG_USER_COUPONS"][$k]);
						$_SESSION["CATALOG_USER_COUPONS"][$k] == "";
					}
				}
			}

			CCatalogDiscountCoupon::Update($arCoupon["ID"], $arFieldsCoupon);
		}
	}

	if ($arCatalogProduct)
	{
		$arResult["WEIGHT"] = IntVal($arCatalogProduct["WEIGHT"]);
	}
	CCatalogProduct::QuantityTracer($productID, $quantity);
	
	return $arResult;
}

/**
 * Функция обратного вызова для корзины
 * аналогична функции CatalogBasketCallback за исключением использования одной определенной цены для конкретного города
 * 
 * @param $productID
 * @param $quantity
 * @param $renewal
 */
function CatalogBasketCustomCallback($productID, $quantity = 0, $renewal = "N")
{
	global $USER;

	$productID = IntVal($productID);
	$quantity = DoubleVal($quantity);
	$renewal = (($renewal == "Y") ? "Y" : "N");

	$arResult = array();

	if ($arCatalogProduct = CCatalogProduct::GetByID($productID))
	{
		if ($arCatalogProduct["QUANTITY_TRACE"]=="Y" && DoubleVal($arCatalogProduct["QUANTITY"])<=0)
			return $arResult;
		
	}

	$dbIBlockElement = CIBlockElement::GetList(
			array(),
			array(
					"ID" => $productID,
					"ACTIVE_DATE" => "Y",
					"ACTIVE" => "Y",
					"CHECK_PERMISSIONS" => "Y"
				)
		);
	$arProduct = $dbIBlockElement->GetNext();
	$arCatalog = CCatalog::GetByID($arProduct["IBLOCK_ID"]);
	if ($arCatalog["SUBSCRIPTION"] == "Y")
	{
		$quantity = 1;
	}
	$rs = CPrice::GetList(
		array(),
		array("CATALOG_GROUP_NAME" => GetCityPrice(), "PRODUCT_ID" => $productID), false, false);
	
	$ar = $rs -> Fetch();

	$arPrice = array();
	$arPrice[] = array(
		"ID" => $ar["ID"],
		"PRICE" => $ar["PRICE"],
		"CURRENCY" => $ar["CURRENCY"],
		"CATALOG_GROUP_ID" => $ar["CATALOG_GROUP_ID"]
	);

	$arPrice = CCatalogProduct::GetOptimalPrice($productID, $quantity, $USER -> GetUserGroupArray(), $renewal, $arPrice);

	if (!$arPrice || count($arPrice) <= 0)
	{
		if ($nearestQuantity = CCatalogProduct::GetNearestQuantityPrice($productID, $quantity, $USER->GetUserGroupArray()))
		{
			$quantity = $nearestQuantity;
			$arPrice = CCatalogProduct::GetOptimalPrice($productID, $quantity, $USER->GetUserGroupArray(), $renewal);
		}
	}

	if (!$arPrice || count($arPrice) <= 0)
	{
		return $arResult;
	}

	$currentPrice = $arPrice["PRICE"]["PRICE"];
	$currentDiscount = 0.0;

	//SIGURD: logic change. see mantiss 5036.
	// discount applied to a final price with VAT already included.
	if ($arPrice['PRICE']['VAT_INCLUDED'] == 'N')
	{
		if(DoubleVal($arPrice['PRICE']['VAT_RATE']) > 0)
		{
			$currentPrice *= (1 + $arPrice['PRICE']['VAT_RATE']);
			$arPrice['PRICE']['VAT_INCLUDED'] = 'y';
		}
	}

	if (isset($arPrice["DISCOUNT"]) && count($arPrice["DISCOUNT"]) > 0)
	{
		if ($arPrice["DISCOUNT"]["VALUE_TYPE"]=="F")
		{
			if ($arPrice["DISCOUNT"]["CURRENCY"] == $arPrice["PRICE"]["CURRENCY"])
				$currentDiscount = $arPrice["DISCOUNT"]["VALUE"];
			else
				$currentDiscount = CCurrencyRates::ConvertCurrency($arPrice["DISCOUNT"]["VALUE"], $arPrice["DISCOUNT"]["CURRENCY"], $arPrice["PRICE"]["CURRENCY"]);
		}
		else
			$currentDiscount = $currentPrice * $arPrice["DISCOUNT"]["VALUE"] / 100.0;

		$currentDiscount = roundEx($currentDiscount, SALE_VALUE_PRECISION);

		if (DoubleVal($arPrice["DISCOUNT"]["MAX_DISCOUNT"]) > 0)
		{
			if ($arPrice["DISCOUNT"]["CURRENCY"] == $baseCurrency)
				$maxDiscount = $arPrice["DISCOUNT"]["MAX_DISCOUNT"];
			else
				$maxDiscount = CCurrencyRates::ConvertCurrency($arPrice["DISCOUNT"]["MAX_DISCOUNT"], $arPrice["DISCOUNT"]["CURRENCY"], $arPrice["PRICE"]["CURRENCY"]);
			$maxDiscount = roundEx($maxDiscount, CATALOG_VALUE_PRECISION);

			if ($currentDiscount > $maxDiscount)
				$currentDiscount = $maxDiscount;
		}
		
		$currentPrice = $currentPrice - $currentDiscount;
	}

	$arResult = array(
			"PRODUCT_PRICE_ID" => $arPrice["PRICE"]["ID"],
			"PRICE" => $currentPrice,
			"VAT_RATE" => $arPrice['PRICE']['VAT_RATE'],
			"CURRENCY" => $arPrice["PRICE"]["CURRENCY"],
			"QUANTITY" => $quantity,
			"DISCOUNT_PRICE" => $currentDiscount,
			"WEIGHT" => 0,
			"NAME" => $arProduct["~NAME"],
			"CAN_BUY" => "Y",
			"NOTES" => $arPrice["PRICE"]["CATALOG_GROUP_NAME"]
		);

	if ($arCatalogProduct)
	{
		$arResult["WEIGHT"] = IntVal($arCatalogProduct["WEIGHT"]);
		if ($arCatalogProduct["QUANTITY_TRACE"]=="Y")
		{
			if ((DoubleVal($arCatalogProduct["QUANTITY"]) - $quantity) < 0)
				$arResult["QUANTITY"] = DoubleVal($arCatalogProduct["QUANTITY"]);
		}
	}

	//echo '<pre>arResult: '; print_r($arResult); echo '</pre>';
	return $arResult;
}
?>