function popup_close(){
	self.close();
}

function opener_reload(){
	
	if (window.opener.document.form)
		window.opener.document.form.submit();
	else
	 window.opener.location.href = window.opener.location.href;
	 if (window.opener.progressWindow){
     	window.opener.progressWindow.close();
  }
}

/**
http://stackoverflow.com/questions/4907843/open-a-url-in-a-new-tab-using-javascript
Opens link in new tab 
**/
function openInNewTab(url) {
    var win = window.open(url, '_blank');
    win.focus();
}		
		
function popup(url, name, width, height) {
	width=Math.min(screen.availWidth,width);
	height=Math.min(screen.availHeight-40,height);
	var poz_x=(screen.availWidth-width)/2;
	var poz_y=(screen.availHeight-height-30)/2;
	newwin=window.open(url, "window", 'scrollbars=1, menubar=no, width='+width+', height='+height+', resizable=yes,toolbar=no, left='+poz_x+', top='+poz_y+', location=no, status=yes');
}

function jquery_date(name){
	$('input[name="' + name + '"]').datepicker({ dateFormat: 'mm-dd-yy'  });
}