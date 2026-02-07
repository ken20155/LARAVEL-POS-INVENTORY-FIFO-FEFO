


<!DOCTYPE html>
<html :class="{ 'theme-dark': dark }" x-data="data()" lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title><?= $title ?> | <?= env('PROJECTTITLE') ?></title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <!-- Site favicon -->
    <link
    rel="apple-touch-icon"
    sizes="180x180"
    href="<?= env('APP_URL') ?>public/plugins/vendors/images/apple-touch-icon.png"
    />
    <link
    rel="icon"
    type="image/png"
    sizes="32x32"
    href="<?= env('APP_URL') ?>public/main/image/sidebar_logo_test.png"
    />
    <link
    rel="icon"
    type="image/png"
    sizes="16x16"
    href="<?= env('APP_URL') ?>public/main/image/sidebar_logo_test.png"
    />

    <!-- Mobile Specific Metas -->
    <meta
    name="viewport"
    content="width=device-width, initial-scale=1, maximum-scale=1"
    />

    <!-- Google Font -->
    <link
    href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap"
    rel="stylesheet"
    />
    <!-- CSS -->
    <link rel="stylesheet" type="text/css" href="<?= env('APP_URL') ?>public/plugins/vendors/styles/core.css" />
    <link
    rel="stylesheet"
    type="text/css"
    href="<?= env('APP_URL') ?>public/plugins/vendors/styles/icon-font.min.css"
    />
    <link
    rel="stylesheet"
    type="text/css"
    href="<?= env('APP_URL') ?>public/plugins/src/plugins/datatables/css/dataTables.bootstrap4.min.css"
    />
    <link
    rel="stylesheet"
    type="text/css"
    href="<?= env('APP_URL') ?>public/plugins/src/plugins/datatables/css/responsive.bootstrap4.min.css"
    />
    <link
    rel="stylesheet"
    type="text/css"
    href="<?= env('APP_URL') ?>public/plugins/src/plugins/fancybox/dist/jquery.fancybox.css"
  />
    <link rel="stylesheet" type="text/css" href="<?= env('APP_URL') ?>public/plugins/vendors/styles/style.css" />

    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script
    async
    src="https://www.googletagmanager.com/gtag/js?id=G-GBZ3SGGX85"
    ></script>
    <script>
    window.dataLayer = window.dataLayer || [];
    function gtag() {
      dataLayer.push(arguments);
    }
    gtag("js", new Date());

    gtag("config", "G-GBZ3SGGX85");
    </script>
    <!-- Google Tag Manager -->
    <script>
    (function (w, d, s, l, i) {
      w[l] = w[l] || [];
      w[l].push({ "gtm.start": new Date().getTime(), event: "gtm.js" });
      var f = d.getElementsByTagName(s)[0],
        j = d.createElement(s),
        dl = l != "dataLayer" ? "&l=" + l : "";
      j.async = true;
      j.src = "https://www.googletagmanager.com/gtm.js?id=" + i + dl;
      f.parentNode.insertBefore(j, f);
    })(window, document, "script", "dataLayer", "GTM-NXZMQSS");
    </script>
    <!-- End Google Tag Manager -->

  </head>
  <body>
    <?php 
    if (env('PRELOAD')) {
    ?>
		<div class="pre-loader">
			<div class="pre-loader-box">
				<div class="loader-logo">
					<img src="<?= env('APP_URL') ?>public/main/image/<?= LOGO ?>" alt="" />
				</div>
				<div class="loader-progress" id="progress_div">
					<div class="bar" id="bar1"></div>
				</div>
				<div class="percent" id="percent1">0%</div>
				<div class="loading-text">Loading...</div>
			</div>
		</div>
    <?php } ?>