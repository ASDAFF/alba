<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
if(!count($arResult))
	return;?>

<!-- Secondary Menu -->
<section class="secondary_nav">
    <div class="container">
        <nav role="secondary_navigation">
            <ul class="secondary_menu clearfix">
                <? foreach($arResult as $k => $arItem) : ?>
                    <?if ($arItem["SELECTED"] == "Y") : ?>
                        <li class="current"><a href="<?=$arItem["LINK"];?>"><?=str_replace(" ","&nbsp;",$arItem["TEXT"])?></a>
                            <ul>
                                <?foreach ($arParams["SUBMENU"] as $id => $section) : ?>
                                    <!-- <li class="current"><a href="#">Nude</a></li> -->
                                    <?if ($_GET["SECTION_CODE"] == $section["CODE"] || $_GET["COLLECTION_CODE"] == $section["CODE"]) : ?>
                                        <li class="current"><a href="<?=$section["SECTION_PAGE_URL"]?>"><?=$section["NAME"]?></a></li>
                                    <?else : ?>
                                        <li><a href="<?=$section["SECTION_PAGE_URL"]?>"><?=$section["NAME"]?></a></li>
                                    <?endif;?>
                                <?endforeach;?>
                            </ul>
                        </li>
                    <?else : ?>
                        <li><a href="<?=$arItem["LINK"];?>"><?=str_replace(" ","&nbsp;",$arItem["TEXT"])?></a></li>
                    <?endif;?>
                <?endforeach;?>
            </ul>
        </nav>
    </div>
</section>
<!-- ... -->