<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();?>
<? require $_SERVER["DOCUMENT_ROOT"] . '/include/collections.sections.php';?>
<!-- Content -->
<section class="gradient_box">
    <div class="container p_rel">
        <a href="#" class="banner extra_banner d_xs_none">Смотреть всю коллекцию</a>
        <h1 class="collection_title"><?=$arResult["SECTION"]["NAME"]?></h1>
        <ul class="collection_list">
            <li class="collection_row m_bottom_20">
                <? foreach ($arResult["ITEMS"] as $id => $item) : ?>
                    <div class="collection_item f_xs_none m_bottom_20">
                        <figure>
                            <img src="<?=$item["PREVIEW_PICTURE"]?>" alt="">
                        </figure>
                        <div class="collection_item__title">
                            <a href="<?=$item["DETAIL_PAGE_URL"]?>" class="collection_btn"><?GetMessage("MORE_LINK")?></a>
                        </div>
                    </div>
                <? endforeach; ?>
                <!-- <div class="collection_item f_xs_none m_bottom_20">
                    <figure>
                        <img src="images/collection_img2.jpg" alt="">
                    </figure>
                    <div class="collection_item__title">
                        <a href="single_collection.html" class="collection_btn">подробнее</a>
                    </div>
                </div>
                <div class="collection_item f_xs_none">
                    <figure>
                        <img src="images/collection_img3.jpg" alt="">
                    </figure>
                    <div class="collection_item__title">
                        <a href="single_collection.html" class="collection_btn">подробнее</a>
                    </div>
                </div> -->
            </li>
            <!-- <li class="collection_row ">
                <div class="collection_item f_xs_none m_bottom_20">
                    <figure>
                        <img src="images/collection_img4.jpg" alt="">
                    </figure>
                    <div class="collection_item__title">
                        <a href="single_collection.html" class="collection_btn">подробнее</a>
                    </div>
                </div>
                <div class="collection_item f_xs_none m_bottom_20">
                    <figure>
                        <img src="images/collection_img5.jpg" alt="">
                    </figure>
                    <div class="collection_item__title">
                        <a href="single_collection.html" class="collection_btn">подробнее</a>
                    </div>
                </div>
                <div class="collection_item f_xs_none">
                    <figure>
                        <img src="images/collection_img6.jpg" alt="">
                    </figure>
                    <div class="collection_item__title">
                        <a href="single_collection.html" class="collection_btn">подробнее</a>
                    </div>
                </div>
            </li> -->
        </ul>
    </div>
</section>
<!-- ... -->