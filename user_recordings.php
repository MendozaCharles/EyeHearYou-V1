<?php
session_start();

// Check if user is logged in
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
    
    <style>
        /* Modal styles */
        .modal {
        display: none; /* Hidden by default */
        position: fixed; /* Stay in place */
        z-index: 1; /* Sit on top */
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        overflow: auto; /* Enable scroll if needed */
        background-color: rgba(0, 0, 0, 0.4); /* Black w/ opacity */
    }

    .modal-content {
        background-color: #fefefe;
        margin: 15% auto; /* 15% from the top and centered */
        padding: 20px;
        border: 1px solid #888;
        border-radius: 15px; /* Rounded corners */
        width: 80%; /* Could be more or less, depending on screen size */
        max-width: 600px; /* Set max width */
        overflow-y: auto; /* Add vertical scrollbar */
        text-align: center; /* Center align content */
        position: relative; /* Added for positioning */
    }

    .close {
        color: #aaa;
        position: absolute; /* Position within the modal */
        top: 10px; /* 10px from the top */
        right: 10px; /* 10px from the right */
        font-size: 28px;
        font-weight: bold;
    }

    .close:hover,
    .close:focus {
        color: black;
        text-decoration: none;
        cursor: pointer;
        }
    </style>
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
                <h1>Past Recordings</h1>
                </div> <!-- end of col -->
            </div> <!-- end of row -->
        </div> <!-- end of container -->
    </header>

    <!-- Past Recordings -->
    <?php
    // Check if user is logged in
    if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
        // Fetch past recordings for the current user
        $userid = $_SESSION["userid"];
        $sql = "SELECT SUBJECTADD.SUBJECT, SUBJECTADD.PROFNAME, USER_TRANSCRIPTION.CONVO_BODY 
                FROM SUBJECTADD 
                INNER JOIN USER_TRANSCRIPTION ON SUBJECTADD.SUBJECTID = USER_TRANSCRIPTION.SUBJECTID 
                WHERE SUBJECTADD.USERID = ?";
        $params = array($userid);
        $stmt = sqlsrv_query($conn, $sql, $params);
        if ($stmt === false) {
            echo "<div>Error fetching recordings.</div>";
        } else {
            // Display each recording as a box container
            echo "<div class='ex-cards-1 pt-3 pb-3'>";
            echo "<div class='container'>";
            while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
                echo "<div class='row'>";
                echo "<div class='card col-lg-10 offset-lg-1 mb-3'>";
                echo "<div class='card-body'>";
                echo "<h5 class='card-title'>" . $row['SUBJECT'] . "</h5>";
                echo "<h6 class='card-subtitle mb-2 text-muted'>" . $row['PROFNAME'] . "</h6>";
                echo "<p class='card-text'>" . substr($row['CONVO_BODY'], 0, 100) . "...</p><br>";
                echo "<button class='btn btn-primary' style='background-color: #1c262f; color: white; border-radius: 15px; border: 2px solid transparent;' 
onmouseover=\"this.style.backgroundColor='#FFFFFF'; this.style.color='#1c262f'; this.style.border='2px solid #1c262f';\" 
onmouseout=\"this.style.backgroundColor='#1c262f'; this.style.color='white'; this.style.border='2px solid transparent';\" 
onclick='openModal(\"{$row['SUBJECT']}\", \"{$row['PROFNAME']}\", \"{$row['CONVO_BODY']}\")'>Read All</button>";

                echo "</div>";
                echo "</div>";
                echo "</div>";
            }
            echo "</div>"; // end of container
            echo "</div>"; // end of ex-cards-1
        }
    }
    ?>
    <!-- end of Past Recordings -->

    <!-- Modal -->
<div id="myModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeModal()">&times;</span>
        <h4 id="modalSubject"></h2>
        <h6 id="modalProfName"></h4>
        <div id="modalContent"></div>
    </div>
</div>

    <script>
        // Function to open the modal and populate with content
        function openModal(subject, profName, content) {
            const modal = document.getElementById('myModal');
            const modalSubject = document.getElementById('modalSubject');
            const modalProfName = document.getElementById('modalProfName');
            const modalContent = document.getElementById('modalContent');

            modal.style.display = 'block';
            modalSubject.innerText = subject;
            modalProfName.innerText = profName;
            modalContent.innerText = content;
        }

        // Function to close the modal
        function closeModal() {
            const modal = document.getElementById('myModal');
            modal.style.display = 'none';
        }

        // Close the modal when clicking outside of it
        window.onclick = function(event) {
            const modal = document.getElementById('myModal');
            if (event.target === modal) {
                modal.style.display = 'none';
            }
        }
    </script>

    <!-- Scripts -->
    <script src="./js/bootstrap.min.js"></script><!-- Bootstrap framework -->
    <script src="./js/fontawesome-all.min.js"></script><!-- FontAwesome icons -->
    <script src="./js/aos.js"></script><!-- AOS on Animation Scroll -->
    <script src="./js/swiper.min.js"></script><!-- Swiper for image and text sliders -->
    <script src="./js/script.js"></script><!-- Custom scripts -->
</body>
</html>
