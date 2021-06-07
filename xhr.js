/*  Name: Syahirah Shafiq Lee ID: 19065338
    This file contains the function to create an XMLHttpRequest object to request data from web server and accomodate
    to the different types of browser. It returns a valid XHR object.
*/

function createRequest() {
    var xhr = false;  
    if (window.XMLHttpRequest) {
        xhr = new XMLHttpRequest();
    }
    else if (window.ActiveXObject) {
        xhr = new ActiveXObject("Microsoft.XMLHTTP");
    }
    return xhr;
} // end function createRequest()
