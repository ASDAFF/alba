<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();?>

<!-- Content -->
<section class="gradient_box">
    <div class="container secondary">
        <div class="clearfix pages_nav">
            <?if ($arResult["PAGINATION"]["PREV_ITEM"]) : ?>
                <a href="/trends/detail.php?ELEMENT_CODE=<?=$arResult["PAGINATION"]["PREV_ITEM"]?>" class="f_left prev_page">Назад</a>
            <?endif;?>
            <?if ($arResult["PAGINATION"]["NEXT_ITEM"]) : ?>
                <a href="/trends/detail.php?ELEMENT_CODE=<?=$arResult["PAGINATION"]["NEXT_ITEM"]?>" class="f_right next_page">Дальше</a>
            <?endif;?>
        </div>
        <article>
            <p class="p_bottom_0 m_bottom_15"><?=$arResult["CURRENT"]["DATE_CREATE"]?></p>
            <h3 class="color_black m_bottom_30"><?=$arResult["CURRENT"]["NAME"]?></h3>
            <img class="m_bottom_45" src="<?=$arResult["CURRENT"]["DETAIL_PICTURE"]?>" alt="">
            <?=$arResult["CURRENT"]["DETAIL_TEXT"]?>
        </article>
    </div>
</section>
<!-- ... -->