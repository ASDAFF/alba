<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();?>
<div class="about_red_box">
    <ul class="histor_list">
        <?$index = false; foreach ($arResult["ITEMS"] as $year => $item) : ?>
            <li <?if (!$index) : ?>class="current or"<?$index = true; endif;?>><a style="color: #ffffff;" href="javascript:;" class="select_year" data-year="<?=$year?>"><?=$year?></a> </li>
        <?endforeach;?>
<!--        <li class="current or">2003</li>-->
    </ul>
</div>
<?$index = false; foreach ($arResult["ITEMS"] as $year => $item) : ?>
    <div class="container history_block <?=$year?>" <?if (!$index) : ?>style="display: block;"<?$index = true; else:?>style="display: none;"<?endif;?>>
        <?=$item["PREVIEW_TEXT"]?>
    </div>
<?endforeach;?>