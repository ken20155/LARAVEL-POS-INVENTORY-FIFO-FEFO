
<form class="row g-3" id="submit-form">
  <div class="row">
    <div class="col-md-3 text-center image-container">
        <?= $user_details->files == null ? '<img src="https://cdn-icons-png.flaticon.com/512/5951/5951752.png" class="img-fluid rounded-circle p-3 fixed-height" width="200" alt="Card image" id="original-image">' : '<img src="'.env('APP_URL').'public/main/uploaded/profile/'.$user_details->folder.'/'.$user_details->files.'" class="img-fluid rounded-circle p-3 fixed-height" width="200" alt="Card image" id="original-image">';?>
        <img class="uploaded-image fixed-height d-none" id="uploaded-image" width="200" alt="Uploaded image">
        <input name = "profile_img"  accept="image/*" type="file" class="image-upload-btn" id="upload-btn">
    </div>
    <div class="col-md-9 mt-2">
        <div class="row">
          <div class="col-md-4 mt-2">
            <label for="validationDefault01" class="form-label">First name <span class="text-danger">*</span></label>
            <input name="first_name" type="text" class="form-control" id="validationDefault01" value="<?= $user_details->first_name ?>" required>
            <input name="user_id" type="hidden" class="form-control" id="validationDefault01" value="<?= $user_details->user_id ?>" required>
            <input name="folder_name" type="hidden" class="form-control" id="validationDefault01" value="<?= $user_details->folder ?>" required>
          </div>
          <div class="col-md-4 mt-2">
            <label for="validationDefault02" class="form-label">Middle Name</label>
            <input name="middle_name" type="text" class="form-control" id="validationDefault02" value="<?= $user_details->middle_name ?>">
          </div>
          <div class="col-md-4 mt-2">
            <label for="validationDefault02" class="form-label">Last name <span class="text-danger">*</span></label>
            <input name="last_name" type="text" class="form-control" id="validationDefault02" value="<?= $user_details->last_name ?>" required>
          </div>
          <div class="col-md-4 mt-2">
            <label for="validationDefault02" class="form-label">Date of Birth <span class="text-danger">*</span></label>
            <input name="bday" type="date" class="form-control" id="validationDefault02" value="<?= $user_details->bday ?>" required>
          </div>
          <div class="col-md-4 mt-2">
            <label for="validationDefault02" class="form-label">Contact Number <span class="text-danger">*</span></label>
            <input name="phone_number" type="number" class="form-control" id="validationDefault02" value="<?= $user_details->phone_number ?>" required>
          </div>
          <div class="col-md-4 mt-2">
            <label for="validationDefault02" class="form-label">Email <span class="text-danger">*</span></label>
            <input name="email" type="email" class="form-control" id="validationDefault02" value="<?= $user_details->email ?>" required>
          </div>
        </div>
    </div>
  </div>


   

    

 
    
    
    <div class="col-md-4 mt-2">
      <label for="validationDefault03" class="form-label">Username <span class="text-danger">*</span></label>
      <input name="username" type="text" class="form-control" id="validationDefault03" value="<?= $user_details->username ?>"required>
    </div>
    <div class="col-md-4 mt-2">
      <label for="validationDefault03" class="form-label">Password <span class="text-danger">(<i>Leave blank if no changes</i>)</span></label>
      <input name="password" type="password" class="form-control" id="validationDefault03">
    </div>
    <div class="col-12 mt-3">
      <button class="btn btn-primary" type="submit">Update</button>
    </div>
  </form>