<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();?>
<? // require $_SERVER["DOCUMENT_ROOT"] . '/include/news.sections.php';?>
<!-- Content -->
<section class="gradient_box">
    <div class="container">
        <ul class="news_list">
            <?foreach ($arResult["ITEMS"] as $id => $item) :?>
            <li class="news_list__item" style="min-height: 400px;">
                <figure class="news_img">
                    <span class="spacer"></span>
                    <img src="<?=$item["PREVIEW_PICTURE"]?>" alt="">
                </figure>
                <div class="news_list__text">
                    <div class="bg_white new_list__text_inner">
                        <time date="2012-12-02" class="news_date"><?=$item["DATE_CREATE"]?></time>
                        <h2 class="news_title"><?=$item["NAME"]?></h2>
                    </div>
                    <div class="new_list__text_inner">
                        <p><?=$item["PREVIEW_TEXT"]?></p>
                        <a href="<?=$item["DETAIL_PAGE_URL"]?>" class="read_more_btn"><?=GetMessage("MORE_LINK")?></a>
                    </div>
                </div>
            </li>
            <?endforeach;?>
        </ul>
        <?if ($arResult["PAGINATION"]) : ?>
        <div class="clearfix pages_nav">
            <a href="#" class="f_left prev_page">Позже</a>
            <a href="#" class="f_right next_page">Раньше</a>
        </div>
        <?endif;?>
    </div>
</section>
<!-- ... -->