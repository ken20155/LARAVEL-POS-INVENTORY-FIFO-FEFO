<input type="hidden" class="form-control" id="validationDefault01" name = "action" value = "<?= $data ? 'edit' : 'add' ?>">
<input type="hidden" class="form-control" id="validationDefault01" name = "id" value = "<?= $data ? $data->stock_id : '' ?>">
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
  <div class="col-md-12">
    <label for="validationDefault01" class="form-label">Product</label>
    <select class="form-control" aria-label="Default select example" name = "product_id" required>
      <option selected disabled value="">-Select-</option>
      <?php 
      if ($products) {
        foreach ($products as $key => $R) {
          $selected = $data && $data->product_id == $R->product_id ? 'selected' : '';

          echo '<option value="'.$R->product_id.'" '.$selected.'>'.$R->product_name.'</option>';
         
        }
      }
      ?>
     
    </select>
  </div>
  <div class="col-md-12">
    <label for="validationDefault01" class="form-label">Stocks</label>
    <input type="number" class="form-control" id="validationDefault01" name = "total_stocks" value = "<?= $data ? $data->total_stocks : '' ?>" required>
  </div>
  <div class="col-md-12">
    <label for="validationDefault02" class="form-label">Notify when stock is below</label>
    <input type="number" class="form-control" id="validationDefault02" name = "notify_stocks" value = "<?= $data ? $data->notify_stocks : '' ?>" required>
  </div>
  
  <div class="col-md-12">
    <label for="validationDefault02" class="form-label">Price</label>
    <input type="number" class="form-control" id="validationDefault02" name = "price" value = "<?= $data ? $data->price : '' ?>" required>
  </div>
  <div class="col-md-12">
    <label for="validationDefault02" class="form-label">Expiration Date</label>
    <input type="date" class="form-control" id="validationDefault02" name = "expiration_date" value = "<?= $data ? $data->expiration_date : '' ?>"  min="<?= date(SQLDATE) ?>" required>
  </div>
  
</div>