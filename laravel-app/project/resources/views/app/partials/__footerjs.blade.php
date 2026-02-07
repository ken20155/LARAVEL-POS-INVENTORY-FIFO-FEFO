<script>
  var baseUrl = "<?= env('APP_URL') ?>";
  var baseUserUrl = "<?= env('APP_URL_USER') ?>";
  var myModule = "<?= $params ?>";
</script>

<script src="<?= env('APP_URL') ?>public/plugins/vendors/scripts/core.min.js"></script>
<script src="<?= env('APP_URL') ?>public/plugins/vendors/scripts/script.js"></script>
<script src="<?= env('APP_URL') ?>public/plugins/vendors/scripts/process.js"></script>
<script src="<?= env('APP_URL') ?>public/plugins/src/plugins/fancybox/dist/jquery.fancybox.js"></script>
<script src="<?= env('APP_URL') ?>public/plugins/vendors/scripts/layout-settings.js"></script>
<script src="<?= env('APP_URL') ?>public/plugins/src/plugins/apexcharts/apexcharts.min.js"></script>
<script src="<?= env('APP_URL') ?>public/plugins/src/plugins/datatables/js/jquery.dataTables.min.js"></script>
<script src="<?= env('APP_URL') ?>public/plugins/src/plugins/datatables/js/dataTables.bootstrap4.min.js"></script>
<script src="<?= env('APP_URL') ?>public/plugins/src/plugins/datatables/js/dataTables.responsive.min.js"></script>
<script src="<?= env('APP_URL') ?>public/plugins/src/plugins/datatables/js/responsive.bootstrap4.min.js"></script>
<script src="<?= env('APP_URL') ?>public/plugins/vendors/scripts/dashboard3.js"></script>
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


<script src="<?= env('APP_URL') ?>public/main/js/main.js"></script>
<script src="<?= env('APP_URL').$params ?>/js/custom"></script>
<script src="<?= env('APP_URL') ?>public/main/js/common.js"></script>




</body>
</html>
