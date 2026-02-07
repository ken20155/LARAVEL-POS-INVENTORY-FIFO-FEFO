

<input type="hidden" class="form-control" id="validationDefault01" name = "action" value = "<?= $data ? 'edit' : 'add' ?>">
<input type="hidden" class="form-control" id="validationDefault01" name = "id" value = "<?= $data ? $data->added_by : '' ?>">
<style>
  #imagePreview {
      /* display: none; */
      width: 200px;
      height: auto;
      margin-top: 10px;
      border-radius: 5px;
      border: 1px solid #ddd;
      padding: 5px;
  }
</style>
<div class="row">
  <div class="col-md-6">
    <label for="validationDefault01" class="form-label">Full name</label>
    <input readonly type="text" class="form-control" id="validationDefault01" name = "full_name" value = "<?= $data ? $data->full_name : '' ?>">
    <input readonly type="hidden" class="form-control" id="validationDefault01" name = "user_id" value = "<?= $data ? $data->added_by : '' ?>">
  </div>
  <div class="col-md-6">
    <label for="validationDefault01" class="form-label">Amount to Pay</label>
    <input readonly type="text" class="form-control" id="" name = "total_stocks" value = "<?= $data ? number_format($data->amount_to_pay,2) : '' ?>">
    <input readonly type="hidden" class="form-control" id="amount_to_pay" name = "amount_to_pay" value = "<?= $data ? $data->amount_to_pay : '' ?>">
  </div>
  <div class="col-md-6">
    <label for="validationDefault01" class="form-label">Balance</label>
    <input readonly type="text" class="form-control" id="balance_amount" name = "balance" value = "<?= $data && $data->balance_payment != null ? $data->balance_payment : 0 ?>">
    <input readonly type="hidden" class="form-control" id="balance_amount_con"  value = "<?= $data && $data->balance_payment != null ? $data->balance_payment : 0 ?>">
  </div>
  <div class="col-md-6">
    <label for="validationDefault01" class="form-label">Status</label>
    <input readonly type="text" class="form-control" id="status_payment" name = "status" value = "<?= $data ? $data->status : '' ?>">
  </div>
  <!-- <div class="col-md-12">
    <label for="validationDefault01" class="form-label">Input Amount</label>
    <input type="number" class="form-control" id="input_amount" name = "input_amount" value = "<?= $data && $data->status != 'PARTIAL' ? $data->amount_to_pay : $data->balance_payment ?>">
  </div>-->
  <div class="col-md-12" style="margin-top:30px">
    
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th scope="col">Product Name</th>
                    <th scope="col">Date Sold</th>
                    <th scope="col">Mark-up Price</th>
                    <th scope="col">QTY Sold</th>
                    <th scope="col">Base Price</th>
                    <th scope="col">Sub total</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                   $total = 0;
                    if ($product) {
                   
                        foreach ($product as $key => $R) {
                          $total += $R->base_price * $R->qty;
                          echo '<input readonly type="hidden" class="form-control" id="transaction_id" name = "transaction_id[]" value = "'.$R->transaction_id.'">';
                           ?>
                            <tr>
                                <td><?= $R->product_name ?></td>
                                <td><?= date(LONGDATE,strtotime($R->added_date))?></td>
                                <td><?= '₱'.number_format($R->mark_up_price,2) ?></td>
                                <td class="text-center"><?= $R->qty ?></td>
                                <td class="text-right"><?= '₱'.number_format($R->base_price,2) ?></td>
                                <td class="text-right"><?= '₱'.number_format($R->base_price * $R->qty,2) ?></td>
                            </tr>
                           <?php
                        }
                    } 
                ?>
            </tbody>
            <tfoot>
              <tr>
                <th colspan="5" class="text-right">Due to Consignor</th>
                <th class="text-right"><?= '₱'.number_format($total,2) ?></th>
              </tr>
            </tfoot>
        </table>

  </div>

  
</div>