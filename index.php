<?php 

	// error_reporting(E_ERROR | E_PARSE); // Only show critical errors
	// ini_set('display_errors', 0);

    $positions = [
        "Administrative Cadre" => [
            "Administrative Cadre",
            "Executive Officer Cadre",
            "Clerical Officer Cadre",
            "Secretarial Cadre",
            "Secretarial Assistant Cadre",
            "Portel",
            "Office Assistant Cadre"
        ],
        "Academic Staff" => [
            "Professor",
            "Associate Professor/Reader",
            "Lecturer I",
            "Lecturer II",
            "Assistant Lecturer",
            "Graduate Assistant"
        ],
        "Bursary" => [
            "Accountant Cadre",
            "Executive Officer (Accounts) Cadre",
            "Stores Officers' Cadre",
            "Store Attendant"
        ],
        "Internal Audit Unit" => [
            "Internal Auditors' Cadre",
            "Executive Officer (Audit) Cadre"
        ],
        "Directorate of Corporate Affairs" => [
            "Information Officer Cadre",
            "Protocol Officer Cadre",
            "Photographer Cadre",
            "Video Camera Operator Cadre",
            "Information Assistant Cadre",
            "Executive Officer (Information) Cadre"
        ],
        "Health Services" => [
            "Doctors Cadre",
            "Pharmacists Cadre",
            "Nursing Officer Cadre",
            "Pharmacy Technician Cadre",
            "Medical Laboratory Technologist Cadre",
            "Medical Laboratory Technician Cadre",
            "Medical Laboratory Assistant Cadre",
            "Health Records Officer",
            "Environmental Health Officer Cadre",
            "Veterinary Officer Cadre"
        ],
        "Legal Unit" => [
            "Legal Officer Cadre"
        ],
        "University Library" => [
            "Library Officer Cadre",
            "Library Assistant Cadre",
            "Bindery Officers' Cadre",
            "Bindery Assistant Cadre"
        ],
        "Directorate of COMSIT" => [
            "Data Operator/I.T. Operator Cadre",
            "Data Analyst Cadre",
            "Computer Electronics Engineer Cadre",
            "Systems Programmer/Analyst Cadre",
            "Director, COMSIT"
        ],
        "Works Unit" => [
            "Engineer Cadre",
            "Architect Cadre",
            "Quantity Surveyor Cadre",
            "Physical Planning Unit",
            "Maintenance Officer",
            "Workshop Attendant/Assistant/Superintendent Cadre",
            "Driver Cadre",
            "Driver/Mechanic Cadre",
            "Craftsman (Carpentry & Mason, Welding, Plumbing, Electrical, R&G, Mechanical, etc.)",
            "Technical Officer Cadre",
            "Artisan/Craftsman",
            "Power Station Operator Cadre",
            "Horticulturist Cadre (Parks & Gardens)",
            "Estate Officers' Cadre",
            "Gardening Staff (Biological and Parks & Gardens Units)"
        ],
        "Laboratory" => [
            "Technologist Cadre",
            "Laboratory Supervisor"
        ],
        "University School" => [
            "Staff School Cadre I (Lower Basic)",
            "Staff School Cadre II (Upper Basic)"
        ],
        "Directorate of Security" => [
            "Security Cadre"
        ],
        "Academic Planning Unit" => [
            "Planning Officer Cadre"
        ],
        "Sport" => [
            "Coach Cadre"
        ],
        "SIWES" => [
            "Coordinator Cadre (SIWES)"
        ],
        "Counselling Center" => [
            "Counsellor Cadre"
        ],
        "Centre for Special Needs" => [
            "Signer (Interpreter) Cadre"
        ],
        "Archives Centre" => [
            "Archives Assistant Cadre",
            "Archives' Officer Cadre",
            "Archivist Cadre"
        ],
        "Educational Technology" => [
            "Graphic Arts Assistant Cadre",
            "Graphic Arts Officers' Cadre"
        ],
        "Fire Services" => [
            "Fireman Cadre",
            "Fire Superintendent Cadre - 120",
            "Fire Officer Cadre - 122"
        ]

    ];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recruitment Portal | UNILORIN</title>
    <link rel="shortcut icon" href="../images/logo-plain.jpeg.jpg" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@3.3.3/dist/tailwind.min.css" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="./style/nav-footer.css">
    <link rel="stylesheet" href="./style/style.css">
</head>
<style>
    /* .gradient-text {
        font-size: 2.5rem;
        font-weight: bold;
        background: linear-gradient(to top, var(--main-bg), var(--main-color));
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        color: transparent;
        margin-top: 100px;
    } */

    .text-cr {
        font-weight: bold;
        font-size: 3.5rem;
        text-align: center;
        color: var(--main-bg);
    }

    .image-container {
        justify-content: center;
        align-items: center;
        width: 70%;
    }

    .gcr {
        background-color: #B0B0B0;

    }

    .gcr:hover {
        transform: scale(1.01);
    }

    .btn-custom {
        background-color: transparent;
        color: white;
        border: 2px solid white;
        font-size: 1rem;
        padding: 0.75rem 1.5rem;
        transition: all 0.3s ease;
    }

    .btn-custom:hover {
        background-color: yellow;
        color: black;
        border-color: yellow;
    }

    h4 {
        font-weight: bold;
        color: var(--main-bg)
    }

    /* Responsive Styling */
    @media (max-width: 768px) {
        .btn-custom {
            width: 90%;
            display: block;
            font-size: 1.25rem;
            padding: 1rem;
            margin-bottom: 1rem;
        }
    }
</style>

<body>
    <main class="winscroll">
       <?php include_once('header.php'); ?>

        <div class="main">
            <div class="con-bg">
                <div class="row">
                    <div class="col-md-6 mt-5 ">
                        <h1 class="text-center mt-5" style="color: var(--white);">Power Your Future With </h1>
                        <h1 class="text-cr" style="color: #fff;">University Of Ilorin</h1>
                        <h5 class="text-center mt-5">To be an international centre of excellence in learning, research,
                            probity and service to humanity.
                            To provide world-class environment for learning, research and community service.</h5>
                        <div class="d-flex justify-content-center mt-5">
                            <a href="#about_us" class="btn btn-success ">About Us</a>
                        </div>
                    </div>
                    <div class="left-img col-md-6 mt-5">
                        <div class="d-flex align-items-center justify-content-center">
                            <img class="image-container rounded img-fluid" src="./images/wahab.png" alt="Mr. Wahab">
                        </div>
                    </div>
                </div>
            </div>

            <section class="container mx-auto py-12 px-6">
                <div class="text-center mb-8">
                    <h2 class="text-3xl font-bold text-[#00044B]">Positions and Career Opportunities at UNILORIN</h2>
                    <p class="mt-4 text-lg text-gray-700">The University of Ilorin offers a wide array of career
                        opportunities, catering to both academic and non-academic roles...</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <?php foreach ($positions as $positionName => $listPositions) { ?>
                        <div class="bg-white shadow-lg rounded-lg p-6 flex flex-col justify-between">
                            <?php 
                            // Example: If each position has an associated image
                            $imagePath = "./images/" . $positionName . ".jpg"; 
                            ?>
                            <img src="<?php echo $imagePath; ?>" alt="<?php echo $positionName; ?>" class="rounded-lg mb-4 w-full h-40 object-cover">

                            <div>
                                <h3 class="text-xl font-semibold text-[#00044B]"><?php echo $positionName; ?></h3>
                                <ul class="mt-4 list-disc list-inside text-gray-700">
                                    <?php 
                                    $totalItems = count($listPositions);
                                    foreach ($listPositions as $index => $listPosition) { 
                                        $hiddenClass = ($index >= 5) ? 'hidden' : ''; 
                                    ?>
                                        <li class="list-item <?php echo $hiddenClass; ?>" data-position="<?php echo $positionName; ?>">
                                            <?php echo htmlspecialchars($listPosition); ?>
                                        </li>
                                    <?php } ?>
                                </ul>
                                <?php if ($totalItems > 5) { ?>
                                    <button class="see-more-btn mt-2 text-blue-500" 
                                        onclick="toggleList('<?php echo $positionName; ?>')">
                                        See More...
                                    </button>
                                    <button class="see-less-btn mt-2 text-blue-500 hidden" 
                                        onclick="toggleList('<?php echo $positionName; ?>')">
                                        See Less
                                    </button>
                                <?php } ?>
                            </div>
                            <button class="mt-6 bg-[#00044B] text-white py-2 px-4 rounded-lg hover:bg-opacity-90 transition">
                                Apply Now
                            </button>
                        </div>
                    <?php } ?>
                </div>

               


            </section>

            <section class="container mx-auto py-12 px-6">
                <div class="text-center mb-8">
                    <h2 class="text-3xl font-bold text-[#bd9119]">Features of the UNILORIN Career Portal</h2>
                    <p class="mt-4 text-lg text-[#111683]">
                        Explore the key features that make our career portal efficient, user-friendly, and tailored to your job search needs.
                    </p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    <!-- Easy Job Application -->
                    <div class="bg-[#00044B] shadow-lg rounded-lg p-6 text-center text-white">
                        <i class="fas fa-file-alt text-[#e4b535] text-4xl"></i>
                        <h3 class="text-xl font-semibold text-[#e4b535] mt-4">Easy Job Application</h3>
                        <p class="mt-2">
                            Apply for multiple positions with a simple and user-friendly application process.
                        </p>
                    </div>

                    <!-- Real-Time Updates -->
                    <div class="bg-[#00044B] shadow-lg rounded-lg p-6 text-center text-white">
                        <i class="fas fa-bell text-[#e4b535] text-4xl"></i>
                        <h3 class="text-xl font-semibold text-[#e4b535] mt-4">Real-Time Updates</h3>
                        <p class="mt-2">
                            Stay informed with real-time notifications on job postings, application status, and deadlines.
                        </p>
                    </div>

                    <!-- Secure Profile Management -->
                    <div class="bg-[#00044B] shadow-lg rounded-lg p-6 text-center text-white">
                        <i class="fas fa-user-shield text-[#e4b535] text-4xl"></i>
                        <h3 class="text-xl font-semibold text-[#e4b535] mt-4">Secure Profile Management</h3>
                        <p class="mt-2">
                            Manage and update your profile securely with encrypted data protection.
                        </p>
                    </div>
                </div>
            </section>

            <div class="container mb-5 rounded">
                <div class="row img-bg">
                    <!-- Background image container -->
                    <div class="col-12 position-relative text-center text-white ">
                        <!-- Overlay for buttons and text -->
                        <div class="d-flex flex-column align-items-center justify-content-center h-100">
                            <!-- Text -->
                            <p class="mb-3 " style="font-size: 4rem;font-weight:bold;">
                                <span>Start</span> your career at University Of Ilorin today
                            </p>
                            <!-- Buttons -->
                            <div class="d-flex flex-md-row align-items-center">
                                <button type="button" class="btn btn-custom   mx-4">Academic</button>
                                <button type="button" class="btn btn-custom   mx-4">Non-Academic </button>
                                <!-- <button type="button" class="btn btn-custom">Button 2</button> -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="container" id="about_us">
                <div class="about">
                    <h2>About UNILORIN</h2>
                    <div class="pos-p">
                        <p>The University of Ilorin, established in 1975, has firmly established itself as a premier
                            institution of higher learning in Nigeria. With a reputation for academic rigor,
                            cutting-edge research, and a vibrant campus community, UNILORIN has consistently ranked
                            among the top universities in the country.</p>
                        <p>As a comprehensive university, UNILORIN offers a diverse range of undergraduate and
                            postgraduate programs across various disciplines, including the sciences, humanities, social
                            sciences, engineering, and more. The university’s commitment to excellence is reflected in
                            its highly qualified faculty, state-of-the-art facilities, and a robust research ecosystem
                            that fosters innovation and knowledge advancement.As a comprehensive university, UNILORIN
                            offers a diverse range of undergraduate and postgraduate programs across various
                            disciplines, including the sciences, humanities, social sciences, engineering, and more. The
                            university’s commitment to excellence is reflected in its highly qualified faculty,
                            state-of-the-art facilities, and a robust research ecosystem that fosters innovation and
                            knowledge advancement.</p>
                        <p>By attracting and nurturing exceptional individuals, UNILORIN aims to maintain its position
                            as a leading center of academic excellence, contributing significantly to the intellectual
                            and socioeconomic development of Nigeria and the broader African continent.</p>
                    </div>
                </div>
            </div>



        </div>

        <?php include_once('footer.php'); ?> 
    </main>

</body>
<script>
    function applyhereHandler(){
        window.location.href = './screening.php'
    }
    function toggleList(positionName) {
        const listItems = document.querySelectorAll(`.list-item[data-position='${positionName}']`);
        const seeMoreBtn = document.querySelector(`.see-more-btn[onclick="toggleList('${positionName}')"]`);
        const seeLessBtn = document.querySelector(`.see-less-btn[onclick="toggleList('${positionName}')"]`);

        listItems.forEach((item, index) => {
            if (index >= 5) {
                item.classList.toggle('hidden');
            }
        });

        seeMoreBtn.classList.toggle('hidden');
        seeLessBtn.classList.toggle('hidden');
    }
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>

</html>