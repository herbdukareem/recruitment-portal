<div id="summary-screen" class="screen" style="display: none;">
    <div class="screen-head">
        <div class="screen-head-left">
            <h2>Application Preview</h2>
        </div>
        <div class="screen-head-right">
            <p>
                <a href="" style="color: #008f4a;"> Job Application</a> / <a href=""><svg xmlns="http://www.w3.org/2000/svg" width="0.9em" height="0.9em" viewBox="0 0 24 24">
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
                background-color: #216745a9;
                color: #fff;
                font-size: 0.5em;
                padding: 0.1em 0.5em;
                border-radius: 0 5px 5px 0;
            }
            .table_data{
                text-align: left;
                border-bottom: 1px solid #216745;
                margin: 0.8em;
            }
            .section_h4{
                background-color: #21674559 ;
                padding: 0.3em;
            }
        </style>
        <form action="">
            <div class="form-head">
                <h2>Appication Summary</h2>
            </div>
            <div class="form-body">
                <!-- Bio Data Summary -->
                <table>
                    <thead>
                        <th class="table_head">
                            <div>
                                <h3 >Bio Data</h3>
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
                                    <?php echo htmlspecialchars($allUserData['localGovernmentArea'] ?? ''); ?>
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
                                    <?php echo htmlspecialchars($allUserData['lgaCertificate'] ?? ''); ?>
                                </div>
                            </td>
                            <td class="table_data" colspan="1.5">
                                <div>
                                    <label>Birth Certifiate</label>
                                </div>
                                <div>
                                    <?php echo htmlspecialchars($allUserData['birthCertificate'] ?? ''); ?>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                    
                </table>
                <!-- Work History Sumary -->
                <table>
                    <thead>
                        <th class="table_head">
                            <div>
                                <h3>Work History</h3>
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
                                    <label for="">Role</label>
                                </div>
                                <div>
                                    <?php echo htmlspecialchars($allUserData['role'] ?? ''); ?>
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
                <!-- Education Summary -->
                <table>
                    <thead>
                        <th class="table_head">
                            <h3 >Education</h3>
                        </th>
                    </thead>
                    <tbody>
                        <tr>
                            <th colspan="3">
                                <h4 class="section_h4">Primary Education</h4>
                            </th>
                        </tr>
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
                        <tr>
                            <th colspan="3">
                                <h4 class="section_h4">Secondary Education</h4>
                            </th>
                        </tr>
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
                                    <?php echo htmlspecialchars($allUserData['secondaryGraduationYear'] ?? ''); ?>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <th colspan="3">
                                <h4 class="section_h4">Higher Education</h4>
                            </th>
                        </tr>
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
                                    <?php echo htmlspecialchars($allUserData['highCertificate'] ?? ''); ?>
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
                        <tr>
                            <th colspan="3">
                                <h4 class="section_h4">NYSC</h4>
                            </th>
                        </tr>
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
                                    <?php echo htmlspecialchars($allUserData['nyscCertificate'] ?? ''); ?>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="form-footer">
                <button id="print" type="" onclick="print()">
                    Print
                </button>
            </div>
        </form>
        
    </div>
</div>
<script>
    const print = document .getElementById('print');
    print.addEventListener('click', (e)=>{
        window.print();
    })
</script>