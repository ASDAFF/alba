<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();?>
<!-- Content -->
<section class="gradient_box m_top" style="margin-top: 0;">
    <div class="container secondary">
        <div class="clearfix">
            <?foreach ($arResult["ITEMS"] as $kol => $items) : ?>
            <div class="f_left trend_column f_xs_none <?if ($kol == 1) : ?>type_2<?endif;?>">
                <!--trend item-->
                <?foreach ($items as $id => $item) : ?>
                <figure class="trend_item">
                    <figcaption class="color_white">
                        <p class="p_bottom_0"><?=$item["DATE_CREATE"]?></p>
                        <h3 class="color_white"><?=$item["NAME"]?></h3>
                    </figcaption>
                    <div class="relative trend_item_img">
                        <img src="<?=$item["DETAIL_PICTURE"]?>" alt="">
                        <a href="<?=$item["DETAIL_PAGE_URL"]?>" role="button" class="button_type_1"><?=GetMessage('MORE_LINK')?></a>
                    </div>
                </figure>
                <?endforeach;?>
            </div>
            <?endforeach;?>
        </div>
        <div class="clearfix pages_nav">
            <?if ($arResult["PAGINATION"]["PREV"]) :?>
                <a href="<?=$arResult["PAGINATION"]["PREV"]?>" class="f_left prev_page">Позже</a>
            <?endif;?>
            <?if ($arResult["PAGINATION"]["NEXT"]) : ?>
                <a href="<?=$arResult["PAGINATION"]["NEXT"]?>" class="f_right next_page">Раньше</a>
            <?endif;?>
        </div>
    </div>
</section>
<!-- ... -->