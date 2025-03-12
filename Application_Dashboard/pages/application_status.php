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
                            <button>
                                <svg xmlns="http://www.w3.org/2000/svg" width="1.2em" height="1.2em" viewBox="0 0 48 48"><g fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="4"><path fill="#00044B" stroke="" d="M24 44C35.0457 44 44 35.0457 44 24C44 12.9543 35.0457 4 24 4C12.9543 4 4 12.9543 4 24C4 35.0457 12.9543 44 24 44Z"/><path stroke="#e4b535" d="M24 12V15"/><path stroke="#e4b535" d="M32.4852 15.5147L30.3639 17.636"/><path stroke="#e4b535" d="M36 24H33"/><path stroke="#e4b535" d="M32.4852 32.4853L30.3639 30.364"/><path stroke="#e4b535" d="M24 36V33"/><path stroke="#e4b535" d="M15.5148 32.4853L17.6361 30.364"/><path stroke="#e4b535" d="M12 24H15"/><path stroke="#e4b535" d="M15.5148 15.5147L17.6361 17.636"/></g></svg>
                                <?php 
                                    if($allUserData['status'] === 'shortlisted'){
                                        echo htmlspecialchars($allUserData['status']);
                                    } else if ($allUserData['status'] === 'interviewed'){
                                        echo htmlspecialchars($allUserData['status']);
                                    } else if ($allUserData['status'] === 'unemployed'){
                                        echo htmlspecialchars($allUserData['status']);
                                    } else {
                                        echo 'Pending...';       
                                    }
                                ?>
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>