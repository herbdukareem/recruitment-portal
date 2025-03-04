<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Basic CBT Quiz</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .selected {
            background-color: #3b82f6;
            color: white;
        }

        .disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }
    </style>
</head>

<body class="bg-gray-50">
    <!-- Welcome Page -->
    <div id="preparation" class="container mx-auto my-8 p-6 bg-white rounded-lg shadow-lg text-center">
        <img src="unilorin_logo.png" alt="UNILORIN Logo" class="mx-auto w-32">
        <h1 class="text-2xl font-bold text-gray-700 mt-4">Welcome to the UNILORIN Basic Computer-Based Test (CBT)</h1>
        <p class="text-gray-600 mt-4">This test consists of 10 basic computer-related questions. You have <strong>60 seconds</strong> to answer all questions. Make sure to select your answers carefully.</p>
        <button onclick="startQuiz()" class="mt-6 bg-blue-700 text-white py-2 px-4 rounded shadow hover:bg-blue-800">Start Exam</button>
    </div>

    <!-- CBT Test -->
    <div id="quiz-container" class="hidden container mx-auto my-8 p-6 bg-white rounded-lg shadow-lg">
        <div id="timer" class="text-right font-bold text-red-600">Time Left: 60s</div>
        <h2 id="question" class="text-lg font-semibold text-gray-700"></h2>
        <div id="options" class="mt-4 space-y-2"></div>
        <div class="flex justify-between mt-6">
            <button onclick="prevQuestion()" class="bg-gray-500 text-white py-2 px-4 rounded shadow hover:bg-gray-600">Previous</button>
            <button onclick="nextQuestion()" class="bg-blue-700 text-white py-2 px-4 rounded shadow hover:bg-blue-800">Next</button>
        </div>
        <div class="flex justify-center space-x-2 mt-6" id="pagination"></div>
        <button onclick="submitQuiz()" id="submit-btn" class="mt-6 bg-green-700 text-white py-2 px-4 rounded shadow hover:bg-green-800 disabled" disabled>Submit Quiz</button>
    </div>

    <div id="result-container" class="hidden container mx-auto my-8 p-6 bg-white rounded-lg shadow-lg text-center">
        <h2 class="text-2xl font-bold text-gray-700">Your Result</h2>
        <p id="score" class="text-lg font-semibold text-gray-600"></p>
        <button onclick="location.reload()" class="mt-4 bg-blue-700 text-white py-2 px-4 rounded shadow hover:bg-blue-800">Go to Homepage</button>
    </div>

    <script>
        let questions = [
            { q: "What does CPU stand for?", options: ["Central Processing Unit", "Computer Personal Unit", "Central Personal Unit", "None"], answer: 0 },
            { q: "Which device is used to input text?", options: ["Monitor", "Keyboard", "Mouse", "Printer"], answer: 1 },
            { q: "What is the full meaning of RAM?", options: ["Random Access Memory", "Read-Only Memory", "Run Access Memory", "None"], answer: 0 },
            { q: "Which software is used for browsing the internet?", options: ["MS Word", "Google Chrome", "Excel", "PowerPoint"], answer: 1 },
            { q: "Which key is used to delete text to the left of the cursor?", options: ["Enter", "Backspace", "Shift", "Spacebar"], answer: 1 },
            { q: "Which of these is an output device?", options: ["Keyboard", "Mouse", "Monitor", "Microphone"], answer: 2 },
            { q: "What does HTML stand for?", options: ["Hyper Text Markup Language", "Hyper Transfer Markup Language", "Hyperlink and Text Markup Language", "None"], answer: 0 },
            { q: "Which file extension is used for Microsoft Word documents?", options: [".txt", ".docx", ".pdf", ".xls"], answer: 1 },
            { q: "What is used to store data permanently?", options: ["RAM", "Hard Drive", "Processor", "Cache"], answer: 1 },
            { q: "What does an operating system do?", options: ["Manages computer hardware and software", "Creates documents", "Plays music", "Prints documents"], answer: 0 }
        ];

        let currentQuestion = 0;
        let score = 0;
        let selectedAnswers = new Array(questions.length).fill(null);
        let timeLeft = 60;
        let timer;

        function startQuiz() {
            document.getElementById("preparation").classList.add("hidden");
            document.getElementById("quiz-container").classList.remove("hidden");
            loadQuestion();
            timer = setInterval(updateTimer, 1000);
        }

        function loadQuestion() {
            let question = questions[currentQuestion];
            document.getElementById("question").textContent = question.q;
            let optionsContainer = document.getElementById("options");
            optionsContainer.innerHTML = "";
            question.options.forEach((option, index) => {
                let button = document.createElement("button");
                button.textContent = option;
                button.className = `w-full py-2 px-4 border rounded-md hover:bg-gray-200 ${selectedAnswers[currentQuestion] === index ? 'selected' : ''}`;
                button.onclick = () => selectAnswer(index, button);
                optionsContainer.appendChild(button);
            });
            updatePagination();
            updateSubmitButton();
        }

        function selectAnswer(index, button) {
            selectedAnswers[currentQuestion] = index;
            document.querySelectorAll("#options button").forEach(btn => btn.classList.remove("selected"));
            button.classList.add("selected");
            updateSubmitButton();
        }

        function prevQuestion() {
            if (currentQuestion > 0) {
                currentQuestion--;
                loadQuestion();
            }
        }

        function nextQuestion() {
            if (currentQuestion < questions.length - 1) {
                currentQuestion++;
                loadQuestion();
            }
        }

        function updatePagination() {
            let paginationContainer = document.getElementById("pagination");
            paginationContainer.innerHTML = "";
            questions.forEach((_, index) => {
                let button = document.createElement("button");
                button.textContent = index + 1;
                button.className = `py-1 px-3 border rounded ${currentQuestion === index ? 'bg-blue-700 text-white' : 'bg-gray-200'}`;
                button.onclick = () => { currentQuestion = index; loadQuestion(); };
                paginationContainer.appendChild(button);
            });
        }

        function updateTimer() {
            if (timeLeft > 0) {
                timeLeft--;
                document.getElementById("timer").textContent = `Time Left: ${timeLeft}s`;
            } else {
                clearInterval(timer);
                submitQuiz();
            }
        }

        function updateSubmitButton() {
            const submitButton = document.getElementById("submit-btn");
            if (selectedAnswers.includes(null)) {
                submitButton.classList.add("disabled");
                submitButton.disabled = true;
            } else {
                submitButton.classList.remove("disabled");
                submitButton.disabled = false;
            }
        }

        function submitQuiz() {
            clearInterval(timer);
            score = selectedAnswers.filter((ans, i) => ans === questions[i].answer).length;
            let percentage = (score / questions.length) * 100;

            document.getElementById("quiz-container").classList.add("hidden");
            document.getElementById("result-container").classList.remove("hidden");
            document.getElementById("score").textContent = `You scored ${score} out of 10 (${percentage.toFixed(2)}%)`;
        }
    </script>
</body>

</html>
