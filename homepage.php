<?php
    session_start();

    //check if session variable is set; if not, do not allow access to this page because user is not logged in
    if(!isset($_SESSION['userId'])) {
        header("location: ./index.php");
        exit();
    }

    //require connection
    require './includes/config.php';
    $userId = $_SESSION["userId"];

    //check if user has active application
    $select = "SELECT applicationId FROM applications WHERE userId = $userId AND (status = 'pending' OR status = 'active')";
    $result = mysqli_query($conn, $select);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="Icon" href="./img/PESO_LOGO.png">
    <link rel="stylesheet" href="./assets/css/style.css">
    <link rel='stylesheet' href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css'>
    <title>PESO Caloocan</title>
</head>
<body> 

    <?php include './includes/header.php'; ?>

    <div class="content">
        <h1>WELCOME TO PESO CALOOCAN</h1>
        <div class="paragraph">
            <span style="color: red; font-weight: 600;">Public Employment Service Office</span><br>
            <div class="important_p"> 
            •Caloocan is here to help you find a job.<br>
            •Our team is dedicated to connecting job seekers with employment opportunities.<br>
            •Whether you're looking for full-time, part-time, or temporary work, we're here to support you.
            </div>
        </div>
        <?php
            if(mysqli_num_rows($result) > 0) {
                echo '<p style="text-align:center;color:orange;">You already sent an application.</p>';
            } else {
                echo '<a class="button" href="applicationForm.php" target="_blank">APPLY NOW!</a>';
            }
        ?>
    </div>

    <script src="./assets/js/script.js"></script>
</body>
</html>