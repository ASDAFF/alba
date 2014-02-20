<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
if(!count($arResult))
	return;?>

<nav role="navigation">
	<ul class="menu clearfix">
	<?
	$cnt = count($arResult) - 1;
	foreach($arResult as $k => $arItem) : ?>
		<? if($arItem["PERMISSION"] <= "D") continue; ?>
		<li><a href="<?=$arItem["LINK"];?>"><?=str_replace(" ","&nbsp;",$arItem["TEXT"])?></a></li>
	<?endforeach;?>
	</ul>
</nav>
