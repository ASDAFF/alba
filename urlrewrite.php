<?
$arUrlRewrite = array(
	array(
		"CONDITION"	=>	"#^/partner/([^/]+)/($|index\\.php|\\?.*)#",
		"RULE"	=>	"ELEMENT_CODE=$1",
		"ID"	=>	"",
		"PATH"	=>	"/partner/index.php",
	),
    array(
        "CONDITION"	=>	"#^/collections/([0-9a-zA-Z_-]+)/([0-9a-zA-Z_-]+)/?.*#",
        "RULE"	=>	"SECTION_CODE=\$1&ELEMENT_CODE=\$2",
        "ID"	=>	"",
        "PATH"	=>	"/collections/detail.php",
    ),
    array(
        "CONDITION"	=>	"#^/collections/([0-9a-zA-Z_-]+)/?.*#",
        "RULE"	=>	"SECTION_CODE=\$1",
        "ID"	=>	"",
        "PATH"	=>	"/collections/index.php",
    ),
	array(
		"CONDITION"	=>	"#^/events/([0-9a-zA-Z_-]+)/([0-9a-zA-Z_-]+)/?.*#",
		"RULE"	=>	"TYPE=\$1&ELEMENT_CODE=\$2",
		"ID"	=>	"",
		"PATH"	=>	"/events/detail.php",
	),
	array(
		"CONDITION"	=>	"#^/events/([0-9a-zA-Z_-]+)/?.*#",
		"RULE"	=>	"YEAR=\$1",
		"ID"	=>	"",
		"PATH"	=>	"/events/index.php",
	),
	array(
		"CONDITION"	=>	"#^/interactive/interview/#",
		"RULE"	=>	"",
		"ID"	=>	"bitrix:news",
		"PATH"	=>	"/interactive/interview/index.php",
	),
	array(
		"CONDITION"	=>	"#^/interactive/contest/#",
		"RULE"	=>	"",
		"ID"	=>	"bitrix:photo",
		"PATH"	=>	"/interactive/contest/index.php",
	),
	array(
		"CONDITION"	=>	"#^/interactive/stock/#",
		"RULE"	=>	"",
		"ID"	=>	"bitrix:news",
		"PATH"	=>	"/interactive/stock/index.php",
	),
	array(
		"CONDITION"	=>	"#^/personal/orders/#",
		"RULE"	=>	"",
		"ID"	=>	"bitrix:sale.personal.order",
		"PATH"	=>	"/personal/orders/index.php",
	),
	array(
		"CONDITION"	=>	"#^/interactive/faq/#",
		"RULE"	=>	"",
		"ID"	=>	"bitrix:news",
		"PATH"	=>	"/interactive/faq/index.php",
	),
	array(
		"CONDITION"	=>	"#^/about/news/#",
		"RULE"	=>	"",
		"ID"	=>	"bitrix:news",
		"PATH"	=>	"/about/news/index.php",
	),
	array(
		"CONDITION"	=>	"#^/about/press/#",
		"RULE"	=>	"",
		"ID"	=>	"bitrix:news",
		"PATH"	=>	"/about/press/index.php",
	),
	array(
		"CONDITION"	=>	"#^/catalog/#",
		"RULE"	=>	"",
		"ID"	=>	"bitrix:catalog",
		"PATH"	=>	"/catalog/index.php",
	),
	array(
		"CONDITION"	=>	"#^/catalog2011/#",
		"RULE"	=>	"",
		"ID"	=>	"bitrix:catalog",
		"PATH"	=>	"/catalog2011/index.php",
	),
);

?>