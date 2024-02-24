<?php
session_start();

$serverName = "CHARLES-MENDOZA\SQLEXPRESS";
$connectionOptions = [
    "Database" => "WEBAPP",
    "Uid" => "",
    "PWD" => ""
];

$conn = sqlsrv_connect($serverName, $connectionOptions);
if ($conn === false) {
    die(print_r(sqlsrv_errors(), true));
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete'])) {
    if (isset($_POST['subjectid'])) {
        $subjectid = $_POST['subjectid'];

        $sqlDelete = "DELETE FROM SUBJECTADD WHERE SUBJECTID = ?";
        $paramsDelete = array($subjectid);
        $stmtDelete = sqlsrv_query($conn, $sqlDelete, $paramsDelete);

        if ($stmtDelete === false) {
            die(print_r(sqlsrv_errors(), true));
        } else {
            echo 'Data deleted successfully.';
        }
    }
}

// Retrieve USERID from session
if(isset($_SESSION["userid"])) {
    $userid = $_SESSION["userid"];

    // Query to fetch subjects related to the logged-in user
    $sql = "SELECT SUBJECTID, SUBJECT FROM SUBJECTADD WHERE USERID = ?";
    $params = array($userid);

    $stmt = sqlsrv_query($conn, $sql, $params);

    if ($stmt === false) {
        die(print_r(sqlsrv_errors(), true));
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Speech to Text Demo</title>
    <style>
        body {
            background-color: black;
            color: white;
            font-family: Arial, sans-serif;
            margin: 0;
            height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: flex-end;
            align-items: center;
        }
        .controls {
            margin-bottom: 20px;
        }
        #transcription {
            padding: 10px;
            margin-bottom: 10px;
            width: 80%;
            max-width: 1000px;
            text-align: center;
        }
        button {
            padding: 10px 20px;
            font-size: 16px;
            margin: 0 5px;
            background-color: black;
            color: gray;
            border: 2px solid gray; /* Add a white border */
            border-radius: 15px;
        }

        /* Pop-up box styles */
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

        /* Modal content */
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
        }

        /* Close button */
        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }

        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }

        /* Vertical scroll bar */
        .scrollable-content {
            max-height: 200px; /* Adjust height as needed */
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }

        .subject-button {
            margin-bottom: 10px;
        }
        #selectedSubject {
            margin-bottom: 20px;
            font-size: 1rem; /* Smaller font size */
            color: darkgray; /* Dark gray color */
            display: none;
        }

        .button-container {
            display: inline-block;
        }


    </style>
</head>
<body>

    <!-- Transcription area -->
    <div id="transcription" style="margin-bottom: 200px; font-size: 2rem; padding-left: 250px; padding-right: 250px;">Transcription will appear here...</div>

    <!-- Controls -->
    <div class="controls">
        <div class="button-container">
            <button onclick="startRecording()">Start Recording</button>
            <button onclick="stopRecording()">Stop Recording</button>
            <button onclick="openSubjectPopup()">Select Subject</button>
        </div>
        <!-- Back button -->
        <form action="user_dashboard.php" method="get" style="display: inline;">
            <button type="submit">Home</button>
        </form>
    </div>

    <!-- Subject selection pop-up box -->
    <div id="subjectPopup" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeSubjectPopup()">&times;</span>
            <div class="scrollable-content">
                <!-- Subject buttons will be added dynamically here -->
                <?php
                while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
                    echo "<button class='subject-button btn btn-primary' onclick='selectSubject({$row['SUBJECTID']}, \"{$row['SUBJECT']}\")'>{$row['SUBJECT']}</button>";
                }                
                ?>
            </div>
        </div>
    </div>

    <!-- Selected subject display -->
    <div id="selectedSubject" style="margin-bottom: 20px; font-size: 1.5rem; display: none;"></div>

    <!-- Scripts -->
    <script>
    // JavaScript code for speech recognition
    let recognition;
    let isRecording = false;
    let currentSubjectId; // Variable to store the current subject ID

    function startRecording() {
        recognition = new webkitSpeechRecognition() || new SpeechRecognition();
        recognition.continuous = true;
        recognition.interimResults = true;

        recognition.onresult = function (event) {
            let transcript = '';
            for (let i = 0; i < event.results.length; i++) {
                transcript += event.results[i][0].transcript;
            }
            document.getElementById('transcription').innerText = transcript;
        };

        recognition.onerror = function (event) {
            console.error('Speech recognition error:', event.error);
        };

        recognition.onend = function () {
            if (isRecording) {
                startRecording(); // Restart recognition if still recording
            }
        };

        recognition.start();
        isRecording = true;
        document.getElementById('transcription').innerText = 'Listening...';
    }

    function stopRecording() {
        if (recognition) {
            recognition.stop();
            isRecording = false;
            const transcription = document.getElementById('transcription').innerText;

            console.log('Transcription:', transcription);
            console.log('Selected Subject ID:', currentSubjectId); // Use currentSubjectId here

            document.getElementById('transcription').innerText = 'Recording stopped. Saving transcription...';

            // Send the transcription and selected subject ID to the server
            fetch('user_transcript.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: 'CONVO_BODY=' + encodeURIComponent(transcription) + '&SUBJECTID=' + encodeURIComponent(currentSubjectId) // Use currentSubjectId here
            })
            .then(response => response.text())
            .then(data => {
                console.log(data); // Log the response from the server
                document.getElementById('transcription').innerText = 'Transcription saved.';
            })
            .catch((error) => {
                console.error('Error:', error);
                document.getElementById('transcription').innerText = 'Failed to save transcription.';
            });
        }
    }

    // JavaScript code for subject selection pop-up box
    function openSubjectPopup() {
        const modal = document.getElementById('subjectPopup');
        modal.style.display = 'block';
    }

    function closeSubjectPopup() {
        const modal = document.getElementById('subjectPopup');
        modal.style.display = 'none';
    }

    function selectSubject(subjectId, subjectName) {
        const selectedSubject = document.getElementById('selectedSubject');
        selectedSubject.innerText = `Selected Subject: ${subjectName}`;
        selectedSubject.style.display = 'block';
        closeSubjectPopup();

        // Set the currentSubjectId variable
        currentSubjectId = subjectId;

        // Call stopRecording without passing subjectId
        stopRecording();
    }

</script>


</body>
</html>
