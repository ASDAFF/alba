<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();?>
<? require $_SERVER["DOCUMENT_ROOT"] . '/include/collections.sections.php';?>
<!-- Content -->
<section class="gradient_box">
    <div class="container">
        
        <h1 class="collection_title breadcrump"><span><?=$arResult["ITEM"]["COLLECTION"]?></span> <?=$arResult["ITEM"]["NAME"]?></h1>
        
        <div class="icon_360">
            <img src="/images/360_icon.png" alt="">
        </div>
        
        <div class="single_collection__gallery">
            <a href="#" class="coll_gal_btn btn_prev" onclick="single_galery_prev(); return false"></a>
            <a href="#" class="coll_gal_btn btn_next" onclick="single_galery_next(); return false"></a>
            <ul id="single_galery">
                <?foreach ($arResult["ITEM"]["PHOTO"] as $id => $src) : ?>
                    <li><a href="#"><img src="<?=$src?>" alt=""></a></li>
                <?endforeach;?>
            </ul>
        </div>
        
        <div class="social_icons">
            
        </div>
        
        <div class="buy_box">
            <a href="#" class="buy_btn">купить в интернет-магазине </a>
        </div>
        
        <div class="find_link_wrap">
            <a href="#" class="find_link">проверить наличие в городе</a>
        </div>

        <ul class="product_description">
            <?foreach ($arResult["PROPERTIES"] as $code => $prop) : ?>
                <li class="wrapper product_row">
                    <div class="product_label"><?=$prop["NAME"]?>:</div>
                    <div class="product_info"><?=$prop["VALUE"]?></div>       
                </li>
            <?endforeach;?>
        </ul>

    </div>
</section>
<!-- ... -->