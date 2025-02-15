<div id="cbt-screen" >
    <div class="proficiency">
        <div class="con">
            <h3>Choose Your Level of Proficiency:</h3>
            <div class="level-card">
                <button class="level-1" id='basic-btn' onclick="openQuiz(this.id)">
                    <div class="icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="4em" height="4em" viewBox="0 0 24 24"><path fill="#e4b535" d="M1 21h20V1m-2 4.83V19H6"/></svg>
                    </div>
                    <div class="text">
                        <h3>Basic</h3>
                    </div>
                </button>
                <button class="level-1" id='inter-btn' onclick="openQuiz(this.id)">
                    <div class="icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="4em" height="4em" viewBox="0 0 24 24"><path fill="#e4b535" d="M1 21h20V1m-2 4.83V19h-6v-7.17"/></svg>
                    </div>
                    <div class="text">
                        <h3>Intermediate</h3>
                    </div>
                </button>
                <button class="level-1" id='advance-btn' onclick="openQuiz(this.id)">
                    <div class="icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="4em" height="4em" viewBox="0 0 24 24"><path fill="#e4b535" d="M1 21h20V1"/></svg>
                    </div>
                    <div class="text">
                        <h3>Advance</h3>
                    </div>
                </button>
            </div>
        </div>
    </div>
    <div class="quiz-container" id="quiz_container" style="display: none;">
        <div class="quiz-subcon">
            <button id="close_quiz" onclick="closeQuiz()" style="text-align: right;">Close</button>
            <div id="preparation" class="quiz_header">
                <h1 class="text-3xl font-bold text-blue-700">UNILORIN Computer-Based Test (CBT) - <span class="level-text"></span></h1>
                <p class="mt-4 text-gray-600">Welcome to the <span class="level-text"></span> CBT. This test consists of 50 questions, and you
                    need to answer at least 10 questions within 2 minutes.</p>
                <p class="mt-2 text-gray-600">Once you begin, the timer will start counting down. You must answer as many
                    questions as possible before time runs out!</p>
                <button onclick="startQuiz()"
                    class="mt-6 bg-blue-700 text-white px-6 py-3 rounded-md shadow-md hover:bg-blue-800">Start Test</button>
            </div>

            <form action="" method="post" enctype="multipart/form-data" id="quiz_form">
                <div id="quiz-section" class="hidden container mx-auto my-10 p-6 bg-white rounded-lg shadow-lg">
                    <div class="text-right text-red-600 font-bold text-lg" id="timer">Time: 02:00</div>
                    <div id="question-container" class="mt-4"></div>
                    <div class="quiz_nav_btn_con">
                        <button type="button" id="prev-btn" class="bg-gray-500 text-white px-4 py-2 rounded" onclick="prevQuestion()">Previous
                            Question</button>
                        <button type="button" id="next-btn" class="bg-blue-700 text-white px-4 py-2 rounded" onclick="nextQuestion()">Next
                            Question</button>
                    </div>
                    <div id="pagination" class="mt-6 flex justify-center space-x-2"></div>
                    <div class="mt-6 text-center">
                        <button id="submit-btn" type="submit" class="bg-green-600 text-white px-6 py-3 rounded-md hover:bg-green-700">Submit Test</button>
                    </div>
                </div>
            </form>
            <form action="" id="realQuizResult" method="post" style="display: none;">
                <input type="text" value="" name="score" id="score">
                <input type="text" value="" name="scorePercentage" id="scorePercentage">
                <button type="submit" name="saveQuizScore" id="saveQuizScore">save</button>
            </form>

            <div id="result-section" class="hidden container mx-auto my-10 p-6 bg-white rounded-lg shadow-lg text-center">
                <h2 class="text-2xl font-bold text-blue-700">Exam Completed</h2>
                <p class="mt-4 text-gray-600">Total Questions Answered Correctly: <span id="answered-count"></span>/10</p>
                <p class="mt-2 text-gray-600">Percentage: <span id="percentage"></span>%</p>
                <button onclick="location.reload()" class="mt-6 bg-blue-700 text-white px-6 py-3 rounded-md">Go to
                    Homepage</button>
            </div>
        </div>
    </div>
</div>
<script>
    const submitBtn = document.getElementById('quiz_form');
    let currentQuestion = 0;
    let selectedAnswers = {};
    let timer;
    let timeLeft = 120;
    let answeredCount = 0;
    let shuffledQuestions = [];
    let selectedQuestions = null;

    // Question
    let basicQuestions = [

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
    let intermediateQuestions = [
        { q: "Who is the current President of Nigeria?", options: ["Goodluck Jonathan", "Muhammadu Buhari", "Bola Ahmed Tinubu", "Yemi Osinbajo"], correct: 2 },
        { q: "What is the capital of Nigeria?", options: ["Lagos", "Abuja", "Port Harcourt", "Kano"], correct: 1 },
        { q: "Which party won the 2023 presidential election in Nigeria?", options: ["PDP", "APC", "LP", "NNPP"], correct: 1 },
        { q: "What is the name of Nigeria’s currency?", options: ["Dollar", "Naira", "Cedi", "Pound"], correct: 1 },
        { q: "Who is the current Vice President of Nigeria?", options: ["Yemi Osinbajo", "Atiku Abubakar", "Kashim Shettima", "Peter Obi"], correct: 2 },
        { q: "Which Nigerian state produces the most crude oil?", options: ["Lagos", "Rivers", "Delta", "Bayelsa"], correct: 1 },
        { q: "Who is the current Governor of the Central Bank of Nigeria (CBN)?", options: ["Godwin Emefiele", "Sanusi Lamido", "Olayemi Cardoso", "Zainab Ahmed"], correct: 2 },
        { q: "What is the largest ethnic group in Nigeria?", options: ["Hausa", "Yoruba", "Igbo", "Fulani"], correct: 0 },
        { q: "Which is the most populated city in Nigeria?", options: ["Abuja", "Lagos", "Kano", "Port Harcourt"], correct: 1 },
        { q: "Which organization is responsible for conducting elections in Nigeria?", options: ["EFCC", "NCC", "INEC", "NDLEA"], correct: 2 },
        { q: "Who is the current Senate President of Nigeria?", options: ["Bukola Saraki", "Ahmad Lawan", "Godswill Akpabio", "David Mark"], correct: 2 },
        { q: "What is the current minimum wage in Nigeria?", options: ["₦30,000", "₦50,000", "₦100,000", "₦18,000"], correct: 0 },
        { q: "Which body is responsible for fighting corruption in Nigeria?", options: ["DSS", "EFCC", "FRSC", "NPC"], correct: 1 },
        { q: "What is the name of Nigeria’s national football team?", options: ["Black Stars", "Super Eagles", "Indomitable Lions", "Bafana Bafana"], correct: 1 },
        { q: "Which is the highest court in Nigeria?", options: ["Court of Appeal", "Federal High Court", "Supreme Court", "Magistrate Court"], correct: 2 },
        { q: "Which Nigerian artist won the first Grammy award?", options: ["Davido", "Burna Boy", "Wizkid", "2Baba"], correct: 1 },
        { q: "Which year did Nigeria gain independence?", options: ["1960", "1963", "1970", "1957"], correct: 0 },
        { q: "Who is the current Inspector General of Police (IGP) in Nigeria?", options: ["Mohammed Adamu", "Usman Alkali Baba", "Kayode Egbetokun", "Solomon Arase"], correct: 2 },
        { q: "Which Nigerian state has the highest GDP?", options: ["Lagos", "Rivers", "Ogun", "FCT"], correct: 0 },
        { q: "Which Nigerian university is ranked highest in Africa?", options: ["University of Lagos", "Obafemi Awolowo University", "Covenant University", "University of Ibadan"], correct: 2 }
    ];
    let advanceQuestions = [
        { q: "Which of the following is a core subject in primary education?", options: ["Mathematics", "History", "Art", "Music"], correct: 0 },
        { q: "What is the main purpose of a curriculum?", options: ["To provide entertainment", "To outline learning objectives", "To replace teachers", "To reduce study hours"], correct: 1 },
        { q: "Which learning method focuses on hands-on experience?", options: ["Lecture-based learning", "Experiential learning", "Passive learning", "Rote memorization"], correct: 1 },
        { q: "What does STEM stand for in education?", options: ["Science, Technology, Engineering, and Mathematics", "Statistics, Teaching, English, and Music", "Social, Technical, Economic, and Management", "Sports, Theater, Ethics, and Medicine"], correct: 0 },
        { q: "Which of these is considered a higher education degree?", options: ["Diploma", "Bachelor’s degree", "Certificate", "License"], correct: 1 },
        { q: "What is the role of accreditation in education?", options: ["To provide funding", "To ensure quality and standards", "To rank schools", "To increase tuition fees"], correct: 1 },
        { q: "Which of the following is an example of an e-learning platform?", options: ["Coursera", "Wikipedia", "Google Docs", "Amazon"], correct: 0 },
        { q: "What is the term for the ability to read and write?", options: ["Numeracy", "Literacy", "Oratory", "Grammar"], correct: 1 },
        { q: "Which of these is a well-known standardized test for college admissions?", options: ["IELTS", "SAT", "GMAT", "TOEFL"], correct: 1 },
        { q: "What is the primary goal of inclusive education?", options: ["To separate students by ability", "To provide equal learning opportunities for all", "To eliminate homework", "To focus only on gifted students"], correct: 1 },
        { q: "Which teaching method encourages students to ask questions and think critically?", options: ["Lecture method", "Socratic method", "Drill and practice", "Memorization"], correct: 1 },
        { q: "What is the primary focus of vocational education?", options: ["Theoretical knowledge", "Skill-based training", "Political studies", "Historical research"], correct: 1 },
        { q: "Which of these is considered an informal form of education?", options: ["University courses", "Online certification", "Learning from parents", "High school classes"], correct: 2 },
        { q: "What does MOOC stand for?", options: ["Massive Open Online Course", "Modern Organized Online Class", "Multiple Open Online Curriculum", "Managed Online Outreach Course"], correct: 0 },
        { q: "Which of the following is a key benefit of early childhood education?", options: ["Delayed social development", "Lower cognitive abilities", "Improved school readiness", "Reduced creativity"], correct: 2 },
        { q: "Which of the following subjects is part of the humanities?", options: ["Physics", "Economics", "Philosophy", "Biology"], correct: 2 },
        { q: "What is the minimum education qualification required to become a university professor?", options: ["High school diploma", "Bachelor’s degree", "Master’s degree", "Ph.D."], correct: 3 },
        { q: "Which of these is a major challenge in education in developing countries?", options: ["Too many schools", "Lack of access to quality education", "Excessive government funding", "Too many teachers"], correct: 1 },
        { q: "Which international organization promotes education worldwide?", options: ["UNESCO", "IMF", "NATO", "WHO"], correct: 0 },
        { q: "What is the primary focus of special education?", options: ["Providing education for students with disabilities", "Teaching only advanced learners", "Eliminating tests in schools", "Reducing school hours"], correct: 0 }
    ];

    // Actions
    submitBtn.addEventListener('submit', (e)=>{
        e.preventDefault();
        showResults()
        setTimeout(()=>{
            document.getElementById('saveQuizScore').click()
        },2000)
    })

    function getRandomQuestions() {
        // Check if shuffledQuestions is an empty array
        if (!Array.isArray(shuffledQuestions) || shuffledQuestions.length === 0) {
            console.error("Error: No questions available to shuffle.");
            return []; 
        }

        // Shuffle the questions array using the Fisher-Yates shuffle algorithm
        for (let i = shuffledQuestions.length - 1; i > 0; i--) {
            const j = Math.floor(Math.random() * (i + 1));
            [shuffledQuestions[i], shuffledQuestions[j]] = [shuffledQuestions[j], shuffledQuestions[i]]; 
        }

        // Select the first 10 questions from the shuffled array (if there are enough questions)
        const numberOfQuestions = Math.min(shuffledQuestions.length, 10);
        return shuffledQuestions.slice(0, numberOfQuestions);
    }

    function openQuiz(id){
        document.getElementById('quiz_container').style.display = 'block';
        var spanText = document.querySelectorAll('.level-text')
        if(id === 'basic-btn'){
            shuffledQuestions = [...basicQuestions]
            spanText.forEach(span => span.innerText = 'Basic Level')
        } else if (id === 'inter-btn'){
            shuffledQuestions = [...intermediateQuestions]
            spanText.forEach(span => span.innerText = 'Intermediate Level')
        } else{
            shuffledQuestions = [...advanceQuestions]
            spanText.forEach(span => span.innerText = 'Advance Level')
        };
        
        selectedQuestions = getRandomQuestions();
    };

    function closeQuiz(){
        document.getElementById('quiz_container').style.display = 'none';
        clearInterval(timer);
        location.reload()
    }

    function startQuiz() {
        document.getElementById('preparation').classList.add('hidden');
        document.getElementById('quiz-section').classList.remove('hidden');
        loadQuestion();
        startTimer();
    }

    function startTimer() {
        let timerElement = document.getElementById('timer');
        
        timer = setInterval(() => {
            if (timeLeft <= 0) {
                clearInterval(timer);
                showResults(); // Calculate and display results
                setTimeout(() => {
                    document.getElementById('saveQuizScore').click(); // Trigger form submission
                }, 2000); 
            } else {
                timeLeft--;
                timerElement.textContent = `Time: ${Math.floor(timeLeft / 60)}:${(timeLeft % 60).toString().padStart(2, '0')}`;
            }
        }, 1000);
    }

    function loadQuestion() {
        const container = document.getElementById('question-container');
        container.innerHTML = `<h2 class='text-xl font-bold'>${selectedQuestions[currentQuestion].q}</h2>`;

        selectedQuestions[currentQuestion].options.forEach((option, index) => {
            const selectedClass = selectedAnswers[currentQuestion] === index ? 'selected' : '';
            container.innerHTML += `<button class='pagination-button ${selectedClass}' onclick='selectAnswer(${index})'>${option}</button>`;
        });

        loadPagination();
    }

    function selectAnswer(index) {
        if (selectedAnswers[currentQuestion] === undefined) {
            answeredCount++;
            console.log(answeredCount)
        }   
        selectedAnswers[currentQuestion] = index;
        loadQuestion();
        updateSubmitButton();
    }

    function nextQuestion() {
        if (currentQuestion < selectedQuestions.length - 1) {
            currentQuestion++;
            loadQuestion();
        }
        if (currentQuestion >= 10){
            currentQuestion = 0;
        }
    }

    function prevQuestion() {
        if (currentQuestion > 0) {
            currentQuestion--;
            loadQuestion();
        }
        if (currentQuestion <= 0) {
            currentQuestion = 10;
        }
    }

    function loadPagination() {
        const pagination = document.getElementById('pagination');
        pagination.innerHTML = ''; 

        selectedQuestions.forEach((_, index) => {
            const isSelected = index === currentQuestion;

            const buttonClass = isSelected
                ? 'pagination-button selected'  
                : 'pagination-button'; 

            pagination.innerHTML += `<button class='px-3 py-1 border ${buttonClass}' onclick='goToQuestion(${index})'>${index + 1}</button>`;
        });
    }

    function goToQuestion(index) {
        currentQuestion = index;
        loadQuestion();
        updateAnsweredCount();
    }

    function updateAnsweredCount() {
        answeredCount = Object.keys(selectedAnswers).length;
        updateSubmitButton();
    }

    function showResults() {
        let correctAnswers = 0;

        selectedQuestions.forEach((question, index) => {
            if (selectedAnswers[index] === question.correct) {
                correctAnswers++;
            }
        });

        let scorePercentage = (correctAnswers / selectedQuestions.length) * 100;

        // Store in hidden fields
        document.getElementById("score").value = correctAnswers;
        document.getElementById("scorePercentage").value = scorePercentage.toFixed(2);

        document.getElementById("answered-count").textContent = correctAnswers;
        document.getElementById("percentage").textContent = scorePercentage.toFixed(2);
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

</script>