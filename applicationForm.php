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
    $error = array();

    //if submit button is clicked
    if(isset($_POST["submit"])){

        //get user inputs
        $fname = $_POST["first_name"];
        $mname = $_POST["middle_name"];
        $lname = $_POST["last_name"];
        $address = $_POST["address"];
        $contact = $_POST["contact_number"];
        $age = $_POST["age"];
        $gender = $_POST["gender"];
        $birthdate = $_POST["dob"];
        $workExp = $_POST["work_experience"];
        $jobs = $_POST["desire_work"];
        
        //check for empty field
        if(empty($fname) || empty($mname) || empty($lname) || empty($address) || empty($contact) || empty($age) || empty($gender) || empty($birthdate) || empty($workExp) || empty($jobs)) {
            $error[] = "Please fill up all required fields.";
        }

        //sanitize inputs
        $fname = mysqli_real_escape_string($conn, $fname);
        $mname = mysqli_real_escape_string($conn, $mname);
        $lname = mysqli_real_escape_string($conn, $lname);
        $address = mysqli_real_escape_string($conn, $address);
        $contact = mysqli_real_escape_string($conn, $contact);
        $age = mysqli_real_escape_string($conn, $age);
        $gender = mysqli_real_escape_string($conn, $gender);
        $birthdate = mysqli_real_escape_string($conn, $birthdate);
        $workExp = mysqli_real_escape_string($conn, $workExp);

        //check for user existing application
        $select = "SELECT 1 FROM applications WHERE userId = $userId";
        $result = mysqli_query($conn, $select);
        if(mysqli_num_rows($result) > 0) {
            $error[] = "You already sent an application.";
        }

        //for image upload
        $target_dir = "./uploads/";
        $target_file = $target_dir . basename($_FILES["imageUpload"]["name"]);
        $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

        //check if uploaded file is an image
        if(getimagesize($_FILES["imageUpload"]["tmp_name"]) == false) {
            $error[] = "Uploaded file is not an image.";
        }

        //check filesize of uploaded image
        if($_FILES["imageUpload"]["size"] > 5000000) {
            $error[] = "Image must be below 5MB";
        }

        //check file extension of image
        if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
            $error[] = "Only jpg/png/jpeg and gif are allowed";
        }

        //check if there are errors
        if(empty($error)) {
            
            //upload image
            $temp = explode(".",$_FILES["imageUpload"]["name"]);
            $newfilename = round(microtime(true)) . '.' . end($temp);   //rename image
            $target_file = $target_dir . $newfilename;
            if(!move_uploaded_file($_FILES["imageUpload"]["tmp_name"], $target_file)) {
                $error[] = "Something Went Wrong Try Again Later";
            }
            
            //save application
            $insert = "INSERT INTO applications (userId, firstName, middleName, lastName, address, contact, age, gender, birthdate, profilePicture, workExperience) VALUES ('$userId', '$fname', '$mname', '$lname', '$address', '$contact', '$age', '$gender', '$birthdate', '$newfilename', '$workExp')";
            if(!mysqli_query($conn, $insert)) {
                $error[] = "Something Went Wrong Try Again Later";
            } else {

                //select the saved application
                $select = "SELECT applicationId FROM applications WHERE userId = $userId";
                $result = mysqli_query($conn, $select);
                $row = mysqli_fetch_assoc($result);
                $applicationId = $row['applicationId'];

                //save applied jobs
                foreach($jobs as $job){
                    $insert = "INSERT INTO appliedJobs (applicationId, jobId) VALUES ($applicationId, $job)";
                    if(!mysqli_query($conn, $insert)) {
                        $error[] = "Something Went Wrong Try Again Later";
                    }
                }

                $error[] = "Application sent!";
            }
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./assets/css/applicationForm.css">
    <title>Apply Page</title>
</head>
<body>
    <div class="Container">
        <form  enctype="multipart/form-data" method="post">
            <h1>APPLICATION FORM</h1>

            <?php if(!empty($error)) { echo '<p style="text-align:center;color:orange;">' . $error[0] . '</p>'; } ?>

            <div class="applicant_name">

                <div class="input-box">
                    <label class="placeholder" for="first_name">First Name</label>
                    <input  autocomplete="off" class="input" type="text" name="first_name" id="first_name" value="" required>
                </div>

                <div class="input-box">
                    <label class="placeholder" for="middle_name">Middle Name</label>
                    <input autocomplete="off" class="input" type="text" name="middle_name" id="middle_name" value="">
                </div>
                
                <div class="input-box">
                    <label class="placeholder" for="last_name">Last Name</label>
                    <input autocomplete="off" class="input" type="text" name="last_name" id="last_name" value="" required>
                </div>
                
            </div>

            <div class="email_adress_contact">
                <div class="input-box">
                    <label class="placeholder" for="address">Adress </label>
                    <input class="input" type="address" name="address" id="address" value="" required>
                </div>

                <div class="input-box">
                    <label class="placeholder" for="contact_number">Contact Number </label>
                    <input class="input" type="contact_number" name="contact_number" id="contact_number" value="" required>
                </div>
            </div>
            
            <div class="date_time">
                <div class="input-box">
                    <label class="placeholder" for="age">Age</label>
                    <input class="input" type="age" name="age" id="age" value="" required>
                </div>

                <select class="gender" name="gender" id="gender" required>
                    <option value="" disabled selected hidden>Select Gender</option>
                    <option  value="male">Male</option>
                    <option  value="female">Female</option>
                </select>
                
                <div class="Birth_date">
                    <label class="placeholder" for="dob">Select Birth Date</label>
                    <input type="date" name="dob" id="dob" required>
                </div>
            </div>

            <div class="upload-container">
                <label for="imageUpload" class="upload-label">Upload Photo</label>
                <input name="imageUpload" type="file" id="imageUpload" accept="image/*" required>
                <div class="preview-container">
                    <img id="imagePreview" class="preview-image" src="" alt="Image Preview" style="display:none;">
                </div>
            </div>

            <div class="work_experience">
                <label class="Experience" for="work_experience">Work Experience</label>
                <textarea class="work_experiences" name="work_experience" id="work_experience"></textarea>
            </div>

            <div class="work_desire">
                <label class="Work_h1">Choose your desire work (maximum of 3)</label>

                <div class="available_work">
                <?php 
                    //get all available jobs
                    $select = "SELECT * FROM jobs ORDER BY jobName ASC";
                    $result = mysqli_query($conn, $select);
                    while($row = mysqli_fetch_assoc($result)){
                    ?>

                    <div class="work_choices">
                        <input type="checkbox" name="desire_work[]" id="<?php echo $row['jobName'];?>" value="<?php echo $row['jobId'];?>" onchange="limitCheckboxes(this)">
                        <label for="<?php echo $row['jobName'];?>"><?php echo $row['jobName'];?></label>
                    </div>
                
                    <?php
                    }
                ?>
                    
                </div>
            </div>
            
        
            <button name="submit" type="submit" class="bottons">Submit</button>
        </form>
    </div>

    <script src="./assets/js/applicationForm.js"></script>
</body>
</html>