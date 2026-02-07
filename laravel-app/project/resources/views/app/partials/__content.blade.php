
<div class="main-container">
    <div class="xs-pd-20-10 pd-ltr-20">
        <div class="title pb-20">
            <div class="row breadcrumb-title-cus">
                <div class="col-md-6 col-sm-12">
                    <div class="title">
                        <h4><?= $title ?></h4>
                    </div>
                    <nav aria-label="breadcrumb" role="navigation">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="dashboard">Home</a>
                            </li>
                            <?php 
                            if ($title != 'Dashboard') {
                                ?>
                                <li class="breadcrumb-item">
                                    <a href="dashboard">Management</a>
                                </li>
                                <?php
                            }
                            ?>
                            
                            <li class="breadcrumb-item active" aria-current="page">
                                <?= $title ?>
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>
            <?= $content ?>
        </div>
    </div>
</div>