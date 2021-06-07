<?php
    /* Name: Syahirah Shafiq Lee ID: 19065338
        This file retrieve booking data based on booking number entered.
        If no input specified, it will retrieve data from the database with a pickup time within 2 hours from current time and 
        display them in table format. It will display appropriate message for invalid input or if no unassigned requests within the 2 h
    */

    //retrieve field value from form
    $booknum = $_POST["bsearch"];
    //set local time zone
    date_default_timezone_set("Pacific/Auckland");
    //set current date and time
    $current = date("Y-m-d H:i");
    $upcomingtime = date("Y-m-d H:i", strtotime('+2 hours')); //for booking in upcoming two hours

    //get sql login info 
    require_once('../../conf/sqlinfo.inc.php');
    
    //create MySQL database connection
    $db_connect = @mysqli_connect($db_host, $db_user, $db_password, $db_name);

    if (!$db_connect) 
    {
      echo "<p>Failed to connect to database</p>";
    } 
    else  // successful database connection
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
        //when user enter booking number to get the specific booking request details (optional)
        if (!empty($booknum))
        {
            if (!preg_match('/^[0-9]+$/', $booknum)) //regular expression to make sure only integers accepted
            {
                echo "<p class=\"w3-text-red\" align=\"center\">Invalid! Please enter numbers only.</p>";  
            }
            else
            {
                //sql command to retrieve booking details for matched booking number entered
                $query_search = "SELECT  bookingNum, custName, custPhone, pickUpAddress, pickupSuburb, destination, pickupDateTime, bookingStatus 
                FROM $db_table WHERE bookingNum ='$booknum'";

                $result_search = @mysqli_query($db_connect, $query_search)
                or die("<p>Failed to execute query for searching booking request.</p>"
                . "  <p>Error code " . mysqli_errno($db_connect)
                . ": " . mysqli_error($db_connect) . "</p>");

                //when match is found
                if(mysqli_num_rows($result_search) > 0) 
                {  
                 
                 //retrieve and display all the status record containing the matched keyword into rows
                 //mysqli_fetch_row()returns the fields in the current row of a resultset into an indexed array and moves the result pointer to the next row
                 echo "<table width='70%' border='1'  align=\"center\">";
                 echo "<tr><th>Booking Number</th><th>Customer Name</th><th>Phone</th><th>Pick Up Address</th><th>Pick Up Suburb</th><th>Destination</th><th>Pick Up Date & Time</th><th>Status</th></tr>";
                 $rows  =  mysqli_fetch_row($result_search)
                 or die("<p>Failed to execute query to retrieve and display results.</p>"
                 . "  <p>Error code " . mysqli_errno($db_connect)
                 . ": " . mysqli_error($db_connect) . "</p>");
                 
                 while ($rows) //loop for results
                 {
                     //retrieve and display each field/column in table
                     echo "<tr><td>{$rows[0]}</td>";  //booking num
                     echo "<td>{$rows[1]}</td>";     //cust name
                     echo "<td>{$rows[2]}</td>";     //phone
                     echo "<td>{$rows[3]}</td>";     //address
                     echo "<td>{$rows[4]}</td>";     //suburb
                     echo "<td>{$rows[5]}</td>";     //destination
                     echo "<td>", date("d/m/Y H:i", strtotime($rows[6])),"</td>";  //date in converted format
                     echo "<td>{$rows[7]}</td></tr>"; //status
                     $rows  =  mysqli_fetch_row($result_search);
                 }
                 echo "</table>";
                 // frees up the memory, after using the search result pointer
                 mysqli_free_result($result_search);
                }
                else //not found any match
                {
                    echo "<p class=\"w3-text-red\" align=\"center\">Booking number does not exist!.</p>";
                }
            }

        }
        else //no booking number entered 
        {

            //sql command to retrieve bookings with pickup time within 2 hours of current time
            $query_display = "SELECT  bookingNum, custName, custPhone, pickUpAddress, pickupSuburb, destination, pickupDateTime, bookingStatus 
            FROM $db_table WHERE bookingStatus = 'unassigned' AND pickupDateTime BETWEEN '$current' AND '$upcomingtime'";

            $result = @mysqli_query($db_connect, $query_display)
            or die("<p>Failed to execute query for display unassigned bookimg requests within 2 hours from now.</p>"
            . "  <p>Error code " . mysqli_errno($db_connect)
            . ": " . mysqli_error($db_connect) . "</p>");

            $unassign_rows = @mysqli_num_rows($result);

            //create and display a table based on the query
            if ($unassign_rows === 0) 
            {
                $display_msg = "<p class=\"w3-text-red\" align=\"center\">No unassigned booking requests within 2 hours from now</p>";
            } 
            else 
            {
                $display_msg = "<table class='table'>
            
                 <thead>
				<tr>
					<th scope='col'>Booking Number
					</th>
					<th scope='col'>Customer Name
					</th>
					<th scope='col'>Customer Phone
					</th>
					<th scope='col'>Pick Up Address
					</th>
                    <th scope='col'>Pick Up Suburb
					</th>
					<th scope='col'>Destination suburb
					</th>
					<th scope='col'>Pick Up Date & Time
					</th>
                    <th scope='col'>Status
					</th>
				</tr>
	            </thead>
			    <tbody>";
    
                while ($unassign_rows = mysqli_fetch_array($result)) 
                {
       
                    $display_msg = $display_msg . "<tr>";
        
                    for ($i = 0; $i < 8; $i++) 
                    {
           
                        $display_msg = $display_msg . "<td>";
                        $display_msg = $display_msg . "<p>" . $unassign_rows[$i] . "</p>";

                    }
                    $display_msg = $display_msg . "</td>";
                    $display_msg = $display_msg . "</tr>";
                }
                mysqli_free_result($result);

                mysqli_close($db_connect);
                $display_msg = $display_msg . "</tbody>
		           </table>";
            }
            echo $display_msg;
        }
    }//end if database connection


?>