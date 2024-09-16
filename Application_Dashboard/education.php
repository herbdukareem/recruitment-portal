<div id="education-screen" style="display: none;">
                <div class="head-edu">
                    <div class="left-edu">
                        <h2>Education</h2>
                    </div>
                    <div class="right-edu">
                        <p><a href="" style="color: #008f4a;"> Job Application</a> / <a href=""><svg xmlns="http://www.w3.org/2000/svg" width="0.9em" height="0.9em" viewBox="0 0 24 24">
                                    <path fill="#000000" d="M17 13h-4v4h-2v-4H7v-2h4V7h2v4h4m2-8H5c-1.11 0-2 .89-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V5a2 2 0 0 0-2-2" />
                                </svg>Education</a></p>
                    </div>
                </div>
                <div class="body-edu">
                    <div class="left-body-edu">
                        <div id="pri-btn">Primary Education</div>
                        <div id="sec-btn">Secondary Education</div>
                        <div id="higher-btn">Higher Education</div>
                        <div id="nysc-btn">NYSC</div>
                    </div>
                    <div class="right-body-edu">
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
                                        <tr data-id="1">
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
                                                    <label for="">Action</label>
                                                </div>
                                            </th>
                                        </tr>
                                        <tr data-id="2">
                                            <td>
                                                <div>
                                                    <input type="text" name="secondary_school_name" id="secEduText" value="<?php echo htmlspecialchars($user_edu_data['secondary_school_name']); ?>">
                                                </div>
                                            </td>
                                            <td>
                                                <div>
                                                    <input type="text" name="secondary_graduation_year" id="secEduYear" value="<?php echo htmlspecialchars($user_edu_data['secondary_graduation_year']); ?>">
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
                                        <tr data-id="3">
                                            <td>
                                                <div>
                                                    <input type="text" name="higher_school_name" id="highEduText" value="<?php echo htmlspecialchars($user_edu_data['higher_school_name']); ?>">
                                                </div>
                                            </td>
                                            <td>
                                                <div>
                                                    <input type="text" name="higher_graduation_year" id="highEduYear" value="<?php echo htmlspecialchars($user_edu_data['higher_graduation_year']); ?>">
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
                                                    <label for="">NYSC Camp Name</label>
                                                </div>
                                            </th>
                                            <th>
                                                <div>
                                                    <label for="">Service Year</label>
                                                </div>
                                            </th>
                                            <th>
                                                <div>
                                                    <label for="">Action</label>
                                                </div>
                                            </th>
                                        </tr>
                                        <tr data-id="4">
                                            <td>
                                                <div>
                                                    <input type="text" name="nysc_camp_name" id="nyscCampName" value="<?php echo htmlspecialchars($user_edu_data['nysc_camp_name']); ?>">
                                                </div>
                                            </td>
                                            <td>
                                                <div>
                                                    <input type="text" name="nysc_sevice_year" id="nyscServiceYear" value="<?php echo htmlspecialchars($user_edu_data['nysc_sevice_year']); ?>">
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
                                                    <input type="text" name="" id="secAddSchoolName" value="">
                                                </div>
                                            </td>
                                            <td>
                                                <div>
                                                    <label for="">Graduation Year</label>
                                                </div>
                                                <div>
                                                    <input type="text" name="" id="secAddGraduationYear" value="" placeholder="2000-2024">
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
                                                    <label for="">School Name</label>
                                                </div>
                                                <div>
                                                    <input type="text" name="" id="highAddSchoolName" value="">
                                                </div>
                                            </td>
                                            <td>
                                                <div>
                                                    <label for="">Graduation Year</label>
                                                </div>
                                                <div>
                                                    <input type="text" name="" id="highAddGraduationYear" value="" placeholder="2000-2024">
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
                                                    <label for="">School Name</label>
                                                </div>
                                                <div>
                                                    <input type="text" name="" id="nyscAddCampName" value="">
                                                </div>
                                            </td>
                                            <td>
                                                <div>
                                                    <label for="">Graduation Year</label>
                                                </div>
                                                <div>
                                                    <input type="text" name="" id="nyscAddServiceYear" value="" placeholder="2000-2024">
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
        const secAddSchoolName = document.getElementById('secAddSchoolName');
        const secAddGraduationYear = document.getElementById('secAddGraduationYear');

        // For Secondary Table
        secAddformSubmit.addEventListener("submit", (e) => {
            e.preventDefault(); // Prevent page reload

            if (secAddSchoolName.value === "" || secAddGraduationYear.value === "") {
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
                            <input type="text" name="secondary_school_name" id="secEduText" value="">
                        </div>
                    </td>
                    <td>
                        <div>
                            <input type="text" name="secondary_graduation_year" id="secEduYear" value="">
                        </div>
                    </td>
                    <td>
                        <div>
                            <button id="" onclick="removeRow(this)">Remove</button>
                        </div>
                    </td>
                `;
                secInputTableBody.appendChild(row);

                // Display value input
                const secEduText = document.getElementById('secEduText');
                const secEduYear = document.getElementById('secEduYear');

                // Directly update the display input fields with the entered data (use .value)
                secEduText.value = secAddSchoolName.value;
                secEduYear.value = secAddGraduationYear.value;
            } else {
                // Directly update the display input fields with the entered data (use .value)
                secEduText.value = secAddSchoolName.value;
                secEduYear.value = secAddGraduationYear.value;
            }

            // Clear the input fields after updating
            secAddSchoolName.value = "";
            secAddGraduationYear.value = "";
        });



        //Higher values Btns
        const highAddformSubmit = document.getElementById('highAddformSubmit');
        const highInputTableBody = document.getElementById('high-input-table-body');
        // Input fields for entering data
        const highAddSchoolName = document.getElementById('highAddSchoolName');
        const highAddGraduationYear = document.getElementById('highAddGraduationYear');

        // For Higher Table
        highAddformSubmit.addEventListener("submit", (e) => {
            e.preventDefault(); // Prevent page reload

            if (highAddSchoolName.value === "" || highAddGraduationYear.value === "") {
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
                            <input type="text" name="higher_school_name" id="highEduText" value="">
                        </div>
                    </td>
                    <td>
                        <div>
                            <input type="text" name="higher_graduation_year" id="highEduYear" value="">
                        </div>
                    </td>
                    <td>
                        <div>
                            <button id="" onclick="removeRow(this)">Remove</button>
                        </div>
                    </td>
                `;
                highInputTableBody.appendChild(row);

                // Display value input
                const highEduText = document.getElementById('highEduText');
                const highEduYear = document.getElementById('highEduYear');

                // Directly update the display input fields with the entered data (use .value)
                highEduText.value = highAddSchoolName.value;
                highEduYear.value = highAddGraduationYear.value;
            } else {
                
                // Directly update the display input fields with the entered data (use .value)
                highEduText.value = highAddSchoolName.value;
                highEduYear.value = highAddGraduationYear.value;
            }

            // Clear the input fields after updating
            highAddSchoolName.value = "";
            highAddGraduationYear.value = "";
        });



        //NYSC values Btns 
        const nyscAddformSubmit = document.getElementById('nyscAddformSubmit');
        const nyscInputTableBody = document.getElementById('nysc-input-table-body');
        // Input fields for entering data
        const nyscAddCampName = document.getElementById('nyscAddCampName');
        const nyscAddServiceYear = document.getElementById('nyscAddServiceYear');

        // For NYSC Table
        nyscAddformSubmit.addEventListener("submit", (e) => {
            e.preventDefault(); // Prevent page reload

            if (nyscAddCampName.value === "" || nyscAddServiceYear.value === "") {
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
                            <input type="text" name="nysc_camp_name" id="nyscCampName" value="">
                        </div>
                    </td>
                    <td>
                        <div>
                            <input type="text" name="nysc_sevice_year" id="nyscServiceYear" value="">
                        </div>
                    </td>
                    <td>
                        <div>
                            <button id="" onclick="removeRow(this)">Remove</button>
                        </div>
                    </td>
                `;
                nyscInputTableBody.appendChild(row);

                // Display value input
                const nyscCampName = document.getElementById('nyscCampName');
                const nyscServiceYear = document.getElementById('nyscServiceYear');

                // Directly update the display input fields with the entered data (use .value)
                nyscCampName.value = nyscAddCampName.value;
                nyscServiceYear.value = nyscAddServiceYear.value;
            } else {
                
                // Directly update the display input fields with the entered data (use .value)
                nyscCampName.value = nyscAddCampName.value;
                nyscServiceYear.value = nyscAddServiceYear.value;
            }

            // Clear the input fields after updating
            nyscAddCampName.value = "";
            nyscAddServiceYear.value = "";
        });



        // Function to remove a row
        window.removeRow = function(button) {
            const row = button.parentNode.parentNode.parentNode;
            row.parentNode.removeChild(row);
        }

    });
</script>

 