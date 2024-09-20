<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recruitment Portal | University Of Ilorin</title>
    <link rel="shortcut icon" href="../images/logo-plain.jpeg.jpg" type="image/x-icon">

    <!-- <link href="https://cdn.jsdelivr.net/npm/tailwindcss@3.3.3/dist/tailwind.min.css" rel="stylesheet"> -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="./menu-styles/nav-footer.css">
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
    h4{
        font-weight: bold;
        color: var(--main-bg)
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
            <div class="con-bg">
                <div class="row">
                    <div class="col-md-6 mt-5 ">
                        <h1 class="text-center mt-5" style="color: var(--white);">Power Your Future With </h1>
                        <h1 class="text-cr">University Of Ilorin</h1>
                        <h5 class="text-center mt-5">To be an international centre of excellence in learning, research, probity and service to humanity.
                        To provide world-class environment for learning, research and community service.</h5>
                        <div class="d-flex justify-content-center mt-5">
                            <a href="#about_us" class="btn btn-success ">About Us</a>
                        </div>
                    </div>
                    <div class="left-img col-md-6 mt-5">
                        <div class="d-flex align-items-center justify-content-center">
                            <img class="image-container rounded img-fluid"
                                src="./images/wahab.png" alt="Mr. Wahab" >
                        </div>
                    </div>
                </div>
            </div>
    
            <div class="container mt-5">
                <h2 class="text-center">Careers at University Of Ilorin</h2>
                <div class="row">
                    <div class="col-md-5 mx-4 mt-4 rounded shadow mb-4 border-color">
                        <img class="gcr mx-4 mt-4 rounded"
                            src="https://careers.nnpcgroup.com/_next/image?url=%2Fcareers%2Fgraduate-career.png&w=384&q=75"
                            alt="">
                        <div class="mx-3">
                            <h4>Academic</h4>
                            <p>Gain hands-on experience, professional development, and mentorship in a dynamic environment.
                            </p>
                        </div>
                        <a href="./Account/session.php#signup" class="btn btn-success mx-5 mb-3">Apply Now</a>
    
                    </div>
                    <div class="col-md-5 mx-4 mt-4 rounded shadow mb-4 border-color">
                        <img class="gcr mx-4 mt-4 rounded"
                            src="https://careers.nnpcgroup.com/_next/image?url=%2Fcareers%2Fexperienced-career.png&w=384&q=75"
                            alt="">
                        <div class="mx-3">
                            <h4>Non Academic</h4>
                            <p>Join our team of industry leaders and innovators, and contribute your skills to impactful
                                projects.</p>
    
    
                        </div>
                        <a href="#" class="btn btn-success mx-5 mb-3">Apply Now</a>
                    </div>
    
                </div>
            </div>
        
            <!-- Positions available -->
            <div class="container">
                <div class="row mx-4 mt-5">
                    <div class="about">
                        <h2>Positions and Career Opportunities at UNILORIN</h2>
                        <div class=" mb-3">
                            <div class="pos-p">
                                <p>The University of Ilorin offers a wide array of career opportunities, catering to both academic and non-academic roles. These positions provide individuals with the chance to contribute to the institution’s mission of academic excellence, research advancement, and community engagement. The available positions at UNILORIN include, but are not limited to:</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-12 mt-4">
                        <div class=" mt-3">
                            <div class="d-flex">
                                <div class="txt w-50 mt-3">
                                    <h3 style="color: var(--main-bg);">Academic Positions:</h3>
                                    <ul class="odd">
                                        <li>Lecturers</li>
                                        <li>Professors</li>
                                        <li>Research Fellows</li>
                                        <li>Assistant Professors</li>
                                        <li>Associate Professors</li>
                                        <li>Postdoctoral Researchers</li>
                                    </ul>
                                </div>
                                <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" fill="var(--main-color-light)"
                                    viewBox="0 0 256 256" class="shrink-0 text-dark" style="opacity: 1; will-change: auto;">
                                    <path d="M176,128a48,48,0,1,1-48-48A48,48,0,0,1,176,128Z" opacity="0.2" ></path>
                                    <path d="M140,128a12,12,0,1,1-12-12A12,12,0,0,1,140,128Z" ></path>
                                </svg>
                                <div class="img-div  w-50 h-75">
                                    <img class="img-fluid rounded " src="./images/Wahab-Egbewole.jpg" alt="">
                                </div>
                            </div>
                            
                        </div>
                       
                    </div>
                    
                    <div class="col-md-12 mt-4">
                        <div class=" mt-3">
                            <div class="d-flex">
                                <div class="img-div  w-50 h-75">
                                    <img class="img-fluid rounded " src="./images/admin-assistant-not-secretary-3.webp" alt="">
                                </div>
                                <div data-orientation="horizontal" role="none"
                                    class="shrink-0 invisible w-0.5 h-44 bg-dark/50 -my-4 "></div>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" fill="var(--main-bg-light)"
                                    viewBox="0 0 256 256" class="shrink-0 text-dark" style="opacity: 1; will-change: auto;">
                                    <path d="M176,128a48,48,0,1,1-48-48A48,48,0,0,1,176,128Z" opacity="0.2" ></path>
                                    <path d="M140,128a12,12,0,1,1-12-12A12,12,0,0,1,140,128Z" ></path>
                                </svg>
                                <div class="txt w-50 mt-3">
                                    <h3 style="color: var(--main-color-light);">Administrative Positions</h3>
                                    <ul class="even">
                                        <li>Administrative Officers</li>
                                        <li>Human Resources Managers</li>
                                        <li>Finance Officers</li>
                                        <li>Procurement Officers</li>
                                        <li>Public Relations Officers</li>
                                        <li>IT Support Staff</li>
                                    </ul>
                                </div>
                            </div>
                            
                        </div>
                       
                    </div>

                    <div class="col-md-12 mt-4">
                        <div class=" mt-3">
                            <div class="d-flex">
                                <div class="txt w-50 mt-3">
                                    <h3 style="color: var(--main-bg);">Support Services Positions:</h3>
                                    <ul class="odd">
                                        <li>Library Assistants</li>
                                        <li>Laboratory Technicians</li>
                                        <li>Maintenance Staff</li>
                                        <li>Security Personnel</li>
                                        <li>Health Services Staff</li>
                                    </ul>
                                </div>
                                <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" fill="var(--main-color-light)"
                                    viewBox="0 0 256 256" class="shrink-0 text-dark" style="opacity: 1; will-change: auto;">
                                    <path d="M176,128a48,48,0,1,1-48-48A48,48,0,0,1,176,128Z" opacity="0.2" ></path>
                                    <path d="M140,128a12,12,0,1,1-12-12A12,12,0,0,1,140,128Z" ></path>
                                </svg>
                                <div class="img-div  w-50 h-75">
                                    <img class="img-fluid rounded " src="./images/supportive.jpeg.png" alt="">
                                </div>
                            </div>
                            
                        </div>
                       
                    </div>
                    <!--  -->
                    <div class="col-md-12 mt-4">
                        <div class=" mt-3">
                            <div class="d-flex">
                                <div class="img-div  w-50 h-75">
                                    <img class="img-fluid rounded " src="./images/tehnical.jpeg.png" alt="">
                                </div>
                                <div data-orientation="horizontal" role="none"
                                    class="shrink-0 invisible w-0.5 h-44 bg-dark/50 -my-4 "></div>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" fill="var(--main-bg-light)"
                                    viewBox="0 0 256 256" class="shrink-0 text-dark" style="opacity: 1; will-change: auto;">
                                    <path d="M176,128a48,48,0,1,1-48-48A48,48,0,0,1,176,128Z" opacity="0.2" ></path>
                                    <path d="M140,128a12,12,0,1,1-12-12A12,12,0,0,1,140,128Z" ></path>
                                </svg>
                                <div class="txt w-50 mt-3">
                                    <h3 style="color: var(--main-color-light);">Teaching and Research Assistants:</h3>
                                    <ul class="even">
                                        <li>Graduate Teaching Assistants</li>
                                        <li>Graduate Research Assistants</li>
                                    </ul>
                                </div>
                            </div>
                            
                        </div>
                       
                    </div>

                    <div class="col-md-12 mt-4">
                        <div class=" mt-3">
                            <div class="d-flex">
                                <div class="txt w-50 mt-3">
                                    <h3 style="color: var(--main-bg);">Specialist Positions:</h3>
                                    <ul class="odd">
                                        <li>Academic Advisors</li>
                                        <li>Career Counselors</li>
                                        <li>Disability Support Officers</li>
                                        <li>International Student Advisors</li>
                                    </ul>
                                </div>
                                <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" fill="var(--main-color-light)"
                                    viewBox="0 0 256 256" class="shrink-0 text-dark" style="opacity: 1; will-change: auto;">
                                    <path d="M176,128a48,48,0,1,1-48-48A48,48,0,0,1,176,128Z" opacity="0.2" ></path>
                                    <path d="M140,128a12,12,0,1,1-12-12A12,12,0,0,1,140,128Z" ></path>
                                </svg>
                                <div class="img-div  w-50` h-75">
                                    <img class="img-fluid rounded " src="./images/specialist.jpg.png" alt="">
                                </div>
                            </div>
                            
                        </div>
                       
                    </div>
                    
                    <div class="col-md-12 mt-4">
                        <div class=" mt-3">
                            <div class="d-flex">
                                <div class="img-div  w-50 h-75">
                                    <img class="img-fluid rounded " src="./images/management.jpg.png" alt="">
                                </div>
                                <div data-orientation="horizontal" role="none"
                                    class="shrink-0 invisible w-0.5 h-44 bg-dark/50 -my-4 "></div>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" fill="var(--main-bg-light)"
                                    viewBox="0 0 256 256" class="shrink-0 text-dark" style="opacity: 1; will-change: auto;">
                                    <path d="M176,128a48,48,0,1,1-48-48A48,48,0,0,1,176,128Z" opacity="0.2" ></path>
                                    <path d="M140,128a12,12,0,1,1-12-12A12,12,0,0,1,140,128Z" ></path>
                                </svg>
                                <div class="txt w-50 mt-3">
                                    <h3 style="color: var(--main-color-light);">Management Positions:</h3>
                                    <ul class="even">
                                        <li>Department Heads</li>
                                        <li>Deans</li>
                                        <li>Vice Chancellors</li>
                                        <li>irectors of Centers and Institutes</li>
                                    </ul>
                                </div>
                            </div>
                            
                        </div>
                       
                    </div>

                    <div class="col-md-12 mt-4">
                        <div class=" mt-3">
                            <div class="d-flex">
                                <div class="txt w-50 mt-3">
                                    <h3 style="color: var(--main-bg);">Technical Positions:</h3>
                                    <ul class="odd">
                                        <li>Engineers (Civil, Mechanical, Electrical, etc.)</li>
                                        <li>Technicians (IT, Electronics, etc.)</li>
                                        <li>Architects</li>
                                        <li>Surveyors</li>
                                    </ul>
                                </div>
                                <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" fill="var(--main-color-light)"
                                    viewBox="0 0 256 256" class="shrink-0 text-dark" style="opacity: 1; will-change: auto;">
                                    <path d="M176,128a48,48,0,1,1-48-48A48,48,0,0,1,176,128Z" opacity="0.2" ></path>
                                    <path d="M140,128a12,12,0,1,1-12-12A12,12,0,0,1,140,128Z" ></path>
                                </svg>
                                <div class="img-div  w-50 h-75">
                                    <img class="img-fluid rounded " src="./images/tehnical.jpeg.png" alt="">
                                </div>
                            </div>
                            
                        </div>
                       
                    </div>
                    
                    <div class="col-md-12 mt-4">
                        <div class=" mt-3">
                            <div class="d-flex">
                                <div class="img-div  w-50 h-75">
                                    <img class="img-fluid rounded " src="./images/legal.jpeg.png" alt="">
                                </div>
                                <div data-orientation="horizontal" role="none"
                                    class="shrink-0 invisible w-0.5 h-44 bg-dark/50 -my-4 "></div>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" fill="var(--main-bg-light)"
                                    viewBox="0 0 256 256" class="shrink-0 text-dark" style="opacity: 1; will-change: auto;">
                                    <path d="M176,128a48,48,0,1,1-48-48A48,48,0,0,1,176,128Z" opacity="0.2" ></path>
                                    <path d="M140,128a12,12,0,1,1-12-12A12,12,0,0,1,140,128Z" ></path>
                                </svg>
                                <div class="txt w-50 mt-3">
                                    <h3 style="color: var(--main-color-light);">Legal and Compliance Positions:</h3>
                                    <ul class="even">
                                        <li>Legal Advisors</li>
                                        <li>Compliance Officers</li>
                                    </ul>
                                </div>
                            </div>
                            
                        </div>
                       
                    </div>

                    <div class="col-md-12 mt-4">
                        <div class=" mt-3">
                            <div class="d-flex">
                                <div class="txt w-50 mt-3">
                                    <h3 style="color: var(--main-bg);">Health and Counseling Services Positions:</h3>
                                    <ul class="odd">
                                        <li>Nurses</li>
                                        <li>Counselors</li>
                                        <li>Psychologists</li>
                                    </ul>
                                </div>
                                <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" fill="var(--main-color-light)"
                                    viewBox="0 0 256 256" class="shrink-0 text-dark" style="opacity: 1; will-change: auto;">
                                    <path d="M176,128a48,48,0,1,1-48-48A48,48,0,0,1,176,128Z" opacity="0.2" ></path>
                                    <path d="M140,128a12,12,0,1,1-12-12A12,12,0,0,1,140,128Z" ></path>
                                </svg>
                                <div class="img-div  w-50 h-75">
                                    <img class="img-fluid rounded " src="./images/health.jpeg.png" alt="">
                                </div>
                            </div>
                            
                        </div>
                       
                    </div>
                    
                    <div class="col-md-12 mt-4">
                        <div class=" mt-3">
                            <div class="d-flex">
                                <div class="img-div  w-50 h-75">
                                    <img class="img-fluid rounded " src="./images/health.jpeg.png" alt="">
                                </div>
                                <div data-orientation="horizontal" role="none"
                                    class="shrink-0 invisible w-0.5 h-44 bg-dark/50 -my-4 "></div>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" fill="var(--main-bg-light)"
                                    viewBox="0 0 256 256" class="shrink-0 text-dark" style="opacity: 1; will-change: auto;">
                                    <path d="M176,128a48,48,0,1,1-48-48A48,48,0,0,1,176,128Z" opacity="0.2" ></path>
                                    <path d="M140,128a12,12,0,1,1-12-12A12,12,0,0,1,140,128Z" ></path>
                                </svg>
                                <div class="txt w-50 mt-3">
                                    <h3 style="color: var(--main-color-light);">Research and Development Positions:</h3>
                                    <ul class="even">
                                        <li>Research Scientists</li>
                                        <li>Project Managers</li>
                                    </ul>
                                </div>
                            </div>
                            
                        </div>
                       
                    </div>


                    <div class="about" style="margin-top: 8px;">
                        <div class="pos-p">
                            <p>This diverse range of opportunities allows individuals with various educational backgrounds, skill sets, and career aspirations to find a role that aligns with their interests and expertise. Whether you are a seasoned academic, a driven professional, or an ambitious recent graduate, UNILORIN offers the chance to contribute to the institution’s mission and advance your career.</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="container mb-5 rounded">
                <div class="row">
                  <!-- Background image container -->
                  <div class="col-12 position-relative text-center text-white img-bg" >
                    <!-- Overlay for buttons and text -->
                    <div class="d-flex flex-column align-items-center justify-content-center h-100">
                      <!-- Text -->
                      <p class="mb-3 " style="font-size: 4rem;font-weight:bold;">
                        <span>Start</span> your career at University Of Ilorin today
                      </p>
                      <!-- Buttons -->
                      <div class="d-flex flex-column flex-md-row align-items-center">
                        <button type="button" class="btn btn-custom   mx-4">Academic Member</button>
                        <button type="button" class="btn btn-custom   mx-4">Non-Academic Member </button>
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
                        <p>The University of Ilorin, established in 1975, has firmly established itself as a premier institution of higher learning in Nigeria. With a reputation for academic rigor, cutting-edge research, and a vibrant campus community, UNILORIN has consistently ranked among the top universities in the country.</p>
                        <p>As a comprehensive university, UNILORIN offers a diverse range of undergraduate and postgraduate programs across various disciplines, including the sciences, humanities, social sciences, engineering, and more. The university’s commitment to excellence is reflected in its highly qualified faculty, state-of-the-art facilities, and a robust research ecosystem that fosters innovation and knowledge advancement.As a comprehensive university, UNILORIN offers a diverse range of undergraduate and postgraduate programs across various disciplines, including the sciences, humanities, social sciences, engineering, and more. The university’s commitment to excellence is reflected in its highly qualified faculty, state-of-the-art facilities, and a robust research ecosystem that fosters innovation and knowledge advancement.</p>
                        <p>By attracting and nurturing exceptional individuals, UNILORIN aims to maintain its position as a leading center of academic excellence, contributing significantly to the intellectual and socioeconomic development of Nigeria and the broader African continent.</p>
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