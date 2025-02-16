<div id="education-screen" class="screen" style="display: none;">
            <div class="screen-head">
                <div class="screen-head-left">
                    <h3>Education</h3>
                </div>
                <div class="screen-head-right">
                <p><a href="" style="color: var(--main-bg);"> Job Application</a> / <a href="" style="color: var(--main-color);"><svg xmlns="http://www.w3.org/2000/svg" width="0.9em" height="0.9em" viewBox="0 0 24 24">
                                <path fill="#000000" d="M17 13h-4v4h-2v-4H7v-2h4V7h2v4h4m2-8H5c-1.11 0-2 .89-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V5a2 2 0 0 0-2-2" />
                            </svg>Education</a></p>
                </div>
            </div>
            <div class="screen-body body-edu">
                <div class="right-edu">
                    <div id="userEduDetails">
                        <!-- Display form input include save -->
                        <form action="" method="post" enctype="multipart/form-data">
                            <style>
                                th{
                                    text-align: left;
                                    font-size: 0.7em;
                                }
                            </style>
                            <div class="form-head">
                                <h4>Education History</h4>
                            </div>
                            <!-- Primary -->
                            <div class="no-br">
                                <div class="form-head">
                                    <h5>Primary Education</h5>
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
                                                <input type="text" name="primary_school_name" id="priEduText" value="<?php echo htmlspecialchars($user_edu_data['primary_school_name']); ?>" >
                                            </div>
                                        </td>
                                        <td>
                                            <div>
                                                <input type="text" name="primary_graduation_year" id="priEduYear" value="<?php echo htmlspecialchars($user_edu_data['primary_graduation_year']); ?>" >
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
                                    <h5>Secondary Education</h5>
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
                                                <label for="">Exam Type</label>
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
                                                <input type="text" name="secondarySchoolName" id="secondarySchoolName" value="<?php echo htmlspecialchars($user_edu_data['secondarySchoolName']); ?>" >
                                            </div>
                                        </td>
                                        <td>
                                            <div>
                                                <input type="text" name="secondaryGraduationYear" id="secondaryGraduationYear" value="<?php echo htmlspecialchars($user_edu_data['secondaryGraduationYear']); ?>" >
                                            </div>
                                        </td>
                                        <td>
                                            <div>
                                                <input type="file" name="secondaryCertificate" id="secondaryCertificate" value=""  accept="application/pdf,image/jpeg,image/png,image/jpg">
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
                                    <h5>Higher Education</h5>
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
                                                <input type="text" name="certificateType" id="certificateType" value="<?php echo htmlspecialchars($user_edu_data['certificateType']); ?>" >
                                            </div>
                                        </td>
                                        <td>
                                            <div>
                                                <input type="text" name="classOfDegree" id="classOfDegree" value="<?php echo htmlspecialchars($user_edu_data['classOfDegree']); ?>" >
                                            </div>
                                        </td>
                                        <td>
                                            <div>
                                                <input type="text" name="institution" id="institution" value="<?php echo htmlspecialchars($user_edu_data['institution']); ?>" >
                                            </div>
                                        </td>
                                        <td>
                                            <div>
                                                <input type="text" name="course" id="course" value="<?php echo htmlspecialchars($user_edu_data['course']); ?>" >
                                            </div>
                                        </td>
                                        <td>
                                            <div>
                                                <input type="text" name="highGraduationYear" id="highGraduationYear" value="<?php echo htmlspecialchars($user_edu_data['highGraduationYear']); ?>" >
                                            </div>
                                        </td>
                                        <td>
                                            <div>
                                                <input type="file" name="highCertificate" id="highCertificate" value=""  accept="application/pdf,image/jpeg,image/png,image/jpg">
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
                                    <h5>NYSC</h5>
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
                                                <label for="">Year of Completion of Service</label>
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
                                                <input type="text" name="nyscCertificateNumber" id="nyscCertificateNumber" value="<?php echo htmlspecialchars($user_edu_data['nyscCertificateNumber']); ?>" >
                                            </div>
                                        </td>
                                        <td>
                                            <div>
                                                <input type="text" name="yearOfService" id="yearOfService" value="<?php echo htmlspecialchars($user_edu_data['yearOfService']); ?>" >
                                            </div>
                                        </td>
                                        <td>
                                            <div>
                                                <input type="file" name="nyscCertificate" id="nyscCertificate" value=""  accept="application/pdf,image/jpeg,image/png,image/jpg">
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
                            <input type="text" name="primary_school_name[]" value="${addPriText.value}" >
                        </div>
                    </td>
                    <td>
                        <div>
                            <input type="text" name="primary_graduation_year[]" value="${addPriYear.value}" >
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
                            <input type="text" name="secondary_school_name[]" value="${addSecondarySchoolName.value}" >
                        </div>
                    </td>
                    <td>
                        <div>
                            <input type="text" name="secondary_graduation_year[]" value="${addSecondaryGraduationYear.value}" >
                        </div>
                    </td>
                    <td>
                        <div>
                            <input type="file" name="secondary_certificate[]" value="${addSecondaryCertificate.value}"  accept="application/pdf,image/jpeg,image/png,image/jpg">
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
                            <input type="text" name="certificate_type[]" value="${addCertificateType.value}" >
                        </div>
                    </td>
                    <td>
                        <div>
                            <input type="text" name="class_of_degree[]" value="${addClassOfDegree.value}" >
                        </div>
                    </td>
                    <td>
                        <div>
                            <input type="text" name="institution[]" value="${addInstitution.value}" >
                        </div>
                    </td>
                    <td>
                        <div>
                            <input type="text" name="course[]" value="${addCourse.value}" >
                        </div>
                    </td>
                    <td>
                        <div>
                            <input type="text" name="graduation_year[]" value="${addHighGraduationYear.value}" >
                        </div>
                    </td>
                    <td>
                        <div>
                            <input type="file" name="highCertificate" id="highCertificate" value="" >
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
                            <input type="text" name="nysc_certificate_number[]" value="${addNyscCertificateNumber.value}" >
                        </div>
                    </td>
                    <td>
                        <div>
                            <input type="text" name="year_of_service[]" value="${addYearOfService.value}" >
                        </div>
                    </td>
                    <td>
                        <div>
                            <input type="file" name="nysc_certificate[]" value="" >
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
