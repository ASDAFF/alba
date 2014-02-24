<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();?>
<!-- Content -->
<section class="gradient_box">
    <div class="container font1">
        <div class="wrapper steps pad1">
           <div class="f_left">
                <a href="<?=$_SESSION["BACK_URL_PUB"]?>" class="down">назад</a>
            </div>
        </div>
        <div class="single_news_box">
            <time date="2012-12-02" class="news_date"><?=$arResult["ITEM"]["DATE_CREATE"]?></time>
            <h1 class="news_title"><?=$arResult["ITEM"]["NAME"]?></h1>
        </div>
        <figure class="single_news_img">
            <img src="<?=$arResult["ITEM"]["PREVIEW_PICTURE"]?>" alt="">
        </figure>
        <?=$arResult["ITEM"]["DETAIL_TEXT"]?>
    </div>
</section>
<!-- ... -->