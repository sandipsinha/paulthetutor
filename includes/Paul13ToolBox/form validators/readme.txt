// Name: php function to call javascript to compare to form fields [RAC Project]
// Author: Andrew Buchan (http://www.andrewbuchan.co.uk) Emai: web@andrewbuchan.co.uk
// Description: Validate 2 form fields, only submit the form if values are equal.
// Date: 02/04/2009


// Directions/Usage

1: In the HTML/php page that has the form in it add the following line (add it where ever you like but I would recommend below the HTML but above the closing body tag)

<script type="text/javascript" src="functions.js"></script>

Note: I assume that the functions.js file is in the same directory as the HTML/PHP file that contains the form.


2: Also in the HTML/php page find the <form> tag and add the following

onsubmit="return compareFields(this.field, this.field2);"

So your form tag will look like something like this

<form name="foo" id="foo" action="somefile.php" method="post" onsubmit="compareFields(this.field, this.field2);">

Note: this.field and this.field2 are the fields you want to validate so replace field and field2 with the names of the form elements you want to validate.
So if the form elements are called favouritefood and favouritedrink your form tag will look like this:

<form name="foo" id="foo" action="somefile.php" method="post" onsubmit="compareFields(this.favouritefood, this.favouritedrink);">




That is all you have to do. If you have any problems please let me know.

Thanks,
Andrew