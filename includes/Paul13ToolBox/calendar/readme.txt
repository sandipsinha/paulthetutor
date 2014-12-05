calender.css-> It is used to design the calender. It defines the hight,
width, font, font size of the calender content. It also defines the header color 
of the calender.

calender_us.js-> This javascript file is used to calculate the calender.

N.B: Basically the above two files is used to create the calender.


index.html-> This file calls calender_us.js and calender.css to design the 
calender. This file include the calender and send the date value to insert.php to 
insert the date to mysql database.

insert.php-> This file graps the date value that comes form index.html and convert
the date value in mysql database date format and insert ot mysql database.


style.css-> It is used to design the index.html.

View.php-> This file takes the date form mysql database as your required format
of the date and show the date in the format of mm/dd/yyyy.

db_connect.php-> It is used to connect to mysql database.



