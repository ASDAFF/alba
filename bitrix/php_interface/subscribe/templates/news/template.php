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
	.b-news{padding:0 0 10px}
	.b-news dl{border-bottom:solid 1px #b1bdc7;padding:0 0 17px;line-height:1.7; margin:0 0 15px}
	.b-news dt{color:#46484f; font-size:.85em}
	.b-news .anons{color:#333; font-size:.9em}
	.b-news .img-left{border: solid 1px #000;float: left;margin: 5px 25px 10px 0;padding: 10px}
	.b-news .text{overflow:hidden}
	.b-news .title{padding:0 0 5px}
</style>
<div class="b-clear"><h1>Последние новости</h1></div>
<?$SUBSCRIBE_TEMPLATE_RESULT = $APPLICATION->IncludeComponent(
	"custom:subscribe.news",
	"",
	Array(
		"SITE_ID" => "s1",
		"IBLOCK_TYPE" => "PUBLICS",
		"ID" => "1",
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