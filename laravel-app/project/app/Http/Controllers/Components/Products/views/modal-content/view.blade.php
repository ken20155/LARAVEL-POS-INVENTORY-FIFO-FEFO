<input type="hidden" class="form-control" id="validationDefault01" name = "action" value = "<?= $data ? 'edit' : 'add' ?>">
<input type="hidden" class="form-control" id="validationDefault01" name = "id" value = "<?= $data ? $data->product_id : '' ?>">
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
    <label for="validationDefault01" class="form-label">Product Name</label>
    <input type="text" class="form-control" id="validationDefault01" name = "product_name" value = "<?= $data ? $data->product_name : '' ?>" required>
  </div>
  <div class="col-md-12">
    <label for="validationDefault01" class="form-label">Product Category</label>
    <select class="form-control" aria-label="Default select example"  name = "product_category" required>
      <option selected disabled value="">-Select-</option>
      <option value="FOOD" <?= $data && $data->product_category == 'FOOD' ? 'selected' : '' ?>>FOOD</option>
      <option value="NON-FOOD" <?= $data && $data->product_category == 'NON-FOOD' ? 'selected' : '' ?>>NON-FOOD</option>
    </select>  
  </div>
  <div class="col-md-12">
    <label for="validationDefault02" class="form-label">Product Description</label>
    <input type="text" class="form-control" id="validationDefault02" name = "product_desc" value = "<?= $data ? $data->product_desc : '' ?>" required>
  </div>
  <div class="col-md-12">
    <label for="validationDefault02" class="form-label">Product Image</label>
    <input class="form-control" type="file" name = "product_image"  id="productImage" accept="image/*" <?= $data ? '' : 'required' ?> >
    <img id="imagePreview"
    <?php
    if ($data) {
      $BASEURL= env('APP_URL');
      echo 'src="'.$BASEURL.'public/main/uploaded/products/'.$data->file.'"';
    }
    ?>
    
    >

  </div>
</div>