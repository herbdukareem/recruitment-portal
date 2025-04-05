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
        <form action="" method="post" enctype="multipart/form-data" id="eduForm">
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
                    </tr>
                    <tr>
                        <td>
                            <div>
                                <input type="text" name="primary_school_name" id="primary_school_name" value="" >
                                <input type="text" name="userId" class="userId" value="" hidden >
                            </div>
                        </td>
                        <td>
                            <div>
                                <input type="text" name="primary_graduation_year" id="primary_graduation_year" value="" >
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
                    </tr>
                    <tr data-id="2">
                        <td>
                            <div>
                                <input type="text" name="secondarySchoolName" id="secondarySchoolName" value="" >
                            </div>
                        </td>
                        <td>
                            <div>
                                <input type="text" name="secondaryGraduationYear" id="secondaryGraduationYear" value="" >
                            </div>
                        </td>
                        <td>
                            <div>
                                <input type="file" name="secondaryCertificate" id="secondaryCertificate" value=""  accept="application/pdf,image/jpeg,image/png,image/jpg">
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
                    </tr>
                    <tr>
                        <td>
                            <div>
                                <input type="text" name="certificateType" id="certificateType" value="" >
                            </div>
                        </td>
                        <td>
                            <div>
                                <input type="text" name="classOfDegree" id="classOfDegree" value="" >
                            </div>
                        </td>
                        <td>
                            <div>
                                <input type="text" name="institution" id="institution" value="" >
                            </div>
                        </td>
                        <td>
                            <div>
                                <input type="text" name="course" id="course" value="" >
                            </div>
                        </td>
                        <td>
                            <div>
                                <input type="text" name="highGraduationYear" id="highGraduationYear" value="" >
                            </div>
                        </td>
                        <td>
                            <div>
                                <input type="file" name="highCertificate" id="highCertificate" value=""  accept="application/pdf,image/jpeg,image/png,image/jpg">
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
                    </tr>
                    <tr>
                        <td>
                            <div>
                                <input type="text" name="nyscCertificateNumber" id="nyscCertificateNumber" value="" >
                            </div>
                        </td>
                        <td>
                            <div>
                                <input type="text" name="yearOfService" id="yearOfService" value="" >
                            </div>
                        </td>
                        <td>
                            <div>
                                <input type="file" name="nyscCertificate" id="nyscCertificate" value=""  accept="application/pdf,image/jpeg,image/png,image/jpg">
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
