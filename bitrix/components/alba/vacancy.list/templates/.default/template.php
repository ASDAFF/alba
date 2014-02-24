<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();?>
<!-- Content -->
<?
//$obCity = new CCity();
//$arCity = $obCity->GetFullInfo();
//var_dump($arCity);
?>

<section class="gradient_box type_2">
    <div class="container secondary">
        <?$APPLICATION->IncludeFile(
            $APPLICATION->GetTemplatePath("/new_includes/vacancy_top.php"),
            Array(),
            Array("MODE"=>"html")
        );?>

        <div class="toggle_container m_bottom_45">
            <div class="clearfix m_bottom_15">
                <h3 class="f_left vacancy_title"><?=GetMessage("TABLE_VACANCY")?></h3>
                <h3 class="f_right vacancy_title"><?=GetMessage("TABLE_REGION")?></h3>
            </div>
            <dl class="toggle vacancy">
                <?foreach ($arResult["ITEMS"] as $id => $item) : ?>
                <dt>
                    <div class="clearfix">
                        <span class="f_left tv_title"><?=$item["NAME"]?></span>
                        <span class="f_right tv_region"><?=$item["REGION"]?></span>
                    </div>
                </dt>
                <dd style="display:none;">
                    <?=$item["PREVIEW_TEXT"]?>
                    <div class="clearfix m_bottom_35"></div>
                    <a href="#" role="button" class="button_type_1 bold f_size_small"><?=GetMessage("RESPOND_VACANCY")?></a>
                </dd>
                <?endforeach;?>
            </dl>
        </div>
        <?$APPLICATION->IncludeFile(
            $APPLICATION->GetTemplatePath("/new_includes/vacancy_bottom.php"),
            Array(),
            Array("MODE"=>"html")
        );?>
    </div>
</section>