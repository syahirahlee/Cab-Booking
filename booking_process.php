<?php
    /*
    Name: Syahirah Shafiq Lee ID: 19065338
    This file takes the input from the form to validate and save them to the database, then display return confirmation information to the client.
    It generates a unique booking reference number, booking date/time and a status with initial value “unassigned”, and 
    save them together with the customer's inputs into the MySQL table.
    */

    //retrieve data from form 
    $name = $_POST['cname'];
    $phone = $_POST['phone'];
    $unit = $_POST['unumber'];
    $streetNumber = $_POST['snumber'];
    $streetName = $_POST['stname'];
    $destination = $_POST['dsbname'];
    $suburb = $_POST['sbname'];
    $date = $_POST['date'];
    $time = $_POST['time'];

    //for error messages when invalid inputs
    $booking_msg = "";
    $count = 0;

    //data validation for required fields
    //validate name for alphabetic format 
    if (empty($name) || !preg_match('/[a-zA-Z]/', $name) || strlen($name) > 50) {
        $booking_msg = $booking_msg . "<p class=\"w3-text-red\" align=\"center\">Invalid name format!</p>";
        $count++;
    
    }
    
    //validate phone number for numbers only, min value =10
    if (empty($phone) || !preg_match('/^[0-9]+$/', $phone) || strlen($phone) < 10) {
        $booking_msg = $booking_msg . "<p class=\"w3-text-red\" align=\"center\">Invalid phone number!</p>";
        $count++;
    
    }
    
    //validate street number for numbers only
    if (empty($streetNumber) || !preg_match('/^[0-9]+$/', $streetNumber) || strlen($streetNumber) > 10) {
        $booking_msg = $booking_msg . "<p class=\"w3-text-red\" align=\"center\">Invalid street number!</p>";
        $count++;
    
    }
    
    
    //validation for street name
    if (empty($streetName) || !preg_match('/[a-zA-Z]/', $streetName) || strlen($streetName) > 50) {
        $booking_msg = $booking_msg . "<p class=\"w3-text-red\" align=\"center\">Invalid street name!</p>";
        $count++;
    
    }
    
    //validate date and time so that it must be after the current time
    date_default_timezone_set("Pacific/Auckland");   //set local time zone
    $dateTimeField = strtotime($date . " " . $time);  //concatenate pickup date and time
    
    //convert to mysql format
    $pickupDateTime = date('Y-m-d H:i', $dateTimeField);
    //create booking date and time when booking request is made
    $bookedDateTime = date('Y-m-d H:i');
    
    if (empty($date) || empty($time) || !preg_match('/:[0-9]/', $time) || !preg_match('/-[0-9]/', $date) || $pickupDateTime < $bookedDateTime) {
        
        $booking_msg = $booking_msg . "<p class=\"w3-text-red\" align=\"center\">Invalid! Please make sure date and time is no earlier than current time.</p>";
        $count++;
    }
    
    //when correct fields are entered:
    if ($count === 0) 
    {
         //get sql login info 
        require_once('../../conf/sqlinfo.inc.php');
    
        //create MySQL database connection
        $db_connect = @mysqli_connect($db_host, $db_user, $db_password, $db_name);
        
        if (!$db_connect) 
        {
            echo "<p>Failure to connect to database.</p>";
        } 
        else  //successful database connection
        {

            $pickupAddress =  $unit . " " . $streetNumber . " " . $streetName; //concatenate address
      
            $bookingQuery = "SELECT * FROM cab_booking";
    
            $query = @mysqli_query($db_connect, $bookingQuery);
            if(!$query)
            {
                echo("Database table does not exist!");
            }
            else
            {
        
                $sql_insert = "INSERT INTO cab_booking(custName, custPhone, pickUpAddress, pickupSuburb, pickupDateTime, destination, bookingDateTime, bookingStatus) 
                                           VALUES ('$name', '$phone', '$pickupAddress', '$suburb', '$pickupDateTime', '$destination', '$bookedDateTime', 'unassigned')";
        
                $query = @mysqli_query($db_connect, $sql_insert);
                if($query)
                {
                    //fetch the auto incremented booking number created
                    $last_id = mysqli_insert_id($db_connect);
                    //convert date format to display
                    $updatedDate = date("d/m/Y", strtotime($date));

                    $booking_msg = "<p class=\"w3-text-orange\" align=\"center\">Thank you! Your booking reference number is $last_id <br>
                    You will be picked up in front of your provided address at $time on  $updatedDate <br></p>";
                    mysqli_close($db_connect);   
                }
     
            }//end if table checking
        
        }//end if database connection
    }
    echo $booking_msg;
    
?>