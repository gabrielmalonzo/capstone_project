<?php

//array for errors
$error = array();

//check if submit button is clicked
if(isset($_POST["submit"])){

    //get user inputs
    $email = $_POST["email"];
    $password = $_POST["password"];
    $confirmPassword = $_POST["confirmpassword"];
    
    //check if email or password is empty
    if(empty($email) || empty($password) || empty($confirmPassword)) {
        $error[] = "Please fill up the required fields.";
    }

    //check if password and confirmPassword DO NOT match
    if($password != $confirmPassword){
        $error[] = "Passwords did not match.";
    }

    //can add more validations here
    //*to check if email is real email
    //*to check for password requiments (length, uppercase, lowercase, numbers, symbols)

    //require connection
    require './includes/config.php';

    //sanitize user inputs
    $email = mysqli_real_escape_string($conn, $email);
    $password = mysqli_real_escape_string($conn, $password);
    $confirmPassword = mysqli_real_escape_string($conn, $confirmPassword);
    
    //query for email
    $select = "SELECT email FROM users WHERE email = '$email'";
    $result = mysqli_query($conn, $select);

    //check if email exists
    if(mysqli_num_rows($result) > 0) {
        $error[] = "Email already registered.";
    }

    //check if there are errors
    if(empty($error)) {
        //hash the password then save to database
        $password = password_hash($password, PASSWORD_DEFAULT);
        $insert = "INSERT INTO users (email, password) VALUES ('$email', '$password')";

        if(mysqli_query($conn, $insert)) {
            $error[] = "Registration successful!";
        } else {
            $error[] = "Something went wrong. Try again later.";
        }
    }
}
?>

<?php include './includes/header.php'; ?>

<link rel="stylesheet" href="./assets/css/register.css">

<div class="Container">
    <form method="post" autocomplete="off">
        <h1>REGISTER</h1>
        
        <?php if(!empty($error)) { echo '<p style="text-align:center;color:orange;">' . $error[0] . '</p>'; } ?>
        
        <div class="input-box">
            <label for="email">Email</label>
            <input type="email" name="email" id="email" placeholder="sample_juan@gmail.com" required>
            <i class='bx bxs-envelope'></i>
        </div>

        <div class="input-box">
            <label for="password">Password</label>
            <input type="password" name="password" id="password" placeholder="Password" required>
            <img src="./img/unsee.png" onclick="togglePasswordVisibility('password')" class="pass-icon" id="pass-icon-password">
        </div>

        <div class="input-box">
            <label for="confirmpassword">Confirm Password</label>
            <input type="password" name="confirmpassword" id="confirmpassword" placeholder="Confirm Password" required>
            <img src="./img/unsee.png" onclick="togglePasswordVisibility('confirmpassword')" class="pass-icon" id="pass-icon-confirmpassword">
        </div>

        <br>
        <button name="submit" type="submit" class="btn">Register</button>
    </form>
</div>

<script src="./assets/js/script.js"></script>

</body>
</html>
