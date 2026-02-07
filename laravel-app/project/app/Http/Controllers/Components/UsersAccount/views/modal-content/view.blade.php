<input type="hidden" class="form-control" id="validationDefault01" name = "action" value = "<?= $data ? 'edit' : 'add' ?>">
<input type="hidden" class="form-control" id="validationDefault01" name = "user_id" value = "<?= $data ? $data->user_id : '' ?>">

<div class="row">
  <div class="col-md-4">
    <label for="validationDefault01" class="form-label">First name</label>
    <input type="text" class="form-control" id="validationDefault01" name = "first_name" value = "<?= $data ? $data->first_name : '' ?>" required>
  </div>
  <div class="col-md-4">
    <label for="validationDefault02" class="form-label">Middle name</label>
    <input type="text" class="form-control" id="validationDefault02" name = "middle_name" value = "<?= $data ? $data->middle_name : '' ?>">
  </div>
  <div class="col-md-4">
    <label for="validationDefault02" class="form-label">Last name</label>
    <input type="text" class="form-control" id="validationDefault02" name = "last_name" value = "<?= $data ? $data->last_name : '' ?>" required>
  </div>
</div>
<div class="row">
  <div class="col-md-4">
    <label for="validationDefault01" class="form-label">Email</label>
    <input type="email" class="form-control" id="validationDefault01" name = "email" value = "<?= $data ? $data->email : '' ?>" required>
  </div>
  <div class="col-md-4">
    <label for="validationDefault02" class="form-label">User role</label>
    <select class="form-control" aria-label="Default select example" name = "user_role" required>
      <option selected disabled value="">-Select-</option>
      <option value="2" <?= $data && $data->user_role == 2 ? 'selected' : '' ?>>Consignor</option>
      <option value="1" <?= $data && $data->user_role == 1 ? 'selected' : '' ?>>Consignee</option>
     
    </select>
  </div>
  <div class="col-md-4">
    <label for="validationDefault02" class="form-label">Contact Number</label>
    <input type="text" class="form-control" id="validationDefault02" name = "phone_number" value = "<?= $data ? $data->phone_number : '' ?>" required>
  </div>
</div>
<div class="row">
    <div class="col-md-6">
        <label for="validationDefault01" class="form-label">Username</label>
        <input type="text" class="form-control" id="validationDefault01" name = "username" value = "<?= $data ? $data->username : '' ?>" required> 
      </div>
      <div class="col-md-6">
        <label for="validationDefault01" class="form-label">Password <?= $data ? "<i style='font-size:13px'>(Please leave the blank if you don't change)</i>" : '' ?></label>
        <input type="text" class="form-control" id="validationDefault01" name = "password" value = "" <?= $data ? '' : 'required' ?>>
      </div>
</div>