<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();?>
<!-- Content -->
<section class="gradient_box m_top">
    <div class="container font1">

        <div class="wrapper map_box">
            <ul class="maps_list f_xs_none">
                <?foreach ($arResult["CITIES"] as $city) : ?>
                    <?if (isset($_GET["CITY"]) && $_GET["CITY"] == $city["ID"]) : ?>
                        <li><a class="active" href="#"><?=$city["NAME"]?></a></li>
                    <?else : ?>
                        <li><a href="/our_shops/?CITY=<?=$city["ID"]?>"><?=$city["NAME"]?></a></li>
                    <?endif;?>
                <?endforeach;?>

            </ul>
            <div class="wrapper map">
                <div class="map_filter">
                    <a href="#" class="active">карта</a>
                    <a href="#">метро</a>
                </div>
                <?$APPLICATION->IncludeComponent("bitrix:map.google.view", ".default", array(
                        "INIT_MAP_TYPE" => "ROADMAP",
                        "MAP_DATA" => serialize(
                            array(
                                'google_lat' => $arResult["DEFAULT_COORD"]["LAT"],
                                'google_lon' => $arResult["DEFAULT_COORD"]["LNG"],
                                'google_scale' => 5,
                                'PLACEMARKS' => $arResult["MARKS"]
                            )
                        ),
                        "MAP_WIDTH" => "660",
                        "MAP_HEIGHT" => "495",
                        "CONTROLS" => array(
                            0 => "SMALL_ZOOM_CONTROL",
                            1 => "TYPECONTROL",
                            2 => "SCALELINE",
                        ),
                        "OPTIONS" => array(
                            0 => "ENABLE_SCROLL_ZOOM",
                            1 => "ENABLE_DBLCLICK_ZOOM",
                            2 => "ENABLE_DRAGGING",
                            3 => "ENABLE_KEYBOARD",
                        ),
                        "MAP_ID" => ""
                    ),
                    false
                );?>
            </div>
        </div>
        <!-- Adress Box END -->

        <ul class="address_list">
            <?foreach ($arResult["SHOPS"] as $sectionShop) : ?>
                <li class="wrapper address_list__item">
                <?foreach ($sectionShop as $k => $shop) :?>
                    <div class="address_list___<?=($k === 1) ? 'right_col' : 'left_col'?> f_xs_none">
                        <h2 class="address_title"><?=$shop["NAME"]?></h2>
                        <dl class="address">
                            <dd>Станция метро: <?=$shop["NAME"]?><dd>
                            <dd><?=$shop["PROPERTY_ADDRESS_VALUE"]?></dd>
                            <dd>Тел. (495) 649 70 82</dd>
                            <dd>Режим работы: с 10:00 до 22:00</dd>
                        </dl>
                        <a href="#" class="map_link">на карте</a>
                    </div>
                <?endforeach;?>
            </li>
        <?endforeach;?>
    </div>
</section>
<!-- ... -->