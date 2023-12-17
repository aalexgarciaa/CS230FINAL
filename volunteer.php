<!-- PHP AND SQL  -->
<?php
    // Variables
        // Confirmation Message
        $mssg= "";

        // Disable boolean . If slots are taken, boolean is "disable"
        $disable1 = ""; // Shift 1
        $disable2 = ""; // Shift 2
        $disable3 = ""; // Shift 3
        $disable4 = ""; // Shift 4
        $disable5 = ""; // Shift 5

        // Variables for Validation
        $err = ""; 
        $err1 = ""; 
        $fname = "";
        $lname = "";
        $email = "";
        //boolean for validation. If all information has been validated, $clear = 1.
        $clear1 = 1;
        $clear2 = 1;    

    // Connecting to SQL and using their database
        // creating variables
        $hn = "localhost";
        $un = "mcuser";
        $pw = "Pa55word";
        // general connection
        $conn = new mysqli($hn, $un,$pw);
        if($conn->connect_error) dies ("Fatal Error 1");
    
    // Creating a database if it already doesnt exists
        $query = "CREATE DATABASE IF NOT EXISTS eventdata";
        $result = $conn->query($query);
        if(!$result) die("Fatal Error 2");

    // Use the database
        $query = "USE eventdata";
        $result = $conn->query($query);
        if(!$result) die("Fatal Error 3");

    // Creating the shift table
        $query = "CREATE TABLE IF NOT EXISTS shifts(
            shiftid INT NOT NULL AUTO_INCREMENT,
            shiftTime VARCHAR(75),
            slotsOpen INT,
            PRIMARY KEY (shiftid)
            )";
        $result = $conn->query($query);
        if(!$result) die("Fatal Error 4");
            // Filling shift table      ( Using where not exists, to ensure that it is not readded each time form is uploaded.)
            $query = "INSERT INTO shifts(shiftTime,slotsOpen) SELECT '5:00pm - 6:00pm', 5 WHERE NOT EXISTS (SELECT shiftTime FROM shifts WHERE shiftTime = '5:00pm - 6:00pm' )";
            $result = $conn->query($query);
            if(!$result) die("Fatal Error 5.1");
            $query = "INSERT INTO shifts(shiftTime,slotsOpen) SELECT '6:00pm - 7:00pm',5 WHERE NOT EXISTS (SELECT shiftTime FROM shifts WHERE shiftTime = '6:00pm - 7:00pm' )";
            $result = $conn->query($query);
            if(!$result) die("Fatal Error 5.2");
            $query = "INSERT INTO shifts(shiftTime,slotsOpen) SELECT '7:00pm - 8:00pm',5 WHERE NOT EXISTS (SELECT shiftTime FROM shifts WHERE shiftTime = '7:00pm - 8:00pm' )";
            $result = $conn->query($query);
            if(!$result) die("Fatal Error 5.3");
            $query = "INSERT INTO shifts(shiftTime,slotsOpen) SELECT '8:00pm - 9:00pm',5 WHERE NOT EXISTS (SELECT shiftTime FROM shifts WHERE shiftTime = '8:00pm - 9:00pm' )";
            $result = $conn->query($query);
            if(!$result) die("Fatal Error 5.4");
            $query = "INSERT INTO shifts(shiftTime,slotsOpen) SELECT '9:00pm - 10:00pm',5 WHERE NOT EXISTS (SELECT shiftTime FROM shifts WHERE shiftTime = '9:00pm - 10:00pm' )";
            $result = $conn->query($query);
            if(!$result) die("Fatal Error 5.5");
    
    // Creating the volunteer table
        $query = "CREATE TABLE IF NOT EXISTS volunteer(
            volunteerID INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
            firstname VARCHAR(75),
            lastname VARCHAR(75),
            email VARCHAR(75)
            )";
        $result = $conn->query($query);
        if(!$result) die("Fatal Error 6");
    
    // Creating the volunteer shift table
        $query = "CREATE TABLE IF NOT EXISTS volunteerShift(
            shiftid INT NOT NULL,
            volunteerID INT NOT NULL,
            FOREIGN KEY (shiftid) REFERENCES shifts(shiftid),
            FOREIGN KEY (volunteerID) REFERENCES volunteer(volunteerID),
            UNIQUE (shiftid,volunteerID)
            )";
        $result = $conn->query($query);
        if(!$result) die("Fatal Error 7");


    // Getting shift openings and storing it into variable
        // Shift 1
        $query = "SELECT slotsOpen FROM  shifts WHERE shiftid = 1";
        $result = $conn->query($query);
        if(!$result) die("Fatal Error 7.1");
        while($row = $result->fetch_assoc()){
            $slotsAvailable1 = htmlspecialchars($row['slotsOpen']);
        }
        // Shift 2
        $query = "SELECT slotsOpen FROM  shifts WHERE shiftid = 2";
        $result = $conn->query($query);
        if(!$result) die("Fatal Error 7.2");
        while($row = $result->fetch_assoc()){
            $slotsAvailable2 = htmlspecialchars($row['slotsOpen']);
        }
        // Shift 3
        $query = "SELECT slotsOpen FROM  shifts WHERE shiftid = 3";
        $result = $conn->query($query);
        if(!$result) die("Fatal Error 7.3");
        while($row = $result->fetch_assoc()){
            $slotsAvailable3 = htmlspecialchars($row['slotsOpen']);
        }
        // Shfit 4
        $query = "SELECT slotsOpen FROM  shifts WHERE shiftid = 4";
        $result = $conn->query($query);
        if(!$result) die("Fatal Error 7.4");
        while($row = $result->fetch_assoc()){
            $slotsAvailable4 = htmlspecialchars($row['slotsOpen']);
        }
        // Shift 5
        $query = "SELECT slotsOpen FROM  shifts WHERE shiftid = 5";
        $result = $conn->query($query);
        if(!$result) die("Fatal Error 7.1");
        while($row = $result->fetch_assoc()){
            $slotsAvailable5 = htmlspecialchars($row['slotsOpen']);
        }
    // SLOT COUNTING                // Doing this before and after form submission
        // SHIFT 5PM - 6PM             // data may already be in sql, so we want to read it  before and after.
            //Disabling 
            if($slotsAvailable1 == 0 )
                $disable1 = "disabled";
        // SHIFT 6PM - 7PM
            //Disabling 
            if($slotsAvailable2 == 0 )
                $disable2 = "disabled";
        // SHIFT 7PM - 8PM
            //Disabling 
            if($slotsAvailable3 == 0 )
                $disable3 = "disabled";
        // SHIFT 8PM - 9PM
            //Disabling 
            if($slotsAvailable4 == 0 )
                $disable4 = "disabled";
        // SHIFT 9PM - 10PM
            //Disabling 
            if($slotsAvailable5 == 0 )
                $disable5 = "disabled";

    // Validation Section 
    if($_SERVER['REQUEST_METHOD'] == 'POST'){  
        // Retrieving information
        $fname = $_POST['fname'];
        $lname = $_POST['lname'];
        $email = $_POST['email'];
        $shiftID = $_POST['shifts'];

        // Regex Codes
        // First and Last name can only allow letters and spaces but not all spaces.
        $nameRegex = "/[^a-zA-Z\s]/";   //checks for special characters
        $nameRegex2 = "/[a-zA-Z]/";   //checks for at least 1 character nonspace.

        // First Name
            //if the string has at least one charcter
            if(preg_match($nameRegex2, $fname) ){    
                //then check for special characters
                if(preg_match($nameRegex, $fname)){
                    $err = "No special characters";
                    $clear1 = 0;
                }else
                    $clear1 = 1;
            //if there are no characters 
            }else{
                    $err = "There must be atleast one charcter.";
                    $clear1 = 0; 
            }
        // Last Name
            //if the string has at least one charcter
            if(preg_match($nameRegex2, $lname) ){    
                //then check for special characters
                if(preg_match($nameRegex, $lname)){
                    $err1 = "No special characters";
                    $clear2 =0;
                }else
                    $clear2 = 1;
            //if there are no characters 
            }else{
                    $err1 = "There must be atleast one charcter.";
                    $clear2 =0;
            }
        // Email
            // using HTML type="email"
    
    //AFTER VALIDATION. Checking if clear to move on.
        if($clear1 == 1 && $clear2 == 1){ 
        // Checking if volunteer already exists.
            $query = "SELECT * FROM volunteer WHERE firstname = '$fname' AND lastname = '$lname' AND email = '$email' ";
            $person = $conn->query($query);
            if(!$person) die("Fatal Error 8");
            
            if($person->num_rows==0){
            // 1. If there are no rows in returned results, then it is the volunteers first time registering.
            //      no need to check for duplicate.
                // Inserting into volunteer table.
                $query = "INSERT INTO volunteer(firstname,lastname,email) VALUES ('$fname','$lname','$email')";
                $result = $conn->query($query);
                if(!$result) die("Fatal Error 8.1");
                // Retrieving volunteerID
                $query = "SELECT volunteerID FROM volunteer WHERE firstname = '$fname' AND lastname = '$lname' AND email = '$email' ";
                $result = $conn->query($query);
                if(!$result) die("Fatal Error 8.1.1");
                while($row = $result->fetch_assoc()){
                    $volunteerID = htmlspecialchars($row['volunteerID']);
                }
                // Inserting information in Volunteer Shift Table
                $query = "INSERT INTO volunteerShift(shiftid, volunteerID) VALUES ('$shiftID','$volunteerID')";     
                $result = $conn->query($query);
                if(!$result) die("Fatal Error 8.1.2");  
                else $mssg =  " Thank you for registering $fname!";
                // Updating slot availability
                    $query = "UPDATE shifts SET slotsOpen = slotsOpen-1  WHERE shiftid ='$shiftID'";
                    $result = $conn->query($query);
                    if(!$result) die("Fatal Error 8.1.3");

            }else{
            // 2. If rows were found, then volunteer already exists in database. 
            // We will need to check if it is duplicate, or they want a different shift.
                // Grabbing record from volunteer shift table
                $query = "SELECT volunteerID FROM volunteer WHERE firstname = '$fname' AND lastname = '$lname' AND email = '$email' ";
                $result = $conn->query($query); 
                if(!$result) die("Fatal Error 8.2.1");
                while($row = $result->fetch_assoc()){
                    $volunteerID = htmlspecialchars($row['volunteerID']);
                }
                // Grabbing Shift ID
                $query = "SELECT shiftid FROM volunteerShift WHERE volunteerID = '$volunteerID' AND shiftid = '$shiftID'";
                $result = $conn->query($query); 
                if(!$result) die("Fatal Error 8.2.2");
                // A. IT IS A DUPLICATE REQUEST
                    if($result->num_rows >= 1)
                        $mssg =  "Duplicate registration not processed.";
                else{
                // B. IT IS NOT A DUPLICATE BUT INSTEAD ASKING FOR ANOTHER SHIFT
                    // Inserting information in Volunteer Shift Table
                    $query = "INSERT INTO volunteerShift(shiftid, volunteerID) VALUES ('$shiftID','$volunteerID')";     
                    $result = $conn->query($query);
                    if(!$result) die("Fatal Error 8.2.3");  
                    else $mssg = "Thank you for being generous with your time.";
                     // Updating slot availability
                    $query = "UPDATE shifts SET slotsOpen = slotsOpen-1  WHERE shiftid ='$shiftID'";
                    $result = $conn->query($query);
                    if(!$result) die("Fatal Error 8.2.4");
                }
            }
        }

        // Updating slot variable for each.
        // Shift 1
        $query = "SELECT slotsOpen FROM  shifts WHERE shiftid = 1";
        $result = $conn->query($query);
        if(!$result) die("Fatal Error 7.1");
        while($row = $result->fetch_assoc()){
            $slotsAvailable1 = htmlspecialchars($row['slotsOpen']);
        }
        // Shift 2
        $query = "SELECT slotsOpen FROM  shifts WHERE shiftid = 2";
        $result = $conn->query($query);
        if(!$result) die("Fatal Error 7.2");
        while($row = $result->fetch_assoc()){
            $slotsAvailable2 = htmlspecialchars($row['slotsOpen']);
        }
        // Shift 3
        $query = "SELECT slotsOpen FROM  shifts WHERE shiftid = 3";
        $result = $conn->query($query);
        if(!$result) die("Fatal Error 7.3");
        while($row = $result->fetch_assoc()){
            $slotsAvailable3 = htmlspecialchars($row['slotsOpen']);
        }
        // Shfit 4
        $query = "SELECT slotsOpen FROM  shifts WHERE shiftid = 4";
        $result = $conn->query($query);
        if(!$result) die("Fatal Error 7.4");
        while($row = $result->fetch_assoc()){
            $slotsAvailable4 = htmlspecialchars($row['slotsOpen']);
        }
        // Shift 5
        $query = "SELECT slotsOpen FROM  shifts WHERE shiftid = 5";
        $result = $conn->query($query);
        if(!$result) die("Fatal Error 7.1");
        while($row = $result->fetch_assoc()){
            $slotsAvailable5 = htmlspecialchars($row['slotsOpen']);
        }
    // SLOT COUNTING
        // SHIFT 5PM - 6PM
            //Disabling 
            if($slotsAvailable1 == 0 )
                $disable1 = "disabled";
        // SHIFT 6PM - 7PM
            //Disabling 
            if($slotsAvailable2 == 0 )
                $disable2 = "disabled";
        // SHIFT 7PM - 8PM
            //Disabling 
            if($slotsAvailable3 == 0 )
                $disable3 = "disabled";
        // SHIFT 8PM - 9PM
            //Disabling 
            if($slotsAvailable4 == 0 )
                $disable4 = "disabled";
        // SHIFT 9PM - 10PM
            //Disabling 
            if($slotsAvailable5 == 0 )
                $disable5 = "disabled";
    }
    //closing the connection
        $conn->close();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Volunteer Registration</title>
    <!-- Begin of Style Sheet -->
    <style>
    html{
            background-color:#c8bad3;
            text-align:center;
        }
        body{
            background-color:white;
            margin: 10px auto 10px auto;
            width: 80%;
            height:auto;
            padding-bottom:40px;
        }
        h1{
            padding-top:20px;
        }
        p{
            margin-left:20px;
            margin-right:20px;
            font-size:20px;
        }
        form{
            margin-left:auto;
            margin-right:auto;
            width:70%;
            border:solid 1px black;
        }
        div{
            display:grid;
            grid-template-columns:1fr 1fr 1fr;
            margin-top:15px;
            font-size:17px;
        }
        input[type='text'],input[type='email'],select{
            font-size:17px;
        }
        .error{
            float:right;
            color:red;
            min-width:300px;
            font-size:17px;
        }
        input[type='submit']{
            margin-top:20px;
            width: 170px;
        }
    </style>
</head>
<!-- HTML -->
<body>
    <h1>Volunteer Registration</h1>
    <p>Thank you for your willingness to volunteer to help Alex's Worthy Cause.
        Please fill out the form below to sign up for a shift. You may register for more than one slot.
        Duplicate registrations for the same time slot will not be processed.</p>

    <!-- Form Box -->
    <form action="volunteer.php" method="post">
        <!-- First Name -->
        <div id= "firstname">
        <label for="fname">First Name</label>
        <input type="text" id="fname" name="fname" value="<?php echo $fname; ?>" required>
            <!-- Error Message -->
            <label class="error"><?php echo $err; ?></label>
        </div>
        <!-- Last Name -->
        <div id="lastname">
        <label for="lname">Last Name</label>
        <input type="text" id="lname" name="lname" value="<?php echo $lname; ?>" required>
            <!-- Error Message -->
            <label class="error"><?php echo $err1; ?></label>
        </div>
        <!-- Email -->
        <div id="email">
        <label for="email">Email</label>
        <input type="email" id="email" name="email" value="<?php echo $email; ?>" required>
        </div>
        <!-- List of Different Shifts -->
        <div id=list>
        <label for="shifts">Choose a shift:</label>
        <select id="shifts" name="shifts" size=5 required>
            <option value="1" <?php echo $disable1;?> >5:00pm - 6:00pm [ <?php echo $slotsAvailable1;?> of 5 avaible ] </option>
            <option value="2" <?php echo $disable2;?> >6:00pm - 7:00pm [ <?php echo $slotsAvailable2;?> of 5 avaible ] </option>
            <option value="3" <?php echo $disable3;?> >7:00pm - 8:00pm [ <?php echo $slotsAvailable3;?> of 5 avaible ] </option>
            <option value="4" <?php echo $disable4;?> >8:00pm - 9:00pm [ <?php echo $slotsAvailable4;?> of 5 avaible ] </option>
            <option value="5" <?php echo $disable5;?> >9:00pm - 10:00pm [ <?php echo $slotsAvailable5;?> of 5 avaible ] </option>         
        </select>
        </div>
        <!-- Submit Button -->
        <input type="submit" value="Register">
        <!-- Message after submitting -->
        <p><?php echo $mssg; ?></p>
    </form>
</body>
</html>