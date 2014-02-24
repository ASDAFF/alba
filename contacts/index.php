<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Контакты");
if (isset($_POST["send"])) {
    CModule::IncludeModule('form');
    $arFields = array(
        "form_text_1" => $_POST["name"],
        "form_text_24" => $_POST["company"],
        "form_text_25" => $_POST["city"],
        "form_text_2" => $_POST["phone"],
        "form_email_3" => $_POST["email"],
        "form_textarea_4" => $_POST["message"],
    );
    if ($RESULT_ID = CFormResult::Add(1, $arFields))
    {
        $successMessage = "Ваше сообщение принято. Спасибо за Ваш отклик.";
    }
    else
    {
        global $strError;
        echo $strError;
    }
}
?><section class="main_gradient">
			<div class="container secondary">
				<h1>Контакты</h1>
				<ul class="contact_list m_bottom_30">
					<li>Россия, 119180 Москва, ул. Большая Полянка д. 50/1, стр. 3 </li>
					<li class="phone">горячая линия ALBA: 8 (800) 555-00-30 </li>
					<li class="time">будни 9:00-18:00  </li>
					<li class="mail"><a href="mailto:info@the-alba.com">info@the-alba.com </a></li>
				</ul>
				<ul class="contact_list m_bottom_30">
					<li><span class="tt_uppercase bold">Представительство компании в Украине (оптовое направление) </span></li>
					<li>04053, ООО «Альба-Украина”, г. Киев, Кияновский переулок, 3-7 </li>
					<li class="phone">тел/факс: +38 (044) 272- 21-87, 272-41-47  </li>
					<li class="mail"><a href="mailto:alba_kiev@mail.ru">alba_kiev@mail.ru</a></li>
				</ul>
				<a href="/our_shops/" class="button_type_1 our_s">Наши салоны</a>
				<hr class="d_type_1">
				<div class="cf_wrap">
                    <?if ($successMessage) : ?>
                        <?=$successMessage;?>
                    <?endif;?>
					<div class="tt_uppercase bold">Обратная связь</div>

					<form id="contact_form" method="POST">
						<ul>
							<li>
								<label for="name">Ваше имя:</label>
								<input type="text" name="name" id="name" style="width: 390px;">
							</li>
							<li>
								<label for="company">Компания:</label>
								<input type="text" name="company" id="company" style="width: 390px;">
							</li>
							<li>
								<label for="city">Город:</label>
								<input type="text" name="city" id="city" style="width: 390px;">
							</li>
							<li>
								<label for="phone">Телефон:</label>
								<input type="text" name="phone" id="phone" style="width: 390px;">
							</li>
							<li>
								<label for="email">E-mail:</label>
								<input type="text" name="email" id="email" style="width: 390px;">
							</li>
							<li>
								<label for="message">Сообщение:</label>
								<textarea name="message" id="message" style="width: 390px;"></textarea>
							</li>
							<li class="clearfix">
								<input type="submit" class="f_right" value="Отправить" name="send" style="margin-right: 235px;">
							</li>
						</ul>
					</form>
				</div>
			</div>
    <script type="text/javascript" src="/js/lv.js" charset="UTF-8"></script>
    <style>
        .LV_valid {color: green; margin-left: 10px; float: right;}
        .LV_invalid {color: red; margin-left: 10px; float: right;}
    </style>
    <script type="text/javascript">
        var f0 = new LiveValidation('name');
        f0.add( Validate.Presence );

        var f1 = new LiveValidation('company');
        f1.add( Validate.Presence );

        var f2 = new LiveValidation('city');
        f2.add( Validate.Presence );

        var f3 = new LiveValidation('phone');
        f3.add( Validate.Presence );

        var f4 = new LiveValidation('email');
        f4.add( Validate.Presence );

        var f5 = new LiveValidation('message');
        f5.add( Validate.Presence );
    </script>
		</section><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>