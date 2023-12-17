<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Page</title>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script>
        $(document).ready(function(){
        let interval;

        timer_countdown(); //to avoid slight lag

        // Interval to display new calculated timeevery seconds.
        interval = setInterval('timer_countdown()',1000);
        })

        /* timer_countdown function evaluates the time until the event*/
        function timer_countdown(){
        // Variables
        let today_date = new Date();                    //present date
        let event_date = new Date(2024,1,14,17,0,0);     //event date
        //let event_date = new Date();
    
        //calculating the days until the event
        count_down = event_date - today_date;

        //checking if the timer has not ended
        if(count_down == 0){
            document.getElementById('date').innerHTML = "The day has arrived!"
            document.getElementById('link').innerHTML = " ";
            document.getElementById('volunteer-text').innerHTML = " ";
            document.getElementById('banner').innerHTML = " ";
        }else{
            //calculating days, hours, and minutes                              // Math.floor rounds the value we get down. So that day 26.7 is just day 26.
            let days = Math.floor(count_down/(1000*60*60*24))                   // days are calculated by dividing count down by 24 hours.
            let hours = Math.floor(count_down%(1000*60*60*24)/(1000*60*60))     // hours are calculated getting the remainder of days. and dividing it by 60 minutes (1 hours).
            let minutes = Math.floor(count_down%(1000*60*60)/(1000*60))         // minutes are calculated by getting the remainder of countdown divided by hours, then dividing by minutes
            let seconds = Math.floor(count_down%(1000*60)/(1000))               // seconds are calculted by getting the remainder of countdown divided by minutes, then dividing by seconds.

            document.getElementById('timer').innerHTML= days.toPrecision(2) + " Days " + Math.floor(hours)+ " Hours " + minutes.toPrecision(2)+ " Minutes " + Math.floor(seconds) + " Seconds ";
        }
    }
    </script>
    <style>
        html{
            background-color:#c8bad3;
            text-align:center;
        }
        body{
            background-color:white;
            margin: 10px auto 10px auto;
            width: 80%;
        }
        h1#title{
            margin: 20px auto 10px auto;
            font-size:45px;
            padding-top:10px;
        }
        p{
            margin-left:20px;
            margin-right:20px;
            font-size: 20px;
        }
        h1#date{
            font-style:italic;
            color:#7a87b8;
            font-style:outline;
        }
        p#timer,h2{
            font-size:25px;
            margin-top:10px;
            margin-bottom:10px;
        }
        a{
            font-size:20px;
            padding-bottom:20px;
        }
    </style>
</head>

<body>
    <h1 id="title">Alex's Worthy Cause</h1>
    <p>Thank you for visting our website and wanteing to learn more about our cause. This is where we would write something 
        compelling to make you want to support our cause. Take a minute to imagine something of great importance to you.
        Now assume that is the foundation of Alex's Worthy Cause.</p>
    <p> We will be holding our annual fundraiser Alex's Worthy Cause on:</p>
    
    <!-- Timer Section -->
    <h1 id="date">February 14, 2024 @ 5pm</h1>
    <h2 id ="banner"> Here is the countdown! </h2>
    <p id="timer"></p>

    <p id="volunteer-text">We need your help to make the event a success! Please click on the link below to volunteer for Alex'x Worthy Cause.
        You will be glad you did! </p>
    <!-- Link to Volunteer page -->
    <a id="link" href = "volunteer.php">Click here to register to volunteer!</a>
</body>
</html>