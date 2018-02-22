
	/**
		list sample delete function 
		Created : 20/11/2016
		Modified : 20/11/2016
	**/
	function delete_alert_func(Message,form_data,form_name){
		if (confirm("Are you sure to delete the record?")) {
			return true;
		}
		return false;
	}

	/**
		get filename from the url
		Created : 24/11/2016
		Modified : 24/11/2016
	**/
	function get_filename() {	
		var url = window.location.href.slice(window.location.href.indexOf('?') + 1).split('&');  
		var yourstring = window.location.pathname;
		var fileNameIndex = yourstring.lastIndexOf("/") + 1;
		var filename = yourstring.substr(fileNameIndex);
		return filename = filename+'?'+url;
	}	

	/**
		get filename from the url
		Created : 25/11/2016
		Modified : 25/11/2016
	**/
	function gup( name ) {
		url = location.href;
		name = name.replace(/[\[]/,"\\\[").replace(/[\]]/,"\\\]");
		var regexS = "[\\?&]"+name+"=([^&#]*)";
		var regex = new RegExp( regexS );
		var results = regex.exec( url );
		return results == null ? null : results[1];
	}	
	
	/**
		get filename from the url
		Created : 24/12/2016
		Modified : 24/12/2016
	**/
	function gup_name( name ) {
		/*url = location.href;
		name = name.replace(/[\[]/,"\\\[").replace(/[\]]/,"\\\]");
		var regexS = "[\\?&]"+name+"=([^&#]*)";
		var regex = new RegExp( regexS );
		var results = regex.exec( url );
		var str = results[1];
		var results[1] = str.replace("list_", "add_");
		return results == null ? null : results[1];*/
	}	
	
	/**
		for cancel button redirection
		Created : 03/12/2016
		Modified : 03/12/2016		
	**/	
	function goto_url(get_val) {
		(!get_val?get_val = 'home' : get_val);
		window.location = 'index.php?do='+get_val;
		exit;
	}
	
	
