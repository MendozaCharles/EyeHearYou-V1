<?php
session_start();

if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
    // Establish database connection
    $serverName = "CHARLES-MENDOZA\SQLEXPRESS";
    $connectionOptions = array(
        "Database" => "WEBAPP",
        "Uid" => "",
        "PWD" => ""
    );

    $conn = sqlsrv_connect($serverName, $connectionOptions);
    if($conn === false){
        die(print_r(sqlsrv_errors(), true));
    } else {
        echo "";
    }
    ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- SEO Meta Tags -->
    <meta name="description" content="Your description">
    <meta name="author" content="Your name">

    <!-- OG Meta Tags to improve the way the post looks when you share the page on Facebook, Twitter, LinkedIn -->
	<meta property="og:site_name" content="" /> <!-- website name -->
	<meta property="og:site" content="" /> <!-- website link -->
	<meta property="og:title" content=""/> <!-- title shown in the actual shared post -->
	<meta property="og:description" content="" /> <!-- description shown in the actual shared post -->
	<meta property="og:image" content="" /> <!-- image link, make sure it's jpg -->
	<meta property="og:url" content="" /> <!-- where do you want your post to link to -->
	<meta name="twitter:card" content="summary_large_image"> <!-- to have large image post format in Twitter -->

    <!-- Webpage Title -->
    <title>EyeHearYou</title>

    <!-- Styles -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;700&display=swap" rel="stylesheet">
    <link href="./css/bootstrap.min.css" rel="stylesheet">
    <link href="./css/fontawesome-all.min.css" rel="stylesheet">
    <link href="./css/aos.min.css" rel="stylesheet">
    <link href="./css/swiper.css" rel="stylesheet">
    <link href="./css/style.css" rel="stylesheet">

    <!-- Favicon -->
    <link rel="icon" href="./assets/images/favicon.png">
</head>
<body>
    
    <!-- Navigation -->
    <nav id="navbar" class="navbar navbar-expand-lg fixed-top navbar-dark" aria-label="Main navigation">
        <div class="container">

            <!-- Image Logo -->
            <!-- <a class="navbar-brand logo-image" href="index.html"><img src="images/logo.svg" alt="alternative"></a> -->

            <!-- Text Logo - Use this if you don't have a graphic logo -->
            <a class="navbar-brand logo-text" href="index.html"><img src="./assets/images/logo.png" style="width: 30px; margin-right: 20px;">EyeHearYou</a>

            <button class="navbar-toggler p-0 border-0" type="button" id="navbarSideCollapse" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="navbar-collapse offcanvas-collapse" id="navbarsExampleDefault" >
                <ul class="navbar-nav ms-auto navbar-nav-scroll">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="index.html">Log Out</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="subject.php">Register a Subject</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="subject_show.php">List of Subjects</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="user_speech.php">Start Transcription</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="user_recordings.php">View Recordings</a>
                    </li>
                </ul>
                <span class="nav-item social-icons">
                    <span class="fa-stack">
                        <a href="#your-link">
                            <i class="fas fa-circle fa-stack-2x"></i>
                            <i class="fab fa-facebook-f fa-stack-1x"></i>
                        </a>
                    </span>
                    <span class="fa-stack">
                        <a href="#your-link">
                            <i class="fas fa-circle fa-stack-2x"></i>
                            <i class="fab fa-twitter fa-stack-1x"></i>
                        </a>
                    </span>
                </span>
            </div> <!-- end of navbar-collapse -->
        </div> <!-- end of container -->
    </nav> <!-- end of navbar -->
    <!-- end of navigation -->



    <header class="ex-header">
        <div class="container">
            <div class="row">
                <div class="col-xl-10 offset-xl-1">
                <?php
    // Prepare and execute SQL query to get user firstname
$sql = "SELECT FIRSTNAME FROM REGISTER WHERE USERID = ?";
$params = array($_SESSION["userid"]);

$stmt = sqlsrv_query($conn, $sql, $params);
if($stmt === false) {
    die(print_r(sqlsrv_errors(), true));
}

// Check if any row is returned
if(sqlsrv_has_rows($stmt)) {
    // Fetch the firstname and display it in the header
    $row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);
    echo "<h1>Hello, ".$row["FIRSTNAME"]."!</h1>";
} else {
    echo "<h1>Hello, User!</h1>"; // Default header if firstname not found
}
}

?>


                </div> <!-- end of col -->
            </div> <!-- end of row -->
        </div> <!-- end of container -->
    </header>


    <!-- Basic -->
    <div class="ex-basic-1 pt-5 pb-5">
        <div class="container text-center">
            <div class="row">
                <div class="col-lg-12">
                    <img class="img-fluid mt-5 mb-3" src="assets/images/article-details-large.jpg" alt="alternative">
                </div> <!-- end of col -->
            </div> <!-- end of row -->
        </div> <!-- end of container -->
    </div> <!-- end of ex-basic-1 -->
    <!-- end of basic -->


    <!-- Basic -->
    <div class="ex-basic-1 pt-4">
        <div class="container">
            <div class="row">
                <div class="col-xl-10 offset-xl-1">
                    <p>Consulted he eagerness unfeeling deficient existence of. Calling nothing end fertile for venture way boy. Esteem spirit temper too say adieus who direct esteem. It esteems luckily mr or picture placing drawing no. Apartments frequently or motionless on reasonable projecting expression. Last sentence of words thus better.</p>
                    <p class="py-2">Ye on properly handsome returned throwing am no whatever. In without wishing he of picture no exposed talking minutes. Curiosity continual belonging offending so explained it exquisite. Do remember to followed yourself material mr recurred carriage. Way mrs end gave fat skin brown yesterday tall walk fact bed.</p>

                    <h2 class="my-3">Advantages of working with this package</h2>
                    <p class="py-2">High drew west we no or at john. About or given on witty event. Or sociable up material bachelor bringing landlord confined. Busy so many in hung easy find well up. So of exquisite my an explained remainder. Dashwood denoting securing be on perceive my laughing so. Ye on properly handsome returned throwing am no whatever.</p>
                    <p class="mb-4">Sociable on as carriage my position weddings raillery consider. Peculiar trifling absolute and wandered vicinity property yet. The and collecting motionless difficulty son. His hearing staying ten colonel met. Word drew six easy four dear cold deny. Fulfilled direction use continual set him propriety continued. Saw met applauded favourite deficient.</p>
                </div> <!-- end of col -->
            </div> <!-- end of row -->
        </div> <!-- end of container -->
    </div> <!-- end of ex-basic-1 -->
    <!-- end of basic -->


    <!-- Cards -->
    <div class="ex-cards-1 pt-3 pb-3 ">
        <div class="container">
            <div class="row col-xl-10 offset-xl-1" >
                    <!-- Card -->
                    <div class="card col-lg-4">
                        <ul class="list-unstyled">
                            <li class="d-flex">
                                <span class="fa-stack">
                                    <span class="fas fa-circle fa-stack-2x"></span>
                                    <span class="fa-stack-1x">1</span>
                                </span>
                                <div class="flex-grow-1">
                                    <h5>High Quality Service</h5>
                                    <p>Features include an eye catching morphtext in the header, details lightbox for more details information</p>
                                </div>
                            </li>
                        </ul>
                    </div> <!-- end of card -->
                    <!-- end of card -->
                    
                    <!-- Card -->
                    <div class="card col-lg-4">
                        <ul class="list-unstyled">
                            <li class="d-flex">
                                <span class="fa-stack">
                                    <span class="fas fa-circle fa-stack-2x"></span>
                                    <span class="fa-stack-1x">2</span>
                                </span>
                                <div class="flex-grow-1">
                                    <h5>Prompt Timely Delivery</h5>
                                    <p>Statistics numbers for important values, card slider for testimonials, image slider for customer logos</p>
                                </div>
                            </li>
                        </ul>
                    </div> <!-- end of card -->
                    <!-- end of card -->
                    
                    <!-- Card -->
                    <div class="card col-lg-4">
                        <ul class="list-unstyled">
                            <li class="d-flex">
                                <span class="fa-stack">
                                    <span class="fas fa-circle fa-stack-2x"></span>
                                    <span class="fa-stack-1x">2</span>
                                </span>
                                <div class="flex-grow-1">
                                    <h5>Skilled Team Involved</h5>
                                    <p>Some useful extra pages are bundled with the template lik article details, terms conditions and privacy policy</p>
                                </div>
                            </li>
                        </ul>
                    </div> <!-- end of card -->
                    <!-- end of card -->
            </div> <!-- end of row -->   
        </div> <!-- end of container -->   
    </div> <!-- end of ex-cards-1 -->
    <!-- end of cards -->



    <!-- Location -->
    <section class="location text-light py-5">
        <div class="container" data-aos="zoom-in">
            <div class="row">
                <div class="col-lg-3 d-flex align-items-center">
                    <div class="p-2"><i class="far fa-map fa-3x"></i></div>
                    <div class="ms-2">
                        <h6>ADDRESS</h6>
                        <p>De La Salle University - Dasmarinas</p>
                    </div>
                </div>
                <div class="col-lg-3 d-flex align-items-center" >
                    <div class="p-2"><i class="fas fa-mobile-alt fa-3x"></i></div>
                    <div class="ms-2">
                        <h6>CALL FOR INQURIES</h6>
                        <p>0921 827 9232</p>
                    </div>
                </div>
                <div class="col-lg-3 d-flex align-items-center" >
                    <div class="p-2"><i class="far fa-envelope fa-3x"></i></div>
                    <div class="ms-2">
                        <h6>SEND US MESSAGE</h6>
                        <p>eyehearyou@gmail.com</p>
                    </div>
                </div>
                <div class="col-lg-3 d-flex align-items-center" >
                    <div class="p-2"><i class="far fa-clock fa-3x"></i></div>
                    <div class="ms-2">
                        <h6>SERVICE HOURS</h6>
                        <p>9:00 AM - 6:00 PM</p>
                    </div>
                </div>
            </div> <!-- end of row -->
        </div> <!-- end of container -->
    </section> <!-- end of location -->


    <!-- Footer -->
    <section class="footer text-light">
        <div class="container">
            <div class="row" data-aos="fade-right">
                <div class="col-lg-3 py-4 py-md-5">
                    <div class="d-flex align-items-center">
                        <h4 class="">EyeHearYou</h4>
                    </div>
                    <p class="py-3 para-light">We hear it, you see it.</p>
                    <div class="d-flex">
                        <div class="me-3">
                            <a href="#your-link">
                                <i class="fab fa-facebook-f fa-2x py-2"></i>
                            </a>
                        </div>
                        <div class="me-3">
                            <a href="#your-link">
                                <i class="fab fa-twitter fa-2x py-2"></i>
                            </a>
                        </div>
                        <div class="me-3">
                            <a href="#your-link">
                                <i class="fab fa-instagram fa-2x py-2"></i>
                            </a>
                        </div>
                    </div>
                </div> <!-- end of col -->

                <div class="col-lg-3 py-4 py-md-5">
                    <div>
                        <h4 class="py-2">Useful Links</h4>
                        <div class="d-flex align-items-center py-2">
                            <i class="fas fa-caret-right"></i>
                            <a href="privacy.html"><p class="ms-3">About</p></a>
                            
                        </div>
                        <div class="d-flex align-items-center py-2">
                            <i class="fas fa-caret-right"></i>
                            <a href="terms.html"><p class="ms-3">Features</p></a>
                        </div>
                        <div class="d-flex align-items-center py-2">
                            <i class="fas fa-caret-right"></i>
                            <a href="#your-link"><p class="ms-3">Register</p></a>
                        </div>
                        <div class="d-flex align-items-center py-2">
                            <i class="fas fa-caret-right"></i>
                            <a href="#your-link"><p class="ms-3">Login</p></a>
                        </div>
                        <div class="d-flex align-items-center py-2">
                            <i class="fas fa-caret-right"></i>
                            <a href="#your-link"><p class="ms-3">Contacts</p></a>
                        </div>
                    </div>
                </div> <!-- end of col -->

                <div class="col-lg-3 py-4 py-md-5">
                    <div class="d-flex align-items-center">
                        <h4>Newsletter</h4>
                    </div>
                    <p class="py-3 para-light">Register your email to get news from EyeHearYou!</p>
                    <div class="d-flex align-items-center">
                        <div class="input-group mb-3">
                            <input type="text" class="form-control p-2" placeholder="Enter Email" aria-label="Recipient's email">
                            <button class="btn-secondary text-light"><i class="fas fa-envelope fa-lg"></i></button>       
                        </div>
                    </div>
                </div> <!-- end of col -->
            </div> <!-- end of row -->
        </div> <!-- end of container -->
    </section> <!-- end of footer -->


    <!-- Bottom -->
    <div class="bottom py-2 text-light" >
        <div class="container d-flex justify-content-between">
            <div>
                <p>Copyright © EyeHearYou</p><br>
            </div>
            <div>
                <i class="fab fa-cc-visa fa-lg p-1"></i>
                <i class="fab fa-cc-mastercard fa-lg p-1"></i>
                <i class="fab fa-cc-paypal fa-lg p-1"></i>
                <i class="fab fa-cc-amazon-pay fa-lg p-1"></i>
            </div>
        </div> <!-- end of container -->
    </div> <!-- end of bottom -->
 
    
    <!-- Back To Top Button -->
    <button onclick="topFunction()" id="myBtn">
        <img src="assets/images/up-arrow.png" alt="alternative">
    </button>
    <!-- end of back to top button -->

    
    <!-- Scripts -->
    <script src="./js/bootstrap.min.js"></script><!-- Bootstrap framework -->
    <script src="./js/purecounter.min.js"></script> <!-- Purecounter counter for statistics numbers -->
    <script src="./js/swiper.min.js"></script><!-- Swiper for image and text sliders -->
    <script src="./js/aos.js"></script><!-- AOS on Animation Scroll -->
    <script src="./js/script.js"></script>  <!-- Custom scripts -->
</body>
</html>