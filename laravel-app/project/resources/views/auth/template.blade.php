<!DOCTYPE html>
    <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Login - <?= env('PROJECTTITLE') ?></title>

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

        <?= $content ?>

    <!-- JS -->
    <script>
        var baseUrl = "<?= env('APP_URL') ?>";
    </script>
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>

    <script src="<?= env('APP_URL') ?>public/plugins/vendors/scripts/core.js"></script>
    <script src="<?= env('APP_URL') ?>public/plugins/vendors/scripts/script.min.js"></script>
    <script src="<?= env('APP_URL') ?>public/plugins/vendors/scripts/process.js"></script>
    <script src="<?= env('APP_URL') ?>public/plugins/vendors/scripts/layout-settings.js"></script>
    <script src="<?= env('APP_URL') ?>public/plugins/vendors/sweetalert/sweetalert.min.js"></script>
    <script src="<?= env('APP_URL') ?>public/plugins/vendors/block-ui/jquery.blockUI.min.js"></script>
    <!-- Google Tag Manager (noscript) -->
    <noscript
        ><iframe
            src="https://www.googletagmanager.com/ns.html?id=GTM-NXZMQSS"
            height="0"
            width="0"
            style="display: none; visibility: hidden"
        ></iframe
    ></noscript>


    {{-- main --}}
    <script src="<?= env('APP_URL') ?>public/main/js/main.js"></script>
    <script src="<?= env('APP_URL') ?>public/main/js/common.js"></script>
</body>
</html>
