<?php 
if ($data) {
    $grand_total = 0;
    foreach ($data as $key => $R) {
       $grand_total += $R->sub_total;
       ?>
        <tr>
            <td scope="row">
                <?= $R->product_name ?>
                
            </td>
            <td class="text-center">
                <div class="input-group bootstrap-touchspin bootstrap-touchspin-injected" 
                    style="margin: 0 auto; max-width: 120px; display: flex; justify-content: center; align-items: center;">
                    
                    <span class="input-group-btn input-group-prepend">
                        <button class="btn btn-primary btn-sm bootstrap-touchspin-down increaseDecrease" data-cartid="<?= $R->cart_id ?>"  data-type="dec" data-qty="<?= $R->qty ?>"   data-stocks="<?= $R->total_stocks ?>"type="button">-</button>
                    </span>
                    
                            <input id="demo2" type="text" value="<?= $R->qty ?>" data-cartid="<?= $R->cart_id ?>" name="produdct_details[<?=$R->cart_id?>][qty]" class="form-control form-control-sm text-center getDataSold input-pos-qty" style="width: 50px; text-align: center;" data-stocks="<?= $R->total_stocks ?>">
                    
                    <span class="input-group-btn input-group-append">
                        <button class="btn btn-primary btn-sm bootstrap-touchspin-up increaseDecrease" data-cartid="<?= $R->cart_id ?>" data-type="inc" data-qty="<?= $R->qty ?>"  data-stocks="<?= $R->total_stocks ?>" type="button">+</button>
                    </span>
                    
                </div>
            </td>
            
            <td class="text-right"><?= number_format($R->price,2) ?></td>
            <th class="text-right"><?= number_format($R->sub_total * $R->qty,2) ?></th>
            <td>
                <button type="button" class="btn btn-danger btn-sm deleteSingleCart"  data-cartid="<?= $R->cart_id ?>"><i class="icon-copy bi bi-trash"></i></button>
            </td>
        </tr>
       <?php
    }
    ?>
        <tr>
            <th colspan="3" class="text-right">Total</th>
            <th class="text-right"><?=number_format($grand_total,2)?></th>
            <td></td>
        </tr>
        <tr>
            <td colspan="4"><button type="button" class="btn btn-danger btn-sm resetNow">Reset</button></td>
            <td colspan="2"><button type="button" class="btn btn-success btn-sm distributeNow">Distribute</button></td>
        </tr>
    <?php
}else{
    ?>
        <tr >
            <td class="text-center" colspan="4">NO SELECTED PRODUCTS</td>
        </tr>
    <?php
}
?>
