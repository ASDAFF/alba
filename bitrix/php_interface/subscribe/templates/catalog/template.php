<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
global $SUBSCRIBE_TEMPLATE_RUBRIC;
$SUBSCRIBE_TEMPLATE_RUBRIC=$arRubric;
global $APPLICATION;
?>
<style type="text/css">
	*{border:0;margin:0;padding:0}
	a{color: #034587;text-decoration: underline}
	a:hover{text-decoration: none}
	body {background: #fff;font: .8125em/1.4 "Trebuchet MS", Arial, Helvetica, sans-serif;padding:30px}
	h1 {background: #000;color: #fff;font: 400 1.85em Arial, Helvetica, sans-serif;margin: 0 0 35px;padding: 1px 5px 2px;display: inline-block;#display:inline;#zoom:1}
	.b-clear:after{content:'';clear:both;display:block}
	.b-clear{#zoom:1}
	.b-cat_list{position:relative}
	.b-cat_list .item{width:120px; margin:30px 0 0; padding:0 0 0 5px; position:relative; display: inline-block; vertical-align: top; #display:inline; #zoom: 1}
	.b-hit{background:url(images/1.png) no-repeat -195px -263px; position:absolute; overflow:hidden; height:24px; width:24px; right:15px; top:0}
</style>
<?$SUBSCRIBE_TEMPLATE_RESULT = $APPLICATION->IncludeComponent(
	"custom:subscribe.news",
	"catalog",
	Array(
		"SITE_ID" => "s1",
		"IBLOCK_TYPE" => "CATALOG",
		"ID" => "9",
		"SORT_BY" => "ACTIVE_FROM",
		"SORT_ORDER" => "DESC",
	),
	null,
	array(
		"HIDE_ICONS" => "Y",
	)
);?><?
if($SUBSCRIBE_TEMPLATE_RESULT)
	return array(
		"SUBJECT"=>$SUBSCRIBE_TEMPLATE_RUBRIC["NAME"],
		"BODY_TYPE"=>"html",
		"CHARSET"=>"Windows-1251",
		"DIRECT_SEND"=>"Y",
		"FROM_FIELD"=>$SUBSCRIBE_TEMPLATE_RUBRIC["FROM_FIELD"],
	);
else
	return false;
?>