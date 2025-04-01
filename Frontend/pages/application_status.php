<div id="application-status_screen" style="display: none;">
    <div class="app-status">
        <div class="app-head">
            <h3>Application Review</h3>
        </div>
        <div class="app-body">
            <table>
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Position</th>
                        <th>CPL%</th>
                        <th>Date</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            <?php echo htmlspecialchars($allUserData['firstname']) ?? '' ?>
                            <?php echo htmlspecialchars($allUserData['lastname']) ?? ''?>
                        </td>
                        <td>
                            <?php echo htmlspecialchars($allUserData['position']) ?? '' ?>
                        </td>
                        <td>
                            <?php echo htmlspecialchars($userQuizScore['score_percentage']) ?? '' ?>
                        </td>
                        <td>
                            <?php echo htmlspecialchars($allUserData['applications_timestamp']) ?? '' ?>
                        </td>
                        <td>
                            <button id="statusText">
                                <svg xmlns="http://www.w3.org/2000/svg" width="1.2em" height="1.2em" viewBox="0 0 48 48"><g fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="4"><path fill="#00044B" stroke="" d="M24 44C35.0457 44 44 35.0457 44 24C44 12.9543 35.0457 4 24 4C12.9543 4 4 12.9543 4 24C4 35.0457 12.9543 44 24 44Z"/><path stroke="#e4b535" d="M24 12V15"/><path stroke="#e4b535" d="M32.4852 15.5147L30.3639 17.636"/><path stroke="#e4b535" d="M36 24H33"/><path stroke="#e4b535" d="M32.4852 32.4853L30.3639 30.364"/><path stroke="#e4b535" d="M24 36V33"/><path stroke="#e4b535" d="M15.5148 32.4853L17.6361 30.364"/><path stroke="#e4b535" d="M12 24H15"/><path stroke="#e4b535" d="M15.5148 15.5147L17.6361 17.636"/></g></svg>
                                <!-- <?php 
                                    if($allUserData['status'] === 'shortlisted'){
                                        echo htmlspecialchars($allUserData['status']);
                                    } else if ($allUserData['status'] === 'interviewed'){
                                        echo htmlspecialchars($allUserData['status']);
                                    } else if ($allUserData['status'] === 'unemployed'){
                                        echo htmlspecialchars($allUserData['status']);
                                    } else {
                                        echo 'Pending...';       
                                    }
                                ?> -->
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    positions = {
        'Professor' : 50,
        'Associate Professor/Reader' : 50,
        'Lecturer I' : 50,
        'Lecturer II' : 50,
        'Assistant Lecturer' : 50,
        'Administrative Cadre' : 40,
        'Executive Officer Cadre' : 35,
        'Clerical Officer Cadre' : 25,
        'Secretarial Cadre' : 50,
        'Secretarial Assistant Cadre' : 30,  
        'Portel': 30,
        'Office Assistant Cadre' : 50,
        'Accountant Cadre' : 50,
        'Executive Officer (Accounts) Cadre' : 40,
        'Stores Officers Cadre' : 45,
        'Store Attendant' : 15,
        'Internal Auditors Cadre' : 50,
        'Executive Officer (Audit) Cadre' : 40,
        'Information Officer Cadre' : 60,
        'Protocol Officer Cadre'  : 50, 
        'Photographer Cadre' : 20,
        'Video Camera Operator Cadre' : 25,
        'Information Assistant Cadre' : 50,
        'Executive Officer (Information) Cadre' : 50,
        'Doctors Cadre' : 60,
        'Pharmacists Cadre' : 55,
        'Nursing Officer Cadre' : 50,
        'Pharmacy Technician Cadre' : 50,
        'Medical Laboratory Technologist Cadre' : 50,
        'Medical Laboratory Technician Cadre' : 40,
        'Medical Laboratory Assistant Cadre' : 25,
        'Health Records Officer' : 45,
        'Environmental Health Officer Cadre' : 45,
        'Veterinary Officer Cadre' : 40,
        'Legal Officer Cadre' : 50,
        'Library Officer Cadre' : 40,
        'Library Assistant Cadre' : 25,
        'Bindery Officers Cadre' : 35,
        'Bindery Assistant Cadre' : 25,
        'Data Operator/I.T. Operator Cadre' : 45,
        'Data Analyst Cadre' : 55,
        'Computer Electronics Engineer Cadre' : 70,
        'Systems Programmer/Analyst Cadre' : 70,
        'Director, COMSIT' : 95,
        'Engineer Cadre' : 50,
        'Architect Cadre' : 55,
        'Quantity Surveyor Cadre' : 50,
        'Physical Planning Unit' : 50,
        'Maintenance Officer' : 45,
        'Workshop Attendant/Assistant/Superintendent Cadre' : 20,
        'Driver Cadre' : 25,
        'Driver/Mechanic Cadre' : 25,
        'Craftsman (Carpentry & Mason, Welding, Plumbing, Electrical, R&G, Mechanical, etc.)' : 15,
        'Technical Officer Cadre' : 35,
        'Artisan/Craftsman' : 20,
        'Power Station Operator Cadre' : 20,
        'Horticulturist Cadre (Parks & Gardens)' : 35,
        'Estate Officers Cadre' : 50,
        'Gardening Staff (Biological and Parks & Gardens Units)' : 15,
        'Technologist Cadre' : 50,
        'Laboratory Supervisor' : 20,
        'Staff School Cadre I (Lower Basic)' : 35,
        'Staff School Cadre II (Upper Basic)' : 35,
        'Security Cadre' : 15,
        'Planning Officer Cadre' : 50,
        'Coach Cadre' : 25,
        'Coordinator Cadre (SIWES)' : 40,
        'Counsellor Cadre' : 40,
        'Signer (Interpreter) Cadre' : 35,
        'Archives Assistant Cadre' : 15,
        'ArchivesOfficer Cadre' : 25,
        'Archivist Cadre' : 45,
        'Graphic Arts Assistant Cadre' : 15,
        'Graphic Arts Officers Cadre' : 35,
        'Fireman Cadre' : 25,
        'Fire Superintendent Cadre - 120' : 30,
        'Fire Officer Cadre - 122' : 40
    };

    let statusText = document.getElementById('statusText');
    let initialPosition = "<?php echo htmlspecialchars($allUserData['position']); ?>";
    let testPercentage = parseInt("<?php echo htmlspecialchars($userQuizScore['score_percentage']); ?>");

    // Check if the position exists in the positions object
    if (positions.hasOwnProperty(initialPosition)) {
        let requiredPercentage = positions[initialPosition]; // Get the required percentage
        
        if (testPercentage >= requiredPercentage) {
            statusText.innerText = "<?php echo htmlspecialchars($allUserData['status'])? $allUserData['status'] : 'In progress..'; ?>";
        } else {
            statusText.innerText = 'Declined';
        }
        consloe.log(statusText);
        consloe.log('statusText');
    } else {
        console.error("Position not found in the list.");
        statusText.value = "Position not recognized";
    }


</script>