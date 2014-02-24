<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Производство");
?> <?$APPLICATION->IncludeComponent(
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
	)
);?> 
<!-- Content -->
 <section class="gradient_box type_2 secondary"> 
  <div class="container"> 
    <p>Центр дизайна и производства располагается в Италии. Здесь начинается с эскизов жизнь любого продукта Alba &ndash; будь то обувь или аксессуар. </p>
   
    <p>Опытные образцы проходят многочисленные испытания, которые позволяют определить их жизнеспособность и в случае необходимости внести изменения в технологический процесс.</p>
   
    <p>Модели, которые получают одобрение технологов, запускаются в массовое производство. Контроль царит и на фабриках: проверяется качество как сырья, так и конечного продукта. </p>
   </div>
 
  <div class="text_container_type_2 m_bottom_45"> 
    <div class="container"> 
      <h3 class="m_bottom_40">В производстве используются лучшие материалы, которые только можно использовать для обуви такого уровня: натуральная кожа, мех, качественная и долговечная фурнитура и резины.</h3>
     </div>
   </div>
 
  <div class="container"> 
    <p>Производственные мощности Alba располагаются в Старом и Новом свете. </p>
   
    <p>После прохождения контроля качества продукта на выходе, он передается в логистический центр для импорта в Россию.</p>
   
    <ul class="sub_menu type_2 prod_tabs_menu"> 
      <li class="active"><a href="javascript:;" class="prod_tabs" data-container="photo">Фото</a></li>
     
      <li><a id="bxid_547303" class="prod_tabs" href="javascript:;" data-container="video">Видео</a></li>
     </ul>
   </div>
 
  <div class="prod_tab_container photo"> <?$APPLICATION->IncludeComponent(
	"alba:lookbook.list",
	".default",
	Array(
		"IBLOCK_TYPE" => "CATALOG",
		"IBLOCK_ID" => "37",
		"CACHE_TYPE" => "A",
		"CACHE_TIME" => "3600"
	)
);?> </div>
 
  <div class="gradient_box prod_tab_container video" style="display: none;"> 
    <div class="container"> <iframe width="100%" height="530" class="m_bottom_20" src="http://www.youtube.com/embed/9ooQBFff6aQ"></iframe> </div>
   </div>
 
  <div class="container"> 
    <p class="t_align_c ls_15 grey_color">Производство обуви ALBA</p>
   </div>
 </section> 
<!-- ... -->
 <?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>