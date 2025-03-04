<div class="card shadow">
    <div class="card-header bg-primary text-white">
        <h4 style="color: #fff;">Applicant Bio Data</h4>
    </div>
    <div class="card-body">
        <form action="" method="post" enctype="multipart/form-data" id="bioForm">
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="supPosition" class="form-label">Position Categories</label>
                    <select id="supPosition" name="supPosition" class="form-select">
                        <option value="">--Select Supervisory Position--</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <label for="position" class="form-label">Position</label>
                    <select name="position" id="position" class="form-select">
                        <option value="">--Select Position--</option>
                    </select>
                </div>
            </div>
            
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="fname" class="form-label">Firstname</label>
                    <input type="text" name="firstname" class="form-control" value="<?php echo htmlspecialchars($_SESSION['user_firstname'])?>">
                </div>
                <div class="col-md-6">
                    <label for="passport" class="form-label">Passport (jpeg, png, jpg, max 2MB)</label>
                    <input type="file" name="passport" class="form-control" accept="image/jpeg,image/png,image/jpg">
                </div>
            </div>
            
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="mname" class="form-label">Middlename</label>
                    <input type="text" name="middlename" class="form-control" value="<?php echo htmlspecialchars($user_data['middlename'] ?? ''); ?>">
                </div>
                <div class="col-md-6">
                    <label for="lname" class="form-label">Surname</label>
                    <input type="text" name="lastname" class="form-control" value="<?php echo htmlspecialchars($_SESSION['user_lastname']) ?? ''?>">
                </div>
            </div>
            
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="gender" class="form-label">Gender</label>
                    <select name="gender" class="form-select">
                        <option value="" disabled hidden selected>--select an option--</option>
                        <option value="Male" <?php echo (isset($user_data['gender']) && $user_data['gender'] == 'Male') ? 'selected' : ''; ?>>Male</option>
                        <option value="Female" <?php echo (isset($user_data['gender']) && $user_data['gender'] == 'Female') ? 'selected' : ''; ?>>Female</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <label for="DoF" class="form-label">Date of Birth</label>
                    <input type="date" name="dateOfBirth" class="form-control" value="<?php echo htmlspecialchars($user_data['dateOfBirth'] ?? ''); ?>">
                </div>
            </div>
            
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="number" class="form-label">Phone Number</label>
                    <input type="text" name="phoneNumber" class="form-control" value="<?php echo htmlspecialchars($user_data['phoneNumber'] ?? ''); ?>">
                </div>
                <div class="col-md-6">
                    <label for="nin" class="form-label">NIN</label>
                    <input type="text" name="nin" class="form-control" value="<?php echo htmlspecialchars($user_data['nin'] ?? ''); ?>">
                </div>
            </div>
            
            <div class="mb-3">
                <label for="address" class="form-label">Residential Address</label>
                <input type="text" name="address" class="form-control" value="<?php echo htmlspecialchars($user_data['address'] ?? ''); ?>">
            </div>
            
            <div class="" style="text-align: right;">
                <button type="submit" name="saveBio" class="btn btn-primary">
                    <svg xmlns="http://www.w3.org/2000/svg" width="1.5em" height="1.5em" viewBox="0 0 24 24">
                        <path fill="white" d="M20 7.423v10.962q0 .69-.462 1.153T18.384 20H5.616q-.691 0-1.153-.462T4 18.384V5.616q0-.691.463-1.153T5.616 4h10.961zm-8.004 9.115q.831 0 1.417-.582T14 14.543t-.582-1.418t-1.413-.586t-1.419.581T10 14.535t.582 1.418t1.414.587M6.769 9.77h7.423v-3H6.77z" />
                    </svg>
                    Save
                </button>
            </div>
        </form>
    </div>
</div>
