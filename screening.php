<?php
  
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Computer Proficiency Level Test Screening | UNILORIN</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-50">
    <style>
        .heading, footer{
            background-color: #00044B;
        }
        .heading h1{
            color: #e4b535;
        }
        .level1{
            background-color: #eee;
            color: #e4b535;
        }
        .level2{
            background-color: #ddd;
            color: #674c02;
        }
        .level3{
            background-color: #ccc;
            color: #00044B;
        }
        .btn{
            box-sizing: border-box;
            padding: 10px 20px;
            background-color: #111683;
            color: #fff;
            font-weight: bold;
            border-radius: 6px;
            transition: 0.2s all ease-in;
        }
        .btn:hover{
            background-color: #00044B;
        }
        .link-full a {
            text-decoration: none;
            border: 1px solid #00044B;
            padding: 0.4em 0.5em;
            font-weight: bold;
            transition: all ease-in 0.2s;
            border-radius: 0.2em;
        }
        .link-full a{
            color: #fff;
            background-color: #232875;
        }
        .link-full a:hover{
            background-color: #00044B;
        }
    </style>

    <!-- Header Section -->
    <header class="text-white p-8 heading">
        <div class="container mx-auto text-center">
            <h1 class="text-4xl font-bold">UNILORIN Computer Proficiency Level Test Screening</h1>
            <p class="text-xl mt-2">Select your level of computer proficiency to begin the test.</p>
        </div>
    </header>

    <!-- Main Content Section -->
    <div class="container mx-auto my-8 p-6 bg-white rounded-lg shadow-xl">

        <!-- Instruction Section -->
        <section class="text-center mb-8">
            <h2 class="text-3xl font-bold text-gray-700 mb-4">Instructions</h2>
            <p class="text-lg text-gray-600">
                This Computer Proficiency Level Test Screening is designed to assess your proficiency in computer applications.
                Depending on your skill level, you will be presented with different sets of questions. The test is divided
                into three categories:
            </p>
            <ul class="mt-4 text-left mx-auto max-w-prose space-y-3 text-lg">
                <li>1. Basic Level: 10 questions under 30 seconds.</li>
                <li>2. Intermediate Level: 10 questions under 60 seconds.</li>
                <li>3. Advanced Level: 10 questions under 120 seconds.</li>
            </ul>
            <p class="mt-4 text-gray-600 text-lg">
                You will need to answer the questions within the time limits to proceed. Please make sure you are in a quiet
                environment and can focus on the test.
            </p>
        </section>

        <!-- Proficiency Level Selection -->
        <section class="text-center mb-8">
            <h3 class="text-2xl font-semibold text-gray-700 mb-6">Choose Your Level of Proficiency:</h3>

            <!-- Detailed Level Descriptions -->
            <div class="space-y-6">
                <!-- Basic Level Description -->
                <div class="level1 p-6 rounded-lg shadow-md hover:shadow-lg transition duration-300">
                    <h4 class="text-2xl font-bold" >Basic Level</h4>
                    <p class="mt-2 text-gray-700 text-lg">
                        The Basic Level is designed for candidates who are just starting with computer applications.
                        You will be tested on fundamental skills such as navigating the operating system, using basic software
                        applications, and performing simple tasks like copy-pasting or typing.
                    </p>
                    <p class="mt-2 text-gray-700 text-lg">
                        Duration: You will have 30 seconds to answer each question. There are 10 questions in total.
                    </p>
                    <!-- <div class="mt-5">
                        <a href="./pages/basic_test.php"
                            class="btn">
                            Basic
                        </a>
                    </div> -->
                </div>

                <!-- Intermediate Level Description -->
                <div class="level2 p-6 rounded-lg shadow-md hover:shadow-lg transition duration-300">
                    <h4 class="text-2xl font-bold" >Intermediate Level</h4>
                    <p class="mt-2 text-gray-700 text-lg">
                        The Intermediate Level is for candidates with a moderate understanding of computer applications. 
                        You will be tested on tasks that require more advanced skills, including using multiple software applications,
                        organizing files, and troubleshooting basic problems.
                    </p>
                    <p class="mt-2 text-gray-700 text-lg">
                        Duration: You will have 60 seconds to answer each question. There are 10 questions in total.
                    </p>
                    <!-- <div class="mt-5">
                        <a href="./pages/intermediate_test.php"
                            class="btn">
                            Intermediate
                        </a>
                    </div> -->
                </div>

                <!-- Advanced Level Description -->
                <div class="level3 p-6 rounded-lg shadow-md hover:shadow-lg transition duration-300">
                    <h4 class="text-2xl font-bold ">Advanced Level</h4>
                    <p class="mt-2 text-gray-700 text-lg">
                        The Advanced Level is for candidates who have a strong proficiency in computer applications. 
                        The test will assess your ability to solve complex problems, use professional software tools, and perform multitasking
                        tasks that are common in office environments or more technical fields.
                    </p>
                    <p class="mt-2 text-gray-700 text-lg">
                        Duration: You will have 120 seconds to answer each question. There are 10 questions in total.
                    </p>
                    <!-- <div class="mt-4">
                        <a href="./pages/advanced_test.php"
                            class="btn">
                            Advance
                        </a>
                    </div> -->
                </div>
            </div>
            <div class="flex justify-center space-x-6 mt-6">
                <h3 class="text-lg text-gray-700 mb-4">Sign up to</h3>
                <div class=" link-full">
                    <a href="./Application_Dashboard/Auth/auth.php?display=signup">GET STARTED</a>
                </div>
            </div>

        </section>

    </div>

    <!-- Footer Section -->
    <footer class="footer text-white py-4 mt-8">
        <div class="container mx-auto text-center">
            <p>&copy; 2025 UNILORIN. All Rights Reserved.</p>
        </div>
    </footer>

</body>

</html>
