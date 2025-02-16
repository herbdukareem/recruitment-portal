<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Intermediate Level CBT</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .selected { background-color: #4CAF50 !important; color: white; }
    </style>
</head>
<body class="bg-gray-50">
    
    <div id="preparation" class="container mx-auto my-10 p-6 bg-white rounded-lg shadow-lg text-center">
        <img src="unilorin_logo.png" alt="UNILORIN Logo" class="mx-auto w-24 mb-4">
        <h1 class="text-3xl font-bold text-blue-700">UNILORIN Computer-Based Test (CBT)</h1>
        <p class="mt-4 text-gray-600">Welcome to the Intermediate Level CBT. This test consists of 10 questions, and you have 2 minutes to complete it.</p>
        <p class="mt-2 text-gray-600">Once you begin, the timer will start counting down. Make sure to answer as many questions as possible before time runs out!</p>
        <button onclick="startQuiz()" class="mt-6 bg-blue-700 text-white px-6 py-3 rounded-md shadow-md hover:bg-blue-800">Start Exam</button>
    </div>
    
    <div id="quiz-section" class="hidden container mx-auto my-10 p-6 bg-white rounded-lg shadow-lg">
        <div class="text-right text-red-600 font-bold text-lg" id="timer">Time: 02:00</div>
        <div id="question-container" class="mt-4"></div>
        <div class="mt-6 flex justify-between">
            <button id="prev-btn" class="bg-gray-500 text-white px-4 py-2 rounded" onclick="prevQuestion()">Previous Question</button>
            <button id="next-btn" class="bg-blue-700 text-white px-4 py-2 rounded" onclick="nextQuestion()">Next Question</button>
        </div>
        <div id="pagination" class="mt-6 flex justify-center space-x-2"></div>
        <div class="mt-6 text-center">
            <button id="submit-btn" onclick="submitQuiz()" class="bg-green-600 text-white px-6 py-3 rounded-md hover:bg-green-700" disabled>Submit Exam</button>
        </div>
    </div>
    
    <div id="result-section" class="hidden container mx-auto my-10 p-6 bg-white rounded-lg shadow-lg text-center">
        <h2 class="text-2xl font-bold text-blue-700">Exam Completed</h2>
        <p class="mt-4 text-gray-600">Total Questions Answered: <span id="answered-count"></span>/10</p>
        <button onclick="location.reload()" class="mt-6 bg-blue-700 text-white px-6 py-3 rounded-md">Go to Homepage</button>
    </div>

    <script>
        const questions = [
            { q: "What is an Operating System?", options: ["A hardware", "A software", "A storage device", "A programming language"], correct: 1 },
            { q: "Which of these is a web browser?", options: ["Google Chrome", "Microsoft Word", "Windows", "Excel"], correct: 0 },
            { q: "What is RAM used for?", options: ["Long-term storage", "Temporary storage", "Running applications", "Backing up data"], correct: 1 },
            { q: "Which of these is an output device?", options: ["Keyboard", "Mouse", "Printer", "Scanner"], correct: 2 },
            { q: "What is the function of a CPU?", options: ["Data processing", "Display graphics", "Store information", "Send emails"], correct: 0 },
            { q: "What does HTTP stand for?", options: ["HyperText Transfer Protocol", "High Tech Processing", "Hyper Transfer Program", "Hyperlink Text Protocol"], correct: 0 },
            { q: "Which key is used to refresh a web page?", options: ["F5", "Ctrl+R", "Alt+F4", "Shift+R"], correct: 0 },
            { q: "Which of these is a file format for images?", options: [".jpg", ".exe", ".mp3", ".doc"], correct: 0 },
            { q: "What does 'Ctrl + C' do?", options: ["Copy", "Paste", "Cut", "Undo"], correct: 0 },
            { q: "Which of these is an antivirus software?", options: ["Adobe Photoshop", "Microsoft Excel", "Norton", "Mozilla Firefox"], correct: 2 }
        ];
        
        let currentQuestion = 0;
        let selectedAnswers = {};
        let timer;
        let timeLeft = 120;

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
                if (timeLeft <= 0) {
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
            enableSubmitButton();
        }

        function selectAnswer(index) {
            selectedAnswers[currentQuestion] = index;
            loadQuestion();
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
            document.getElementById('answered-count').innerText = Object.keys(selectedAnswers).length;
        }

        function enableSubmitButton() {
            // Enable Submit button if at least 5 questions are answered
            const answeredQuestions = Object.keys(selectedAnswers).length;
            const submitBtn = document.getElementById('submit-btn');
            submitBtn.disabled = answeredQuestions < 5;
        }

        function submitQuiz() {
            clearInterval(timer);
            showResults();
        }
    </script>
</body>
</html>
