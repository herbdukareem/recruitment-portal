<div class="nav">
            <div class="left-nav">
                <div class="left-menu">
                    <a href="./index.html"><img src="./images/nnpc.svg" alt="NNPC Logo"></a>
                </div>
                <div class="right-menu">
                    <svg id="open" style="display: block;" xmlns="http://www.w3.org/2000/svg" width="2em" height="2em"
                        viewBox="0 0 24 24">
                        <g fill="none" stroke="" stroke-linecap="round" stroke-linejoin="round" stroke-width="2">
                            <path d="M5 5L19 19M5 19L19 5">
                                <animate fill="freeze" attributeName="d" dur="0.4s"
                                    values="M5 5L19 19M5 19L19 5;M5 5L19 5M5 19L19 19" />
                            </path>
                            <path d="M12 12H12" opacity="0">
                                <animate fill="freeze" attributeName="d" begin="0.2s" dur="0.4s"
                                    values="M12 12H12;M5 12H19" />
                                <set fill="freeze" attributeName="opacity" begin="0.2s" to="1" />
                            </path>
                        </g>
                    </svg>
                    <svg id="close" style="display: none;" xmlns="http://www.w3.org/2000/svg" width="2em" height="2em"
                        viewBox="0 0 24 24">
                        <g fill="none" stroke="" stroke-linecap="round" stroke-linejoin="round" stroke-width="2">
                            <path d="M5 12H19">
                                <animate fill="freeze" attributeName="d" dur="0.4s" values="M5 12H19;M12 12H12" />
                                <set fill="freeze" attributeName="opacity" begin="0.4s" to="0" />
                            </path>
                            <path d="M5 5L19 5M5 19L19 19" opacity="0">
                                <animate fill="freeze" attributeName="d" begin="0.2s" dur="0.4s"
                                    values="M5 5L19 5M5 19L19 19;M5 5L19 19M5 19L19 5" />
                                <set fill="freeze" attributeName="opacity" begin="0.2s" to="1" />
                            </path>
                        </g>
                    </svg>
                </div>
            </div>
            <div class="center-nav" id="mo-cen">
                <ul>
                    <li >
                        <a href="./index.php">
                            Home
                        </a>
                    </li>
                    <li>
                        <a href="./Account/session.php">
                            Apply Now
                        </a>
                    </li>
                    <li >
                        <a href="./candidate_jor.php">
                            Candidate Journey
                        </a>
                    </li>
                    <li class="relative" >
                        <a href="" id="hover-nav">
                            Help
                            <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24"><path fill="none" stroke-dasharray="12" stroke-dashoffset="12" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 16l-7 -7M12 16l7 -7"><animate fill="freeze" attributeName="stroke-dashoffset" dur="0.3s" values="12;0"/></path></svg>
                        </a>
                        
                        <div class="absolute" id="absolute" style="visibility: hidden;">
                            <div class="left-absolute" id="help-link">
                                <img src="../images/nnpc.svg" alt="" width="100px">
                                <p>
                                    <b>Help</b> <br>
                                    Get assistance and <br> support when you <br> need it...
                                </p>
                            </div>
                            <div class="right-absolute" >
                                <div class="top-right-absolute" id="faq-link">
                                    <p>
                                        <b>FAQ</b><br>
                                        Find answers to commonly <br>asked questions about...
                                    </p>
                                </div>
                                <div class="middle-right-absolute" id="hta-link">
                                    <p>
                                        <b>How to apply</b><br>
                                        Ready to take the next step <br>in your career with NNPC?...
                                    </p>
                                </div>
                                <div class="botttom-right-absolute" id="cs-link">
                                    <p>
                                        <b>Candidate Support</b><br>
                                        Reach out to our team for <br> assistance, inquiries, or...
                                    </p>
                                </div>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
            <div class="right-nav" id="mo-rig">
                <div class="inline link">
                    <a href="./Account/session.php">Login</a>
                </div>
                <div class="inline theme">
                    <div>
                        <div id="light-theme">
                            <svg xmlns="http://www.w3.org/2000/svg" width="30px" height="30px" viewBox="0 0 512 512">
                                <defs>
                                    <symbol id="meteoconsClearDay0" viewBox="0 0 375 375">
                                        <circle cx="187.5" cy="187.5" r="84" fill="none" stroke="white"
                                            stroke-miterlimit="10" stroke-width="15" />
                                        <path fill="none" stroke="white" stroke-linecap="round" stroke-miterlimit="10"
                                            stroke-width="15"
                                            d="M187.5 57.2V7.5m0 360v-49.7m92.2-222.5l35-35M60.3 314.7l35.1-35.1m0-184.4l-35-35m254.5 254.5l-35.1-35.1M57.2 187.5H7.5m360 0h-49.7">
                                            <animateTransform additive="sum" attributeName="transform" dur="6s"
                                                repeatCount="indefinite" type="rotate"
                                                values="0 187.5 187.5; 45 187.5 187.5" />
                                        </path>
                                    </symbol>
                                </defs>
                                <use width="375" height="375" href="#meteoconsClearDay0"
                                    transform="translate(68.5 68.5)" />
                            </svg>
                        </div>
                        <div id="dark-theme" style="display: none;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="30px" height="30px" viewBox="0 0 512 512">
                                <defs>
                                    <linearGradient id="meteoconsStarryNightFill0" x1="54.3" x2="187.2" y1="29"
                                        y2="259.1" gradientUnits="userSpaceOnUse">
                                        <stop offset="0" stop-color="#002914" />
                                        <stop offset=".5" stop-color="#002914" />
                                        <stop offset="1" stop-color="#003d1e" />
                                    </linearGradient>
                                    <linearGradient id="meteoconsStarryNightFill1" x1="294" x2="330" y1="112.8"
                                        y2="175.2" gradientUnits="userSpaceOnUse">
                                        <stop offset="0" stop-color="white" />
                                        <stop offset=".5" stop-color="white" />
                                        <stop offset="1" stop-color="white" />
                                    </linearGradient>
                                    <linearGradient id="meteoconsStarryNightFill2" x1="295.5" x2="316.5" y1="185.9"
                                        y2="222.1" href="#meteoconsStarryNightFill1" />
                                    <linearGradient id="meteoconsStarryNightFill3" x1="356.3" x2="387.7" y1="194.8"
                                        y2="249.2" href="#meteoconsStarryNightFill1" />
                                    <symbol id="meteoconsStarryNightFill4" viewBox="0 0 270 270">
                                        <path fill="url(#meteoconsStarryNightFill0)" stroke="white"
                                            stroke-linecap="round" stroke-linejoin="round" stroke-width="6"
                                            d="M252.3 168.6A133.4 133.4 0 0 1 118 36.2A130.5 130.5 0 0 1 122.5 3A133 133 0 0 0 3 134.6C3 207.7 63 267 137.2 267c62.5 0 114.8-42.2 129.8-99.2a135.6 135.6 0 0 1-14.8.8Z">
                                            <animateTransform additive="sum" attributeName="transform" dur="6s"
                                                repeatCount="indefinite" type="rotate"
                                                values="-15 135 135; 9 135 135; -15 135 135" />
                                        </path>
                                    </symbol>
                                </defs>
                                <path fill="url(#meteoconsStarryNightFill1)" stroke="white" stroke-linecap="round"
                                    stroke-linejoin="round" stroke-width="2"
                                    d="m282.8 162.8l25-6.4a1.8 1.8 0 0 1 1.7.5l18.3 18a1.8 1.8 0 0 0 3-1.7l-6.4-25a1.8 1.8 0 0 1 .5-1.7l18-18.4a1.8 1.8 0 0 0-1.8-3l-24.9 6.5a1.8 1.8 0 0 1-1.7-.5l-18.4-18a1.8 1.8 0 0 0-3 1.7l6.5 25a1.8 1.8 0 0 1-.5 1.7l-18 18.3a1.8 1.8 0 0 0 1.7 3Z">
                                    <animateTransform additive="sum" attributeName="transform" calcMode="spline"
                                        dur="6s" keySplines=".42, 0, .58, 1; .42, 0, .58, 1" repeatCount="indefinite"
                                        type="rotate" values="-15 312 144; 15 312 144; -15 312 144" />
                                    <animate attributeName="opacity" dur="6s" values="1; .75; 1; .75; 1; .75; 1" />
                                </path>
                                <path fill="url(#meteoconsStarryNightFill2)" stroke="white" stroke-linecap="round"
                                    stroke-linejoin="round" stroke-width="2"
                                    d="m285.4 193.4l12 12.3a1.2 1.2 0 0 1 .3 1.1l-4.3 16.6a1.2 1.2 0 0 0 2 1.2l12.3-12a1.2 1.2 0 0 1 1.1-.3l16.6 4.3a1.2 1.2 0 0 0 1.2-2l-12-12.3a1.2 1.2 0 0 1-.3-1.1l4.3-16.6a1.2 1.2 0 0 0-2-1.2l-12.3 12a1.2 1.2 0 0 1-1.1.3l-16.7-4.3a1.2 1.2 0 0 0-1.1 2Z">
                                    <animateTransform additive="sum" attributeName="transform" begin="-.33s"
                                        calcMode="spline" dur="6s" keySplines=".42, 0, .58, 1; .42, 0, .58, 1"
                                        repeatCount="indefinite" type="rotate"
                                        values="-15 306 204; 15 306 204; -15 306 204" />
                                    <animate attributeName="opacity" begin="-.33s" dur="6s"
                                        values="1; .75; 1; .75; 1; .75; 1" />
                                </path>
                                <path fill="url(#meteoconsStarryNightFill3)" stroke="white" stroke-linecap="round"
                                    stroke-linejoin="round" stroke-width="2"
                                    d="m337.3 223.7l24.8 7a1.8 1.8 0 0 1 1.3 1.2l6.9 24.8a1.8 1.8 0 0 0 3.4 0l7-24.8a1.8 1.8 0 0 1 1.2-1.3l24.8-6.9a1.8 1.8 0 0 0 0-3.4l-24.8-7a1.8 1.8 0 0 1-1.3-1.2l-6.9-24.8a1.8 1.8 0 0 0-3.4 0l-7 24.8a1.8 1.8 0 0 1-1.2 1.3l-24.8 6.9a1.8 1.8 0 0 0 0 3.4Z">
                                    <animateTransform additive="sum" attributeName="transform" begin="-.67s"
                                        calcMode="spline" dur="6s" keySplines=".42, 0, .58, 1; .42, 0, .58, 1"
                                        repeatCount="indefinite" type="rotate"
                                        values="-15 372 222; 15 372 222; -15 372 222" />
                                    <animate attributeName="opacity" begin="-.67s" dur="6s"
                                        values="1; .75; 1; .75; 1; .75; 1" />
                                </path>
                                <use width="270" height="270" href="#meteoconsStarryNightFill4"
                                    transform="translate(121 121)" />
                            </svg>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        
        <script src="./function.js"></script>