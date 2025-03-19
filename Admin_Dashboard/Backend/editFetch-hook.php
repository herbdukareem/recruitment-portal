<?php 
    if (isset($user_id)) {
        // Fetch user firstname and lastname from the database using user ID
        $stmt = $pdo->prepare("SELECT * FROM users WHERE id = :user_id");
        $stmt->execute(['user_id' => $user_id]);
        $user_names = $stmt->fetch(PDO::FETCH_ASSOC);


		// Fetch user data for display in the form after saving
		$fetchUserData = $pdo->prepare("SELECT * FROM user_applications WHERE user_id = :user_id");
		$fetchUserData->execute(['user_id' => $user_id]);
		$user_data = $fetchUserData->fetch(PDO::FETCH_ASSOC);

		// Fetch user Education Detials for display in the form after saving
		$fetchUserEducationData = $pdo->prepare("SELECT * FROM user_education_details WHERE user_id = :user_id");
		$fetchUserEducationData->execute(['user_id' => $user_id]);
		$user_edu_data = $fetchUserEducationData->fetch(PDO::FETCH_ASSOC);

		// Fetch user Education Detials for display in the form after saving
		$fetchUserWorkData = $pdo->prepare("SELECT * FROM user_work_details WHERE user_id = :user_id");
		$fetchUserWorkData->execute(['user_id' => $user_id]);
		$user_work_data = $fetchUserWorkData->fetch(PDO::FETCH_ASSOC);

		$fetchUserPMCData = $pdo->prepare("SELECT * FROM user_pmc_details WHERE user_id = :user_id");
		$fetchUserPMCData->execute(['user_id' => $user_id]);
		$user_pmc_data = $fetchUserPMCData->fetch(PDO::FETCH_ASSOC);
		//Fetching user score from DB
		$fetchUserQuizScore = $pdo->prepare("SELECT * FROM quiz_scores WHERE user_id = :user_id");
		$fetchUserQuizScore->execute(['user_id' => $user_id]);
		$userQuizScore = $fetchUserQuizScore->fetch(PDO::FETCH_ASSOC);

		$fetchAllUserData = $pdo->prepare("
			SELECT * 
			FROM users as u
			JOIN user_applications as b ON u.id = b.user_id 
			JOIN (
				SELECT *
				FROM user_education_details
			) as e ON u.id = e.user_id
			JOIN (
				SELECT *
				FROM user_files
			) as f ON u.id = f.user_id
			JOIN (
				SELECT *
				FROM user_work_details
			)as w ON u.id = w.user_id
			JOIn (
				SELECT *
				FROM user_pmc_details
			)as p ON u.id = p.user_id
			WHERE u.id = :user_id

		");
		$fetchAllUserData->execute(['user_id' => $user_id]);
		$allUserData = $fetchAllUserData->fetch(PDO::FETCH_ASSOC);
	}
?>