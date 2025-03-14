<?php
    function renderPositionSection($positionId, $positionData, $index) {
    ?>

    <div id="<?php echo htmlspecialchars($positionId); ?>" class="row">
        <div class="postion-body">
            <div class="col-md-12">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th scope="col">Id</th>
                                <th scope="col">Profile</th>
                                <th scope="col">Full Name</th>
                                <th scope="col">Email</th>
                                <th scope="col">CPL%</th>
                                <th scope="col">Reg Date/Time</th>
                                <th scope="col">View Details</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!is_array($positionData)): ?>
                                <?php foreach ($positionData as $index => $user): ?>
                                    <tr>
                                        <td><?php echo $index; ?></td>
                                        <td>
                                            <a href="../Application_Dashboard/<?php echo htmlspecialchars($user['passport_file_path']); ?>" target="_blank">
                                                <img src="../Application_Dashboard/<?php echo htmlspecialchars($user['passport_file_path']); ?>" 
                                                    alt="<?php echo htmlspecialchars($user['lastname']); ?>" 
                                                    width="50" height="50">
                                            </a>
                                        </td>
                                        <td><?php echo htmlspecialchars($user['email']); ?></td>
                                        <td><?php echo htmlspecialchars($user['score_percentage']); ?></td>
                                        <td><?php echo htmlspecialchars($user['created_at']); ?></td>
                                        <td>
                                            <button id="btn_<?php echo $positionId . '-' . $index; ?>" 
                                                class="btn btn-primary" 
                                                onclick="toggleDetails('<?php echo $positionId; ?>', <?php echo $index; ?>)">
                                                View Details
                                            </button>
                                        </td>
                                        <td>
                                            <form action="" method="POST" class="statusForm">
                                                <input type="hidden" name="user_id" value="<?php echo $user['user_id']; ?>">
                                                <input type="hidden" name="status" id="statusInput_<?php echo $user['user_id'] ?>">

                                                <div class="button-container">
                                                    <button type="button" class="btn btn-primary" 
                                                        onclick="confirmHandler('<?php echo $user['user_id']; ?>', 'shortlisted')">
                                                        Shortlist
                                                    </button>

                                                    <button type="button" class="btn btn-warning" 
                                                        onclick="confirmHandler('<?php echo $user['user_id']; ?>', 'interviewed')">
                                                        Interviewed
                                                    </button>

                                                    <button type="button" class="btn btn-danger" 
                                                        onclick="confirmHandler('<?php echo $user['user_id']; ?>', 'unemployed')">
                                                        Unemployed
                                                    </button>
                                                </div>

                                                <div class="status_con modal-container" id="statusModal_<?php echo $user['user_id'] ?>" style="display:none;">
                                                    <div class="modal">
                                                        <div class="modal_text" id="modalMessage_<?php echo $user['user_id'] ?>">Are you sure?</div>
                                                        <div class="modal_btn">
                                                            <button type="submit" name="saveStatus" class="btn btn-success">Confirm</button>
                                                            <button type="button" class="btn btn-inverse" onclick="closeModal('<?php echo $user['user_id'] ?>')">Cancel</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        </td>
                                    </tr>
                                    <tr class="details-row" id="details_<?php echo $positionId; ?>-<?php echo $index; ?>" style="display:none;">
                                        <td colspan="8">
                                            <table style="width: 100%;" class="table">
                                                <tbody>
                                                    <tr>
                                                        <td><strong>Gender:</strong> <?php echo htmlspecialchars($user['gender']); ?></td>
                                                        <td><strong>DOB:</strong> <?php echo htmlspecialchars($user['dateOfBirth']); ?></td>
                                                        <td><strong>MS:</strong> <?php echo htmlspecialchars($user['maritalStatus']); ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td><strong>Phone No.:</strong> <?php echo htmlspecialchars($user['phoneNumber']); ?></td>
                                                        <td><strong>Emergency No.:</strong> <?php echo htmlspecialchars($user['emergencyNumber']); ?></td>
                                                        <td><strong>NIN:</strong> <?php echo htmlspecialchars($user['nin']); ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td><strong>Address:</strong> <?php echo htmlspecialchars($user['address']); ?></td>
                                                        <td><strong>LGA:</strong> <?php echo htmlspecialchars($user['lga']); ?></td>
                                                        <td><strong>SOO:</strong> <?php echo htmlspecialchars($user['stateOfOrigin']); ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td><strong>Pri Name:</strong> <?php echo htmlspecialchars($user['primary_school_name']); ?></td>
                                                        <td><strong>Year: </strong> <?php echo htmlspecialchars($user['primary_graduation_year']); ?></td>
                                                        <td></td>
                                                    </tr>
                                                    <tr>
                                                        <td><strong>Sec Name:</strong> <?php echo htmlspecialchars($user['secondarySchoolName']); ?></td>
                                                        <td><strong>Year:</strong> <?php echo htmlspecialchars($user['secondaryGraduationYear']); ?></td>
                                                        <td><a href="../Application_Dashboard/<?php echo htmlspecialchars($user['sec_file_path']); ?>" target="_blank">Sec Cert</a></td>
                                                    </tr>
                                                    <tr>
                                                        <td><strong>Insti Name:</strong> <?php echo htmlspecialchars($user['institution']); ?></td>
                                                        <td><strong>Cert:</strong> <?php echo htmlspecialchars($user['certificateType']); ?></td>
                                                        <td><a href="../Application_Dashboard/<?php echo htmlspecialchars($user['high_certificate_file_path']); ?>" target="_blank">High Inst Cert</a></td>
                                                    </tr>
                                                    <tr>
                                                        <td><strong>Degree:</strong> <?php echo htmlspecialchars($user['classOfDegree']); ?></td>
                                                        <td><strong>Course:</strong> <?php echo htmlspecialchars($user['course']); ?></td>
                                                        <td><strong>Year:</strong> <?php echo htmlspecialchars($user['highGraduationYear']); ?></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
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
?>S


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

    function confirmHandler(index, status) {
        // Close any open modals before opening a new one
        closeModal(index);

        // Get modal elements
        let modal = document.getElementById('statusModal_'+ index);
        let modalMessage = document.getElementById('modalMessage_' + index);
        let confirmButton = document.getElementById('confirmButton');
        let statusInput = document.getElementById('statusInput_' + index);

        // Set modal message and button color dynamically
        if (status === 'shortlisted') {
            modalMessage.textContent = `Are you sure you want to shortlisted this applicant?`;
            confirmButton.className = "btn btn-success";
        } else if (status === 'interviewed') {
            modalMessage.textContent = `Are you sure this applicant has been interviewed?`;
            confirmButton.className = "btn btn-success";
        } else {
            modalMessage.textContent = `Are you sure you want to decline this applicant?`;
            confirmButton.className = "btn btn-danger";
        }

        // Update hidden input field with status
        statusInput.value = status;

        // Set form action dynamically
        confirmButton.onclick = function () {
            statusInput.closest('form').submit();
        };

        // Show modal
        modal.style.display = "block";
    }

    function closeModal(index) {
        document.getElementById('statusModal_' + index).style.display = "none";
    }

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


</script>