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
            <div id="application-summary" class="form-head" style="display:flex; justify-content:space-between; align-items:center;">
                <div id="application-title">
                    <h2>Application Summary for the position of <span style="font-weight:bold;color:var(--main-color-light)"></span></h2>
                </div>
                <div id="passport-photo" style="padding: 8px 5px 5px 5px;">
                        <!-- populate  -->
                </div>
            </div>

            <div id="form-body" class="form-body">
                <!-- Bio Data Summary -->
                <table id="bio-data">
                    <thead>
                        <th class="table_head" colspan="3">
                            <div id="bio-data-title">
                                <h4>Bio Data</h4>
                            </div>
                        </th>
                    </thead>
                    <tbody>
                        <tr>
                            <td id="first-name" class="table_data">
                                <div>
                                    <label>First Name</label>
                                </div>
                                <div>
                                    <p id="sfname"></p>
                                </div>
                            </td>
                            <td id="middle-name" class="table_data">
                                <div>
                                    <label>Middle Name</label>
                                </div>
                                <div>
                                    <p id="smname"></p>
                                </div>
                            </td>
                            <td id="last-name" class="table_data">
                                <div>
                                    <label>Last Name</label>
                                </div>
                                <div>
                                    <p id="slname"></p>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td id="" class="table_data">
                                <div>
                                    <label>Gender</label>
                                </div>
                                <div>
                                    <p id="sgender"></p>
                                </div>
                            </td>
                            <td id="" class="table_data">
                                <div>
                                    <label>Date Of Birth</label>
                                </div>
                                <div>
                                    <p id="sdob"></p>
                                </div>
                            </td>
                            <td id="marital-status" class="table_data">
                                <div>
                                    <label>Marital Status</label>
                                </div>
                                <div>
                                    <p id="smaritalstatus"></p>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td id="phone-number" class="table_data">
                                <div>
                                    <label>Phone Number</label>
                                </div>
                                <div>
                                    <p id="sphoneNumber"></p>
                                </div>
                            </td>
                            <td id="emergency-number" class="table_data">
                                <div>
                                    <label>Emergency Number</label>
                                </div>
                                <div>
                                    <p id="semerNumber"></p>
                                </div>
                            </td>
                            <td id="" class="table_data">
                                <div>
                                    <label>NIN</label>
                                </div>
                                <div>
                                    <p id="snin"></p>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td id="state-of-origin" class="table_data">
                                <div>
                                    <label>State Of Origin</label>
                                </div>
                                <div>
                                    <p id="ssof"></p>
                                </div>
                            </td>
                            <td id="local-government" class="table_data">
                                <div>
                                    <label>Local Government</label>
                                </div>
                                <div>
                                    <p id="slga"></p>
                                </div>
                            </td>
                            <td id="" class="table_data">
                                <div>
                                    <label>Residential Address</label>
                                </div>
                                <div>
                                    <p id="saddress"></p>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td id="lga-certificate" class="table_data" colspan="1.5">
                                <div>
                                    <label>LGA Indigene/Origin Certificate</label>
                                </div>
                                <div>
                                    <a href="" target="_blank" id="slgaCert">Origin Cert</a>
                                </div>
                            </td>
                            <td id="birth-certificate" class="table_data" colspan="1.5">
                                <div>
                                    <label>Birth Certificate</label>
                                </div>
                                <div>
                                    <a href="" target="_blank" id="sbirthCert">Birth Cert</a>
                                </div>
                            </td>
                            <td></td>
                        </tr>
                    </tbody>
                </table>

                <!-- Education Summary -->
                <table id="education-summary">
                    <thead>
                        <th class="table_head" colspan="3">
                            <h4>Education</h4>
                        </th>
                    </thead>
                    <tbody>
                        <tr id="primary-education">
                            <td id="primary-school-name" colspan="2" class="table_data">
                                <div>
                                    <label>Primary School Name</label>
                                </div>
                                <div>
                                    <p id="spriSchoolName"></p>
                                </div>
                            </td>
                            <td id="primary-graduation-year" class="table_data">
                                <div>
                                    <label>Graduation Year</label>
                                </div>
                                <div>
                                    <p id="spriGradYear"></p>
                                </div>
                            </td>
                        </tr>
                        <tr id="secondary-education">
                            <td id="secondary-school-name" class="table_data">
                                <div>
                                    <label>Secondary Education</label>
                                </div>
                                <div>
                                    <p id="ssecName"></p>
                                </div>
                            </td>
                            <td id="secondary-certificate" class="table_data">
                                <div>
                                    <label>Graduation Year</label>
                                </div>
                                <div>
                                    <p id="ssecGradYear"></p>
                                </div>
                            </td>
                            <td id="secondary-graduation-year" class="table_data">
                                <div>
                                    <label>Secondary Education Certificate</label>
                                </div>
                                <div>
                                    <a href="" target="_blank" id="ssecEduCert">Sec Cert</a>
                                </div>
                            </td>
                        </tr>
                        <tr id="higher-education">
                            <td id="institution-name" class="table_data">
                                <div>
                                    <label>Higher Institution Name</label>
                                </div>
                                <div>
                                    <p id="shighName"></p>
                                </div>
                            </td>
                            <td id="certificate-type" class="table_data">
                                <div>
                                    <label>Certificate Type</label>
                                </div>
                                <div>
                                    <p id="scertType"></p>
                                </div>
                            </td>
                            <td id="class-of-degree" class="table_data">
                                <div>
                                    <label>Class Of Degree</label>
                                </div>
                                <div>
                                    <p id="scod"></p>
                                </div>
                            </td>
                        </tr>
                        <tr id="course">
                            <td id="course-name" class="table_data">
                                <div>
                                    <label>Course</label>
                                </div>
                                <div>
                                    <p id="scourse"></p>
                                </div>
                            </td>
                            <td id="higher-education-certificate" class="table_data">
                                <div>
                                    <label>Higher Education Certificate</label>
                                </div>
                                <div>
                                    <a href="" target="_blank" id="shighCert">Higher Cert</a>
                                </div>
                            </td>
                            <td id="higher-graduation-year" class="table_data">
                                <div>
                                    <label>Graduation Year</label>
                                </div>
                                <div>
                                    <p id="shighGradYear"></p>
                                </div>
                            </td>
                        </tr>
                        <tr id="nysc">
                            <td id="nysc-certificate-number" class="table_data">
                                <div>
                                    <label>Certificate Number</label>
                                </div>
                                <div>
                                    <p id="snyscCertNo"></p>
                                </div>
                            </td>
                            <td id="nysc-year-of-service" class="table_data">
                                <div>
                                    <label>Year Of Service</label>
                                </div>
                                <div>
                                    <p id="snyscYOS"></p>
                                </div>
                            </td>
                            <td id="nysc-certificate" class="table_data">
                                <div>
                                    <label>NYSC Certificate</label>
                                </div>
                                <div>
                                    <a href="" target="_blank" id="snyscCert">NYSC Cert</a>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>

                <!-- Work History Summary -->
                <table id="work-history-summary">
                    <thead>
                        <th class="table_head" colspan="2">
                            <div id="work-history-title">
                                <h4>Work History</h4>
                            </div>
                        </th>
                    </thead>
                    <tbody>
                        <tr id="organization-name">
                            <td class="table_data">
                                <div>
                                    <label>Organization Name</label>
                                </div>
                                <div>
                                    <p id="sorgName"></p>
                                </div>
                            </td>
                            <td class="table_data">
                                <div>
                                    <label>Rank</label>
                                </div>
                                <div>
                                    <p id="sorgRank"></p>
                                </div>
                            </td>
                        </tr>
                        <tr id="responsibilities">
                            <td colspan="2" class="table_data">
                                <div>
                                    <label>Responsibilities</label>
                                </div>
                                <div>
                                    <p id="sorgRes"></p>
                                </div>
                            </td>
                        </tr>
                        <tr id="work-start-end-dates">
                            <td class="table_data">
                                <div>
                                    <label>Start Date</label>
                                </div>
                                <div>
                                    <p id="sstartDate"></p>
                                </div>
                            </td>
                            <td class="table_data">
                                <div>
                                    <label>End Date</label>
                                </div>
                                <div>
                                    <p id="sendDate"></p>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>

                <!-- Work Professional Membership -->
                <table id="professional-membership-summary">
                    <thead>
                        <th class="table_head" colspan="3">
                            <div id="professional-membership-title">
                                <h4>Professional Membership</h4>
                            </div>
                        </th>
                    </thead>
                    <tbody>
                        <tr id="membership-body">
                            <td class="table_data">
                                <div>
                                    <label>Body Name</label>
                                </div>
                                <div>
                                    <p id="sbodyName"></p>
                                </div>
                            </td>
                            <td class="table_data">
                                <div>
                                    <label>Membership ID</label>
                                </div>
                                <div>
                                    <p id="smemId"></p>
                                </div>
                            </td>
                            <td class="table_data">
                                <div>
                                    <label>Membership Type</label>
                                </div>
                                <div>
                                    <p id="smemTpe"></p>
                                </div>
                            </td>
                        </tr>
                        <tr id="membership-responsibilities">
                            <td colspan="3" class="table_data">
                                <div>
                                    <label>Responsibilities</label>
                                </div>
                                <div>
                                    <p id="smemRes"></p>
                                </div>
                            </td>
                        </tr>
                        <tr id="membership-certificate">
                            <td class="table_data">
                                <div>
                                    <label>Certificate Date</label>
                                </div>
                                <div>
                                    <p id="smemCertDate"></p>
                                </div>
                            </td>
                            <td class="table_data">
                                <div>
                                    <label>Certificate</label>
                                </div>
                                <div>
                                    <a href="" target="_blank" id="smemCert">Membership Cert</a>
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
