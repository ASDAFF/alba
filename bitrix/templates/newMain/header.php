<!doctype html>
<!--[if IE 8]><html class="ie8" lang="en"><![endif]-->
<!--[if IE 9]><html class="ie9" lang="en"><![endif]-->
<!--[if (gt IE 9)|!(IE)]><!--><html lang="ru"><!--<![endif]>-->
	<head>
		<? $APPLICATION->ShowHead() ?>
		<title><?$APPLICATION->ShowTitle();?></title>
		<!--meta tags-->
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<meta name="author" content="">
		<meta name="keywords" content="">
		<meta name="description" content="">
		<!--[if IE]><meta http-equiv="X-UA-Compitible" content="IE=edge,chrome=1"><![endif]-->
		<!--include stylesheets and font-->
		<link rel="stylesheet" type="text/css" href="/css/style.css">
<link rel="stylesheet" type="text/css" href="/css/owl.carousel.css">
		<link href='http://fonts.googleapis.com/css?family=Oranienbaum&subset=latin,cyrillic' rel='stylesheet' type='text/css'>
		<!--[if lt IE 9]>
			<script type="text/javascript" src="/js/html5.js"></script>
		<![endif]-->
	</head>
	<body><? $APPLICATION->ShowPanel(); ?><div id="scrollbody">
		<!--markup header-->
		<header role="banner">
			<div class="container clearfix t_align_c">
				<!--language settings-->
				<div class="f_left d_sm_none d_xs_none">
					<ul class="ls clearfix">
						<li class="active"><a href="/">РУС</a></li>
						<li><a href="/">ENG</a></li>
						<li><a href="/">IT</a></li>
					</ul>
				</div>
				<!--logo-->
				<a class="logo f_left d_sm_block d_xs_block" href="/">
					<img src="/images/logo.jpg" alt="">
				</a>
				<div class="f_right f_sm_left f_xs_left">
					<ul class="h_contact_list t_align_l">
						<?$APPLICATION->IncludeFile(
						$APPLICATION->GetTemplatePath("/new_includes/header_contacts.php"),
						Array(),
						Array("MODE"=>"html")
					);?>
					</ul>
					<a href="http://shop.the-alba.com/" class="shop_btn f_sm_right f_xs_right">интернет-магазин</a>
				</div>
			</div>
		</header>
		<!--main menu-->
		<section class="navigation_wrap home">
			<div class="container">
<?$APPLICATION->IncludeComponent(
	"bitrix:menu",
	"",
	Array(
		"ROOT_MENU_TYPE" => "top",
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
			</div>
<?if ($APPLICATION->GetCurPage() == "/") : ?>			
<div class="banners_wrap">
				<div class="container clearfix">
					<a href="http://shop.the-alba.com/" class="banner f_right">Интернет-Магазин</a>
                    <?$APPLICATION->IncludeFile(
                        $APPLICATION->GetTemplatePath("/new_includes/header_link_actions.php"),
                        Array(),
                        Array("MODE"=>"html")
                    );?>
				</div>
			</div>
<?endif;?>
		</section>
<?if ($APPLICATION->GetCurPage() == "/") : ?>		
<div class="bottom_arrow"><img class="f_chrome" src="/images/arrow_bottom_icon.png" alt=""></div>
<?endif;?>
		