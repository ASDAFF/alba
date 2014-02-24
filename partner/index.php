<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Партнерам");
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
?>
<?if ($successMessage) : ?>
    <div class="success_message_partner" style="display: none;"><?=$successMessage;?></div>
<?endif;?>
<?$APPLICATION->IncludeComponent(
	"alba:partners.list",
	"",
Array(),
false
);?>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>