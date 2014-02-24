<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
if(!count($arResult))
	return;?>

<?$shown = false; foreach($arResult as $k => $arItem) : ?>
    <?if ($arItem["SELECTED"] == "Y") : $shown = true; ?>
        <div class="or toggle_menu__top">
            <a href="<?=$arItem["LINK"];?>" class="toggle_link" data-show=".toggle_menu_list"><?=str_replace(" ","&nbsp;",$arItem["TEXT"])?></a>
        </div>
    <?unset($arResult[$k]); endif;?>
<?endforeach;?>
<?if (!$shown) : $item = array_shift($arResult);?>
    <div class="or toggle_menu__top">
        <a href="<?=$item["LINK"];?>" class="toggle_link" data-show=".toggle_menu_list"><?=str_replace(" ","&nbsp;",$item["TEXT"])?></a>
    </div>
<?endif;?>
<ul class="toggle_menu_list">
    <?foreach($arResult as $k => $arItem) :?>
        <li class="toggle_menu__item"><a href="<?=$arItem["LINK"];?>"><?=str_replace(" ","&nbsp;",$arItem["TEXT"])?></a></li>
    <?endforeach;?>
</ul>