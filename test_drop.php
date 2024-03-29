<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>CSSnewbie Example: CSS-Only Dropdown Menu</title>
<style>
/* These styles just pretty up the page a bit. */
body {
   font: 62.5%/1.2 Arial, Helvetica, sans-serif;
   background-color: #eee; }
#wrap {
   font-size: 1.3em;
   width: 500px;
   padding: 20px;
   margin: 0 auto; 
   background-color: #fff;
   position: relative; }

/* These styles create the dropdown menus. */
#navbar {
   margin: 0;
   padding: 0;
   height: 1em; }
#navbar li {
   list-style: none;
   float: left; }
#navbar li a {
   display: block;
   background-color: #5e8ce9;
   color: #fff;
   text-decoration: none; }
#navbar li ul {
   display: none; 
   width: 10em; /* Width to help Opera out */
   background-color: #69f;}
#navbar li:hover ul, #navbar li.hover ul {
   display: block;
   position: absolute;
   margin: 0;
   padding: 0; }
#navbar li:hover li, #navbar li.hover li {
   float: none; }
#navbar li:hover li a, #navbar li.hover li a {
   background-color: #69f;
   border-bottom: 1px solid #fff;
   color: #000; }
#navbar li li a:hover {
   background-color: #8db3ff; }
</style>

<script>
// Javascript originally by Patrick Griffiths and Dan Webb.
// http://htmldog.com/articles/suckerfish/dropdowns/
sfHover = function() {
   var sfEls = document.getElementById("navbar").getElementsByTagName("li");
   for (var i=0; i<sfEls.length; i++) {
      sfEls[i].onmouseover=function() {
         this.className+=" hover";
      }
      sfEls[i].onmouseout=function() {
         this.className=this.className.replace(new RegExp(" hover\\b"), "");
      }
   }
}
if (window.attachEvent) window.attachEvent("onload", sfHover);
</script>

</head>
<body>
   <div id="wrap">
      <h1>CSS-Only Dropdown Menu</h1>
      <ul id="navbar">
      <!-- The strange spacing herein prevents an IE6 whitespace bug. -->
         <li><a href="#">Item One</a><ul>
            <li><a href="#">Subitem One</a></li><li>
            <a href="#">Second Subitem</a></li><li>
            <a href="#">Numero Tres</a></li></ul>
         </li>
         <li><a href="#">Second Item</a>
            <ul>
               <li><a href="#">Just one subitem</a></li></ul>
         </li>
         <li><a href="#">No Subitem</a></li>
         <li><a href="#">Number Four</a>
            <ul>
               <li><a href="#">Subitem One</a></li><li>
               <a href="#">Second Subitem</a></li><li>
               <a href="#">Numero Tres</a></li><li>
               <a href="#">Fourth Thinger</a></li></ul>         
         </li>
      </ul>
      <p><a href="/easy-css-dropdown-menus/">Go back to the main article.</a> This CSS-only dropdown menu should work in all modern browsers. It has been tested and found working in Firefox 2, IE 7, Safari 3, and Opera 8.5. With the included JavaScript, the dropdowns also work in IE 6 (the all-important non-modern browser).</p>
      <p>Donec vel massa. Ut nibh. Donec placerat ultrices dui. Morbi eu dui eget mauris cursus pellentesque. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Cras ante neque, tempor eu, semper sit amet, hendrerit vitae, quam. Nullam ante. Pellentesque arcu sapien, suscipit in, elementum vitae, vulputate quis, metus. Quisque sollicitudin leo a diam. Quisque in risus sit amet mi faucibus feugiat. Ut ullamcorper pede a libero. Donec nisl.</p>
   </div>

</body>
</html>
