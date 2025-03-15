<div id="summary-screen" class="screen" style="display: none;">
    <div class="screen-head">
        <div class="screen-head-left">
            <h3>Application Preview</h3>
        </div>
        <div class="screen-head-right">
        <p><a href="" style="color: var(--main-bg);"> Job Application</a> / <a href="" style="color: var(--main-color);"><svg xmlns="http://www.w3.org/2000/svg" width="0.9em" height="0.9em" viewBox="0 0 24 24">
                        <path fill="#000000" d="M17 13h-4v4h-2v-4H7v-2h4V7h2v4h4m2-8H5c-1.11 0-2 .89-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V5a2 2 0 0 0-2-2" />
                    </svg>
                    Appication Summary
                </a>
            </p>
        </div>
    </div>
    <div class="screen-body">
        <style>
            tr{
                margin-bottom: 0.8em;
                min-height: 30px;
            }
            .table_head{
                background-color: var(--main-color);
                text-align: center;
                color: #fff;
                font-size: 0.7em;
                padding: 0.1em 0.5em;
            }
            .table_data{
                text-align: left;
                border-bottom: 1px solid var(--main-color);
                margin: 1.5em;
            }
            .section_h4{
                background-color: var(--main-bg-light) ;
                padding: 0.3em;
                color: #fff
            }
        </style>
        <form action="" id="printableArea">
            <div class="form-head" style="display:flex; justify-content:space-between; align-items:center;">
                <div>
                    <h2>Appication Summary for the position of <span style="font-weight:bold;color:var(--main-color-light)"><?php echo htmlspecialchars($allUserData['position'] ?? ''); ?></span></h2>
                </div>
                <div style="padding: 8px 5px 5px 5px;">
                    <?php if (!empty($allUserData['passport_file_path'])): ?>
                        <img src="<?php echo htmlspecialchars($allUserData['passport_file_path']); ?>" alt="My Profile" width="200px">
                    <?php else: ?>
                        <p>No passport uploaded.</p>
                    <?php endif; ?>
                </div>
            </div>
            <div class="form-body">
                <!-- Bio Data Summary -->
                <table>
                    <thead>
                        <th class="table_head" colspan="3">
                            <div>
                                <h4 >Bio Data</h4>
                            </div>
                        </th>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="table_data">
                                <div>
                                    <label>First Name</label>
                                </div>
                                <div>
                                    <?php echo htmlspecialchars($allUserData['firstname'] ?? ''); ?>
                                </div>
                            </td>
                            <td class="table_data">
                                <div>
                                    <label>Middle Name</label>
                                </div>
                                <div>
                                    <?php echo htmlspecialchars($allUserData['middlename'] ?? ''); ?>
                                </div>
                            </td>
                            <td class="table_data">
                                <div>
                                    <label>Last Name</label>
                                </div>
                                <div>
                                    <?php echo htmlspecialchars($allUserData['lastname'] ?? ''); ?>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td class="table_data">
                                <div>
                                    <label>Gender</label>
                                </div>
                                <div>
                                    <?php echo htmlspecialchars($allUserData['gender'] ?? ''); ?>
                                </div>
                            </td>
                            <td class="table_data">
                                <div>
                                    <label>Date Of Birth</label>
                                </div>
                                <div>
                                    <?php echo htmlspecialchars($allUserData['dateOfBirth'] ?? ''); ?>
                                </div>
                            </td>
                            <td class="table_data">
                                <div>
                                    <label>Marital Status</label>
                                </div>
                                <div>
                                    <?php echo htmlspecialchars($allUserData['maritalStatus'] ?? ''); ?>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td class="table_data">
                                <div>
                                    <label>Phone Number</label>
                                </div>
                                <div>
                                    <?php echo htmlspecialchars($allUserData['phoneNumber'] ?? ''); ?>
                                </div>
                            </td>
                            <td class="table_data">
                                <div>
                                    <label>Emergency Number</label>
                                </div>
                                <div>
                                    <?php echo htmlspecialchars($allUserData['emergencyNumber'] ?? ''); ?>
                                </div>
                            </td>
                            <td class="table_data">
                                <div>
                                    <label>NIN</label>
                                </div>
                                <div>
                                    <?php echo htmlspecialchars($allUserData['nin'] ?? ''); ?>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td class="table_data">
                                <div>
                                    <label>State Of Origin</label>
                                </div>
                                <div>
                                    <?php echo htmlspecialchars($allUserData['stateOfOrigin'] ?? ''); ?>
                                </div>
                            </td>
                            <td class="table_data">
                                <div>
                                    <label>Local Government</label>
                                </div>
                                <div>
                                    <?php echo htmlspecialchars($allUserData['lga'] ?? ''); ?>
                                </div>
                            </td>
                            <td class="table_data">
                                <div>
                                    <label>Residential Address</label>
                                </div>
                                <div>
                                    <?php echo htmlspecialchars($allUserData['address'] ?? ''); ?>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td class="table_data" colspan="1.5">
                                <div>
                                    <label>LGA Indigene\Origin Certifiate</label>
                                </div>
                                <div>
                                    <a href="../Application_Dashboard/<?php echo $allUserData['lga_file_path'] ?>" target="_blank">Origin Cert</a>
                                </div>
                            </td>
                            <td class="table_data" colspan="1.5">
                                <div>
                                    <label>Birth Certifiate</label>
                                </div>
                                <div>
                                    <a href="../Application_Dashboard/<?php echo $allUserData['birth_certificate_file_path'] ?>" target="_blank">Birth Cert</a>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                    
                </table>
                
                <!-- Education Summary -->
                <table>
                    <thead>
                        <th class="table_head" colspan="3">
                            <h4 >Education</h4>
                        </th>
                    </thead>
                    <tbody>
                        <!-- <tr>
                            <th colspan="3">
                                <h4 class="section_h4">Primary Education</h4>
                            </th>
                        </tr> -->
                        <tr>
                            <td colspan="2" class="table_data">
                                <div>
                                    <label for="">Primary School Name</label>
                                </div>
                                <div>
                                    <?php echo htmlspecialchars($allUserData['primary_school_name'] ?? ''); ?>
                                </div>
                            </td>
                            <td class="table_data">
                                <div>
                                    <label for="">Graduation Year</label>
                                </div>
                                <div>
                                    <?php echo htmlspecialchars($allUserData['primary_graduation_year'] ?? ''); ?>
                                </div>
                            </td>
                        </tr>
                        <!-- <tr>
                            <th colspan="3">
                                <h4 class="section_h4">Secondary Education</h4>
                            </th>
                        </tr> -->
                        <tr>
                            <td class="table_data">
                                <div>
                                    <label for="">Secondary Education</label>
                                </div>
                                <div>
                                    <?php echo htmlspecialchars($allUserData['secondarySchoolName'] ?? ''); ?>
                                </div>
                            </td>
                            <td class="table_data">
                                <div>
                                    <label for="">Secondary Education Certificate</label>
                                </div>
                                <div>
                                    <?php echo htmlspecialchars($allUserData['secondaryCertificate'] ?? ''); ?>
                                </div>
                            </td>
                            <td class="table_data">
                                <div>
                                    <label for="">Graduation Year</label>
                                </div>
                                <div>
                                    <a href="../Application_Dashboard/<?php echo $allUserData['sec_file_path'] ?>" target="_blank">Sec Cert</a>
                                </div>
                            </td>
                        </tr>
                        <!-- <tr>
                            <th colspan="3">
                                <h4 class="section_h4">Higher Education</h4>
                            </th>
                        </tr> -->
                        <tr>
                            <td class="table_data">
                                <div>
                                    <label for="">Higher Institution Name</label>
                                </div>
                                <div>
                                    <?php echo htmlspecialchars($allUserData['institution'] ?? ''); ?>
                                </div>
                            </td>
                            <td class="table_data">
                                <div>
                                    <label for="">Certificate Type</label>
                                </div>
                                <div>
                                    <?php echo htmlspecialchars($allUserData['certificateType'] ?? ''); ?>
                                </div>
                            </td>
                            <td class="table_data">
                                <div>
                                    <label for="">Class Of Degree</label>
                                </div>
                                <div>
                                    <?php echo htmlspecialchars($allUserData['classOfDegree'] ?? ''); ?>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td class="table_data">
                                <div>
                                    <label for="">Course</label>
                                </div>
                                <div>
                                    <?php echo htmlspecialchars($allUserData['course'] ?? ''); ?>
                                </div>
                            </td>
                            <td class="table_data">
                                <div>
                                    <label for="">Higher Education Certificate</label>
                                </div>
                                <div>
                                    <a href="../Application_Dashboard/<?php echo $allUserData['high_certificate_file_path'] ?>" target="_blank">Higher Cert</a>
                                </div>
                            </td>
                            <td class="table_data">
                                <div>
                                    <label for="">Graduation Year</label>
                                </div>
                                <div>
                                    <?php echo htmlspecialchars($allUserData['highGraduationYear'] ?? ''); ?>
                                </div>
                            </td>
                        </tr>
                        <!-- <tr>
                            <th colspan="3">
                                <h4 class="section_h4">NYSC</h4>
                            </th>
                        </tr> -->
                        <tr>
                            <td class="table_data">
                                <div>
                                    <label for="">Certificate Number</label>
                                </div>
                                <div>
                                    <?php echo htmlspecialchars($allUserData['nyscCertificateNumber'] ?? ''); ?>
                                </div>
                            </td>
                            <td class="table_data">
                                <div>
                                    <label for="">Year Of Service</label>
                                </div>
                                <div>
                                    <?php echo htmlspecialchars($allUserData['yearOfService'] ?? ''); ?>
                                </div>
                            </td>
                            <td class="table_data">
                                <div>
                                    <label for="">NYSC Certificate</label>
                                </div>
                                <div>
                                    <a href="../Application_Dashboard/<?php echo $allUserData['nysc_file_path'] ?>" target="_blank">NYSC Cert</a>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <!-- Work History Sumary -->
                <table>
                    <thead>
                        <th class="table_head" colspan="2">
                            <div>
                                <h4>Work History</h4>
                            </div>
                        </th>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="table_data">
                                <div>
                                    <label for="">Organization Name</label>
                                </div>
                                <div>
                                    <?php echo htmlspecialchars($allUserData['organizationName'] ?? ''); ?>
                                </div>
                            </td>
                            <td class="table_data">
                                <div>
                                    <label for="">Rank</label>
                                </div>
                                <div>
                                    <?php echo htmlspecialchars($allUserData['rank'] ?? ''); ?>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2" class="table_data">
                                <div>
                                    <label for="">Responsibilities</label>
                                </div>
                                <div>
                                    <?php echo htmlspecialchars($allUserData['responsibilities'] ?? ''); ?>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td class="table_data">
                                <div>
                                    <label for="">Start Date</label>
                                </div>
                                <div>
                                    <?php echo htmlspecialchars($allUserData['startDate'] ?? ''); ?>
                                </div>
                            </td>
                            <td class="table_data">
                                <div>
                                    <label for="">End Date</label>
                                </div>
                                <div>
                                    <?php echo htmlspecialchars($allUserData['endDate'] ?? ''); ?>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
                 <!-- Work Professional Membership -->
                 <table>
                    <thead>
                        <th class="table_head" colspan="3">
                            <div>
                                <h4>Professional Membership</h4>
                            </div>
                        </th>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="table_data">
                                <div>
                                    <label for="">Body Name</label>
                                </div>
                                <div>
                                    <?php echo htmlspecialchars($allUserData['bodyName'] ?? ''); ?>
                                </div>
                            </td>
                            <td class="table_data">
                                <div>
                                    <label for="">Membership ID</label>
                                </div>
                                <div>
                                    <?php echo htmlspecialchars($allUserData['membershipID'] ?? ''); ?>
                                </div>
                            </td>
                            <td class="table_data">
                                <div>
                                    <label for="">Membership Type</label>
                                </div>
                                <div>
                                    <?php echo htmlspecialchars($allUserData['membershipType'] ?? ''); ?>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3" class="table_data">
                                <div>
                                    <label for="">Responsibilities</label>
                                </div>
                                <div>
                                    <?php echo htmlspecialchars($allUserData['membershipResposibilities'] ?? ''); ?>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td class="table_data">
                                <div>
                                    <label for="">Certificate Date</label>
                                </div>
                                <div>
                                    <?php echo htmlspecialchars($allUserData['certificateDate'] ?? ''); ?>
                                </div>
                            </td>
                            <td class="table_data">
                                <div>
                                    <label for="">Certificate</label>
                                </div>
                                <div>
                                    <a href="../Application_Dashboard/<?php echo $allUserData['pmc_file_path'] ?>" target="_blank">Membership Cert</a>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="form-footer">
                <button id="print" type="" onclick="printDiv('printableArea')">
                    Print
                </button>
            </div>
        </form>
        
    </div>
</div>
<script>

  function printDiv(divId) {
    // Get the content of the div
    var content = document.getElementById(divId).innerHTML;

    // Create a new window
    var printWindow = window.open('', '', 'height=600,width=800');

    // Write the content to the new window
    printWindow.document.write(`
        <html>
            <head>
                <title>Print</title>
                <link rel="stylesheet" href="./af_style.css">
                <style>
                    table{
                        width:100%;
                        margin:20px    
                    }
                    tr{
                        width:100%;
                        margin-bottom: 0.8em;
                        min-height: 30px;
                        padding:10px;
                        margin:10px;
                    }x 
                    .table_head{
                        background-color: var(--main-color);
                        text-align: center;
                        color: #fff;
                        font-size: 0.7em;
                        padding: 1em;
                    }
                    .table_data{
                        text-align: left;
                        border-bottom: 1px solid var(--main-color);
                        margin: 1.5em;
                    }
                    .section_h4{
                        background-color: var(--main-bg-light) ;
                        padding: 0.3em;
                        margin:8px 0
                        color: #fff
                    }
                    label{
                        font-size:0.5em
                    }
                </style>
            </head>
            <body>
                <div style="display:flex;justify-content:center;align-items:center;">
                    <img src="../images/print.jpg" alt="Print Image">
                </div>
                <div>
                    ${content}
                </div>
            </body>
        </html>
    `);

    // Close the document to finish loading
    printWindow.document.close();

    // Wait for the content to fully load, then trigger the print dialog
    printWindow.focus();
    printWindow.onload = function() {
      printWindow.print();
      printWindow.close(); // Close the window after printing
    };
  }
</script>
