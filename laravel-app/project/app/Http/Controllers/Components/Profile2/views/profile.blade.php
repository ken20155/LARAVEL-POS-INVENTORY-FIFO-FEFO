<form class="row g-3" id="submit-form">
  <div class="col-md-12 text-center image-container"style="
  background-color: #c6bcddf2;
  border-radius: 50px;
">
        <?= $user_details->files == null ? '<img src="https://cdn-icons-png.flaticon.com/512/6325/6325109.png" class="img-fluid rounded-circle p-3 fixed-height" width="200" alt="Card image" id="original-image">' : '<img src="'.env('APP_URL').'public/main/uploaded/profile/'.$user_details->folder.'/'.$user_details->files.'" class="img-fluid rounded-circle p-3 fixed-height" width="200" alt="Card image" id="original-image">';?>
        <img class="uploaded-image fixed-height d-none" id="uploaded-image" width="200" alt="Uploaded image">
        <input name = "profile_img"   type="file" class="image-upload-btn" id="upload-btn">
        <input name="folder_name" type="hidden" class="form-control" id="validationDefault01" value="<?= $user_details->folder ?>" required>

    </div>
    <div class="col-md-4">
      <label for="validationDefault01" class="form-label">First name <span class="text-danger">*</span></label>
      <input name="first_name" type="text" class="form-control" id="validationDefault01" value="<?= $user_details->first_name ?>" required>
      <input name="user_id" type="hidden" class="form-control" id="validationDefault01" value="<?= $user_details->user_id ?>" required>
    </div>
    <div class="col-md-4">
      <label for="validationDefault02" class="form-label">Middle Name</label>
      <input name="middle_name" type="text" class="form-control" id="validationDefault02" value="<?= $user_details->middle_name ?>">
    </div>
    <div class="col-md-4">
      <label for="validationDefault02" class="form-label">Last name <span class="text-danger">*</span></label>
      <input name="last_name" type="text" class="form-control" id="validationDefault02" value="<?= $user_details->last_name ?>" required>
    </div>
    <div class="col-md-4">
      <label for="validationDefault02" class="form-label">Suffix (e.g. jr., Sr., I, II)</label>
      <input name="suffix" type="text" class="form-control" id="validationDefault02" value="<?= $user_details->suffix ?>" >
    </div>
    <div class="col-md-4">
      <label for="validationDefault02" class="form-label">Date of Birth <span class="text-danger">*</span></label>
      <input name="bday" type="date" class="form-control" id="validationDefault02" value="<?= $user_details->bday ?>" required>
    </div>
    <div class="col-md-4">
        <label for="validationDefault04" class="form-label">Civil Status <span class="text-danger">*</span></label>
        <select name="civil_status" class="form-select form-select-lg" id="validationDefault04" required>
            <option value="" selected disabled>-Select-</option>
            <option value="Legally separated" <?= 'Legally separated' == $user_details->civil_status ? 'selected' : '' ?>>Legally separated</option>
            <option value="Single" <?= 'Single' == $user_details->civil_status ? 'selected' : '' ?>>Single</option>
            <option value="Married" <?= 'Married' == $user_details->civil_status ? 'selected' : '' ?>>Married</option>
            <option value="Widowed" <?= 'Widowed' == $user_details->civil_status ? 'selected' : '' ?>>Widowed</option>
        </select>
    </div>
    <div class="col-md-4">
      <label for="validationDefault02" class="form-label">Phone Number <span class="text-danger">*</span></label>
      <input name="phone_number" type="number" class="form-control" id="validationDefault02" value="<?= $user_details->phone_number ?>" required>
    </div>
    <div class="col-md-4">
      <label for="validationDefault02" class="form-label">Email <span class="text-danger">*</span></label>
      <input name="email" type="email" class="form-control" id="validationDefault02" value="<?= $user_details->email ?>" required>
    </div>
    <div class="col-md-4">
        <label for="validationDefault04" class="form-label">Barangay <span class="text-danger">*</span></label>
        <select name="barangay" class="form-select form-select-lg" id="validationDefault04" required>
          <option value="" selected disabled>-Select-</option>
            <?php 
            $locations = [
            "BALUARTE",
            "CASINGLOT",
            "GRACIA",
            "MOHON",
            "NATUMOLAN",
            "POBLACION",
            "ROSARIO",
            "SANTA ANA",
            "SANTA CRUZ",
            "SUGBONGCOGON"
            ];
            foreach ($locations as $location) { 
              $selected = $location == $user_details->barangay ? 'selected' : '';
              ?>
                <option value="<?= $location ?>" <?= $selected ?>><?= $location ?></option>
            <?php  } ?>
        </select>
    </div>
    <div class="col-md-4">
        <label for="validationDefault04" class="form-label">Sex <span class="text-danger">*</span></label>
        <select name="gender" class="form-select form-select-lg" id="validationDefault04" required>
          <option value="" selected disabled>-Select-</option>
            <option value="Female" <?= 'Female' == $user_details->gender ? 'selected' : '' ?>>Female</option>
            <option value="Male" <?= 'Male' == $user_details->gender ? 'selected' : '' ?>>Male</option>
        </select>
    </div>
    <div class="col-md-4">
        <label for="validationDefault02" class="form-label">Citizenship <span class="text-danger">*</span></label>
        <input name="citizenship" type="text" class="form-control" id="validationDefault02" value="<?= $user_details->citizenship ?>" required>
    </div>
    <div class="col-md-4">
        <label for="validationDefault02" class="form-label">House/Building No. & Name <span class="text-danger">*</span></label>
        <input name="house_no" type="text" class="form-control" id="validationDefault02" value="<?= $user_details->house_no ?>" required>
    </div>
    <div class="col-md-4">
        <label for="validationDefault02" class="form-label">Street <span class="text-danger">*</span></label>
        <input name="street" type="text" class="form-control" id="validationDefault02" value="<?= $user_details->street ?>" required>
    </div>
    
    <div class="col-md-4">
        <label for="validationDefault02" class="form-label">Form of Ownership <span class="text-danger">*</span></label>
        <select name="form_ownership" class="form-select form-select-lg" id="validationDefault04" required>
          <option value="" selected disabled>-Select-</option>
            <?php 
            $locations2 = [
            "Sole Proprietorship",
            "Partnership",
            "Corporation",
            "Association",
            "Organization",
            "Foundation",
            "Rural Workers Org.",
            ];
            foreach ($locations2 as $location) { 
              $selected2 = $location == $user_details->form_ownership ? 'selected' : '';
              ?>
                <option value="<?= $location ?>" <?= $selected2 ?>><?= $location ?></option>
            <?php  } ?>
        </select>
    </div>
    
    <div class="col-md-4">
        <label for="validationDefault02" class="form-label">Category of Entrepreneur <span class="text-danger">*</span></label>
        <select name="category_entrepreneur" class="form-select form-select-lg" id="validationDefault04" required>
          <option value="" selected disabled>-Select-</option>
            <?php 
            $locations3 = [
            "Housewife/Husband",
            "Student",
            "Out of School Youth",
            "Military/Police",
            "Ex-convict",
            "Professional",
            "Private Employee",
            "Government Employee",
            "Retire",
            "Self-employed",
            "Unemployed",
            "OFW",
            "Drug Surrender",
            "Other",
            ];
            foreach ($locations3 as $location) {  
              $selected3 = $location == $user_details->category_entrepreneur ? 'selected' : '';
              ?>
                <option value="<?= $location ?>" <?= $selected3 ?>><?= $location ?></option>
            <?php  } ?>
        </select>
    </div>
    
    
    <div class="col-md-6">
      <label for="validationDefault03" class="form-label">Username <span class="text-danger">*</span></label>
      <input name="username" type="text" class="form-control" id="validationDefault03" value="<?= $user_details->username ?>"required>
    </div>
    <div class="col-md-6">
      <label for="validationDefault03" class="form-label">Password <span class="text-danger">(<i>Leave blank if no changes</i>)</span></label>
      <input name="password" type="password" class="form-control" id="validationDefault03">
    </div>
    <div class="col-12">
      <button class="btn btn-primary" type="submit">Update</button>
    </div>
  </form>