<?php
    include './includes/adminHeader.php';
    include './includes/config.php';
    $userId = $_SESSION['userId'];

    //if accept button is clicked
    if(isset($_POST['accept'])) {
        $appId = $_POST['appId'];
        $update = "UPDATE applications SET `status` = 'approved' WHERE applicationId = $appId";
        mysqli_query($conn, $update);
    }

    //if reject button is clicked
    if(isset($_POST['reject'])) {
        $appId = $_POST['appId'];
        $update = "UPDATE applications SET `status` = 'rejected' WHERE applicationId = $appId";
        mysqli_query($conn, $update);
    }
?>    


<div class="PENDING_PAGE">
<?php 
    //get pending applications
    $select = "SELECT *
        FROM applications A 
        INNER JOIN users B ON B.userId = A.userId
        WHERE A.status = 'pending'";
    $result = mysqli_query($conn, $select);
    while($row = mysqli_fetch_assoc($result)) {
    ?>
    <div class="resume_sample">
        <div class="Information_top_part">
            <div class="Inoformation_part">
                <p>Name : <?php echo $row['firstName']." ".$row['middleName']." ".$row['lastName'];?></p>
                <p>Age : <?php echo $row['age'];?></p>
                <p>Birth Date : <?php echo date('M d, Y h:i a', strtotime($row['birthdate']));?></p>
                <p>Address : <?php echo $row['address'];?></p>
                <p>Contact : <?php echo $row['contact'];?></p>
                <p>Email : <?php echo $row['email'];?></p>
                <p>Work Experience : <?php echo $row['workExperience'];?></p>
                <p>
                    Desire Job :
                    <?php
                        //select jobs for this application
                        $selectedJobs = NULL;
                        $applicationId = $row['applicationId'];
                        $select2 = "SELECT * FROM appliedJobs A INNER JOIN jobs B ON B.jobId = A.jobId WHERE A.applicationId = $applicationId";
                        $result2 = mysqli_query($conn, $select2);
                        while($row2 = mysqli_fetch_assoc($result2)) {
                            $selectedJobs = $selectedJobs . ", " . $row2['jobName'];
                        }
                        echo ltrim($selectedJobs, ', ');
                    ?>
                </p>
            </div>

            <img class="applicant_image" src="./uploads/<?php echo $row['profilePicture'];?>">
        </div>

        <form method="post" class="decision">
            <input type="hidden" name="appId" value="<?php echo $applicationId;?>">
            <div class="accepted">
                <button name="accept">ACCEPT</button>
            </div>
            <div class="rejected">
                <button name="reject">REJECT</button>
            </div>
        </form> 
    </div>
    <?php
    }
?>

</div>


<script src="./assets/js/admin.js"></script>

</body>
</html>