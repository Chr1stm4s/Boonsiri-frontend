<?php
	require_once "functions.php";

	$StaticPage = [
		"home", 
		"about", 
		"jobs", 
		"articles", 
		"contact", 
		"all-products", 
		"policy", 
		"login", 
		"promotions", 
		"products-category", 
		"register", 
	];

	if (in_array($page, $StaticPage)) {
		$PageID = [
			"home" => 1, 
			"about" => 2, 
			"jobs" => 3, 
			"articles" => 4, 
			"contact" => 5, 
			"all-products" => 6, 
			"policy" => 7, 
			"login" => 8, 
			"promotions" => 9, 
			"products-category" => 10, 
			"register" => 11, 
		];

		$MetaRequestData = [
			"id" => $PageID[$page]
		];
	
		$MetaRequestAPI = connect_api("{$API_URL}page/get-page", $MetaRequestData);

		$ogImg = rootURL()."meta/{$MetaRequestAPI["page"]["cover"]}";
		$title = $MetaRequestAPI["page"]["title"];
		$ogTitle = $MetaRequestAPI["page"]["metaTitle"];
		$ogDesc = $MetaRequestAPI["page"]["metaDescription"];
		$keywords = $MetaRequestAPI["page"]["keywords"];
	} elseif ($page == "articles-category") {
		$RequestAPI = [
            "id" => $id
        ];

		$ResultAPI = connect_api("{$API_URL}article-category/get-article-category", $RequestAPI);

        if ($ResultAPI['responseCode'] == 000) {
            $ResultAPI = $ResultAPI['articleCategory'];

			$ogImg = ($ResultAPI['thumbnail'] && file_exists("articles/".$ResultAPI['thumbnail'])) ? rootURL()."articles/".$ResultAPI['thumbnail'] : rootURL()."images/logo.png";
			$title = $ResultAPI["title"];
			$ogTitle = $ResultAPI["metaTitle"];
			$ogDesc = $ResultAPI["metaDescription"];
			$keywords = $ResultAPI["keywords"];
        } else {
            echo $ResultAPI['responseCode'];

            exit();
        }
	} elseif ($page == "article") {
        $id = ($_GET['id']) ? $_GET['id'] : redirect(rootURL());

		$APIRequest = [
            'id' => $id, 
        ];

        $Response = connect_api("{$API_URL}article/get-article", $APIRequest);

        if ($Response['responseCode'] == 000) {
            $Data = $Response['article'];

			$ogImg = ($Data['thumbnail'] && file_exists("articles/{$Data['id']}/{$Data['thumbnail']}")) ? rootURL()."articles/{$Data['id']}/{$Data['thumbnail']}" : rootURL()."images/logo.png";
			$title = $Data["title"];
			$ogTitle = $Data["metaTitle"];
			$ogDesc = $Data["metaDescription"];
			$keywords = $Data["keywords"];
        } else {
            redirect(rootURL());
        }

        $RequestAPI = [
            "id" => $Data['categoryId']
        ];

		$ResultAPI = connect_api("{$API_URL}article-category/get-article-category", $RequestAPI);

        if ($ResultAPI['responseCode'] == 000) {
            $ResultData = $ResultAPI['articleCategory'];
        } else {
            echo $ResultAPI['responseCode'];

            exit();
        }
	} elseif ($page == "job-details") {
        $id = ($_GET['id']) ? $_GET['id'] : redirect(rootURL());

		$APIRequest = [
            'id' => $id, 
        ];

        $Response = connect_api("{$API_URL}job/get-job", $APIRequest);

        if ($Response['responseCode'] == 000) {
            $Data = $Response['job'];
            $JobData = $data['job'];

			$ogImg = rootURL()."meta/1717403864-0.png";
			$title = $Data["title"];
			$ogTitle = $Data["title"];
			$ogDesc = $Data["description"];
			$keywords = "รับสมัครงาน";
        } else {
            redirect(rootURL());
        }
	} elseif ($page == "products") {
        $CategoryID = $_GET['id'];
        $WhsCode = (@$_SESSION['whsCode']) ? $_SESSION['whsCode'] : "SSK";

        $CategoryAPIDataRequest = [
            "whsCode" => $WhsCode, 
            'categoryId' => $CategoryID
        ];

        $CategoryMain = connect_api("{$API_URL}category/get-category-by-id", $CategoryAPIDataRequest);

        if ($CategoryMain['responseCode'] == 000) {
            $CategoryData = $CategoryMain['product'][0];

			$ogImg = ($CategoryData['image'] && file_exists("products/category/".$CategoryData['image'])) ? rootURL()."products/category/".$CategoryData['image'] : rootURL()."images/logo.png";
			$title = $CategoryData["title"];
			$ogTitle = $CategoryData["metaTitle"];
			$ogDesc = $CategoryData["metaDescription"];
			$keywords = $CategoryData["keywords"];
        } else {
            echo $CategoryMain['responseCode'];

            exit();
        }
	} elseif ($page == "products-search") {
		$ogImg = rootURL()."meta/1717403864-0.png";
		$title = "ค้นหาสินค้าบุญศิริ - {$search}";
		$ogTitle = "ค้นหาสินค้าบุญศิริ - {$search}";
		$ogDesc = "ค้นหาสินค้าบุญศิริ - {$search}";
		$keywords = $search;
	} else {
		$ogImg = rootURL()."meta/1717403864-0.png";
		$title = "บุญศิริโฟรเซ่นโปรดักส์";
		$ogTitle = "บุญศิริโฟรเซ่นโปรดักส์";
		$ogDesc = "บุญศิริโฟรเซ่นโปรดักส์";
		$keywords = "บุญศิริโฟรเซ่นโปรดักส์";
	}

	$ogURL = actualURL();
?>

<!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-4Z4N2V1ETF"></script>
<script>
	window.dataLayer = window.dataLayer || [];

	function gtag() {
		dataLayer.push(arguments);
	}
	gtag('js', new Date());

	gtag('config', 'G-4Z4N2V1ETF');
</script>

<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<title><?= $title; ?></title>

<meta property="og:url" content="<?= $ogURL; ?>" />
<meta property="og:type" content="website" />
<meta property="og:title" content="<?= $ogTitle; ?>" />
<meta property="og:description" content="<?= $ogDesc; ?>" />
<meta property="og:image" content="<?= $ogImg; ?>" />
<meta property="og:locale" content="th_TH">
<meta property="og:site_name" content="บุญศิริโฟรเซ่นโปรดักส์">
<meta property="fb:app_id" content="197604500692653" />
<meta property="fb:page_id" content="197604500692653" />
<meta property="fb:pages" content="197604500692653">
<meta property="ia:markup_url" content="<?= $ogURL; ?>">
<meta property="ia:rules_url" content="<?= $ogURL; ?>">

<meta name="keywords" content="<?= $keywords; ?>">
<meta name="title" content="<?= $ogTitle; ?>">
<meta name="description" content="<?= $ogDesc; ?>">
<meta name="author" content="บุญศิริโฟรเซ่นโปรดักส์">

<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:description" content="<?= $ogDesc; ?>">
<meta name="twitter:title" content="<?= $ogTitle; ?>">
<meta name="twitter:image" content="<?= $ogImg; ?>">

<meta name="robots" content="index,follow" />
<meta name="googlebot" content="index,follow" />
<meta name="googlebot-news" content="index,follow" />

<link rel="canonical" href="<?= $ogURL; ?>" />

<meta name="language" content="th-TH" />
<meta name="distribution" content="Global" />
<meta name="rating" content="General" />
<meta name="creator" content="บุญศิริโฟรเซ่นโปรดักส์" />
<meta name="publisher" content="บุญศิริโฟรเซ่นโปรดักส์" />

<link rel="apple-touch-icon" sizes="57x57" href="<?= rootURL(); ?>favicon/apple-icon-57x57.png">
<link rel="apple-touch-icon" sizes="60x60" href="<?= rootURL(); ?>favicon/apple-icon-60x60.png">
<link rel="apple-touch-icon" sizes="72x72" href="<?= rootURL(); ?>favicon/apple-icon-72x72.png">
<link rel="apple-touch-icon" sizes="76x76" href="<?= rootURL(); ?>favicon/apple-icon-76x76.png">
<link rel="apple-touch-icon" sizes="114x114" href="<?= rootURL(); ?>favicon/apple-icon-114x114.png">
<link rel="apple-touch-icon" sizes="120x120" href="<?= rootURL(); ?>favicon/apple-icon-120x120.png">
<link rel="apple-touch-icon" sizes="144x144" href="<?= rootURL(); ?>favicon/apple-icon-144x144.png">
<link rel="apple-touch-icon" sizes="152x152" href="<?= rootURL(); ?>favicon/apple-icon-152x152.png">
<link rel="apple-touch-icon" sizes="180x180" href="<?= rootURL(); ?>favicon/apple-icon-180x180.png">
<link rel="icon" type="image/png" sizes="192x192" href="<?= rootURL(); ?>favicon/android-icon-192x192.png">
<link rel="icon" type="image/png" sizes="32x32" href="<?= rootURL(); ?>favicon/favicon-32x32.png">
<link rel="icon" type="image/png" sizes="96x96" href="<?= rootURL(); ?>favicon/favicon-96x96.png">
<link rel="icon" type="image/png" sizes="16x16" href="<?= rootURL(); ?>favicon/favicon-16x16.png">
<link rel="manifest" href="<?= rootURL(); ?>favicon/manifest.json">
<meta name="msapplication-TileColor" content="#65b7d6">
<meta name="msapplication-TileImage" content="<?= rootURL(); ?>favicon/ms-icon-144x144.png">
<meta name="theme-color" content="#65b7d6">

<link rel="stylesheet" href="<?= rootURL(); ?>bootstrap/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<link rel="stylesheet" href="<?= rootURL(); ?>style-theme.css?version=<?= time(); ?>">
<link rel="stylesheet" href="<?= rootURL(); ?>style-desktop.css?version=<?= time(); ?>">
<link rel="stylesheet" href="<?= rootURL(); ?>style-tablet.css?version=<?= time(); ?>">
<link rel="stylesheet" href="<?= rootURL(); ?>style-mobile.css?version=<?= time(); ?>">
<link href="<?= rootURL(); ?>select2/css/select2.min.css" rel="stylesheet" />