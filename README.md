# Cab-Booking

Brief instructions on how to use the system
********************************************
1. "Cab_booking" table needs to be created in the database to store all the booking requests information.
(Check mysqlcommand text file for the table creation)
2. Open either the booking.html or admin.html to access the website.
3. Browse through the two components using the navigation bar.
4. **Booking component** <br>
	This component enables customers to put in a taxi booking request through the booking form. 
	The required fields in the form are name, phone number, street number, street name, pick-up date and time.
	When the form is submitted, all the input will then be processed and validated before sending to the server and saved to the MYSQL table: "cab_booking" in database.
	Appropriate error messages will be displayed if there is any invalid inputs according to the respective required fields.
	If successful, a return confirmation message will be displayed with the booking reference number, pick-up date and pick-up time below the form.
	
	i) Fill in the form accordingly. Messages for valid input are displayed in the textfield for information. <br>
	ii) Click submit button if all required fields are filled in. Click reset button to erase all data entered. <br>
	iii) If successful, a return confirmation message will be displayed with the booking reference number, pick-up date and pick-up time below the form.<br>
	     If not, error messages will be displayed to inform which fields are incorrect. Please fill in again.
	     
	     
5. **Admin component** <br>
	This component enables users to search booking requests based on booking reference number, or view all booking requests with no input entered, 
	that has pick-up time within 2 hours from the current time.
	It also enables user to assign cab to the unassigned booking requests based on the booking reference number entered. The status of the booking will be updated 
	from "unassigned" to "assigned" in the database table.
	Appropriate error messages will be displayed if there is invalid booking number input or if there are no unassigned booking requests within 2 hours from now 
	or if the cab has been assigned.
	If successful, the retrieved data will be displayed in table format.

	i) Fill in the booking number to search. Click view booking request to display the booking details of that particular booking.<br>
	   Click the button without filling in the booking number to view all unassigned booking request within 2 hours pick-up time from current time. <br>
	   A message will be displayed if no available booking requests within 2 hours from now to inform the user. <br>
	ii) Fill in the booking number. Click assign cab button to assign cab to the unassigned booking request. <br>
	   If booking request is already assigned, a message will be displayed to inform the user. <br>
	   If invalid or booking number does not exist, error message will be displayed. A successful message will be displayed if unassigned request is assigned a cab.
	   
	   
<br>
The navigation bar is used to make easier to browse between admin and booking components <br>
Security for admin component was not required in the task, but open to further implementations, as well as other functions.
<br><br>

List of all the files in the system
*************************************
1. xhr.js

2. Booking component
   HTML
   -booking.html

   Javascript
   -booking.js

   PHP
   -booking_process.php	 

2. Admin component
   HTML
   -admin.html

   Javascript
   -admin.js

   PHP
   -admin_assign.php	 
   -admin_display.php	 

3. Styling (CSS files)
  -stylesheet.css
  -W3.css
  -form_style.css

4. mysqlcommand.txt

5. readme.txt

6. cabslogo.png image file
