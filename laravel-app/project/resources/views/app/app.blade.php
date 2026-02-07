
<?php 
echo $header;
echo '<div class="container-scroller">';
    echo $topbar;
    echo '<div class="container-fluid page-body-wrapper">';
        echo $sidebar;
        echo '<div class="main-panel">
                <div class="content-wrapper">';
                    echo $body;
        echo '  </div>
            </div>';
        echo $footer;
    echo '</div>';
    echo $settings;
echo '</div>
';
echo $footerlink;
?>

