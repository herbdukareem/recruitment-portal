<?php
    function renderPositionSection($positionId, $positionName, $totalApplications, $totalGenderCount, $positionData) {
        ?>

        <div id="<?php echo $positionId ?>" class="position row">
            <div class="card-header">
                <h4><?php echo strtoupper($positionName); ?> APPLICANTS</h4>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-5 d-flex align-items-center">
                                <svg width="30" height="30" viewBox="0 0 42 42" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M38.4998 10.4995H35.0002V38.4999H38.4998C40.4245 38.4999 42 36.9238 42 34.9992V13.9992C42 12.075 40.4245 10.4995 38.4998 10.4995Z"
                                        fill="#2BC155"></path>
                                    <path
                                        d="M27.9998 10.4995V6.9998C27.9998 5.07515 26.4243 3.49963 24.5001 3.49963H17.4998C15.5757 3.49963 14.0001 5.07515 14.0001 6.9998V10.4995H10.5V38.4998H31.5V10.4995H27.9998ZM24.5001 10.4995H17.4998V6.99929H24.5001V10.4995Z"
                                        fill="#2BC155"></path>
                                    <path
                                        d="M3.50017 10.4995C1.57551 10.4995 0 12.075 0 13.9997V34.9997C0 36.9243 1.57551 38.5004 3.50017 38.5004H6.99983V10.4995H3.50017Z"
                                        fill="#2BC155"></path>
                                </svg>
                            </div>
                            <div class="col-7">
                                <p class="text-light">Application Submitted</p>
                                <h5 class="text-light"><?php echo $totalApplications[$positionName] ?></h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-3">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-4 d-flex align-items-center">
                                <svg width="30" height="30" viewBox="0 0 42 42" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M33.25 8.75H31.5V5.25C31.5 4.78587 31.3156 4.34075 30.9874 4.01256C30.6593 3.68437 30.2141 3.5 29.75 3.5C29.2859 3.5 28.8407 3.68437 28.5126 4.01256C28.1844 4.34075 28 4.78587 28 5.25V8.75H14V5.25C14 4.78587 13.8156 4.34075 13.4874 4.01256C13.1592 3.68437 12.7141 3.5 12.25 3.5C11.7859 3.5 11.3408 3.68437 11.0126 4.01256C10.6844 4.34075 10.5 4.78587 10.5 5.25V8.75H8.75C7.35761 8.75 6.02226 9.30312 5.03769 10.2877C4.05312 11.2723 3.5 12.6076 3.5 14V15.75H38.5V14C38.5 12.6076 37.9469 11.2723 36.9623 10.2877C35.9777 9.30312 34.6424 8.75 33.25 8.75Z"
                                        fill="#3F9AE0"></path>
                                    <path
                                        d="M3.5 33.25C3.5 34.6424 4.05312 35.9777 5.03769 36.9623C6.02226 37.9469 7.35761 38.5 8.75 38.5H33.25C34.6424 38.5 35.9777 37.9469 36.9623 36.9623C37.9469 35.9777 38.5 34.6424 38.5 33.25V19.25H3.5V33.25Z"
                                        fill="#3F9AE0"></path>
                                </svg>
                            </div>
                            <div class="col-8">
                                <p class="text-light"> Male</p>
                                <h5 class="text-light"><?php echo $totalGenderCount[$positionName]['Male'] ?></h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-3">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-4 d-flex align-items-center">
                                <i class="fas fa-id-card  icon-home bg-warning text-light"></i>
                            </div>
                            <div class="col-8">
                                <p class="text-light">Female</p>
                                <h5 class="text-light"><?php echo $totalGenderCount[$positionName]['Female'] ?></h5>
                            </div>
                        </div>
                    </div>
                </div>

            </div>


            

            <div class="col-md-8 mx-auto"> <!-- Adjust the column size as needed -->
                <canvas id="myChart"></canvas>
            </div>

            <div class="col-md-12">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th scope="col"> Id</th>
                                <th scope="col">Full Name</th>
                                <th scope="col">Email</th>
                                
                                <th scope="col">Reg Date/Time </th>
                                
                                <th scope="col">View Details</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($positionData[$positionName])): ?>
                                <?php foreach ($positionData[$positionName] as $index => $user): // Adding $index here to track iteration ?>
                                    <tr>
                                        <td><?php echo $user['user_id']; ?></td>
                                        <td><?php echo $user['firstname']; ?> <?php echo $user['middlename']; ?> <?php echo $user['lastname']; ?></td>
                                        <td><?php echo $user['email']; ?></td>
                                        <td><?php echo $user['created_at']; ?></td>
                                        <td><button id="btn_<?php echo $positionId; ?>-<?php echo $index; ?>" class="btn btn-primary" onclick="toggleDetails('<?php echo $positionId; ?>', <?php echo $index; ?>)">View Details</button> </td>
                                    </tr>
                                    <tr class="details-row" id="details_<?php echo $positionId; ?>-<?php echo $index; ?>" style="display:none;">
                                        <td colspan="5"> <!-- Ensure this spans the correct number of columns -->
                                            <table style="width: 100%;" class="table">
                                                <tbody>
                                                    <tr>
                                                        <td><strong>Gender:</strong><?php echo $user['gender']; ?></td>
                                                        <td><strong>DOB:</strong><?php echo $user['dateOfBirth']; ?></td>
                                                        <td><strong>MS:</strong><?php echo $user['maritalStatus']; ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td><strong>Phone No.:</strong><?php echo $user['phoneNumber']; ?></td>
                                                        <td><strong>Emergency No.:</strong><?php echo $user['emergencyNumber']; ?></td>
                                                        <td><strong>NIN.:</strong><?php echo $user['nin']; ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td><strong>Address:</strong><?php echo $user['address']; ?></td>
                                                        <td><strong>LGA:</strong><?php echo $user['lga']; ?></td>
                                                        <td><strong>SOO:</strong><?php echo $user['stateOfOrigin']; ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td><strong>Pri Name:</strong><?php echo $user['primary_school_name']; ?></td>
                                                        <td></td> <!-- Placeholder for the empty cell -->
                                                        <td><strong>Year: </strong><?php echo $user['primary_graduation_year']; ?></td>

                                                    </tr>
                                                    <tr>
                                                        <td><strong>Sec Name:</strong><?php echo $user['secondarySchoolName']; ?></td>
                                                        <td></td> <!-- Placeholder for the empty cell -->
                                                        <td> <strong>Year</strong><?php echo $user['secondaryGraduationYear']; ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="2"><strong>Insti Name</strong><?php echo $user['institution']; ?></td>
                                                        <td><strong>Cert:</strong><?php echo $user['certificateType']; ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td><strong>Degree:</strong><?php echo $user['classOfDegree']; ?></td>
                                                        <td><strong>Course:</strong><?php echo $user['course']; ?></td>
                                                        <td><strong>Year:</strong><?php echo $user['highGraduationYear']; ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td><strong>NYSC Cert No.:</strong><?php echo $user['nyscCertificateNumber']; ?></td>
                                                        <td></td> <!-- Placeholder for the empty cell -->
                                                        <td><strong>Year:</strong><?php echo $user['yearOfService']; ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td><strong>Org Name:</strong><?php echo $user['organizationName']; ?></td>
                                                        <td></td> <!-- Placeholder for the empty cell -->
                                                        <td><strong>Role:</strong><?php echo $user['role']; ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="3"><strong>Res:</strong><?php echo $user['responsibilities']; ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td><strong>S-Date:</strong><?php echo $user['startDate']; ?></td>
                                                        <td></td> <!-- Placeholder for the empty cell -->
                                                        <td><strong>E-Date:</strong><?php echo $user['endDate']; ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td><strong>Bodey Name:</strong><?php echo $user['bodyName']; ?></td>
                                                        <td><strong>Memb ID:</strong><?php echo $user['membershipID']; ?></td>
                                                        <td><strong>Cert Date:</strong><?php echo $user['certificateDate']; ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="3"><strong>Res:</strong><?php echo $user['membershipResposibilities']; ?></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="5">No Applicant data found</td> <!-- Adjust colspan to match -->
                                </tr>
                            <?php endif; ?>
                        </tbody>
                        <script>
                            // Function to toggle the display of the details row and change button text
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
                    </table>
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
}
</script>