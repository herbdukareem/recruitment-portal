<div id="biodata-screen" style="display: block;">
                <div class="head-bio">
                    <div class="left-bio">
                        <h2>Bio Data</h2>
                    </div>
                    <div class="right-bio">
                        <p><a href="" style="color: #008f4a;"> Job Application</a> / <a href=""><svg xmlns="http://www.w3.org/2000/svg" width="0.9em" height="0.9em" viewBox="0 0 24 24">
                                    <path fill="#000000" d="M17 13h-4v4h-2v-4H7v-2h4V7h2v4h4m2-8H5c-1.11 0-2 .89-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V5a2 2 0 0 0-2-2" />
                                </svg>Bio Data</a></p>
                    </div>
                </div>
                <div class="body-bio">
                    <form action="" method="post">
                        <div class="form-head">
                            <h2>Candidate Bio Data</h2>
                        </div>
                        <div class="form-body">
                            <table>
                                <tr>
                                    <td>
                                        <div>
                                            <label for="fname">Firstname</label>
                                        </div>
                                        <div>
                                            <input type="text" name="firstname" id="" value="<?php echo htmlspecialchars($_SESSION['user_firstname'])?>">
                                        </div>
                                    </td>
                                    <td>
                                        <div>
                                            <label for="mname">Middlename</label>
                                        </div>
                                        <div>
                                            <input type="text" name="middlename" id=""  value="<?php echo htmlspecialchars($user_data['middlename'] ?? ''); ?>">
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div>
                                            <label for="lname">Lastname</label>
                                        </div>
                                        <div>
                                            <input type="text" name="lastname" id=""  value=" <?php echo htmlspecialchars($_SESSION['user_lastname'])?>">
                                        </div>
                                    </td>
                                    <td>
                                        <div>
                                            <label for="gender">Gender</label>
                                        </div>
                                        <div>
                                            <select name="gender" id="" value="<?= $gender?>">
                                                <option value="" disabled hidden selected> --select an option--</option>
                                                <option value="Male" <?php echo (isset($user_data['gender']) && $user_data['gender'] == 'Male') ? 'selected' : ''; ?>>Male</option>
                                                <option value="Female" <?php echo (isset($user_data['gender']) && $user_data['gender'] == 'Female') ? 'selected' : ''; ?>>Female</option>
                                            </select>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div>
                                            <label for="DoF">Date of Birth</label>
                                        </div>
                                        <div>
                                            <input type="date" name="dateOfBirth" id="" value="<?php echo htmlspecialchars($user_data['dateOfBirth'] ?? ''); ?>" placeholder="mm/dd/yy">
                                        </div>
                                    </td>
                                    <td>
                                        <div>
                                            <label for="">Birth Certifiate <i>(file types, jpeg, png, pdf, size limit 2MB)</i></label>
                                        </div>
                                        <div>
                                            <input type="file" name="birthCertificate" id="" value="" placeholder="No file chosen">
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div>
                                            <label for="">Marital status</label>
                                        </div>
                                        <div>
                                            <select name="maritalStatus" id="" Value="">
                                                <option value="" disabled hidden selected> --select an option--</option>
                                                <option value="Married" <?php echo (isset($user_data['maritalStatus']) && $user_data['maritalStatus'] == 'Married') ? 'selected' : ''; ?>>Married</option>
                                                <option value="Single" <?php echo (isset($user_data['maritalStatus']) && $user_data['maritalStatus'] == 'Single') ? 'selected' : ''; ?>>Single</option>
                                                <option value="Divorce" <?php echo (isset($user_data['maritalStatus']) && $user_data['maritalStatus'] == 'Divorce') ? 'selected' : ''; ?>>Divorce</option>
                                            </select>
                                        </div>
                                    </td>
                                    <td>
                                        <div>
                                            <label for="">State of Origin</label>
                                        </div>
                                        <div>
                                            <select name="stateOfOrigin" id="" Value="">
                                                <option value="" disabled hidden selected> --select an option--</option>
                                                <option value="Osun"  <?php echo (isset($user_data['stateOfOrigin']) && $user_data['stateOfOrigin'] == 'Osun') ? 'selected' : ''; ?>>Osun</option>
                                                <option value="Ogun" <?php echo (isset($user_data['stateOfOrigin']) && $user_data['stateOfOrigin'] == 'Ogun') ? 'selected' : ''; ?>>Ogun</option>
                                                <option value="Ekiti" <?php echo (isset($user_data['stateOfOrigin']) && $user_data['stateOfOrigin'] == 'Ekiti') ? 'selected' : ''; ?>>Ekiti</option>
                                            </select>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div>
                                            <label for="lga">LGA</label>
                                        </div>
                                        <div>
                                            <select name="localGovernmentArea" id="" Value="">
                                                <option value="" disabled hidden selected> --select an option--</option>
                                                <option value="Obokun" <?php echo (isset($user_data['localGovernmentArea']) && $user_data['localGovernmentArea'] == 'Obokun') ? 'selected' : ''; ?>>Obokun</option>
                                                <option value="Ido" <?php echo (isset($user_data['localGovernmentArea']) && $user_data['localGovernmentArea'] == 'Ido') ? 'selected' : ''; ?>>Ido</option>
                                            </select>
                                        </div>
                                    </td>
                                    <td>
                                        <div>
                                            <label for="lga-cert">LGA Indigene\Origin Certifiate <i>(file types, jpeg, png, pdf, size limit 2MB)</i></label>
                                        </div>
                                        <div>
                                            <input type="file" name="lgaCertificate" id="" value="" placeholder="No file chosen">
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div>
                                            <label for="nin">NIN</label>
                                        </div>
                                        <div>
                                            <input type="text" name="nin" id="" value="<?php echo htmlspecialchars($user_data['nin'] ?? ''); ?>">
                                        </div>
                                    </td>
                                    <td>
                                        <div>
                                            <label for="number">Phone Number</label>
                                        </div>
                                        <div id="Emergency">
                                            <select name="phone_abb" id="" >
                                                <option value="" disabled hidden selected> --select an option--</option>
                                                <option value="+234">+234</option>
                                                <option value="+234">+234</option>
                                                <option value="+234">+234</option>
                                                <option value="+234">+234</option>
                                                <option value="+234">+234</option>
                                            </select>
                                            <input type="text" name="phoneNumber" id=""  value="<?php echo htmlspecialchars($user_data['phoneNumber'] ?? ''); ?>">
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div>
                                            <label for="">Emergency number</label>
                                        </div>
                                        <div id="Emergency">
                                            <select name="" id="">
                                                <option value="" disabled hidden selected> --select an option--</option>
                                                <option value="+234">+234</option>
                                                <option value="+234">+234</option>
                                                <option value="+234">+234</option>
                                                <option value="+234">+234</option>
                                                <option value="+234">+234</option>
                                            </select>
                                            <input type="text" name="emergencyNumber" id="" value="<?php echo htmlspecialchars($user_data['emergencyNumber'] ?? ''); ?>">
                                        </div>
                                    </td>
                                    <td>
                                        <div>
                                            <label for="">Residetial Address</label>
                                        </div>
                                        <div>
                                            <input type="text" name="address" id="" value="<?php echo htmlspecialchars($user_data['address'] ?? ''); ?>">
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div class="form-footer">
                            <button type="submit" name="saveBio">
                                <svg xmlns="http://www.w3.org/2000/svg" width="1.5em" height="1.5em" viewBox="0 0 24 24">
                                    <path fill="white" d="M20 7.423v10.962q0 .69-.462 1.153T18.384 20H5.616q-.691 0-1.153-.462T4 18.384V5.616q0-.691.463-1.153T5.616 4h10.961zm-8.004 9.115q.831 0 1.417-.582T14 14.543t-.582-1.418t-1.413-.586t-1.419.581T10 14.535t.582 1.418t1.414.587M6.769 9.77h7.423v-3H6.77z" />
                                </svg>
                                Save
                            </button>
                        </div>
                    </form>
                </div>
            </div>