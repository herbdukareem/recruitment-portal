<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Advanced Level CBT</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .selected { background-color: #4CAF50 !important; color: white; }

        /* Pagination styling */
        #pagination {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 10px;
        }

        #pagination button {
            padding: 10px 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
            background-color: #f0f0f0;
            transition: background-color 0.3s, color 0.3s;
        }

        #pagination button:hover {
            background-color: #4CAF50;
            color: white;
        }

        #pagination button.bg-blue-700 {
            background-color: #4CAF50;
            color: white;
        }

        #pagination button.bg-gray-200 {
            background-color: #f0f0f0;
            color: black;
        }
        
    </style>
</head>

<body class="bg-gray-50">

    <div id="preparation" class="container mx-auto my-10 p-6 bg-white rounded-lg shadow-lg text-center">
        <img src="unilorin_logo.png" alt="UNILORIN Logo" class="mx-auto w-24 mb-4">
        <h1 class="text-3xl font-bold text-blue-700">UNILORIN Computer-Based Test (CBT) - Advanced Level</h1>
        <p class="mt-4 text-gray-600">Welcome to the Advanced Level CBT. This test consists of 50 questions, and you
            need to answer at least 10 questions within 2 minutes.</p>
        <p class="mt-2 text-gray-600">Once you begin, the timer will start counting down. You must answer as many
            questions as possible before time runs out!</p>
        <button onclick="startQuiz()"
            class="mt-6 bg-blue-700 text-white px-6 py-3 rounded-md shadow-md hover:bg-blue-800">Start Exam</button>
    </div>
    <form action="" method="post" id="saveQuiz">
        <div id="quiz-section" class="hidden container mx-auto my-10 p-6 bg-white rounded-lg shadow-lg">
            <div class="text-right text-red-600 font-bold text-lg" id="timer">Time: 02:00</div>
            <div id="question-container" class="mt-4"></div>
            <div class="mt-6 flex justify-between">
                <button id="prev-btn" class="bg-gray-500 text-white px-4 py-2 rounded" onclick="prevQuestion()">Previous
                    Question</button>
                <button id="next-btn" class="bg-blue-700 text-white px-4 py-2 rounded" onclick="nextQuestion()">Next
                    Question</button>
            </div>
            <div id="pagination" class="mt-6 flex justify-center space-x-2"></div>
            <input type="text" value="" name="score" id="score" hidden>
            <input type="text" value="" name="scorePercentage" id="scorePercentage" hidden>
            <div class="mt-6 text-center">
                <button id="submit-btn" type="submit" name="saveQuizScore" class="bg-green-600 text-white px-6 py-3 rounded-md hover:bg-green-700" disabled>Submit Test</button>
            </div>
        </div>
    </form>

    <div id="result-section" class="hidden container mx-auto my-10 p-6 bg-white rounded-lg shadow-lg text-center">
        <h2 class="text-2xl font-bold text-blue-700">Exam Completed</h2>
        <p class="mt-4 text-gray-600">Total Questions Answered: <span id="answered-count"></span>/10</p>
        <p class="mt-2 text-gray-600">Total Questions Missed: <span id="missed-count"></span>/10</p>
        <p class="mt-2 text-gray-600">Percentage: <span id="percentage"></span>%</p>
        <button onclick="location.reload()" class="mt-6 bg-blue-700 text-white px-6 py-3 rounded-md">Go to
            Homepage</button>
    </div>

    <script>
        const questions = [

            { q: "Which of the following is a type of database index?", options: ["Hash index", "B-tree index", "Bitmap index", "All of the above"], correct: 3 },
            { q: "What is the main purpose of a network protocol?", options: ["To provide security", "To define communication rules", "To encrypt data", "To control network devices"], correct: 1 },
            { q: "In object-oriented programming, what is inheritance?", options: ["A mechanism to reuse code", "A feature of arrays", "A type of method", "A function to return data"], correct: 0 },
            { q: "Which of these data structures is used in the implementation of a stack?", options: ["Linked list", "Queue", "Array", "Tree"], correct: 2 },
            { q: "What is the maximum depth of a binary tree with 10 nodes?", options: ["3", "5", "7", "9"], correct: 1 },
            { q: "Which algorithm is used to solve the shortest path problem?", options: ["QuickSort", "Dijkstra's algorithm", "MergeSort", "HeapSort"], correct: 1 },
            { q: "What is the output of the following JavaScript code: 'console.log(0.1 + 0.2 === 0.3)'?", options: ["true", "false", "undefined", "NaN"], correct: 1 },
            { q: "In SQL, which command is used to remove a table?", options: ["REMOVE", "DROP", "DELETE", "TRUNCATE"], correct: 1 },
            { q: "What is the difference between GET and POST methods in HTTP?", options: ["GET is used for data retrieval, POST is for data submission", "GET can send large data, POST can send smaller data", "GET is more secure than POST", "POST sends data as URL parameters"], correct: 0 },
            { q: "What does CSS stand for?", options: ["Cascading Style Sheets", "Creative Style Sheets", "Computer Style Sheets", "Colorful Style Sheets"], correct: 0 },
            { q: "Which of the following is the best description of polymorphism in OOP?", options: ["One class extends another", "One method behaves differently based on object type", "Multiple objects of different types", "A class has multiple constructors"], correct: 1 },
            { q: "Which of these is a NoSQL database?", options: ["MySQL", "MongoDB", "PostgreSQL", "Oracle"], correct: 1 },
            { q: "In JavaScript, what does the 'this' keyword refer to?", options: ["The global object", "The current function", "The current object", "The parent object"], correct: 2 },
            { q: "Which of the following is NOT a characteristic of a stack?", options: ["Last In, First Out", "First In, First Out", "Push operation", "Pop operation"], correct: 1 },
            { q: "What is the primary function of an operating system?", options: ["Memory management", "Data encryption", "Code compilation", "User interface design"], correct: 0 },
            { q: "Which programming language is primarily used for web front-end development?", options: ["C", "Java", "JavaScript", "Python"], correct: 2 },
            { q: "What does AJAX stand for?", options: ["Asynchronous JavaScript and XML", "Asynchronous JavaScript and JSON", "Active JavaScript and XML", "Active JSON and XML"], correct: 0 },
            { q: "What is the size of an int data type in C?", options: ["4 bytes", "8 bytes", "2 bytes", "1 byte"], correct: 0 },
            { q: "Which of these is NOT a valid HTML tag?", options: ["<form>", "<button>", "<section>", "<header>"], correct: 3 },
            { q: "Which of the following is a graph traversal algorithm?", options: ["MergeSort", "Breadth-First Search", "QuickSort", "HeapSort"], correct: 1 },
            { q: "Which of these is used to manage memory in Java?", options: ["Memory manager", "Garbage collection", "Buffer management", "Stack management"], correct: 1 },
            { q: "In CSS, what does the 'z-index' property do?", options: ["Sets the opacity of an element", "Sets the stacking order of elements", "Sets the font size of text", "Sets the background color of an element"], correct: 1 },
            { q: "What does DNS stand for?", options: ["Dynamic Network Server", "Domain Name System", "Direct Network Service", "Digital Name Server"], correct: 1 },
            { q: "Which of these is a basic principle of Agile software development?", options: ["Strict documentation", "Rigid project timelines", "Iterative development", "Large team collaborations"], correct: 2 },
            { q: "What is the output of the following Python code: 'print(type(4))'?", options: ["int", "float", "str", "bool"], correct: 0 },
            { q: "What is the largest prime number less than 100?", options: ["97", "89", "91", "93"], correct: 0 },
            { q: "Which of these is NOT an HTTP method?", options: ["GET", "POST", "FETCH", "PUT"], correct: 2 },
            { q: "What does the acronym SQL stand for?", options: ["Structured Query Language", "Simple Query Language", "Standard Query Language", "Syntactical Query Language"], correct: 0 },
            { q: "In Java, what is the default value of a boolean?", options: ["true", "false", "null", "undefined"], correct: 1 },
            { q: "Which of these is a key characteristic of a queue?", options: ["First In, First Out", "Last In, First Out", "Push operation", "Pop operation"], correct: 0 },
            { q: "Which of the following is a type of SQL join?", options: ["INNER JOIN", "OUTER JOIN", "CROSS JOIN", "All of the above"], correct: 3 },
            { q: "Which sorting algorithm has the best average time complexity?", options: ["QuickSort", "MergeSort", "BubbleSort", "InsertionSort"], correct: 1 },
            { q: "Which protocol is used to secure HTTP connections?", options: ["HTTPS", "FTP", "SMTP", "SSH"], correct: 0 },
            { q: "What does a '404 error' indicate?", options: ["Page not found", "Forbidden access", "Internal server error", "Bad gateway"], correct: 0 },
            { q: "Which of these is an example of a primary key in a database?", options: ["ID column", "Username column", "Phone number column", "Email column"], correct: 0 },
            { q: "Which programming paradigm uses classes and objects?", options: ["Functional programming", "Object-oriented programming", "Procedural programming", "Event-driven programming"], correct: 1 },
            { q: "What is the result of '5 + 2 * 3' in JavaScript?", options: ["21", "11", "16", "17"], correct: 1 },
            { q: "What is the function of a DNS server?", options: ["To translate domain names to IP addresses", "To send data over the internet", "To monitor network traffic", "To authenticate user credentials"], correct: 0 },
            { q: "Which of these is a feature of a linked list?", options: ["Dynamic size", "Random access", "Fixed size", "Fast retrieval of elements"], correct: 0 },
            { q: "In Python, what does the 'len()' function do?", options: ["Returns the length of an object", "Returns the last element of an object", "Adds two numbers", "Converts a string to a list"], correct: 0 },
            { q: "Which HTTP status code indicates a successful request?", options: ["404", "500", "200", "301"], correct: 2 },
            { q: "What is a recursive function?", options: ["A function that calls another function", "A function that calls itself", "A function that is not callable", "A function with multiple return statements"], correct: 1 },
            { q: "What is the time complexity of accessing an element in an array?", options: ["O(n)", "O(log n)", "O(1)", "O(n^2)"], correct: 2 },
            { q: "Which of these is used to define a constant value in JavaScript?", options: ["const", "var", "let", "define"], correct: 0 },
            { q: "Which sorting algorithm is most efficient in terms of worst-case time complexity?", options: ["QuickSort", "MergeSort", "HeapSort", "BubbleSort"], correct: 1 },
            { q: "What is the main function of the ARPANET?", options: ["To send emails", "To create websites", "To connect computers", "To monitor networks"], correct: 2 },
            { q: "What is the time complexity of quicksort?", options: ["O(n)", "O(n log n)", "O(n^2)", "O(log n)"], correct: 1 },
            { q: "Which of the following is NOT a relational database?", options: ["MySQL", "PostgreSQL", "MongoDB", "SQLite"], correct: 2 },
            { q: "Which HTTP method is used to retrieve data from a server?", options: ["POST", "GET", "PUT", "DELETE"], correct: 1 },
            { q: "What does CPU stand for?", options: ["Central Processing Unit", "Central Program Unit", "Central Processing Unit", "Central Power Unit"], correct: 0 },
            { q: "Which of these is a function of an operating system?", options: ["Memory management", "Compiling code", "Running machine learning models", "None of the above"], correct: 0 },
            { q: "What is the largest data type in C programming?", options: ["int", "long", "float", "double"], correct: 3 },
            { q: "Which algorithm is used for sorting?", options: ["Bubble sort", "Quicksort", "Merge sort", "All of the above"], correct: 3 },
            { q: "What is the maximum value of an 8-bit signed integer?", options: ["127", "255", "256", "-128"], correct: 0 },
            { q: "What is the default port for HTTP?", options: ["80", "443", "22", "21"], correct: 0 },
            { q: "Which of these is a type of loop?", options: ["For loop", "While loop", "Do-while loop", "All of the above"], correct: 3 },
        ];

        let currentQuestion = 0;
        let selectedAnswers = {};
        let timer;
        let timeLeft = 120;
        let answeredCount = 0;
        let missedCount = 0;

        function startQuiz() {
            document.getElementById('preparation').classList.add('hidden');
            document.getElementById('quiz-section').classList.remove('hidden');
            loadQuestion();
            startTimer();
        }

        function startTimer() {
            timer = setInterval(() => {
                timeLeft--;
                document.getElementById('timer').innerText = `Time: ${Math.floor(timeLeft / 60)}:${(timeLeft % 60).toString().padStart(2, '0')}`;
                if (timeLeft <= 0 || answeredCount === 10) {
                    clearInterval(timer);
                    showResults();
                }
            }, 1000);
        }

        function loadQuestion() {
            const container = document.getElementById('question-container');
            container.innerHTML = `<h2 class='text-xl font-bold'>${questions[currentQuestion].q}</h2>`;
            questions[currentQuestion].options.forEach((option, index) => {
                const selectedClass = selectedAnswers[currentQuestion] === index ? 'selected' : '';
                container.innerHTML += `<button class='block w-full p-3 my-2 border rounded ${selectedClass}' onclick='selectAnswer(${index})'>${option}</button>`;
            });
            loadPagination();
        }

        function selectAnswer(index) {
            // If the current question hasn't been answered before, increment answeredCount
            if (selectedAnswers[currentQuestion] === undefined) {
                answeredCount++;
            }

            // Update the selected answer
            selectedAnswers[currentQuestion] = index;

            // Re-render the question to update the selection
            loadQuestion();

            // Update the submit button status based on the number of answers selected
            updateSubmitButton();
        }

        function nextQuestion() {
            if (currentQuestion < questions.length - 1) {
                currentQuestion++;
                loadQuestion();
            }
        }

        function prevQuestion() {
            if (currentQuestion > 0) {
                currentQuestion--;
                loadQuestion();
            }
        }

        function loadPagination() {
            const pagination = document.getElementById('pagination');
            pagination.innerHTML = '';
            questions.forEach((_, index) => {
                pagination.innerHTML += `<button class='px-3 py-1 border ${index === currentQuestion ? 'bg-blue-700 text-white' : 'bg-gray-200'}' onclick='goToQuestion(${index})'>${index + 1}</button>`;
            });
        }

        function goToQuestion(index) {
            currentQuestion = index;
            loadQuestion();
        }

        function showResults() {
            document.getElementById('quiz-section').classList.add('hidden');
            document.getElementById('result-section').classList.remove('hidden');

            let correctCount = 0;
            for (let i = 0; i < questions.length; i++) {
                if (selectedAnswers[i] === questions[i].correct) {
                    correctCount++;
                } else if (selectedAnswers[i] === undefined) {
                    missedCount++;
                }
            }

            console.log(correctCount)

            document.getElementById('answered-count').innerText = correctCount;
            document.getElementById('missed-count').innerText = missedCount;
            document.getElementById('percentage').innerText = ((correctCount / questions.length) * 100).toFixed(2);
            document.getElementById('score').value = correctCount;
            document.getElementById('scorePercentage').value = ((correctCount / questions.length) * 100).toFixed(2);

        }

        function updateSubmitButton() {
            const submitButton = document.getElementById('submit-btn');
            // Enable submit button only if 10 questions have been answered
            if (answeredCount >= 10) {
                submitButton.disabled = false;
            } else {
                submitButton.disabled = true;
            }
        }

        document.getElementById('saveQuiz').addEventListener('submit', (e)=>{
            e.preventDefault();
            clearInterval(timer);
            showResults();

        })
    </script>
</body>

</html>