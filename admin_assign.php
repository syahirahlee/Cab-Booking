<?php
    /* Name: Syahirah Shafiq Lee ID: 19065338
        This file fetch booking data from the database based on matched booking number and update 
        the booking status from 'unassigned' to 'assigned'
    */

    //check if booking number has value
    if (!empty ($_POST["bsearch"]) )
    {
        //retrieve field value from form
        $booknum = $_POST["bsearch"];
        //get sql login info 
        require_once('../../conf/sqlinfo.inc.php');
        $db_table = "cab_booking";
    
        //create MySQL database connection
        $db_connect = @mysqli_connect($db_host, $db_user, $db_password, $db_name);
        if (!$db_connect) 
        {
            echo "<p>Failed to connect to database</p>";
        }    
        else  //successful database connection
        {
           
            //check if table exists in database, and create the table if not
            $db_table = "cab_booking";		
            $sql_tbl = "SELECT bookingNum FROM $db_table";		
            $query_tblresult = @mysqli_query($db_connect, $sql_tbl);
            if (!$query_tblresult)
            {
                $query_tbl = mysqli_query($db_connect,
                "CREATE TABLE cab_booking
                (
                    bookingNum INT NOT NULL  AUTO_INCREMENT,
                    custName VARCHAR(50) NOT NULL,
                    custPhone INT(12) NOT NULL,
                    pickUpAddress VARCHAR(300) NOT NULL,
                    pickupDateTime DateTime NOT NULL,
                    pickupSuburb VARCHAR(100),
                    destination VARCHAR(100) NOT NULL,
                    bookingDateTime DateTime NOT NULL,
                    bookingStatus VARCHAR(20) NOT NULL,
                    PRIMARY KEY (bookingNum) 
                );" 
                );
            }
            //SQL command to search the database to find matched booking reference number that admin entered
            $sql_search1 = "SELECT * FROM $db_table WHERE bookingNum  = '$booknum'";;
            //store result of search into result pointer
            $result_search1 = @mysqli_query($db_connect, $sql_search1)
            or die("<p>Failed to execute search query for booking number.</p>"
            . "  <p>Error code " . mysqli_errno($db_connect)
            . ": " . mysqli_error($db_connect) . "</p>");

           //when the booking no matches and found in database,  otherwise display error message	
           if(mysqli_num_rows($result_search1) > 0) 
           {
               //SQL command to search the database to find matched booking reference number and status to check if cab has already been assigned
               $sql_search2 = "SELECT * FROM $db_table WHERE bookingNum = '$booknum' AND bookingStatus= 'assigned'";;
               //store result of search into result pointer
               $result_search2 = @mysqli_query($db_connect, $sql_search2)
               or die("<p>Failed to execute search query for booking number and status.</p>"
               . "  <p>Error code " . mysqli_errno($db_connect)
               . ": " . mysqli_error($db_connect) . "</p>");

               //when the booking no and status matches and found in database
               if(mysqli_num_rows($result_search2) > 0) 
               {
                   //display appropriate message to inform it has been assigned
                   echo "<p class=\"w3-text-red\" align=\"center\">A cab has been assigned to this booking number! Please check another cab booking request.</p>";
               }
               else //update status of 'unassigned' booking request to 'assigned'
               {
                   $assign_query = "UPDATE $db_table SET bookingStatus = 'assigned' WHERE bookingNum = $booknum";
                   $assign_result = @mysqli_query($db_connect, $assign_query)
                               or die("<p>Failed to execute assign query.</p>"
                               . "<p>Error code " . mysqli_errno($db_connect)
                               . ": " . mysqli_error($db_connect). "</p>"); 
                   
                   //display confirmation message 
                   echo "<p class=\"w3-text-orange\" align=\"center\">The booking request $booknum has been successfully assigned!</p>";
               }
           }
           else //when results found 0 matches in database for the searched booking number
           {
               echo  "<p class=\"w3-text-red\" align=\"center\">Booking number does not exist or invalid! Please try again.</p>";
           }
          
        }
    }
    else //blank field
    {
        echo "<p class=\"w3-text-red\" align=\"center\">Invalid! Please enter booking number correctly.</p>";
    }
    mysqli_close($db_connect);

?>