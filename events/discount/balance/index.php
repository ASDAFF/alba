<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Проверка баланса");
?><?$APPLICATION->IncludeComponent("bitrix:menu", "submenu", array(
	"ROOT_MENU_TYPE" => "collections_menu",
	"MENU_CACHE_TYPE" => "N",
	"MENU_CACHE_TIME" => "3600",
	"MENU_CACHE_USE_GROUPS" => "Y",
	"MENU_CACHE_GET_VARS" => array(
	),
	"MAX_LEVEL" => "1",
	"CHILD_MENU_TYPE" => "left",
	"USE_EXT" => "N",
	"DELAY" => "N",
	"ALLOW_MULTI_SELECT" => "N"
	),
	false
);?> <?$APPLICATION->IncludeComponent("bitrix:menu", "submenu", array(
	"ROOT_MENU_TYPE" => "third_level",
	"MENU_CACHE_TYPE" => "N",
	"MENU_CACHE_TIME" => "3600",
	"MENU_CACHE_USE_GROUPS" => "Y",
	"MENU_CACHE_GET_VARS" => array(
	),
	"MAX_LEVEL" => "1",
	"CHILD_MENU_TYPE" => "left",
	"USE_EXT" => "N",
	"DELAY" => "N",
	"ALLOW_MULTI_SELECT" => "N"
	),
	false
);?>
<style>
    .LV_valid {color: green; margin-left: 10px;}
    .LV_invalid {color: red; margin-left: 10px;}
</style>
    <!-- Content -->
    <section class="gradient_box">
        <div class="container font1" action="" method="POST">
            <div class="pad_box">
                <h1 class="big_title1">Проверка баланса</h1>

                <p class="p_stripe p6">Для того чтобы проверить сумму накоплений на Вашей карте, введите фамилию, на которую зарегистрирована карта и идентификационный номер карты (введите фамилию и номер, размещенный на лицевой стороне карты):</p>
<? if (isset($_POST['name'])) {
//	print_r ($_POST);

    $user_error=false;
//Проверка КАПЧИ
    if (isset($_POST['captcha_sid'])) {
        if (!$APPLICATION->CaptchaCheckCode($_POST["captcha_word"], $_POST["captcha_sid"]))
        {
            $wrong_captcha=1;
        } else {
            $wrong_captcha=0;
        }
    }// else {


//Если КАПЧА ОК
    if (isset($_POST['captcha_sid']) && $wrong_captcha==0) {

        CModule::IncludeModule("iblock");
        $dbElement = CIBlockElement::GetList(
            array(),
            array(
                "IBLOCK_ID" => 17,
                "NAME" => "02".$_POST['num']
            ),
            false,
            false//array("nTopCount" =>6)
//			array("ID", "IBLOCK_ID", "IBLOCK_SECTION_ID", "PROPERTY_IMAGES")
        );

        if ($obElement = $dbElement->GetNextElement())
        {
            $arElement = $obElement->GetFields();
            $arElementProps = $obElement->GetProperties();
        }
//$bal=IntVal(str_replace(" ", "", $arElementProps["DC_BALANCE"]["VALUE"]." "));
        $bal2=$arElementProps["DC_BALANCE"]["VALUE"];
        for ($i=0; $i<(strlen($bal2)+2); $i++) {
            if ($bal2[$i]==",") break;
            if (is_numeric($bal2[$i])) $bal.=$bal2[$i];
        }
        $sum2=$arElementProps["DC_SUM"]["VALUE"];
        for ($i=0; $i<(strlen($sum2)+2); $i++) {
            if ($sum2[$i]==",") break;
            if (is_numeric($sum2[$i])) $sum.=$sum2[$i];
        }
        $show=false;
        $block=false;
        $nocard=false;
        if ((strlen($arElementProps["DC_FAM"]["VALUE"]) < 4) && ($arElementProps["DC_FAM"]["VALUE"]==$_POST['name'])) $show=true;
        elseif ((strlen($_POST['name']) > 3) && (substr_count($arElementProps["DC_FAM"]["VALUE"],$_POST['name']) > 0)) $show=true;
        else $nocard=true;
        if ($arElement["ACTIVE"]=="N") { $block=true; $show=false; }
        if (count($arElement)==0) $nocard=true;
    }

} ?>
<? if ($show) { ?>

    Баланс карты: <b><?=($bal+$sum)?></b><br>
    <?/* if (($bal+$sum)>50000) { ?>
Доступно баллов: <b><?=round(((($bal+$sum)-50000)/10)+$arElementProps["DC_BALLS"]["VALUE"]);?></b><br>
<? }*/ ?>
    <br>
    Номер карты: <b><?=$_POST['num']?></b><br>
    Фамилия: <b><?=$arElementProps["DC_FAM"]["VALUE"]?></b>
    <br><Br>


<? } else { ?>
    <script type="text/javascript" src="/js/lv.js" charset="UTF-8"></script>
    <? if ($block) { ?><div class="LV_invalid" style="margin-bottom: 20px; font-weight: bold;">Карта заблокирована. Введите номер новой карты.</div><? } ?>
    <? if ($nocard) { ?><div class="LV_invalid" style="margin-bottom: 20px; font-weight: bold;">Неправильный номер карты или фамилия.</div><? } ?>
                <form class="form_balance" method="POST" action="">
                    <h4 class="small_title1">Проверка баланса</h4>

                    <div class="form_balance__row">
                        <div class="label">Фамилия:</div>
                        <input type="text" id="f0" value="<?=$_POST['name']?>" name="name"/>
                    </div>
                    <script type="text/javascript">
                        var f0 = new LiveValidation('f0');
                        f0.add( Validate.Presence );
                    </script>

                    <div class="form_balance__row">
                        <div class="label">Номер карты:</div>
                        <input type="text" name="num" id="f1" value="<?=$_POST['num']?>"/>
                    </div>

                    <script type="text/javascript">
                        var f1 = new LiveValidation('f1');
                        f1.add( Validate.Presence );
                    </script>

                    <div class="form_balance__row">
                        <div class="label">&nbsp;</div>
                        <input type="hidden" name="captcha_sid" value="f77953fce6aabfd741bbfe8d71f6c278" />
                        <div class="wrapper"><img style="margin-left: 1px;" src="/bitrix/tools/captcha.php?captcha_sid=f77953fce6aabfd741bbfe8d71f6c278" alt="CAPTCHA" /></div>
                    </div>

                    <div class="form_balance__row">
                        <div class="label">Введите код с картинки:</div>
                        <input type="text" name="captcha_word" class="small_field" />
                        <? if ($wrong_captcha==1) { ?><div class="label LV_invalid">Неверный код</div><? } ?>
                    </div>

                    <div class="form_balance__row">
                        <div class="label">&nbsp;</div>
                        <input type="submit" value="Отправить" class="form_btn" />
                    </div>
                </form>

<? } ?>
    <h4 class="small_title tt_uppercase">Узнать сумму накоплений на карте также можно:</h4>

    <ul class="list1">
        <li>В салоне на кассе (сообщите номер карты продавцу-консультанту, и он поможет узнать сумму накоплений)</li>

        <li>По телефону горячей линии <strong>8 800 555 00 30</strong> (сообщите номер карты оператору, и он поможет узнать сумму накоплений)</li>
    </ul>
    </div>
    </div>
</section>
    <!-- ... -->

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>