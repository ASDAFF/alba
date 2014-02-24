<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();?>
<!-- Content -->
<?
foreach ($arResult["MARKS"] as $mark) {
    $marks[] = array($mark["LAT"], $mark["LON"]);
    $baloons[] = $mark["TEXT"];
}
$baloons = json_encode($baloons);
$marks = json_encode($marks);

?>

<script src="http://api-maps.yandex.ru/2.0-stable/?load=package.standard&lang=ru-RU" type="text/javascript"></script>
<script type="text/javascript">
    ymaps.ready(init);
    var myMap,
        coords = <?=$marks?>,
        baloons = <?=$baloons?>;

    function init(){
        myMap = new ymaps.Map ("map", {
            center: [<?=$arResult["DEFAULT_COORD"]["LAT"]?>, <?=$arResult["DEFAULT_COORD"]["LNG"]?>],
            zoom: 10
        });

        myMap.controls
            // Кнопка изменения масштаба.
            .add('zoomControl', { left: 5, top: 5 })
            // Список типов карты
            .add('typeSelector')
            // Стандартный набор кнопок
            .add('mapTools', { left: 35, top: 5 });

        myCollection = new ymaps.GeoObjectCollection({}, {
            preset: 'twirl#blueIcon', //все метки красные
            draggable: false // и их можно перемещать
        });
        // или myCollection = new ymaps.GeoObjectArray(...);

        for (var i = 0; i < coords.length; i++) {
            if (coords[i]) {
                myCollection.add(new ymaps.Placemark(coords[i], {iconContent: i, balloonContent: baloons[i] }));
            }
        }

        myMap.geoObjects.add(myCollection);
    }
</script>
<section class="gradient_box m_top">
    <div class="container font1">

        <div class="wrapper map_box">
            <ul class="maps_list f_xs_none">
                <?$index = 0; foreach ($arResult["CITIES"] as $city) : ?>
                    <?if ((isset($_GET["CITY"]) && $_GET["CITY"] == $city["ID"]) || (!isset($_GET["CITY"]) && ++$index == 1)) : ?>
                        <li><a class="active" href="#"><?=$city["NAME"]?></a></li>
                    <?else : ?>
                        <li><a href="/our_shops/?CITY=<?=$city["ID"]?>"><?=$city["NAME"]?></a></li>
                    <?endif;?>
                <?endforeach;?>

            </ul>
            <div class="wrapper map">
                <div class="map_filter">
                    <a href="#" class="active">карта</a>
<!--                    <a href="#">метро</a>-->
                </div>
                <div id="map" style="width: 600px; height: 500px"></div>
<!--                --><?//$APPLICATION->IncludeComponent("bitrix:map.google.view", ".default", array(
//                        "INIT_MAP_TYPE" => "ROADMAP",
//                        "MAP_DATA" => serialize(
//                            array(
//                                'google_lat' => $arResult["DEFAULT_COORD"]["LAT"],
//                                'google_lon' => $arResult["DEFAULT_COORD"]["LNG"],
//                                'google_scale' => 9,
//                                'PLACEMARKS' => $arResult["MARKS"]
//                            )
//                        ),
//                        "MAP_WIDTH" => "660",
//                        "MAP_HEIGHT" => "495",
//                        "CONTROLS" => array(
//                            0 => "SMALL_ZOOM_CONTROL",
//                            1 => "TYPECONTROL",
//                            2 => "SCALELINE",
//                        ),
//                        "OPTIONS" => array(
//                            0 => "ENABLE_SCROLL_ZOOM",
//                            1 => "ENABLE_DBLCLICK_ZOOM",
//                            2 => "ENABLE_DRAGGING",
//                            3 => "ENABLE_KEYBOARD",
//                        ),
//                        "MAP_ID" => ""
//                    ),
//                    false
//                );?>
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
                            <?if ($shop["PROPERTY_UNDERGROUND_VALUE"]) : ?>
                                <dd>Станция метро: <?=$shop["PROPERTY_UNDERGROUND_VALUE"]?><dd>
                            <?endif;?>
                            <dd><?=$shop["PROPERTY_ADDRESS_VALUE"]?></dd>
                            <?if ($shop["PROPERTY_PHONE_VALUE"]) : ?>
                                <dd>Тел. <?=$shop["PROPERTY_PHONE_VALUE"]?></dd>
                            <?endif;?>
                            <?if ($shop["PROPERTY_WORK_TIME_VALUE"]) : ?>
                                <dd>Режим работы: <?=$shop["PROPERTY_WORK_TIME_VALUE"]?></dd>
                            <?endif;?>
                        </dl>
                        <a href="#" class="map_link">на карте</a>
                    </div>
                <?endforeach;?>
            </li>
        <?endforeach;?>
    </div>
</section>
<!-- ... -->