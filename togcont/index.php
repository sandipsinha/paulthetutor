<html>
<head>
<title>Add Gmail Contact</title>

<script src="http://code.jquery.com/jquery-latest.js"></script>
<script type="text/javascript" src="http://jzaefferer.github.com/jquery-validation/jquery.validate.js"></script>

<style type="text/css">
label { width: 10em; float: left; }
label.error { float: none; color: red; padding-left: .5em; vertical-align: top; }
p { clear: both; }
.submit { margin-left: 12em; }
em { font-weight: bold; padding-right: 1em; vertical-align: top; }
</style>

<script>
  $(document).ready(function(){
    $("#add_contact").validate();
  });
</script>
  
</head>
<body>

<form name="add_contact" id="add_contact" method="POST" action="addContact.php">
<table>
<tr><td COLSPAN="2"><h3>Contact info</h3></td></tr>

<tr><td><label>First Name</label></td>
<td><input type="text" name="first_name" id="first_name" class="required" minlength="2"/></td></tr>

<tr><td><label>Middle Name</label></td>
<td><input type="text" name="middle_name" id="middle_name" class="required" minlength="2"/></td></tr>

<tr><td><label>Last Name</label></td>
<td><input type="text" name="last_name" id="last_name" class="required" minlegth="2"/></td></tr>

<tr><td><label>Home</label></td>
<td><input type="text" name="home" id="home" class="required"/></td></tr>

<tr><td><label>Mobile</label></td>
<td><input type="text" name="mobile" id="mobile" class="required"/></td></tr>

<tr><td><label>Work</label></td>
<td><input type="text" name="work" id="work" class="required"/></td></tr>

<tr><td><label>Email</label></td>
<td><input type="text" name="email" id="email" class="required email"/></td></tr>

<tr><td><label>Company</label></td>
<td><input type="text" name="company" id="company" class="required"/></td></tr>

<tr><td><label>Position</label></td>
<td><input type="text" name="position" id="position" class="required"/></td></tr>

<tr><td COLSPAN="2"><h3>Gmail Account</h1></h3></tr>
<tr><td><label>Username</label></td><td><input type="text" name="gmail_username" id="gmail_username" class="required email"/></td></tr>
<tr><td><label>Password</label></td><td><input type="password" name="gmail_password" id="gmail_password" class="required"/></td></tr>
<tr><td><input type="submit" value="Add Contact" /></td></tr>
</table>
</form>

</body>
</html>
