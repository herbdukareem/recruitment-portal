<div id="work-screen" class="screen" style="display: none;">
                <div class="screen-head">
                    <div class="screen-head-left">
                        <h3>Work History</h3>
                    </div>
                    <div class="screen-head-right">
                    <p><a href="" style="color: var(--main-bg);"> Job Application</a> / <a href="" style="color: var(--main-color);"><svg xmlns="http://www.w3.org/2000/svg" width="0.9em" height="0.9em" viewBox="0 0 24 24">
                                    <path fill="#000000" d="M17 13h-4v4h-2v-4H7v-2h4V7h2v4h4m2-8H5c-1.11 0-2 .89-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V5a2 2 0 0 0-2-2" />
                                </svg>
                                Work History
                            </a>
                        </p>
                    </div>
                </div>
                <div class="screen-body">
                    <!-- Display Input Data -->
                    <form action="" method="post">
                        <div class="form-head">
                            <h4>Work History</h4>
                        </div>
                        <div class="no-br">

                            <table id="workInputTableBody">
                                <tr>
                                    <td>
                                        <div>
                                            <label for="">Organization Name</label>
                                        </div>
                                    </td>
                                    <td>
                                        <div>
                                            <label for="">Rank</label>
                                        </div>
                                    </td>
                                    <td>
                                        <div>
                                            <label for="">Resposibilities</label>
                                        </div>
                                    </td>
                                    <td>
                                        <div>
                                            <label for="">Start Date</label>
                                        </div>
                                    </td>
                                    <td>
                                        <div>
                                            <label for="">End Date</label>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div>
                                            <input type="text" name="organizationName" id="organizationName" value="<?php echo htmlspecialchars($user_work_data['organizationName']); ?>" >
                                        </div>
                                    </td>
                                    <td>
                                        <div>
                                            <input type="text" name="rank" id="rank" value="<?php echo htmlspecialchars($user_work_data['rank']); ?>" >
                                        </div>
                                    </td>
                                    <td>
                                        <div>
                                            <input type="text" name="responsibilities" id="responsibilities" value="<?php echo htmlspecialchars($user_work_data['responsibilities']); ?>" >
                                        </div>
                                    </td>
                                    <td>
                                        <div>
                                            <input type="date" name="startDate" id="startDate" value="<?php echo htmlspecialchars($user_work_data['startDate']); ?>" >
                                        </div>
                                    </td>
                                    <td>
                                        <div>
                                            <input type="date" name="endDate" id="endDate" value="<?php echo htmlspecialchars($user_work_data['endDate']); ?>" >
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div class="form-footer">
                            <button type="sunmit" name="saveWork">
                                <svg xmlns="http://www.w3.org/2000/svg" width="1.5em" height="1.5em" viewBox="0 0 24 24">
                                    <path fill="white" d="M20 7.423v10.962q0 .69-.462 1.153T18.384 20H5.616q-.691 0-1.153-.462T4 18.384V5.616q0-.691.463-1.153T5.616 4h10.961zm-8.004 9.115q.831 0 1.417-.582T14 14.543t-.582-1.418t-1.413-.586t-1.419.581T10 14.535t.582 1.418t1.414.587M6.769 9.77h7.423v-3H6.77z" />
                                </svg>
                                Save
                            </button>
                        </div>
                    </form>

                    <!-- Add input data form -->
                    <form action="" class="mar-top" id="workAddformSubmit">
                        <div class="form-head">
                            <h4>Add Work History</h4>
                        </div>
                        <div class="form-body">
                            <table>
                                <tr>
                                    <td>
                                        <div>
                                            <label for="">Organization Name</label>
                                        </div>
                                        <div>
                                            <input type="text" name="" id="addOrganizationName" value="">
                                        </div>
                                    </td>
                                    <td>
                                        <div>
                                            <label for="">Rank</label>
                                        </div>
                                        <div>
                                            <input type="text" name="" id="addRank" value="">
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2">
                                        <div>
                                            <label for="">Resposibilities <i>(max of 1000 words)</i></label>
                                        </div>
                                        <div>
                                            <textarea name="" id="addResponsibilities"></textarea>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div>
                                            <label for="">Start Date</label>
                                        </div>
                                        <div>
                                            <input type="date" name="" id="addStartDate" value="">
                                        </div>
                                    </td>
                                    <td>
                                        <div>
                                            <label for="">End Date</label>
                                        </div>
                                        <div>
                                            <input type="date" name="" id="addEndDate" value="">
                                        </div>
                                        <div style="font-size: 12px;">
                                            <input type="checkbox">currently works here
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
</div>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const workAddformSubmit = document.getElementById('workAddformSubmit');
        const workInputTableBody = document.getElementById('workInputTableBody');
        const addOrganizationName = document.getElementById('addOrganizationName');
        const addRank = document.getElementById('addRank');
        const addResponsibilities = document.getElementById('addResponsibilities');
        const addStartDate = document.getElementById('addStartDate');
        const addEndDate = document.getElementById('addEndDate');

        workAddformSubmit.addEventListener("submit", (e) => {
            e.preventDefault(); // Prevent page reload

            // Validate all fields
            if (addOrganizationName.value === "" || addRank.value === "" || addResponsibilities.value === "" || addStartDate.value === "" || addEndDate.value === "") {
                alert("Please fill out all the fields.");
                return;
            }

            // Check if the table has any rows
            const rows = workInputTableBody.getElementsByTagName('tr');
            if (rows.length === 2) {
                // Add new row to the table
                const newRow = document.createElement('tr');
                newRow.innerHTML = `
                    <td>
                        <div>
                            <input type="text" name="organizationName" id="organizationName" value="<?php echo htmlspecialchars($user_work_data['organizationName']); ?>" >
                        </div>
                    </td>
                    <td>
                        <div>
                            <input type="text" name="rank" id="rank" value="<?php echo htmlspecialchars($user_work_data['rank']); ?>" >
                        </div>
                    </td>
                    <td>
                        <div>
                            <input type="text" name="resposibilities" id="resposibilities" value="<?php echo htmlspecialchars($user_work_data['resposibilities']); ?>" >
                        </div>
                    </td>
                    <td>
                        <div>
                            <input type="text" name="startDate" id="startDate" value="<?php echo htmlspecialchars($user_work_data['startDate']); ?>" >
                        </div>
                    </td>
                    <td>
                        <div>
                            <input type="text" name="endDate" id="endDate" value="<?php echo htmlspecialchars($user_work_data['endDate']); ?>" >
                        </div>
                    </td>
                    `;

                workInputTableBody.appendChild(newRow);
                // Display value input
                const organizationName = document.getElementById('organizationName');
                const rank = document.getElementById('rank');
                const resposibilities = document.getElementById('resposibilities');
                const startDate = document.getElementById('startDate');
                const endDate = document.getElementById('endDate');

                // Directly update the display input fields with the entered data (use .value)
                organizationName.value = addOrganizationName.value;
                rank.value = addRank.value;
                resposibilities.value = addResponsibilities.value;
                startDate.value = addStartDate.value;
                endDate.value = addEndDate.value;
            } else {
                // Directly update the display input fields with the entered data (use .value)
                organizationName.value = addOrganizationName.value;
                rank.value = addRank.value;
                resposibilities.value = addResponsibilities.value;
                startDate.value = addStartDate.value;
                endDate.value = addEndDate.value;
            }

            // Clear the input fields
            addOrganizationName.value = "";
            addRank.value = "";
            addResponsibilities.value = "";
            addStartDate.value = "";
            addEndDate.value = "";
        });

        // Remove row function
        window.removeRow = function (button) {
            const row = button.closest('tr');
            row.remove();
        };
    });
</script>
