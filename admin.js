/*  Name: Syahirah Shafiq Lee ID: 19065338
    This file processes user input from admin.html form before passing to server (data retrieval) by using the xhr object.
*/

var xhr = createRequest();

// function to execute php file and display the retrieved data from the server with pick up time within 2 hours from now
//if input is entered, it displays details of the matched booking reference number
function display(dataSource, divID, bsearch, date) 
{
    if (xhr) 
    {
        //get element to display information
        var obj = document.getElementById(divID);
        // Send data to admin_display.php file using POST method
        var requestbody = "&bsearch=" + encodeURIComponent(bsearch)
            + "&date=" + encodeURIComponent(date);
        xhr.open("POST", dataSource, true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        
        xhr.onreadystatechange = function () {
            if (xhr.readyState == 4 && xhr.status == 200) {
                
                obj.innerHTML = xhr.responseText;
            } 
        } 
        xhr.send(requestbody);
    }
}

// function to execute php file and fetch data according to booking reference number from the server 
function assign(dataSource, divID, bsearch) 
{
    if (xhr)
     {
        //get element to display information
        var obj = document.getElementById(divID);
         // Send data to admin_assign.php file using POST method
        var requestbody = "bsearch=" + encodeURIComponent(bsearch);
        
        xhr.open("POST", dataSource, true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
       
        xhr.onreadystatechange = function () {
            if (xhr.readyState == 4 && xhr.status == 200) {
               
                obj.innerHTML = xhr.responseText;
            } 
        } 
        // send request to server using the parameter
        xhr.send(requestbody);
    } 
}
