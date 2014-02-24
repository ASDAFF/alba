<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();?>
<? require $_SERVER["DOCUMENT_ROOT"] . '/include/collections.sections.php';?>
<!-- Content -->
<script type="text/javascript" src="/js/highslide-full.min.js"></script>
<link rel="stylesheet" type="text/css" href="/js/highslide.css" /
<section class="gradient_box">
    <div class="container">
        
        <h1 class="collection_title breadcrump"><span><?=$arResult["ITEM"]["COLLECTION"]?></span> <?=$arResult["ITEM"]["NAME"]?></h1>
        
<!--        <div class="icon_360">-->
<!--            <img src="/images/360_icon.png" alt="">-->
<!--        </div>-->
        
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
        <div class="highslide-html-content" id="my-content" style="width: 600px; height: 500px;">

        <div class="highslide-body">
        <?
        $ip_a=explode(",",$_SERVER["HTTP_X_FORWARDED_FOR"]);
        $ip=$ip_a[0];
        //echo $ip;
        $xml = simplexml_load_file("http://ipgeobase.ru:7020/geo?ip=".$ip);
        //print_r ($xml);
        $lat = $xml->ip->lat;
        $city = $xml->ip->city;
        $city.="";
        //echo $city;
        //$city="Санкт-Петербург";
        //echo "<pre>"; print_r ($arResult); echo "</pre>";
        //if ($arResult["PROPERTIES"]["AVAILABILITY"]["VALUE"]=="Y") {
        if (strlen($arResult["~PREVIEW_TEXT"])>0) {
            //echo $arResult["~PREVIEW_TEXT"];
            $prices2=explode("%%", $arResult["~PREVIEW_TEXT"]);
            unset($prices2[0]);
            $prices2=array_values($prices2);
            $mags=Array();
            foreach ($prices2 as $pr)
                $prices[]=explode("|",$pr);
            if (count($prices[0])==2) $shoes=false; else $shoes=true;
            foreach ($prices as $p)
                if (!in_array($p[0], $mags)) {
                    $mags[]=$p[0];
                    $m_items[$p[0]][$p[1]]=$p[2];
                } else {
                    $m_items[$p[0]][$p[1]]=$p[2];
                }
                //echo "<pre>"; print_r ($m_items); echo "</pre>";

        }
        //	define("CACHE_TIME_MAIN_PC", 60 * 60 * 6);
        define("CACHE_TIME_MAIN_PC", 0);
        $cache = new CPHPCache;
        $cache_id = SITE_ID."_new_podcast";
        $cache_path = "/".SITE_ID."/items/".$arResult["ID"]."/".$lat;
        if ($cache->InitCache(CACHE_TIME_MAIN_PC, $cache_id, $cache_path))
        {
            extract($cache->GetVars());
        }
        else
        {
            CModule::IncludeModule("iblock");
            $arSelect = Array("ID", "NAME", "PREVIEW_TEXT", "DETAIL_TEXT", "IBLOCK_SECTION_ID");
            $arFilter = Array("IBLOCK_ID" => 16, "ACTIVE" => "Y", "PREVIEW_TEXT" => $mags);
            $dbElement = CIBlockElement::GetList(Array(), $arFilter, false, false, $arSelect);
            while ($obElement = $dbElement->GetNext()) {
                $res = CIBlockSection::GetByID($obElement["IBLOCK_SECTION_ID"]);
                if($ar_res = $res->GetNext()) $obElement["CITY"]=$ar_res['NAME'];
                if (!in_array($obElement["CITY"], $cities)) {
                    $cities[]=$obElement["CITY"];
                    $m[$obElement["CITY"]][$obElement["PREVIEW_TEXT"]]=$obElement["NAME"];
                } else {
                    $m[$obElement["CITY"]][$obElement["PREVIEW_TEXT"]]=$obElement["NAME"];
                }
                $m_type[$obElement["DETAIL_TEXT"]][]=$obElement["NAME"];
            }
            // Все закэшируем
            if (CACHE_TIME_MAIN_PC > 0)
            {
                $cache->StartDataCache(CACHE_TIME_MAIN_PC, $cache_id, $cache_path);
                $cache->EndDataCache(
                    Array(
                        "cities" => $cities,
                        "m" => $m,
                        "m_type" => $m_type,
                        "obElement" => $obElement
                    )
                );
            }
        }
        $r_prices0=explode("%%", $arResult['~DETAIL_TEXT']);
        unset ($r_prices0[0]);
        foreach($r_prices0 as $rp0) { $rp1=explode("|", $rp0); $m_type[$rp1[0]]['price']=$rp1[1]; }
        foreach($m_type as $mt) {
            if (isset($mt['price'])) {
                foreach ($mt as $mt0) {
                    foreach ($m as $mn0 => $m0){
                        foreach ($m0 as $mn00 => $m00){
                            if ($m00==$mt0) $m[$mn0][$mn00]=$m00."|".$mt['price'];
                        }
                    }
                }
            }
        }
        //if (isset($_GET['rp']))	{ echo "<pre>"; print_r ($m); echo "</pre>"; }
        //	echo "<pre>"; print_r ($m_city); echo "</pre>";
        foreach ($m as $m_c=>$mg) {
            foreach ($mg as $mg_id=>$mg_n) { $m2[$m_c][$mg_id]=$m_items[$mg_id]; $m2[$m_c][$mg_id]["name"]=$mg_n; }
        }

        foreach ($m2 as $m2_n=>$mm2) {
            if (substr($m2_n,1)==substr($city,1)) $m_city=$mm2;
        }
        $s_price=false;
        echo "<div style=\"background: #FFF; padding: 10px;\">";
        if (count($m_city)>0) {
            echo "Ваш город определен как <span style=\"font-size: 16px; font-weight: bold;\">".$city."</span><br>";
            foreach ($m_city as $mm2) {
                $mm2arr=explode("|",$mm2['name']);
                if ($mm2arr[0]=="Купи VIP") $mm2arr[0]="<a href=\"http://shop.the-alba.com\">Интернет-магазин</a>";
                echo "<div style=\"padding-top: 20px;\"><b>".$mm2arr[0]."</b> <span style=\"padding-left: 20px; color: #900;\"><b>";
                if ($mm2arr[1]) { $s_price=true; $s_price_value=$mm2arr[1]; echo $mm2arr[1]; } else echo $arResult["PROPERTIES"]["PRICE_1C"]["VALUE"];
                echo "</b> ".$arResult["PROPERTIES"]["CURRENCY"]["VALUE"]."</span></div>";
                if ($shoes)
                    echo "<div style=\"padding: 5px 0 0 0px; font-size: 12px;\">Размеры (количество): ";
                else
                    echo "<div style=\"padding: 5px 0 0 0px; font-size: 12px;\">Количество: ";
                $i=0;
                foreach ($mm2 as $m3_n=>$mm3) {
                    if ($m3_n!="name") { if ($i!=0) echo ", "; echo "<b>".$m3_n."</b>"; if ($shoes) echo "(".$mm3.")"; $i++; }
                }
                echo "</div>";
            }
        } else echo "<div>Ваш город не определен или данный товар в нем отсутствует</div>";
        echo "<div style=\"margin-top: 15px; padding: 15px 0 0px 0; border-top: 1px solid #aaa;\">Предложения в других городах (кликните на название города, чтобы увидеть информацию):</div>";
        //	echo "<pre>"; print_r ($m_city); echo "</pre>";
        //	echo "<pre>"; print_r ($m2); echo "</pre>";
        $j=0;
        foreach ($m2 as $m2_n=>$mm2) {
            if (substr($m2_n,1)!=substr($city,1)){
                echo "<div style=\"padding-top: 20px;\">";
                ?>  <a style="color: #000; text-decoration: none; font-weight: bold;" href="#" onClick="return false" id="a<?=$j?>"><span id="sp<?=$j?>">+</span><span id="sm<?=$j?>" style="display: none;">-</span> <?=$m2_n?></a><?
            echo "</b></div>";
            echo "<div id=\"d".$j."\" style=\"display: none; padding-left: 40px;\">";
            foreach ($mm2 as $mmm2) {
                $mmm2arr=explode("|",$mmm2['name']);
                echo "<div style=\"padding-top: 20px;\"><b>".$mmm2arr[0]."</b> <span style=\"padding-left: 20px; color: #900;\"><b>";
                if ($mmm2arr[1]) echo $mmm2arr[1]; else echo $arResult["PROPERTIES"]["PRICE_1C"]["VALUE"];
                echo "</b> ".$arResult["PROPERTIES"]["CURRENCY"]["VALUE"]."</span></div>";
                if ($shoes)
                    echo "<div style=\"padding: 5px 0 0 0px; font-size: 12px;\">Размеры (количество): ";
                else
                    echo "<div style=\"padding: 5px 0 0 0px; font-size: 12px;\">Количество: ";
                $i=0;
                foreach ($mmm2 as $m3_n=>$mm3) {
                    if ($m3_n!="name") { if ($i!=0) echo ", "; echo "<b>".$m3_n."</b>"; if ($shoes) echo " (".$mm3.")"; $i++; }
                }
                echo "</div>";
            }

            echo "</div>";
            ?>
                <script>
                    $("#a<?=$j?>").click(function () {
                        $("#d<?=$j?>").toggle("slow");
                        $("#sp<?=$j?>").toggle();
                        $("#sm<?=$j?>").toggle();
                    });
                </script>
                <?
                $j++;
            }
        }
        echo "</div>";
        ?>
    </div>

</div>
<!--<a href="javascript:;" style="color: #900; text-decoration: underline;" class="highslide" onclick="return hs.htmlExpand(this, { contentId: 'my-content' } )">-->
<!--    Проверить наличие в вашем городе-->
<!--</a>-->
        <div class="find_link_wrap">
            <a href="javascript:;" class="find_link">проверить наличие в городе</a>
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