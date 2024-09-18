<div id="education-screen" class="screen" style="display: none;">
                <div class="screen-head">
                    <div class="screen-head-left">
                        <h2>Education</h2>
                    </div>
                    <div class="screen-head-right">
                        <p><a href="" style="color: #008f4a;"> Job Application</a> / <a href=""><svg xmlns="http://www.w3.org/2000/svg" width="0.9em" height="0.9em" viewBox="0 0 24 24">
                                    <path fill="#000000" d="M17 13h-4v4h-2v-4H7v-2h4V7h2v4h4m2-8H5c-1.11 0-2 .89-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V5a2 2 0 0 0-2-2" />
                                </svg>Education</a></p>
                    </div>
                </div>
                <div class="screen-body body-edu">
                    <div class="left-edu">
                        <div id="pri-btn">Primary Education</div>
                        <div id="sec-btn">Secondary Education</div>
                        <div id="higher-btn">Higher Education</div>
                        <div id="nysc-btn">NYSC</div>
                    </div>
                    <div class="right-edu">
                        <div id="userEduDetails">
                            <!-- Display form input include save -->
                            <form action="" method="post">
                                <style>
                                    th{
                                        text-align: left;
                                        font-size: 0.7em;
                                    }
                                </style>
                                <div class="form-head">
                                    <h2>Education History</h2>
                                </div>
                                <!-- Primary -->
                                <div class="no-br">
                                    <div class="form-head">
                                        <h3>Primary Education</h3>
                                    </div>
                                    <table id="pri-input-table-body">
                                        <tr>
                                            <th>
                                                <div>
                                                    <label for="">School Name</label>
                                                </div>
                                            </th>
                                            <th>
                                                <div>
                                                    <label for="">Graduation Year</label>
                                                </div>
                                            </th>
                                            <th>
                                                <div>
                                                    <label for="">Action</label>
                                                </div>
                                            </th>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div>
                                                    <input type="text" name="primary_school_name" id="priEduText" value="<?php echo htmlspecialchars($user_edu_data['primary_school_name']); ?>">
                                                </div>
                                            </td>
                                            <td>
                                                <div>
                                                    <input type="text" name="primary_graduation_year" id="priEduYear" value="<?php echo htmlspecialchars($user_edu_data['primary_graduation_year']); ?>">
                                                </div>
                                            </td>
                                            <td>
                                                <div>
                                                    <button id="" name="delete" value="delete_id" onclick="removeRow(this)">Remove</button>
                                                </div>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                                <!-- Secondary -->
                                <div class="no-br">
                                    <div class="form-head">
                                        <h3>Secondary Education</h3>
                                    </div>
                                    <table id="sec-input-table-body">
                                        <tr>
                                            <th>
                                                <div>
                                                    <label for="">School Name</label>
                                                </div>
                                            </th>
                                            <th>
                                                <div>
                                                    <label for="">Graduation Year</label>
                                                </div>
                                            </th>
                                            <th>
                                                <div>
                                                    <label for="">Certificate</label>
                                                </div>
                                            </th>
                                            <th>
                                                <div>
                                                    <label for="">Action</label>
                                                </div>
                                            </th>
                                        </tr>
                                        <tr data-id="2">
                                            <td>
                                                <div>
                                                    <input type="text" name="secondarySchoolName" id="secondarySchoolName" value="<?php echo htmlspecialchars($user_edu_data['secondarySchoolName']); ?>">
                                                </div>
                                            </td>
                                            <td>
                                                <div>
                                                    <input type="text" name="secondaryGraduationYear" id="secondaryGraduationYear" value="<?php echo htmlspecialchars($user_edu_data['secondaryGraduationYear']); ?>">
                                                </div>
                                            </td>
                                            <td>
                                                <div>
                                                    <input type="file" name="secondaryCertificate" id="secondaryCertificate" value="">
                                                </div>
                                            </td>
                                            <td>
                                                <div>
                                                    <button id="" name="delete" onclick="removeRow(this)">Remove</button>
                                                </div>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                                <!-- Higher -->
                                <div class="no-br">
                                    <div class="form-head">
                                        <h3>Higher Education</h3>
                                    </div>
                                    <table id="high-input-table-body">
                                        <tr>
                                            <th>
                                                <div>
                                                    <label for="">Certificate Type</label>
                                                </div>
                                            </th>
                                            <th>
                                                <div>
                                                    <label for="">Class Of Degree</label>
                                                </div>
                                            </th>
                                            <th>
                                                <div>
                                                    <label for="">Institution</label>
                                                </div>
                                            </th>
                                            <th>
                                                <div>
                                                    <label for="">Course</label>
                                                </div>
                                            </th>
                                            <th>
                                                <div>
                                                    <label for="">Graduation Year</label>
                                                </div>
                                            </th>
                                            <th>
                                                <div>
                                                    <label for="">Certificate</label>
                                                </div>
                                            </th>
                                            <th>
                                                <div>
                                                    <label for="">Action</label>
                                                </div>
                                            </th>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div>
                                                    <input type="text" name="certificateType" id="certificateType" value="<?php echo htmlspecialchars($user_edu_data['certificateType']); ?>">
                                                </div>
                                            </td>
                                            <td>
                                                <div>
                                                    <input type="text" name="classOfDegree" id="classOfDegree" value="<?php echo htmlspecialchars($user_edu_data['classOfDegree']); ?>">
                                                </div>
                                            </td>
                                            <td>
                                                <div>
                                                    <input type="text" name="institution" id="institution" value="<?php echo htmlspecialchars($user_edu_data['institution']); ?>">
                                                </div>
                                            </td>
                                            <td>
                                                <div>
                                                    <input type="text" name="course" id="course" value="<?php echo htmlspecialchars($user_edu_data['course']); ?>">
                                                </div>
                                            </td>
                                            <td>
                                                <div>
                                                    <input type="text" name="highGraduationYear" id="highGraduationYear" value="<?php echo htmlspecialchars($user_edu_data['highGraduationYear']); ?>">
                                                </div>
                                            </td>
                                            <td>
                                                <div>
                                                    <input type="file" name="highCertificate" id="highCertificate" value="">
                                                </div>
                                            </td>
                                            <td>
                                                <div>
                                                    <button id="" name="delete" onclick="removeRow(this)">Remove</button>
                                                </div>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                                <!-- NYSC -->
                                <div class="no-br">
                                    <div class="form-head">
                                        <h3>NYSC</h3>
                                    </div>
                                    <table id="nysc-input-table-body">
                                        <tr>
                                            <th>
                                                <div>
                                                    <label for="">Certificate Number</label>
                                                </div>
                                            </th>
                                            <th>
                                                <div>
                                                    <label for="">Year Of Service</label>
                                                </div>
                                            </th>
                                            <th>
                                                <div>
                                                    <label for="">Certificate</label>
                                                </div>
                                            </th>
                                            <th>
                                                <div>
                                                    <label for="">Action</label>
                                                </div>
                                            </th>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div>
                                                    <input type="text" name="nyscCertificateNumber" id="nyscCertificateNumber" value="<?php echo htmlspecialchars($user_edu_data['nyscCertificateNumber']); ?>">
                                                </div>
                                            </td>
                                            <td>
                                                <div>
                                                    <input type="text" name="yearOfService" id="yearOfService" value="<?php echo htmlspecialchars($user_edu_data['yearOfService']); ?>">
                                                </div>
                                            </td>
                                            <td>
                                                <div>
                                                    <input type="file" name="nyscCertificate" id="nyscCertificate" value="">
                                                </div>
                                            </td>
                                            <td>
                                                <div>
                                                    <button id="" name="delete" onclick="removeRow(this)">Remove</button>
                                                </div>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="form-footer">
                                    <button type="submit" name="saveEdu">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="1.5em" height="1.5em" viewBox="0 0 24 24">
                                            <path fill="white" d="M20 7.423v10.962q0 .69-.462 1.153T18.384 20H5.616q-.691 0-1.153-.462T4 18.384V5.616q0-.691.463-1.153T5.616 4h10.961zm-8.004 9.115q.831 0 1.417-.582T14 14.543t-.582-1.418t-1.413-.586t-1.419.581T10 14.535t.582 1.418t1.414.587M6.769 9.77h7.423v-3H6.77z" />
                                        </svg>
                                        Save
                                    </button>
                                </div>
                            </form>
                        </div>
                        <div id="primary">
                                    <!-- Add form iincludes add up -->
                            <form action="" method="post" id="priAddformSubmit" class="mar-top">
                                <div class="form-head">
                                    <h2>Primary Education</h2>
                                </div>
                                <div class="form-body">
                                    <table>
                                        <tr>
                                            <td>
                                                <div>
                                                    <label for="">School Name</label>
                                                </div>
                                                <div>
                                                    <input type="text" name="" id="addPriText" value="">
                                                </div>
                                            </td>
                                            <td>
                                                <div>
                                                    <label for="">Graduation Year</label>
                                                </div>
                                                <div>
                                                    <input type="text" name="" id="addPriYear" value="" placeholder="2000-2024">
                                                </div>
                                            </td>
                                        </tr>

                                    </table>
                                </div>
                                <div class="form-footer">
                                    <button id="" type="submit">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="1.5em" height="1.5em" viewBox="0 0 24 24">
                                            <g fill="none" stroke="white" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"><path stroke-dasharray="64" stroke-dashoffset="64" d="M13 3l6 6v12h-14v-18h8"><animate fill="freeze" attributeName="stroke-dashoffset" dur="0.6s" values="64;0"/></path><path stroke-dasharray="14" stroke-dashoffset="14" stroke-width="1" d="M12.5 3v5.5h6.5"><animate fill="freeze" attributeName="stroke-dashoffset" begin="0.7s" dur="0.2s" values="14;0"/></path><path stroke-dasharray="8" stroke-dashoffset="8" d="M9 14h6"><animate fill="freeze" attributeName="stroke-dashoffset" begin="0.9s" dur="0.2s" values="8;0"/></path><path stroke-dasharray="8" stroke-dashoffset="8" d="M12 11v6"><animate fill="freeze" attributeName="stroke-dashoffset" begin="1.1s" dur="0.2s" values="8;0"/></path></g>
                                        </svg>
                                        Add
                                    </button>
                                </div>
                            </form>
                        </div>
                        <div id="secondary" style="display: none;">
                                    <!-- Add form iincludes add up -->
                            <form action="" method="post" id="secAddformSubmit" class="mar-top">
                                <div class="form-head">
                                    <h2>Secondary Education</h2>
                                </div>
                                <div class="form-body">
                                    <table>
                                        <tr>
                                            <td>
                                                <div>
                                                    <label for="">School Name</label>
                                                </div>
                                                <div>
                                                    <input type="text" name="" id="addSecondarySchoolName" value="">
                                                </div>
                                            </td>
                                            <td>
                                                <div>
                                                    <label for="">Graduation Year</label>
                                                </div>
                                                <div>
                                                    <input type="text" name="" id="addSecondaryGraduationYear" value="" placeholder="2000-2024">
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="2">
                                                <div>
                                                    <label for="">Certificate</label>
                                                </div>
                                                <div>
                                                    <input type="file" name="" id="addSecondaryCertificate" value="">
                                                </div>
                                            </td>
                                        </tr>

                                    </table>
                                </div>
                                <div class="form-footer">
                                    <button  type="submit">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="1.5em" height="1.5em" viewBox="0 0 24 24">
                                            <g fill="none" stroke="white" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"><path stroke-dasharray="64" stroke-dashoffset="64" d="M13 3l6 6v12h-14v-18h8"><animate fill="freeze" attributeName="stroke-dashoffset" dur="0.6s" values="64;0"/></path><path stroke-dasharray="14" stroke-dashoffset="14" stroke-width="1" d="M12.5 3v5.5h6.5"><animate fill="freeze" attributeName="stroke-dashoffset" begin="0.7s" dur="0.2s" values="14;0"/></path><path stroke-dasharray="8" stroke-dashoffset="8" d="M9 14h6"><animate fill="freeze" attributeName="stroke-dashoffset" begin="0.9s" dur="0.2s" values="8;0"/></path><path stroke-dasharray="8" stroke-dashoffset="8" d="M12 11v6"><animate fill="freeze" attributeName="stroke-dashoffset" begin="1.1s" dur="0.2s" values="8;0"/></path></g>
                                        </svg>
                                        Add
                                    </button>
                                </div>
                            </form>
                        </div>
                        <div id="higher" style="display: none;">
                                    <!-- Add form iincludes add up -->
                            <form action="" method="post" id="highAddformSubmit" class="mar-top">
                                <div class="form-head">
                                    <h2>Higher Education</h2>
                                </div>
                                <div class="form-body">
                                    <table>
                                        <tr>
                                            <td>
                                                <div>
                                                    <label for="">Certificate Type</label>
                                                </div>
                                                <div>
                                                    <input type="text" name="" id="addCertificateType" value="">
                                                </div>
                                            </td>
                                            <td>
                                                <div>
                                                    <label for="">Class Of Degree</label>
                                                </div>
                                                <div>
                                                    <input type="text" name="" id="addClassOfDegree" value="">
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div>
                                                    <label for="">Institution</label>
                                                </div>
                                                <div>
                                                    <input type="text" name="" id="addInstitution" value="">
                                                </div>
                                            </td>
                                            <td>
                                                <div>
                                                    <label for="">Course</label>
                                                </div>
                                                <div>
                                                    <input type="text" name="" id="addCourse" value="">
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div>
                                                    <label for="">Graduation Year</label>
                                                </div>
                                                <div>
                                                    <input type="text" name="" id="addHighGraduationYear" value="">
                                                </div>
                                            </td>
                                            <td>
                                                <div>
                                                    <label for="">Certificate</label>
                                                </div>
                                                <div>
                                                    <input type="file" name="" id="addHighCertificate" value="" placeholder="2000-2024">
                                                </div>
                                            </td>
                                        </tr>

                                    </table>
                                </div>
                                <div class="form-footer">
                                    <button type="submit">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="1.5em" height="1.5em" viewBox="0 0 24 24">
                                            <g fill="none" stroke="white" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"><path stroke-dasharray="64" stroke-dashoffset="64" d="M13 3l6 6v12h-14v-18h8"><animate fill="freeze" attributeName="stroke-dashoffset" dur="0.6s" values="64;0"/></path><path stroke-dasharray="14" stroke-dashoffset="14" stroke-width="1" d="M12.5 3v5.5h6.5"><animate fill="freeze" attributeName="stroke-dashoffset" begin="0.7s" dur="0.2s" values="14;0"/></path><path stroke-dasharray="8" stroke-dashoffset="8" d="M9 14h6"><animate fill="freeze" attributeName="stroke-dashoffset" begin="0.9s" dur="0.2s" values="8;0"/></path><path stroke-dasharray="8" stroke-dashoffset="8" d="M12 11v6"><animate fill="freeze" attributeName="stroke-dashoffset" begin="1.1s" dur="0.2s" values="8;0"/></path></g>
                                        </svg>
                                        Add
                                    </button>
                                </div>
                            </form>
                        </div>
                        <div id="nysc" style="display: none;">
                                    <!-- Add form iincludes add up -->
                            <form action="" method="post" id="nyscAddformSubmit" class="mar-top">
                                <div class="form-head">
                                    <h2>NYSC</h2>
                                </div>
                                <div class="form-body">
                                    <table>
                                        <tr>
                                            <td>
                                                <div>
                                                    <label for="">NYSC Certificate Number</label>
                                                </div>
                                                <div>
                                                    <input type="text" name="" id="addNyscCertificateNumber" value="">
                                                </div>
                                            </td>
                                            <td>
                                                <div>
                                                    <label for="">Year Of Service</label>
                                                </div>
                                                <div>
                                                    <input type="text" name="" id="addYearOfService" value="" placeholder="2000-2024">
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="2">
                                                <div>
                                                    <label for="">NYSC/Exemption Certificate</label>
                                                </div>
                                                <div>
                                                    <input type="file" name="" id="addNyscCertificate" value="">
                                                </div>
                                            </td>
                                        </tr>

                                    </table>
                                </div>
                                <div class="form-footer">
                                    <button id="nyscAddRow" type="submit">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="1.5em" height="1.5em" viewBox="0 0 24 24">
                                            <g fill="none" stroke="white" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"><path stroke-dasharray="64" stroke-dashoffset="64" d="M13 3l6 6v12h-14v-18h8"><animate fill="freeze" attributeName="stroke-dashoffset" dur="0.6s" values="64;0"/></path><path stroke-dasharray="14" stroke-dashoffset="14" stroke-width="1" d="M12.5 3v5.5h6.5"><animate fill="freeze" attributeName="stroke-dashoffset" begin="0.7s" dur="0.2s" values="14;0"/></path><path stroke-dasharray="8" stroke-dashoffset="8" d="M9 14h6"><animate fill="freeze" attributeName="stroke-dashoffset" begin="0.9s" dur="0.2s" values="8;0"/></path><path stroke-dasharray="8" stroke-dashoffset="8" d="M12 11v6"><animate fill="freeze" attributeName="stroke-dashoffset" begin="1.1s" dur="0.2s" values="8;0"/></path></g>
                                        </svg>
                                        Add
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Primary School Form Logic
        const priAddformSubmit = document.getElementById('priAddformSubmit');
        const priInputTableBody = document.getElementById('pri-input-table-body');
        const addPriText = document.getElementById('addPriText');
        const addPriYear = document.getElementById('addPriYear');

        priAddformSubmit.addEventListener("submit", (e) => {
            e.preventDefault(); // Prevent page reload

            if (addPriText.value === "" || addPriYear.value === "") {
                alert("Please fill out both the school name and graduation year.");
                return;
            }

            // Check if the table has any rows
            const rows = priInputTableBody.getElementsByTagName('tr');
            if (rows.length === 1) {
                // Add a new row
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td>
                        <div>
                            <input type="text" name="primary_school_name[]" value="${addPriText.value}">
                        </div>
                    </td>
                    <td>
                        <div>
                            <input type="text" name="primary_graduation_year[]" value="${addPriYear.value}">
                        </div>
                    </td>
                    <td>
                        <div>
                            <button type="button" onclick="removeRow(this)">Remove</button>
                        </div>
                    </td>
                `;
                priInputTableBody.appendChild(row);
                // Display value input
                const priEduText = document.getElementById('priEduText');
                const priEduYear = document.getElementById('priEduYear');

                // Directly update the display input fields with the entered data (use .value)
                priEduText.value = addPriText.value;
                priEduYear.value = addPriYear.value;
            } else {
                // Directly update the display input fields with the entered data (use .value)
                priEduText.value = addPriText.value;
                priEduYear.value = addPriYear.value;
            }
            // Clear input fields after submission
            addPriText.value = "";
            addPriYear.value = "";
        });

        // Secondary School Form Logic
        const secAddformSubmit = document.getElementById('secAddformSubmit');
        const secInputTableBody = document.getElementById('sec-input-table-body');
        const addSecondarySchoolName = document.getElementById('addSecondarySchoolName');
        const addSecondaryGraduationYear = document.getElementById('addSecondaryGraduationYear');
        const addSecondaryCertificate = document.getElementById('addSecondaryCertificate');

        secAddformSubmit.addEventListener("submit", (e) => {
            e.preventDefault(); // Prevent page reload

            if (addSecondarySchoolName.value === "" || addSecondaryGraduationYear.value === "") {
                alert("Please fill out both the school name and graduation year.");
                return;
            }

            // Check if the table has any rows
            const rows = secInputTableBody.getElementsByTagName('tr');
            if (rows.length === 1) {
                // Add a new row
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td>
                        <div>
                            <input type="text" name="secondary_school_name[]" value="${addSecondarySchoolName.value}">
                        </div>
                    </td>
                    <td>
                        <div>
                            <input type="text" name="secondary_graduation_year[]" value="${addSecondaryGraduationYear.value}">
                        </div>
                    </td>
                    <td>
                        <div>
                            <input type="file" name="secondary_certificate[]" value="">
                        </div>
                    </td>
                    <td>
                        <div>
                            <button type="button" onclick="removeRow(this)">Remove</button>
                        </div>
                    </td>
                `;
                secInputTableBody.appendChild(row);
                // Display value input
                const secondarySchoolName = document.getElementById('secondarySchoolName');
                const secondaryGraduationYear = document.getElementById('secondaryGraduationYear');

                // Directly update the display input fields with the entered data (use .value)
                secondarySchoolName.value = addSecondarySchoolName.value;
                secondaryGraduationYear.value = addSecondaryGraduationYear.value;
            } else {
                // Directly update the display input fields with the entered data (use .value)
                secondarySchoolName.value = addSecondarySchoolName.value;
                secondaryGraduationYear.value = addSecondaryGraduationYear.value;
            }
            // Clear input fields after submission
            addSecondarySchoolName.value = "";
            addSecondaryGraduationYear.value = "";
        });

        // Higher Education Form Logic
        const highAddForm = document.getElementById('highAddformSubmit');
        const highInputTableBody = document.getElementById('high-input-table-body');
        const addCertificateType = document.getElementById('addCertificateType');
        const addClassOfDegree = document.getElementById('addClassOfDegree');
        const addInstitution = document.getElementById('addInstitution');
        const addCourse = document.getElementById('addCourse');
        const addHighGraduationYear = document.getElementById('addHighGraduationYear');

        highAddForm.addEventListener("submit", (e) => {
            e.preventDefault(); // Prevent page reload

            if (addCertificateType.value === "" || addClassOfDegree.value === "" || addInstitution.value === "" || addCourse.value === "" || addHighGraduationYear.value === "") {
                alert("Please fill out all the fields.");
                return;
            }

            // Check if the table has any rows
            const rows = highInputTableBody.getElementsByTagName('tr');
            if (rows.length === 1) {
                // Add a new row
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td>
                        <div>
                            <input type="text" name="certificate_type[]" value="${addCertificateType.value}">
                        </div>
                    </td>
                    <td>
                        <div>
                            <input type="text" name="class_of_degree[]" value="${addClassOfDegree.value}">
                        </div>
                    </td>
                    <td>
                        <div>
                            <input type="text" name="institution[]" value="${addInstitution.value}">
                        </div>
                    </td>
                    <td>
                        <div>
                            <input type="text" name="course[]" value="${addCourse.value}">
                        </div>
                    </td>
                    <td>
                        <div>
                            <input type="text" name="graduation_year[]" value="${addHighGraduationYear.value}">
                        </div>
                    </td>
                    <td>
                        <div>
                            <input type="file" name="highCertificate" id="highCertificate" value="">
                        </div>
                    </td>
                    <td>
                        <div>
                            <button type="button" onclick="removeRow(this)">Remove</button>
                        </div>
                    </td>
                `;
                highInputTableBody.appendChild(row);
                // Display value input
                const certificateType = document.getElementById('certificateType');
                const classOfDegree = document.getElementById('classOfDegree');
                const institution = document.getElementById('institution');
                const course = document.getElementById('course');
                const highGraduationYear = document.getElementById('highGraduationYear');

                // Directly update the display input fields with the entered data (use .value)
                certificateType.value = addCertificateType.value;
                classOfDegree.value = addClassOfDegree.value;
                institution.value = addInstitution.value;
                course.value = addCourse.value;
                highGraduationYear.value = addHighGraduationYear.value;
            } else {
                
                // Directly update the display input fields with the entered data (use .value)
                certificateType.value = addCertificateType.value;
                classOfDegree.value = addClassOfDegree.value;
                institution.value = addInstitution.value;
                course.value = addCourse.value;
                highGraduationYear.value = addHighGraduationYear.value;
            }
            // Clear input fields after submission
            addCertificateType.value = "";
            addClassOfDegree.value = "";
            addInstitution.value = "";
            addCourse.value = "";
            addHighGraduationYear.value = "";
        });

        // NYSC Form Logic
        const nyscAddformSubmit = document.getElementById('nyscAddformSubmit');
        const nyscInputTableBody = document.getElementById('nysc-input-table-body');
        const addNyscCertificateNumber = document.getElementById('addNyscCertificateNumber');
        const addYearOfService = document.getElementById('addYearOfService');

        nyscAddformSubmit.addEventListener("submit", (e) => {
            e.preventDefault(); // Prevent page reload

            if (addNyscCertificateNumber.value === "" || addYearOfService.value === "") {
                alert("Please fill out both the certificate number and year of service.");
                return;
            }

            // Check if the table has any rows
            const rows = nyscInputTableBody.getElementsByTagName('tr');
            if (rows.length === 1) {
                // Add a new row
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td>
                        <div>
                            <input type="text" name="nysc_certificate_number[]" value="${addNyscCertificateNumber.value}">
                        </div>
                    </td>
                    <td>
                        <div>
                            <input type="text" name="year_of_service[]" value="${addYearOfService.value}">
                        </div>
                    </td>
                    <td>
                        <div>
                            <input type="file" name="nysc_certificate[]" value="">
                        </div>
                    </td>
                    <td>
                        <div>
                            <button type="button" onclick="removeRow(this)">Remove</button>
                        </div>
                    </td>
                `;
                nyscInputTableBody.appendChild(row);
                // Display value input
                const nyscCertificateNumber = document.getElementById('nyscCertificateNumber');
                const yearOfService = document.getElementById('yearOfService');

                // Directly update the display input fields with the entered data (use .value)
                nyscCertificateNumber.value = addNyscCertificateNumber.value;
                yearOfService.value = addYearOfService.value;
            } else {
                
                // Directly update the display input fields with the entered data (use .value)
                nyscCertificateNumber.value = addNyscCertificateNumber.value;
                yearOfService.value = addYearOfService.value;
            }
            // Clear input fields after submission
            addNyscCertificateNumber.value = "";
            addYearOfService.value = "";
        });

        // Function to remove a row
        window.removeRow = function(button) {
            const row = button.closest('tr');
            row.remove();
        }
    });
</script>
<!-- <script>
    // Function to dynamically add rows to the input table
    document.addEventListener("DOMContentLoaded", function() {
        //Primary values Btns
        const priAddformSubmit = document.getElementById('priAddformSubmit');
        const priInputTableBody = document.getElementById('pri-input-table-body');
        // Input fields for entering data
        const addPriText = document.getElementById('addPriText');
        const addPriYear = document.getElementById('addPriYear');

        //For Primary Table 
        priAddformSubmit.addEventListener("submit", (e) => { 
            e.preventDefault(); // Prevent page reload

            if (addPriText.value === "" || addPriYear.value === "") {
                alert("Please fill out both the school name and graduation year.");
                return;
            }

            // Check if the table has any rows
            const rows = priInputTableBody.getElementsByTagName('tr');
            if (rows.length === 1) {
                // Add a new row
                const row = document.createElement('tr');
                row.innerHTML = `
                   <td>
                        <div>
                            <input type="text" name="primary_school_name" id="priEduText" value="">
                        </div>
                    </td>
                    <td>
                        <div>
                            <input type="text" name="primary_graduation_year" id="priEduYear" value="">
                        </div>
                    </td>
                    <td>
                        <div>
                            <button id="" onclick="removeRow(this)">Remove</button>
                        </div>
                    </td>
                `;
                priInputTableBody.appendChild(row);

                // Display value input
                const priEduText = document.getElementById('priEduText');
                const priEduYear = document.getElementById('priEduYear');

                // Directly update the display input fields with the entered data (use .value)
                priEduText.value = addPriText.value;
                priEduYear.value = addPriYear.value;
            } else {
                // Directly update the display input fields with the entered data (use .value)
                priEduText.value = addPriText.value;
                priEduYear.value = addPriYear.value;
            }

            // Clear the input fields after updating
            addPriText.value = "";
            addPriYear.value = "";
        });
        


        //Secondary values Btns
        const secAddformSubmit = document.getElementById('secAddformSubmit');
        const secInputTableBody = document.getElementById('sec-input-table-body');
        // Input fields for entering data
        const addSecondarySchoolName = document.getElementById('addSecondarySchoolName');
        const addSecondaryGraduationYear = document.getElementById('addSecondaryGraduationYear');
        const addSecondaryCertificate = document.getElementById('addSecondaryCertificate');

        // For Secondary Table
        secAddformSubmit.addEventListener("submit", (e) => {
            e.preventDefault(); // Prevent page reload

            if (addSecondarySchoolName.value === "" || addSecondaryGraduationYear.value === "") {
                alert("Please fill out both the school name and graduation year.");
                return;
            }

            // Check if the table has any rows
            const rows = secInputTableBody.getElementsByTagName('tr');
            if (rows.length === 1) {
                // Add a new row
                const row = document.createElement('tr');
                row.innerHTML = `
                   <td>
                        <div>
                            <input type="text" name="secondarySchoolName" id="secondarySchoolName" value="<?php echo htmlspecialchars($user_edu_data['secondarySchoolName']); ?>">
                        </div>
                    </td>
                    <td>
                        <div>
                            <input type="text" name="secondaryGraduationYear" id="secondaryGraduationYear" value="<?php echo htmlspecialchars($user_edu_data['secondaryGraduationYear']); ?>">
                        </div>
                    </td>
                    <td>
                        <div>
                            <input type="file" name="secondaryCertificate" id="secondaryCertificate" value="">
                        </div>
                    </td>
                    <td>
                        <div>
                            <button id="" name="delete" onclick="removeRow(this)">Remove</button>
                        </div>
                    </td>
                `;
                secInputTableBody.appendChild(row);

                // Display value input
                const secondarySchoolName = document.getElementById('secondarySchoolName');
                const secondaryGraduationYear = document.getElementById('secondaryGraduationYear');
                const secondaryCertificate = document.getElementById('secondaryCertificate');

                // Directly update the display input fields with the entered data (use .value)
                secondarySchoolName.value = addSecondarySchoolName.value;
                secondaryGraduationYear.value = addSecondaryGraduationYear.value;
                secondaryCertificate.value = addSecondaryCertificate.value;
            } else {
                // Directly update the display input fields with the entered data (use .value)
                secondarySchoolName.value = addSecondarySchoolName.value;
                secondaryGraduationYear.value = addSecondaryGraduationYear.value;
                secondaryCertificate.value = addSecondaryCertificate.value;
            }

            // Clear the input fields after updating
            addSecondarySchoolName.value = "";
            addSecondaryGraduationYear.value = "";
            addSecondaryCertificate.value = "";
        });



        //Higher values Btns
        const highAddForm = document.getElementById('highAddformSubmit');
        const highInputTableBody = document.getElementById('high-input-table-body');
        // Input fields for entering data
        const addCertificateType = document.getElementById('addCertificateType');
        const addClassOfDegree = document.getElementById('addClassOfDegree');
        const addInstitution = document.getElementById('addInstitution');
        const addCourse = document.getElementById('addCourse');
        const addHighGraduationYear = document.getElementById('addHighGraduationYear');
        const addHighCertificate = document.getElementById('addHighCertificate');

        // For Higher Table
        highAddForm.addEventListener("submit", (e) => {
            e.preventDefault(); // Prevent page reload

            if (addCertificateType.value === "" || addClassOfDegree.value === "" || addInstitution.value === "" || addCourse.value === "" || addHighGraduationYear.value === "") {
                alert("Please fill out both the school name and graduation year.");
                return;
            }

            // Check if the table has any rows
            const rows = highInputTableBody.getElementsByTagName('tr');
            if (rows.length === 1) {
                // Add a new row
                const row = document.createElement('tr');
                row.innerHTML = `
                   <td>
                        <div>
                            <input type="text" name="certificateType" id="certificateType" value="<?php echo htmlspecialchars($user_edu_data['certificateType']); ?>">
                        </div>
                    </td>
                    <td>
                        <div>
                            <input type="text" name="classOfDegree" id="classOfDegree" value="<?php echo htmlspecialchars($user_edu_data['classOfDegree']); ?>">
                        </div>
                    </td>
                    <td>
                        <div>
                            <input type="text" name="institution" id="institution" value="<?php echo htmlspecialchars($user_edu_data['institution']); ?>">
                        </div>
                    </td>
                    <td>
                        <div>
                            <input type="text" name="course" id="course" value="<?php echo htmlspecialchars($user_edu_data['course']); ?>">
                        </div>
                    </td>
                    <td>
                        <div>
                            <input type="text" name="graduationYear" id="graduationYear" value="<?php echo htmlspecialchars($user_edu_data['graduationYear']); ?>">
                        </div>
                    </td>
                    <td>
                        <div>
                            <input type="file" name="certificate" id="certificate" value="">
                        </div>
                    </td>
                    <td>
                        <div>
                            <button id="" name="delete" onclick="removeRow(this)">Remove</button>
                        </div>
                    </td>
                `;
                highInputTableBody.appendChild(row);

                // Display value input
                const certificateType = document.getElementById('certificateType');
                const classOfDegree = document.getElementById('classOfDegree');
                const institution = document.getElementById('institution');
                const course = document.getElementById('course');
                const highGraduationYear = document.getElementById('highGraduationYear');
                const highCertificate = document.getElementById('highCertificate');

                // Directly update the display input fields with the entered data (use .value)
                certificateType.value = addCertificateType.value;
                classOfDegree.value = addClassOfDegree.value;
                institution.value = addInstitution.value;
                course.value = addCourse.value;
                highGraduationYear.value = addHighGraduationYear.value;
                highCertificate.value = addHighCertificate.value;
            } else {
                
                // Directly update the display input fields with the entered data (use .value)
                certificateType.value = addCertificateType.value;
                classOfDegree.value = addClassOfDegree.value;
                institution.value = addInstitution.value;
                course.value = addCourse.value;
                highGraduationYear.value = addHighGraduationYear.value;
                highCertificate.value = addHighCertificate.value;
            }

            // Clear the input fields after updating
            addCertificateType.value = "";
            addClassOfDegree.value = "";
            addInstitution.value = "";
            addCourse.value = "";
            addHighGraduationYear.value = "";
            addHighCertificate.value = "";
        });



        //NYSC values Btns 
        const nyscAddformSubmit = document.getElementById('nyscAddformSubmit');
        const nyscInputTableBody = document.getElementById('nysc-input-table-body');
        // Input fields for entering data
        const addNyscCertificateNumber = document.getElementById('addNyscCertificateNumber');
        const addYearOfService = document.getElementById('addYearOfService');
        const addNyscCertificate = document.getElementById('addNyscCertificate');

        // For NYSC Table
        nyscAddformSubmit.addEventListener("submit", (e) => {
            e.preventDefault(); // Prevent page reload

            if (addNyscCertificateNumber.value === "" || addYearOfService.value === "") {
                alert("Please fill out both the school name and graduation year.");
                return;
            }

            // Check if the table has any rows
            const rows = nyscInputTableBody.getElementsByTagName('tr');
            if (rows.length === 1) {
                // Add a new row
                const row = document.createElement('tr');
                row.innerHTML = `
                   <td>
                        <div>
                            <input type="text" name="nyscCertificateNumber" id="nyscCertificateNumber" value="<?php echo htmlspecialchars($user_edu_data['nyscCertificateNumber']); ?>">
                        </div>
                    </td>
                    <td>
                        <div>
                            <input type="text" name="yearOfService" id="yearOfService" value="<?php echo htmlspecialchars($user_edu_data['yearOfService']); ?>">
                        </div>
                    </td>
                    <td>
                        <div>
                            <input type="file" name="nyscCertificate" id="nyscCertificate" value="">
                        </div>
                    </td>
                    <td>
                        <div>
                            <button id="" name="delete" onclick="removeRow(this)">Remove</button>
                        </div>
                    </td>
                `;
                nyscInputTableBody.appendChild(row);

                // Display value input
                const nyscCertificateNumber = document.getElementById('nyscCertificateNumber');
                const yearOfService = document.getElementById('yearOfService');
                const nyscCertificate = document.getElementById('nyscCertificate');

                // Directly update the display input fields with the entered data (use .value)
                nyscCertificateNumber.value = addNyscCertificateNumber.value;
                yearOfService.value = addYearOfService.value;
                nyscCertificate.value = addNyscCertificate.value;
            } else {
                
                // Directly update the display input fields with the entered data (use .value)
                nyscCertificateNumber.value = addNyscCertificateNumber.value;
                yearOfService.value = addYearOfService.value;
                nyscCertificate.value = addNyscCertificate.value;
            }

            // Clear the input fields after updating
            addNyscCertificateNumber.value = "";
            addYearOfService.value = "";
            addNyscCertificate.value = "";
        });



        // Function to remove a row
        window.removeRow = function(button) {
            const row = button.parentNode.parentNode.parentNode;
            row.parentNode.removeChild(row);
        }

    });
</script> -->

 