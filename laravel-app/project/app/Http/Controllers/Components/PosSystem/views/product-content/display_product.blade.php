<style>
    .card-img-top {
    width: 100%; /* Ensures the image takes the full width of the card */
    height: 200px; /* Set a fixed height */
    object-fit: cover; /* Ensures the image fills the space while maintaining aspect ratio */
}

</style>
  <?php 
  if ($data) {
    foreach ($data as $key => $R) {
      $total_stocks = $R->total_stocks - $R->sold_product - $R->qty_return;
      if ($total_stocks > 0) {
        ?>
        <div class="col-2" style="padding-left: 10px !important;padding-right: 0px !important">
            <div class="card">
            <img src="<?= BASEURL.'public/main/uploaded/products/'.$R->file ?>" class="card-img-top" alt="...">
            <div class="card-body" style="
            font-size: 12px;
            padding-left: 10px !important;
            padding-right: 10px !important;
            padding-top: 10px !important;
            padding-bottom: 0px !important;
            ">
                <strong  style="font-size: 14px; font-weight: bold;"><?= $R->product_name ?></strong><br>
                <strong class="card-text" style="font-size: 12px;">Stocks: <?= $R->total_stocks - $R->sold_product - $R->qty_return ?></strong><br>
                <strong class="card-texts" style="font-size: 13px; font-weight: bold;">Price: <?= number_format($R->price,2) ?></strong>
                
                <p class="text-center mt-1">
                  <button type="button"
                  style="width:80px; font-size:20px; padding:2px 4px;"
                  class="btn btn-primary addToCart"
                  data-stockid="<?= $R->stock_id ?>"
                  data-productid="<?= $R->product_id ?>"
                  data-price="<?= $R->price ?>"
                  <?= in_array($R->product_id, $cart) ? 'disabled' : '' ?>
              >
                  Add
              </button>

                </p>
            </div>
            
            </div>
        </div>
        <?php
    }
  }
  }else{
    ?>
    <div class="col-12">
        <h3 class="text-center">NO STOCKS</h3>
    </div>
    <?php
  }
  ?>