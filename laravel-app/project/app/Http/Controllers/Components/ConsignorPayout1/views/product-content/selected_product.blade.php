

<div style="height: 600px; overflow: auto; border: 1px solid #ccc;">
<?php 
if ($data) {
    $grand_total = 0;
    $x = 1;
    foreach ($data as $key => $R) {
        $grand_total += $R->price * $R->qty;
?>
    
    <div class="card mb-2">
        <div class="card-header" id="headingOne<?=$x?>">
            <div class="d-flex justify-content-between align-items-center">
                <button class="btn btn-link p-0" style="font-size:20px;" type="button" data-toggle="collapse"
                        data-target="#collapseOne<?=$x?>" aria-expanded="true" aria-controls="collapseOne<?=$x?>">
                    <?= $R->product_name ?>
                </button>
                <button type="button" class="btn btn-danger btn-sm deleteSingleCart" data-cartid="<?= $R->cart_id ?>">
                    <i class="bi bi-trash"></i>
                </button>
            </div>
        </div>

        <!-- OPEN BY DEFAULT -->
        <div id="collapseOne<?=$x?>" class="collapse show" aria-labelledby="headingOne<?=$x?>">
            <div class="card-body">
                <div class="row">
                    <div class="col-4">
                        <p class="text-center p-0" style="font-size:20px;padding:0px!important">QTY</p>
                        <div class="input-group bootstrap-touchspin bootstrap-touchspin-injected">
                    
                            <span class="input-group-btn input-group-prepend">
                                <button type="button" class="btn btn-primary bootstrap-touchspin-down increaseDecrease" data-cartid="<?= $R->cart_id ?>"  data-type="dec" data-qty="<?= $R->qty ?>"   data-stocks="<?= $R->total_stocks ?>"type="button">-</button>
                            </span>
                            
                            <input id="demo2" type="text" value="<?= $R->qty ?>" name="produdct_details[<?=$R->cart_id?>][qty]" class="form-control form-con text-center getDataSold" style="width: 50px; text-align: center;" readonly>
                            <input type="hidden" name="produdct_details[<?=$R->cart_id?>][stockid]" value="<?= $R->stock_id ?>" class="getDataSold" id="">
                            <input type="hidden" name="produdct_details[<?=$R->cart_id?>][productid]" value="<?= $R->product_id ?>" class="getDataSold" id="">
                            <input type="hidden" name="produdct_details[<?=$R->cart_id?>][price]" value="<?= $R->price ?>" class="getDataSold" id="">
                            <input type="hidden" name="produdct_details[<?=$R->cart_id?>][subtotal]" value="<?= $R->price * $R->qty ?>" class="getDataSold" id="">
                            
                            <span class="input-group-btn input-group-append">
                                <button type="button" class="btn btn-primary bootstrap-touchspin-up increaseDecrease" data-cartid="<?= $R->cart_id ?>" data-type="inc" data-qty="<?= $R->qty ?>"  data-stocks="<?= $R->total_stocks ?>" type="button">+</button>
                            </span>
                            
                        </div>
                    </div>
                    <div class="col-4">
                        <p class="text-center p-0" style="font-size:20px;padding:0px!important">Price / Each</p>
                        <p class="text-center p-0" style="font-size:20px;padding:0px!important"><?= number_format($R->price,2) ?></p>
                    </div>
                    <div class="col-4">
                        <p class="text-center p-0" style="font-size:20px;padding:0px!important">Sub Total</p>
                        <p class="text-center p-0" style="font-size:20px;padding:0px!important"><?= number_format($R->price * $R->qty,2) ?></p>
                    </div>
                </div>

            </div>
        </div>
    </div>
<?php
        $x++;
    }

?>
</div>
<div style="border: 1px solid rgb(35, 27, 27);padding:5px;">
    <p class="text-right" style="font-size:30px;">GRAND TOTAL : ₱<?= number_format($grand_total,2) ?> </p>
    <input type="hidden" name="grand_total" value="<?= $grand_total ?>" class="getDataSold" id="">

</div>
<div class="row mt-3 mb-2">
    <div class="col-6"><button type="button" class="btn btn-danger resetNow">Reset</button></div>
    <div class="col-6 text-right"><button type="button" class="btn btn-success distributeNow">Submit</button></div>
</div>
<?php 
    }else{
        echo '<h3 class="text-center mt-3">NO SELECTED PRODUCT!</h3>';
    } 
?>
 

