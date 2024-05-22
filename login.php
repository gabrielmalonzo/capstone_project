<?php

//array for errors
$error = array();

//check if submit button is clicked
if (isset($_POST["submit"])) {
    
    //get user inputs
    $email = $_POST["email"];
    $password = $_POST["password"];

    //check if email or password is empty
    if(empty($email) || empty($password)) {
        $error[] = "Please fill up the required fields.";
    }

    //require connection
    require './includes/config.php';

    //sanitize user inputs
    $email = mysqli_real_escape_string($conn, $email);
    $password = mysqli_real_escape_string($conn, $password);

    //query for email
    $select = "SELECT * FROM users WHERE email = '$email'";
    $result = mysqli_query($conn, $select);
    $row = mysqli_fetch_assoc($result);

    //check if email exists (use generic message to avoid notifying others that the account exists)
    if(mysqli_num_rows($result) <= 0) {
        $error[] = "Email or password incorrect.";
    } else {
        
        //check if password is incorrect
        if (!password_verify($password, $row["password"])) {
            $error[] = "Email or password incorrect.";
        }
    }

    //check if there are errors
    if(empty($error)) {
        
        //start session then set session variables to use across pages
        session_start();
        $_SESSION["userId"] = $row["userId"];
            
        //check if user is admin then redirect to appropriate page
        if($row["isAdmin"] == 1){
            header("location: pending.php");
            exit();     //always use exit() after header to prevent codes below from executing (if there's more)
        }else{
            header("location: homepage.php");
            exit();
        }
    }
}
?>

<?php include './includes/header.php'; ?>

<div class="wrapper">
    <form method="post">
        <h1>Login</h1>

        <?php if(!empty($error)) { echo '<p style="text-align:center;color:orange;">' . $error[0] . '</p>'; } ?>
        
        <div class="input-box">
            <input type="text" name="email" placeholder="Email" required>
            <i class='bx bxs-user'></i>
        </div>

        <div class="input-box">
            <input type="password" name="password" placeholder="Password" required>
            <i class='bx bxs-lock-alt' ></i>
        </div>

        <div class="remember-forgot">
            <label><input type="checkbox"> Remember me</label>
            <a href="#">Forgot password</a>
        </div>   

        <button type="submit" name="submit" class="btn">Login</button>

        <div class="register-link">
            <p>Don't have an account? <a href="register.php">Register</a></p>
        </div>
    </form>
</div>

<script src="./assets/js/script.js"></script>
</body>
</html>
