<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Candidates Support</title>
  <link rel="stylesheet" href="./Candidate_support/can_sup_style.css">
  <!-- <link href="https://cdn.jsdelivr.net/npm/tailwindcss@3.3.3/dist/tailwind.min.css" rel="stylesheet"> -->
  <link rel="stylesheet"
    href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="./menu-styles/nav-footer.css">
  <link rel="stylesheet" href="./style/style.css">


</head>
<style>
  .email-container {
    background-color: transparent;
    margin: auto;
  }

  .email-input {
    border-radius: 5px;
    border: 1px solid  #00b05080;
  }
</style>

<body>
  <main class="winscroll">
  <?php include_once('header.php');?>

      <div class="right-nav" id="mo-rig">
          <div class="inline link">
              <a href="../Account/session.htm">Login</a>
          </div>
          <div class="inline theme">
              <div>
                  <div id="light-theme">
                      <svg  xmlns="http://www.w3.org/2000/svg" width="30px" height="30px" viewBox="0 0 512 512"><defs><symbol id="meteoconsClearDay0" viewBox="0 0 375 375"><circle cx="187.5" cy="187.5" r="84" fill="none" stroke="white" stroke-miterlimit="10" stroke-width="15"/><path fill="none" stroke="white" stroke-linecap="round" stroke-miterlimit="10" stroke-width="15" d="M187.5 57.2V7.5m0 360v-49.7m92.2-222.5l35-35M60.3 314.7l35.1-35.1m0-184.4l-35-35m254.5 254.5l-35.1-35.1M57.2 187.5H7.5m360 0h-49.7"><animateTransform additive="sum" attributeName="transform" dur="6s" repeatCount="indefinite" type="rotate" values="0 187.5 187.5; 45 187.5 187.5"/></path></symbol></defs><use width="375" height="375" href="#meteoconsClearDay0" transform="translate(68.5 68.5)"/></svg>
                  </div>
                  <div id="dark-theme"  style="display: none;">
                      <svg  xmlns="http://www.w3.org/2000/svg" width="30px" height="30px" viewBox="0 0 512 512"><defs><linearGradient id="meteoconsStarryNightFill0" x1="54.3" x2="187.2" y1="29" y2="259.1" gradientUnits="userSpaceOnUse"><stop offset="0" stop-color="#002914"/><stop offset=".5" stop-color="#002914"/><stop offset="1" stop-color="#003d1e"/></linearGradient><linearGradient id="meteoconsStarryNightFill1" x1="294" x2="330" y1="112.8" y2="175.2" gradientUnits="userSpaceOnUse"><stop offset="0" stop-color="white"/><stop offset=".5" stop-color="white"/><stop offset="1" stop-color="white"/></linearGradient><linearGradient id="meteoconsStarryNightFill2" x1="295.5" x2="316.5" y1="185.9" y2="222.1" href="#meteoconsStarryNightFill1"/><linearGradient id="meteoconsStarryNightFill3" x1="356.3" x2="387.7" y1="194.8" y2="249.2" href="#meteoconsStarryNightFill1"/><symbol id="meteoconsStarryNightFill4" viewBox="0 0 270 270"><path fill="url(#meteoconsStarryNightFill0)" stroke="white" stroke-linecap="round" stroke-linejoin="round" stroke-width="6" d="M252.3 168.6A133.4 133.4 0 0 1 118 36.2A130.5 130.5 0 0 1 122.5 3A133 133 0 0 0 3 134.6C3 207.7 63 267 137.2 267c62.5 0 114.8-42.2 129.8-99.2a135.6 135.6 0 0 1-14.8.8Z"><animateTransform additive="sum" attributeName="transform" dur="6s" repeatCount="indefinite" type="rotate" values="-15 135 135; 9 135 135; -15 135 135"/></path></symbol></defs><path fill="url(#meteoconsStarryNightFill1)" stroke="white" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m282.8 162.8l25-6.4a1.8 1.8 0 0 1 1.7.5l18.3 18a1.8 1.8 0 0 0 3-1.7l-6.4-25a1.8 1.8 0 0 1 .5-1.7l18-18.4a1.8 1.8 0 0 0-1.8-3l-24.9 6.5a1.8 1.8 0 0 1-1.7-.5l-18.4-18a1.8 1.8 0 0 0-3 1.7l6.5 25a1.8 1.8 0 0 1-.5 1.7l-18 18.3a1.8 1.8 0 0 0 1.7 3Z"><animateTransform additive="sum" attributeName="transform" calcMode="spline" dur="6s" keySplines=".42, 0, .58, 1; .42, 0, .58, 1" repeatCount="indefinite" type="rotate" values="-15 312 144; 15 312 144; -15 312 144"/><animate attributeName="opacity" dur="6s" values="1; .75; 1; .75; 1; .75; 1"/></path><path fill="url(#meteoconsStarryNightFill2)" stroke="white" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m285.4 193.4l12 12.3a1.2 1.2 0 0 1 .3 1.1l-4.3 16.6a1.2 1.2 0 0 0 2 1.2l12.3-12a1.2 1.2 0 0 1 1.1-.3l16.6 4.3a1.2 1.2 0 0 0 1.2-2l-12-12.3a1.2 1.2 0 0 1-.3-1.1l4.3-16.6a1.2 1.2 0 0 0-2-1.2l-12.3 12a1.2 1.2 0 0 1-1.1.3l-16.7-4.3a1.2 1.2 0 0 0-1.1 2Z"><animateTransform additive="sum" attributeName="transform" begin="-.33s" calcMode="spline" dur="6s" keySplines=".42, 0, .58, 1; .42, 0, .58, 1" repeatCount="indefinite" type="rotate" values="-15 306 204; 15 306 204; -15 306 204"/><animate attributeName="opacity" begin="-.33s" dur="6s" values="1; .75; 1; .75; 1; .75; 1"/></path><path fill="url(#meteoconsStarryNightFill3)" stroke="white" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m337.3 223.7l24.8 7a1.8 1.8 0 0 1 1.3 1.2l6.9 24.8a1.8 1.8 0 0 0 3.4 0l7-24.8a1.8 1.8 0 0 1 1.2-1.3l24.8-6.9a1.8 1.8 0 0 0 0-3.4l-24.8-7a1.8 1.8 0 0 1-1.3-1.2l-6.9-24.8a1.8 1.8 0 0 0-3.4 0l-7 24.8a1.8 1.8 0 0 1-1.2 1.3l-24.8 6.9a1.8 1.8 0 0 0 0 3.4Z"><animateTransform additive="sum" attributeName="transform" begin="-.67s" calcMode="spline" dur="6s" keySplines=".42, 0, .58, 1; .42, 0, .58, 1" repeatCount="indefinite" type="rotate" values="-15 372 222; 15 372 222; -15 372 222"/><animate attributeName="opacity" begin="-.67s" dur="6s" values="1; .75; 1; .75; 1; .75; 1"/></path><use width="270" height="270" href="#meteoconsStarryNightFill4" transform="translate(121 121)"/></svg>
                  </div>
              </div>
              
          </div>
      </div>
  </div>



    <div class="container-fluid full-page w-100 mb-1 ">
      <div class="row w-100 justify-content-center overlay">
        <h1 class="col-12 col-md-11">Candidate Support</h1>
        <div class="col-2 col-md-2 bg-yellow mt-5"></div>
      </div>
    </div>
    <div class="container mt-5">
      <div class="row text-center d-flex flex-column align-items-center">
        <h1 class="mb-3">Candidate Support</h1>
        <h5 class="w-75">We are here to help! <span class="fs-bold">Our support team is available Monday to Friday, from
            9:00 AM to 4:30 PM.</span></h5>
      </div>
    </div>


    <div class="container row  email-container ">
      <label for="emailInput" class="form-label mx-1 fs-2">Email</label>
      <div class=" col-8 col-md-8 email-input w-100 h-25 mb-2 p-3 ">
        <p>careers@nnpcgroup.com</p>
      </div>
    </div>
    <div class="container row  email-container ">
      <label for="emailInput" class="form-label mx-1 fs-2">Mobile</label>
      <div class="d-block col-8 col-md-8 email-input w-100 h-50 mb-2 p-4 ">
        <p class="fs-4 fs-bold">MTN</p>
        <div class="d-flex">
          <p><span style="color:#e4e4e7 ;">HR</span> +234 803 999 0032</p>
        </div>
        <div class="d-flex">
          <p><span style="color:#e4e4e7 ;">IT</span> +234 803 999 0033</p>
        </div>
        
      </div>
    </div>
    <div class="container row  email-container mt-4">
      <!-- <label for="emailInput" class="form-label mx-1 fs-2">Mobile</label> -->
      <div class="d-block col-8 col-md-8 email-input w-100 h-50 mb-2 p-4 ">
        <p class="fs-4 fs-bold">AIRTEL</p>
        <div class="d-flex">
          <p><span style="color:#e4e4e7 ;">HR</span> +234 0912 222 2706</p>
        </div>
        <div class="d-flex">
          <p><span style="color:#e4e4e7 ;">IT</span> +234 803 999 0033</p>
        </div>
        
      </div>
    </div>
    <div class="container row  email-container mt-4">
      <!-- <label for="emailInput" class="form-label mx-1 fs-2">Mobile</label> -->
      <div class="d-block col-8 col-md-8 email-input w-100 h-50 mb-2 p-4 ">
        <p class="fs-4 fs-bold">GLO</p>
        <div class="d-flex">
          <p><span style="color:#e4e4e7 ;">HR</span> +234 705 252 7755</p>
        </div>
        <!-- <div class="d-flex">
          <p><span style="color:#e4e4e7 ;">IT</span> +234 803 999 0033</p>
        </div> -->
        
      </div>
    </div>
    <div class="container row  email-container mt-4">
      <!-- <label for="emailInput" class="form-label mx-1 fs-2">Mobile</label> -->
      <div class="d-block col-8 col-md-8 email-input w-100 h-50 mb-2 p-4 ">
        <p class="fs-4 fs-bold">9Mobile</p>
        <div class="d-flex">
          <p><span style="color:#e4e4e7 ;">HR</span> +234 705 252 7755</p>
        </div>
        <!-- <div class="d-flex">
          <p><span style="color:#e4e4e7 ;">IT</span> +234 803 999 0033</p>
        </div> -->
        
      </div>
    </div>
    <div class="container row  email-container mt-4">
      <!-- <label for="emailInput" class="form-label mx-1 fs-2">Mobile</label> -->
      <div class="d-block col-8 col-md-8 email-input w-100 h-50 mb-2 p-4 ">
        <p class="fs-4 fs-bold">WhatsApp</p>
        <div class="d-flex">
          <p><span style="color:#e4e4e7 ;">HR</span> +234 705 252 7755</p>
        </div>
        <div class="d-flex">
          <p><span style="color:#e4e4e7 ;">IT</span> +234 803 999 0033</p>
        </div>
        
      </div>
    </div>
    <div class="container row  email-container ">
      <label for="emailInput" class="form-label mx-1 fs-2">Contact Information</label>
      <div class="d-block col-8 col-md-8 email-input w-100 h-25 mb-2 p-3 ">
        <p>Address</p>
        <p>NNPC Towers, Herbert Macaulay Way Central Business District Abuja, Federal Capital Territory (FCT), Nigeria</p>
      </div>
    </div>

    <?php include_once('footer.php');?>



  
      </main>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
  integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

</html>