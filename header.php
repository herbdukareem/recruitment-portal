<div class="nav">
            <div class="left-nav">
                <div class="left-menu">
                    <a href="./index.php"><img src="./images/logo.png" alt="Uni Ilorin Logo" width="150px"></a>
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
                            Apply Here
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
            </div>
        </div>

        
        <script src="./function.js"></script>