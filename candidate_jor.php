<<<<<<< HEAD
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Canditate Journey | UNILORIN</title>
    <link rel="stylesheet" href="./style/style.css">
    <link rel="stylesheet" href="./style/nav-footer.css">
    <link rel="shortcut icon" href="./images/logo-plain.jpeg.jpg" type="image/x-icon">

</head>
<body>
    <div class="winscroll">
    <?php include_once('header.php');?>


        <div class="main">
            
            <header>
                <div class="con-bg">
                    <div class="row">
                        <div class="col-md-6 mt-5 ">
                            <h1 class="text-center mt-5" style="color: var(--white);text-align:center">ONLINE APPLICATION</h1>
                        </div>
                    </div>
                </div>
            </header>

            <section>
                <div class="progress">
                    <div class="left-pro">
                        <h3 class="">Application Status</h3>
                        <div class="">Online Application on
                            <span style="color: var(--main-bg);">
                                UNILORIN Careers
                            </span>
                            Page. Candidates are advised to read the eligibilty criteria thoroughly before applying.
                        </div>
                    </div>
                    <div class="right-pro">
                        <button onclick="applicationStatusHandler()">
                            Under Review....
                        </button>
                    </div>
                </div>
            </section>
            
        </div>



        <?php include_once('footer.php');?>

    </div>

    <script>
        function applicationStatusHandler(){
            window.location.href = './Application_Dashboard/Auth/auth.php?display=login'
        }
    </script>

</body>
=======
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Canditate Journey | UNILORIN</title>
    <link rel="stylesheet" href="./style/style.css">
    <link rel="stylesheet" href="./style/nav-footer.css">
    <link rel="shortcut icon" href="./images/logo-plain.jpeg.jpg" type="image/x-icon">

</head>
<body>
    <div class="winscroll">
    <?php include_once('header.php');?>


        <div class="main">
            
            <header>
                <div class="con-bg">
                    <div class="row">
                        <div class="col-md-6 mt-5 ">
                            <h1 class="text-center mt-5" style="color: var(--white);text-align:center">ONLINE APPLICATION</h1>
                        </div>
                    </div>
                </div>
            </header>

            <section>
                <div class="progress">
                    <div class="left-pro">
                        <h3 class="">Application Status</h3>
                        <div class="">Online Application on
                            <span style="color: var(--main-bg);">
                                UNILORIN Careers
                            </span>
                            Page. Candidates are advised to read the eligibilty criteria thoroughly before applying.
                        </div>
                    </div>
                    <div class="right-pro">
                        <button onclick="applicationStatusHandler()">
                            Under Review....
                        </button>
                    </div>
                </div>
            </section>
            
        </div>



        <?php include_once('footer.php');?>

    </div>

    <script>
        function applicationStatusHandler(){
            window.location.href = './Application_Dashboard/Auth/auth.php?display=login'
        }
    </script>

</body>
>>>>>>> ca0affc (latest)
</html>