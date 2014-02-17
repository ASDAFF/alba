<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();?>
<!--mobile copy-->
<section id="m_lookbook" class="d_none d_xs_block">
</section>
<!--lookbook-->
<section class="lookbook d_xs_none">
    <div class="container relative">
        <div class="lookbook_list clearfix">
            <?foreach ($arResult["ITEMS"] as $id => $item) : ?>    
                <div class="carousel-item">
                    <div class="normal-image" style="background: url('<?=$item["PREVIEW_PICTURE"]?>') center center no-repeat;">
                        <div class="hover_container t_align_r">
                            <ul class="shop_mini_section t_align_left clearfix">
                                <li><?=$item["NAME"]?><a href="<?=$item["DETAIL_PAGE_URL"]?>" class="button_type_2"><?=GetMessage("BUY")?></a></li>
                            </ul>

                            <div class="social_icons_wrap clearfix">
                                <ul class="social_icons f_right clearfix">
                                    <li class="fb"><a href="#"><img src="/images/si_fb.jpg" alt=""></a></li>
                                    <li class="vk"><a href="#"><img src="/images/si_vk.jpg" alt=""></a></li>
                                    <li class="tw"><a href="#"><img src="/images/si_tw.jpg" alt=""></a></li>
                                    <li class="in"><a href="#"><img src="/images/si_in.jpg" alt=""></a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            <?endforeach;?>
        </div>
        <div class="pattern_right"></div>
        <div class="pattern_left"></div>
        <div class="bottom_arrow lb">
            <img class="f_chrome" src="/images/arrow_bottom_icon.png" alt="">
        </div>
    </div>
</section>