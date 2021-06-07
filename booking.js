/*  Name: Syahirah Shafiq Lee ID: 19065338
	This file processes and validates user input from booking.html form before passing to server (saving data) by using the xhr object.
	The minimum values for date and time are set up, validates input from the form.
*/

//create xhr object
var xhr = createRequest();

//function to process and send data from client side; booking form to server side; booking.php file 
function saveBooking(dataSource, ID, cname, phone, unumber, snumber, stname, sbname, date, time, dsbname) {
    if (xhr) {

        //get element to display information
        var obj = document.getElementById(ID);
        // Send data to booking_process.php file using POST method
        var requestbody = "cname=" + encodeURIComponent(cname)
            + "&phone=" + encodeURIComponent(phone)
            + "&unumber=" + encodeURIComponent(unumber)
            + "&snumber=" + encodeURIComponent(snumber)
            + "&stname=" + encodeURIComponent(stname)
            + "&sbname=" + encodeURIComponent(sbname)
            + "&date=" + encodeURIComponent(date)
            + "&time=" + encodeURIComponent(time)
            + "&dsbname=" + encodeURIComponent(dsbname);
        
            xhr.open("POST", dataSource, true);
        
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        
            // Response on ready state
            xhr.onreadystatechange = function () {
            if (xhr.readyState == 4 && xhr.status == 200) {
                //display HTML element
                obj.innerHTML = xhr.responseText;
            }
        }
        // send request to server using the parameter
        xhr.send(requestbody);
    }
}