<?php
function renderPositionSection($positionId, $positionData, $index) {
?>

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
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
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
                                <td>
                                   <button class="btn btn-primary">Edit</button>
                                </td>
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

</script>