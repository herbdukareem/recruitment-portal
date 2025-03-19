<?php
function renderPositionSection($allApplicant, $index, $adminRole) {
?>

<style>
    /* General Styles */
    body {
        font-family: Arial, sans-serif;
        background-color: #f8f9fa;
        color: #333;
    }

    .container {
        margin: 20px auto;
        padding: 20px;
        max-width: 1200px;
    }

    /* Table Styles */
    table {
        width: 100%;
        border-collapse: collapse;
        background-color: #fff;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    }

    th, td {
        padding: 12px 15px;
        text-align: left;
        border-bottom: 1px solid #ddd;
    }

    th {
        background-color: #00044B;
        color: #fff;
    }

    tr:hover {
        background-color: #f1f1f1;
    }

    .details-row {
        background-color: #f9f9f9;
    }

    .table-responsive {
        overflow-x: auto;
    }

    /* Image Styling */
    img {
        border-radius: 50%;
        width: 50px;
        height: 50px;
    }

    /* Button Styling */
    button {
        padding: 8px 16px;
        border-radius: 4px;
        font-size: 14px;
        cursor: pointer;
        transition: background-color 0.3s;
    }

    .btn-primary {
        background-color: #00044B;
        color: #fff;
        border: none;
    }

    .btn-primary:hover {
        background-color: #111683;
    }

    .btn-warning {
        background-color: #ffc107;
        color: #fff;
        border: none;
    }

    .btn-warning:hover {
        background-color: #e0a800;
    }

    .btn-danger {
        background-color: #dc3545;
        color: #fff;
        border: none;
    }

    .btn-danger:hover {
        background-color: #c82333;
    }

    .button-container {
        display: flex;
        gap: 10px;
    }

    /* Modal Styling */
    .modal {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
        justify-content: center;
        align-items: center;
        z-index: 1000;
    }

    .modal-content {
        background-color: #fff;
        padding: 20px;
        border-radius: 8px;
        width: 400px;
        text-align: center;
        position: relative;
    }

    .modal .close {
        position: absolute;
        top: 10px;
        right: 10px;
        font-size: 20px;
        cursor: pointer;
    }

    /* Action Column */
    th.action-column, td.action-column {
        width: 120px;
        text-align: center;
    }

    /* Responsive Styles */
    @media (max-width: 768px) {
        table {
            font-size: 14px;
        }

        .details-row {
            font-size: 12px;
        }

        .button-container {
            flex-direction: column;
            align-items: stretch;
        }

        button {
            width: 100%;
            margin-bottom: 10px;
        }
    }

</style>
<div id="<?php echo htmlspecialchars($positionId); ?>" class="row" style="margin-top:20px">
    <div class="postion-body">
        <div class="col-md-12">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th scope="col">Id</th>
                            <th scope="col">Profile</th>
                            <th scope="col">Email</th>
                            <th scope="col">CPL%</th>
                            <th scope="col">Reg Date/Time</th>
                            <th scope="col">View Details</th>
                            <?php if( !empty($adminRole) && $adminRole  === 'sup_admin'){ ?>
                                <th scope="col">Action</th>
                            <?php } ?>
                        </tr>
                    </thead>
                    <tbody>

                        <?php foreach ($allApplicant as $positionId => $positionData) { ?>

                            <?php if (is_array($positionData) && !empty($positionData)): ?>

                                <tr>
                                    <td><?php echo $index + 1; ?></td>
                                    <td>
                                        <a href="../Application_Dashboard/<?php echo htmlspecialchars($positionData['passport_file_path']); ?>" target="_blank">
                                            <img src="../Application_Dashboard/<?php echo htmlspecialchars($positionData['passport_file_path']); ?>" 
                                                alt="<?php echo htmlspecialchars($positionData['lastname']); ?>" 
                                                width="50" height="50" style="border-radius:50%">
                                        </a>
                                    </td>
                                    <td><?php echo htmlspecialchars($positionData['email']); ?></td>
                                    <td><?php echo htmlspecialchars($positionData['score_percentage']); ?></td>
                                    <td><?php echo htmlspecialchars($positionData['created_at']); ?></td>
                                    <td>
                                        <button id="btn_<?php echo $positionId . '-' . $index; ?>" 
                                            class="btn btn-primary" 
                                            onclick="toggleDetails('<?php echo $positionId; ?>', <?php echo $index; ?>)">
                                            View Details
                                        </button>
                                    </td>
                                    <?php if( !empty($adminRole) && $adminRole  === 'sup_admin'){ ?>
                                        <td>
                                            <button class="btn btn-primary" onclick="editButtonHandler('<?php echo htmlspecialchars($positionData['user_id']); ?>')">Edit</button>
                                            <form action="" method="post" id="editSubmit_<?php echo htmlspecialchars($positionData['user_id']); ?>" style="display:none;">
                                                <input type="text" id="edituser_<?php echo htmlspecialchars($positionData['user_id']); ?>" name="edituser" hidden>
                                                <button name="editUser"></button>
                                            </form>
                                        </td>

                                    <?php } ?>
                                    
                                </tr>
                                <tr class="details-row" id="details_<?php echo $positionId; ?>-<?php echo $index; ?>" style="display:none;">
                                    <td colspan="8">
                                        <table style="width: 100%;" class="table">
                                            <tbody>
                                                <tr>
                                                    <td><strong>Position:</strong> <?php echo htmlspecialchars($positionData['position']); ?></td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Firstname:</strong> <?php echo htmlspecialchars($positionData['firstname']); ?></td>
                                                    <td><strong>MIddlename:</strong> <?php echo htmlspecialchars($positionData['middlename']); ?></td>
                                                    <td><strong>Lastname:</strong> <?php echo htmlspecialchars($positionData['lastname']); ?></td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Gender:</strong> <?php echo htmlspecialchars($positionData['gender']); ?></td>
                                                    <td><strong>DOB:</strong> <?php echo htmlspecialchars($positionData['dateOfBirth']); ?></td>
                                                    <td><strong>MS:</strong> <?php echo htmlspecialchars($positionData['maritalStatus']); ?></td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Phone No.:</strong> <?php echo htmlspecialchars($positionData['phoneNumber']); ?></td>
                                                    <td><strong>Emergency No.:</strong> <?php echo htmlspecialchars($positionData['emergencyNumber']); ?></td>
                                                    <td><strong>NIN:</strong> <?php echo htmlspecialchars($positionData['nin']); ?></td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Address:</strong> <?php echo htmlspecialchars($positionData['address']); ?></td>
                                                    <td><strong>LGA:</strong> <?php echo htmlspecialchars($positionData['lga']); ?></td>
                                                    <td><strong>SOO:</strong> <?php echo htmlspecialchars($positionData['stateOfOrigin']); ?></td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Pri Name:</strong> <?php echo htmlspecialchars($positionData['primary_school_name']); ?></td>
                                                    <td><strong>Year: </strong> <?php echo htmlspecialchars($positionData['primary_graduation_year']); ?></td>
                                                    <td></td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Sec Name:</strong> <?php echo htmlspecialchars($positionData['secondarySchoolName']); ?></td>
                                                    <td><strong>Year:</strong> <?php echo htmlspecialchars($positionData['secondaryGraduationYear']); ?></td>
                                                    <td><a href="../Application_Dashboard/<?php echo htmlspecialchars($positionData['sec_file_path']); ?>" target="_blank">Sec Cert</a></td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Insti Name:</strong> <?php echo htmlspecialchars($positionData['institution']); ?></td>
                                                    <td><strong>Cert:</strong> <?php echo htmlspecialchars($positionData['certificateType']); ?></td>
                                                    <td><a href="../Application_Dashboard/<?php echo htmlspecialchars($positionData['high_certificate_file_path']); ?>" target="_blank">High Inst Cert</a></td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Degree:</strong> <?php echo htmlspecialchars($positionData['classOfDegree']); ?></td>
                                                    <td><strong>Course:</strong> <?php echo htmlspecialchars($positionData['course']); ?></td>
                                                    <td><strong>Year:</strong> <?php echo htmlspecialchars($positionData['highGraduationYear']); ?></td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Organization Name:</strong> <?php echo htmlspecialchars($positionData['organizationName']); ?></td>
                                                    <td><strong>Rank:</strong> <?php echo htmlspecialchars($positionData['rank']); ?></td>
                                                </tr>
                                                <tr>
                                                    <td colspan="3"><strong>Responsibilities:</strong> <?php echo htmlspecialchars($positionData['responsibilities']); ?></td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Start Date:</strong> <?php echo htmlspecialchars($positionData['startDate']); ?></td>
                                                    <td><strong>End Date:</strong> <?php echo htmlspecialchars($positionData['endDate']); ?></td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Body Name:</strong> <?php echo htmlspecialchars($positionData['organizationName']); ?></td>
                                                    <td><strong>Membership ID:</strong> <?php echo htmlspecialchars($positionData['rank']); ?></td>
                                                    <td><strong>Membership Type:</strong> <?php echo htmlspecialchars($positionData['rank']); ?></td>
                                                </tr>
                                                <tr>
                                                    <td colspan="3"><strong>Responsibilities:</strong> <?php echo htmlspecialchars($positionData['responsibilities']); ?></td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Cert Date:</strong> <?php echo htmlspecialchars($positionData['startDate']); ?></td>
                                                    <td><a href="../Application_Dashboard/<?php echo htmlspecialchars($positionData['sec_file_path']); ?>" target="_blank">PMC Cert</a></td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <form action="" method="POST" class="statusForm">
                                                            <input type="hidden" name="user_id" value="<?php echo $positionData['user_id']; ?>">
                                                            <input type="hidden" name="status" id="statusInput_<?php echo $positionData['user_id'] ?>" value="">

                                                            <div class="button-container">
                                                                <button type="button" class="btn btn-primary" 
                                                                    onclick="confirmHandler('<?php echo $positionData['user_id']; ?>', 'shortlisted')">
                                                                    Shortlist
                                                                </button>

                                                                <button type="button" class="btn btn-warning" 
                                                                    onclick="confirmHandler('<?php echo $positionData['user_id']; ?>', 'interviewed')">
                                                                    Interviewed
                                                                </button>

                                                                <button type="button" class="btn btn-danger" 
                                                                    onclick="confirmHandler('<?php echo $positionData['user_id']; ?>', 'unemployed')">
                                                                    Unemployed
                                                                </button>
                                                            </div>

                                                            <!-- MODAL for each user -->
                                                            <div id="statusModal_<?php echo $positionData['user_id']; ?>" class="modal" style="display: none;">
                                                                <div class="modal-content">
                                                                    <span class="close" onclick="closeModal('<?php echo $positionData['user_id']; ?>')">&times;</span>
                                                                    <p id="modalMessage_<?php echo $positionData['user_id']; ?>"></p>

                                                                    <!-- Unique Confirm Button -->
                                                                    <button type="submit" name="saveStatus" id="confirmButton_<?php echo $positionData['user_id']; ?>" class="btn">
                                                                        Confirm
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </form>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                            <?php else: ?>
                                <tr>
                                    <td colspan="8">No Applicant data found</td>
                                </tr>
                            <?php endif; ?>

                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?php
}
?>

<script>

    function toggleDetails(positionId, index) {
        // Get the details row by index
        var detailsRow = document.getElementById("details_" + positionId + "-" + index);

        // Get the button
        var button = document.getElementById("btn_" + positionId + "-" + index);

        // Toggle the display of the details row and the button text
        if (detailsRow.style.display === "none" || detailsRow.style.display === "") {
            detailsRow.style.display = "table-row";
            button.textContent = "Hide Details";
        } else {
            detailsRow.style.display = "none";
            button.textContent = "View Details";
        }
    };

    function toggleDetailsAC(index) {
        // Get the details row by index
        var detailsRow = document.getElementById("details_AC-" + index);

        // Get the button inside the current row
        var button = document.getElementById("#btn_AC-" + index);

        // Toggle the display of the details row and the button text
        if (detailsRow.style.display === "none" || detailsRow.style.display === "") {
            detailsRow.style.display = "table-row";
            button.textContent = "Hide Details";
        } else {
            detailsRow.style.display = "none";
            button.textContent = "View Details";
        }
    }

    function confirmHandler(index, status) {
        // Get modal elements
        let modal = document.getElementById('statusModal_' + index);
        let modalMessage = document.getElementById('modalMessage_' + index);
        let confirmButton = document.getElementById('confirmButton_' + index); // FIXED: Use unique ID
        let statusInput = document.getElementById('statusInput_' + index);

        // Ensure elements exist before modifying them
        if (!modal || !modalMessage || !confirmButton || !statusInput) {
            console.error("Modal elements not found for index:", index);
            return;
        }

        // Set modal message and button color dynamically
        if (status === 'shortlisted') {
            modalMessage.textContent = `Are you sure you want to shortlist this applicant?`;
            confirmButton.className = "btn btn-success";
        } else if (status === 'interviewed') {
            modalMessage.textContent = `Are you sure this applicant has been interviewed?`;
            confirmButton.className = "btn btn-warning";
        } else {
            modalMessage.textContent = `Are you sure you want to decline this applicant?`;
            confirmButton.className = "btn btn-danger";
        }

        // Update hidden input field with status
        statusInput.value = status;

        // Show modal
        modal.style.display = "block";
    }

    // Function to close modal
    function closeModal(index) {
        let modal = document.getElementById('statusModal_' + index);
        if (modal) {
            modal.style.display = "none";
        }
    }

    // Edit function
    function editButtonHandler(id) {
        let editValue = document.getElementById(`edituser_${id}`);
        const editForm = document.getElementById(`editSubmit_${id}`);
        if (editValue && editForm) {
            editValue.value = id;
            console.log(editValue.value); // For debugging purposes
            editForm.submit(); // Submitting the form
        } else {
            console.error('Either the input field or form element was not found');
        }
}



</script>