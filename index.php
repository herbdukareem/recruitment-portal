<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="stylesheet" href="style.css">
    <!-- <link href="https://cdn.jsdelivr.net/npm/tailwindcss@3.3.3/dist/tailwind.min.css" rel="stylesheet"> -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="./menu-styles/nav-footer.css">
</head>
<style>
    .gradient-text {
        font-size: 2.5rem;
        /* Adjust font size as needed */
        font-weight: bold;
        background: linear-gradient(to right, #B0B0B0, #FFD700);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        color: transparent;
        margin-top: 100px;
    }

    .nnpc {
        font-weight: bold;
        font-size: 2.5rem;
        align-self: center;
        /* text-align: center; */
    }

    .btn button {
        margin: auto;
    }

    .image-container {
        /* Background gradient */
        background: linear-gradient(to right, #FFDD57, #6AB04A, #A9A9A9);
        /* Yellow, Green, and Ash */
        padding: 10px;
        /* Adds some space around the image */
        border-radius: 100px;
        /* Rounds the corners */
        display: flex;
        justify-content: center;
        align-items: center;
        width: 100%;
        /* Full width of the column */
        height: 100%;
        /* Full height of the column */
    }

    .image-container img {
        max-width: 75%;
        /* Limit the width to 75% of the container */
        border-radius: 100px;
        /* Match the border radius */
        border: 1px solid #FFDD5757;
    }

    .gcr {
        background-color: #B0B0B0;

    }

    .gcr:hover {
        transform: scale(1.01);
    }

    .btn-custom {
        width: fit-content;
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

    /* Responsive Styling */
    @media (max-width: 768px) {
      .btn-custom {
        display: block;
        width: 100%;
        font-size: 1.25rem;
        padding: 1rem;
        margin-bottom: 1rem;
      }
    }


</style>

<body>
    <main class="winscroll">
        <?php include_once('header.php');?>

        <div class="main">
            <div class="container main">
                <div class="row">
                    <div class="col-md-6 mt-5 ">
                        <h1 class="gradient-text text-center mt-5">Power Your Future With </h1>
                        <h1 class="nnpc text-success text-center ">NNPC Limited</h1>
                        <h5 class="text-center mt-5">Join our dynamic team and unlock a world of opportunities where your
                            skills
                            and ambitions can
                            make a global impact.</h5>
                        <div class="d-flex justify-content-center mt-5">
                            <button class="btn btn-success ">Candidate Journey</button>
                        </div>
                    </div>
                    <div class="col-md-6 mt-5">
                        <div class="image-container h-100 w-100 d-flex align-items-center justify-content-center">
                            <img class="rounded img-fluid"
                                src="https://careers.nnpcgroup.com/_next/image?url=%2Fhero.png&w=640&q=70" alt="">
                        </div>
                    </div>
                </div>
            </div>
    
            <div class="container mt-5 main">
                <div class="row">
                    <h2 class="text-center">Careers at NNPC Limited</h2>
                    <div class="col-md-5 border border-warning mx-4 mt-4 rounded shadow mb-4">
                        <img class="gcr mx-4 mt-4 rounded"
                            src="https://careers.nnpcgroup.com/_next/image?url=%2Fcareers%2Fgraduate-career.png&w=384&q=75"
                            alt="">
                        <div class="mx-3">
                            <h4>Graduate Trainee Program</h4>
                            <p>Gain hands-on experience, professional development, and mentorship in a dynamic environment.
                            </p>
                        </div>
                        <a href="./Account/session.htm#signup" class="btn btn-success mx-5 mb-3">Apply Now</a>
    
                    </div>
                    <div class="col-md-5 border border-warning mx-4 mt-4 rounded shadow mb-4">
                        <img class="gcr mx-4 mt-4 rounded img-fluid"
                            src="https://careers.nnpcgroup.com/_next/image?url=%2Fcareers%2Fexperienced-career.png&w=384&q=75"
                            alt="">
                        <div class="mx-3">
                            <h4>Experienced Hire Program</h4>
                            <p>Join our team of industry leaders and innovators, and contribute your skills to impactful
                                projects.</p>
    
    
                        </div>
                        <div class="btn btn-success mx-5 mb-3">Apply Now</div>
                    </div>
    
                </div>
            </div>
    
    
            <div class="container">
                <div class="row mx-4 mt-5">
                    <h1 class="text-center">Why Join NNPC Limited?</h1>
                    <div class="col-md-12 mt-4">
                        <div class=" mt-3">
                            <div class="d-flex">
                                <div class="img-div  w-75 h-75">
                                    <img class="img-fluid rounded " src="https://careers.nnpcgroup.com/_next/image?url=%2Ffeature%2Fcareer-growth.jpg&w=640&q=75" alt="">
                                </div>
                                <div data-orientation="horizontal" role="none"
                                    class="shrink-0 invisible w-0.5 h-44 bg-dark/50 -my-4 "></div>
                                <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" fill="currentColor"
                                    viewBox="0 0 256 256" class="shrink-0 text-dark" style="opacity: 1; will-change: auto;">
                                    <path d="M176,128a48,48,0,1,1-48-48A48,48,0,0,1,176,128Z" opacity="0.2" ></path>
                                    <path d="M140,128a12,12,0,1,1-12-12A12,12,0,0,1,140,128Z" ></path>
                                </svg>
                                <div class="txt w-50 mt-3">
                                    <h3>Career Growth</h3>
                                    <p>We believe in nurturing talent and providing opportunities for advancement. At NNPC Limited, you'll have access to professional development programs, mentorship, and clear career progression pathways to help you achieve your full potential.</p>
                                </div>
                            </div>
                            
                        </div>
                       
                    </div>
                    <div class="col-md-12 mt-4">
                        <div class=" mt-3">
                            <div class="d-flex">
                                <div class="img-div  w-75 h-75">
                                    <img class="img-fluid rounded " src="https://careers.nnpcgroup.com/_next/image?url=%2Ffeature%2Fglobal-impact.jpg&w=640&q=75" alt="">
                                </div>
                                <div data-orientation="horizontal" role="none"
                                    class="shrink-0 invisible w-0.5 h-44 bg-dark/50 -my-4 "></div>
                                <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" fill="currentColor"
                                    viewBox="0 0 256 256" class="shrink-0 text-dark" style="opacity: 1; will-change: auto;">
                                    <path d="M176,128a48,48,0,1,1-48-48A48,48,0,0,1,176,128Z" opacity="0.2" ></path>
                                    <path d="M140,128a12,12,0,1,1-12-12A12,12,0,0,1,140,128Z" ></path>
                                </svg>
                                <div class="txt w-50 mt-3">
                                    <h3>Global Impact</h3>
                                    <p>NNPC Limited is a global leader in the energy sector. Your work here will have a far-reaching impact, contributing to critical energy infrastructure and solutions that support communities around the world.</p>
                                </div>
                            </div>
                            
                        </div>
                       
                    </div>
                    <div class="col-md-12 mt-4">
                        <div class=" mt-3">
                            <div class="d-flex">
                                <div class="img-div  w-75 h-75">
                                    <img class="img-fluid rounded " src="https://careers.nnpcgroup.com/_next/image?url=%2Ffeature%2Fsustainability.jpg&w=640&q=75" alt="">
                                </div>
                                <div data-orientation="horizontal" role="none"
                                    class="shrink-0 invisible w-0.5 h-44 bg-dark/50 -my-4 "></div>
                                <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" fill="currentColor"
                                    viewBox="0 0 256 256" class="shrink-0 text-dark" style="opacity: 1; will-change: auto;">
                                    <path d="M176,128a48,48,0,1,1-48-48A48,48,0,0,1,176,128Z" opacity="0.2" ></path>
                                    <path d="M140,128a12,12,0,1,1-12-12A12,12,0,0,1,140,128Z" ></path>
                                </svg>
                                <div class="txt w-50 mt-3">
                                    <h3>Sustainability Focus</h3>
                                    <p>Sustainability is at the core of our operations. By joining our team, you'll be part of initiatives aimed at reducing environmental impact, promoting renewable energy sources, and ensuring a sustainable future for generations to come.</p>
                                </div>
                            </div>
                            
                        </div>
                       
                    </div>
                </div>
            </div>
    
            <div class="container">
                <div class="row mt-5 mb-3 text-center">
                    <h3 class="mt-5 mb-3">By the Numbers: Why Choose NNPC Limited?</h3>
                    <h5 class=" mt-2 mb-5">Our global reach, commitment to innovation, and dedication to sustainability make us a top choice for skilled professionals seeking a rewarding career.</h5>
                    <div class="col-md-4 px-3 pt-2  mx-0.1 bg-secondary-subtle text-secondary-emphasis text-center shadow-lg p-3 mb-5 bg-body-tertiary rounded">
                        <h3 >100,000+</h3>
                        <p>Hours of training each year</p>
                    </div>
                    <div class="col-md-4 px-3 pt-2 mx-0.1 bg-secondary-subtle text-secondary-emphasis text-center shadow-lg p-3 mb-5 bg-body-tertiary rounded">
                        <h3>99 %</h3>
                        <p>Employee retention rate</p>
                    </div>
                    <div class="col-md-4 px-3 pt-2 mx-0.1 bg-secondary-subtle text-secondary-emphasis text-center shadow-lg p-3 mb-5 bg-body-tertiary rounded">
                        <h3>30 %</h3>
                        <p>Reduction in carbon emissions achieved in the last decade</p>
                    </div>
                </div>
            </div>
    
            <div class="container mb-5 rounded">
                <div class="row">
                  <!-- Background image container -->
                  <div class="col-12 position-relative text-center text-white" style="background-image: url('https://careers.nnpcgroup.com/_next/image?url=%2Froad.jpg&w=1920&q=75'); background-size: cover; background-position: center; height: 400px;">
                    <!-- Overlay for buttons and text -->
                    <div class="d-flex flex-column align-items-center justify-content-center h-100">
                      <!-- Text -->
                      <h1 class="mb-3 " style="font-size: 4rem;">
                        <span style="color: #FFD700;">Start</span> your career at NNPC Limited today
                      </h1>
                      <!-- Buttons -->
                      <div class="d-flex flex-column flex-md-row align-items-center">
                        <button type="button" class="btn btn-custom   mx-4">Graduate Trainee</button>
                        <button type="button" class="btn btn-custom   mx-4">Experience Hire </button>
                        <!-- <button type="button" class="btn btn-custom">Button 2</button> -->
                      </div>
                    </div>
                  </div>
                </div>
            </div>
        </div>
        
    <?php include_once('footer.php');?>
          

        


    </main>

</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
</html>