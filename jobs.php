<?php
    include './includes/adminHeader.php';
?>  

<!-- add jobs -->
<link rel="stylesheet" href="./assets/css/jobs.css">

<div class="jobs">

    <div class="addjobcontainer">
        <h1>Create Jobs</h1>

        <div class="jobname">
            <label>Job Name</label>
            <input class="input-container" type="text" name="jobname" placeholder="Enter Name of Job">
        </div>

        <div class="jobdescription">
            <label>Job Description</label>
            <textarea placeholder="Enter Job Description here..."></textarea>
        </div>

        <button class="btn">Add Job</button>
    </div>

    <div class="availablejobs">
        <h1>Available Jobs</h1>

        <div class="availablejobcontainer">

            <div class="availablejobsname">
                <label>Job Name :</label>
                <p> Sales Agent</p>

                <div class="indicator">
                
                </div>
            </div>

            <div class="availablejobdescription">
                <label>Job Description :</label>
                <label for="">As a Sales Agent at SM Caloocan, your primary responsibility will be to drive sales and provide outstanding customer service. You will be the face of our store, engaging with customers to ensure they have a positive shopping experience.</label>
            </div>

            <div class="display">
                <div class="leftdisplay">
                    <button id="toggleButton">Turn On</button>
                </div>
                <div class="rightdisplay">
                    <button>Delete</button>
                </div>
            </div>
        </div>

    </div>
</div>
    <script src="./assets/js/admin.js"></script>
</body>
</html>