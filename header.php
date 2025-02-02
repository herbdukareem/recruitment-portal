<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Header</title>
  <!-- Tailwind CSS -->
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet" />
  <!-- FontAwesome -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet" />
  <style>
    .hover-bg:hover {
      background-color: #00044B;
      color: white;
    }
  </style>
</head>
<body class="bg-gray-50">
  <!-- Main Navigation -->
  <nav class="flex items-center justify-between px-5 py-3 bg-white shadow relative">
    <!-- Left Section: Logo -->
    <div class="flex items-center space-x-4">
      <a href="index.php">
        <img src="images/logo.png" alt="Uni Ilorin Logo" class="w-36" />
      </a>
    </div>

    <!-- Center Section: Navigation Links (Desktop) -->
    <div class="hidden lg:flex items-center space-x-8">
      <a href="index.php" class="hover-bg px-3 py-2 rounded">Home</a>
      <a href="Account/session.php" class="hover-bg px-3 py-2 rounded">Apply Here</a>
      <a href="candidate_jor.php" class="hover-bg px-3 py-2 rounded">Applicant Journey</a>
      
      <!-- Help Dropdown -->
      <div class="relative group">
        <button id="help-toggler" class="flex items-center px-3 py-2 rounded hover-bg focus:outline-none">
          Help <i class="fas fa-chevron-down ml-1 text-sm"></i>
        </button>
        <!-- Dropdown Content -->
        <div id="help-menu"
             class="absolute left-0 top-full mt-2 w-80 bg-white shadow-lg rounded p-4 text-base opacity-0 invisible transition-all duration-200 z-10">
          <div class="flex">
            <!-- Left Column -->
            <div class="w-1/3">
              <img src="images/logo-plain.jpeg.jpg" alt="Help Logo" class="w-24 mb-2" />
              <p class="font-bold">Help</p>
              <p class="text-sm">Get assistance and support when you need it...</p>
            </div>
            <!-- Right Column -->
            <div class="w-2/3 pl-4 space-y-4">
              <a href="./faq.php" class="block hover-bg px-2 py-1 rounded">FAQ</a>
              <a href="./hta.php" class="block hover-bg px-2 py-1 rounded">How to apply</a>
              <a href="./can_support.php" class="block hover-bg px-2 py-1 rounded">Candidate Support</a>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Right Section: Login -->
    <div class="hidden lg:block">
      <a href="Account/session.php" class="hover-bg px-3 py-2 rounded">Login</a>
    </div>

    <!-- Mobile Menu Toggle (Right-aligned) -->
    <button id="open-menu" class="lg:hidden focus:outline-none absolute right-5">
      <i class="fas fa-bars text-2xl"></i>
    </button>

    <!-- Mobile Menu (hidden by default) -->
    <div id="mobile-menu" class="lg:hidden hidden absolute top-16 left-0 right-0 bg-white shadow p-4">
      <div class="flex flex-col space-y-4">
        <a href="index.php" class="hover-bg px-3 py-2 rounded">Home</a>
        <a href="Account/session.php" class="hover-bg px-3 py-2 rounded">Apply Here</a>
        <a href="candidate_jor.php" class="hover-bg px-3 py-2 rounded">Applicant Journey</a>
        <button id="mobile-help-toggler" class="flex items-center px-3 py-2 rounded hover-bg focus:outline-none">
          Help <i class="fas fa-chevron-down ml-1 text-sm"></i>
        </button>
        <div id="mobile-help-menu" class="hidden flex-col space-y-2 pl-4">
          <a href="#" class="block hover-bg px-3 py-1 rounded">FAQ</a>
          <a href="#" class="block hover-bg px-3 py-1 rounded">How to apply</a>
          <a href="#" class="block hover-bg px-3 py-1 rounded">Candidate Support</a>
        </div>
        <a href="Account/session.php" class="hover-bg px-3 py-2 rounded">Login</a>
      </div>
    </div>
  </nav>

  <!-- JavaScript -->
  <script>
    document.getElementById("open-menu").addEventListener("click", function () {
      document.getElementById("mobile-menu").classList.toggle("hidden");
    });

    document.getElementById("help-toggler").addEventListener("click", function () {
      const helpMenu = document.getElementById("help-menu");
      helpMenu.classList.toggle("opacity-0");
      helpMenu.classList.toggle("invisible");
    });

    document.getElementById("mobile-help-toggler").addEventListener("click", function () {
      document.getElementById("mobile-help-menu").classList.toggle("hidden");
    });
  </script>
</body>
</html>
