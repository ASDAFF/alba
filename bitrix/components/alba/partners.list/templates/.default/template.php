<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();?>
<section class="f_pagination">
    <div class="container">
        <ul class="fp clearfix main_font">
            <?$index = 0; foreach ($arResult["ITEMS"] as $id => $item) : ?>
                <?if ($item["CODE"] == $_GET["partner"]) : ?>
                    <li class="active"><a href="/partner/?partner=<?=$item["CODE"]?>"><?=++$index?></a></li>
                <?else : ?>
                    <li><a href="/partner/?partner=<?=$item["CODE"]?>"><?=++$index?></a></li>
                <?endif;?>
            <?endforeach;?>
        </ul>
    </div>
</section>
<?$item = $arResult["CURRENT"];?>
<div class="container secondary">
    <div class="clearfix pages_nav">
        <?if ($arResult["PAGINATION"]["PREV_ITEM"]) : ?>
            <a href="/partner/?partner=<?=$arResult["PAGINATION"]["PREV_ITEM"]?>" class="f_left prev_page">Назад</a>  
        <?endif;?>
        <?if ($arResult["PAGINATION"]["NEXT_ITEM"]) : ?>
            <a href="/partner/?partner=<?=$arResult["PAGINATION"]["NEXT_ITEM"]?>" class="f_right next_page">Дальше</a>
        <?endif;?>
    </div>
    <h1><?=$item["NAME"]?></h1>
    <?=$item["DETAIL_TEXT"]?>

    <div class="clearfix pages_nav">
        <?if ($arResult["PAGINATION"]["PREV_ITEM"]) : ?>
            <a href="/partner/?partner=<?=$arResult["PAGINATION"]["PREV_ITEM"]?>" class="f_left prev_page">Назад</a>  
        <?endif;?>
        <?if ($arResult["PAGINATION"]["NEXT_ITEM"]) : ?>
            <a href="/partner/?partner=<?=$arResult["PAGINATION"]["NEXT_ITEM"]?>" class="f_right next_page">Дальше</a>
        <?endif;?>
    </div>
</div>