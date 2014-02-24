<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("О компании");
?>
<?$APPLICATION->IncludeComponent(
    "bitrix:menu",
    "submenu",
    Array(
        "ROOT_MENU_TYPE" => "submenu",
        "MAX_LEVEL" => "1",
        "CHILD_MENU_TYPE" => "left",
        "USE_EXT" => "N",
        "DELAY" => "N",
        "ALLOW_MULTI_SELECT" => "N",
        "MENU_CACHE_TYPE" => "N",
        "MENU_CACHE_TIME" => "3600",
        "MENU_CACHE_USE_GROUPS" => "Y",
        "MENU_CACHE_GET_VARS" => array()
    ),
    false
);?>
<!-- Content -->
 		<section class="gradient_box"> 			 
  <div class="container"> 				 
    <h1 class="big_title1">Философия бренда</h1>
   			</div>
 			 
  <div class="or about_red_box"> 				 
    <div class="container"> 	  Идея, воплощаемая в каждой коллекции обуви и аксессуаров ALBA, &ndash; создавать конкурентоспособный европейский продукт для российского рынка отвечающий всем канонам классического итальянского стиля. 					</div>
   			</div>
 			 
  <div class="container font1"> 				 
    <p>Торговая марка ALBA ориентирована на современного жителя мегаполиса, делового, успешного, динамичного. Компания THE ALBA СORPORATION LTD смогла понять и оценить предпочтения и вкусы российских покупателей, что позволило сформулировать новую задачу для продвижения философии о доступной европейской классике для российского покупателя и открыть собственное производство обуви. Натуральная кожа, мягкая блестящая замша, продуманный дизайн и качественный пошив обуви зарекомендовали ALBA на рынке как одну из ведущих марок. Разработка сезонных коллекций ведется дизайнерами ALBA с учетом актуальных тенденций.</p>
   				В переводе с итальянского, ALBA означает &laquo;рассвет, начало&raquo;, поэтому символичное название компании отразило не только географическую составляющую, но и концептуальную ориентацию бренда на передовые тенденции, технологии и материалы при создании каждой модели в коллекции, призванной стать законодателем образов для ценителей классики. 
    <br />
   				 
    <h1 class="big_title1">История</h1>
   			</div>
 <?$APPLICATION->IncludeComponent(
	"alba:history.all",
	"",
	Array(
		"IBLOCK_TYPE" => "COMMUNITY",
		"IBLOCK_ID" => "36",
		"CACHE_TYPE" => "A",
		"CACHE_TIME" => "3600"
	)
);?> 		</section> 		 
<!-- ... -->
 <?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>