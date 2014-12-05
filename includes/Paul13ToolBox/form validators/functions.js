// Name: functions.js
// Author: Andrew Buchan (http://www.andrewbuchan.co.uk) Emai: web@andrewbuchan.co.uk
// Description: Provides site-wide functions in an external javascript file
// Date: 02/04/2009

// compareFields(form element, form element)
// Returns: true if field and field2 are equal, false otherwise
compareFields = function(field, field2)
{
	if(field.value == field2.value)
	{
		return true;
	}
	else
	{
		alert("Field1 and Field2 are not identical.");
		return false;
	}
}