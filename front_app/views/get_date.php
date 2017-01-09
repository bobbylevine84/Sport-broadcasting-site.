<?php
?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script> 
 <script>

$(document).ready(function(){
	myFunction();
	function myFunction() {
    var d = new Date();
    var n = d.getTimezoneOffset();
    //document.getElementById("demo").innerHTML = n;

    var d = new Date();
    //alert(n); Shows offset for time zone.
	var gmtHours = -d.getTimezoneOffset()/60;
	//var d = new Date();
	//var na = d.toUTCString();
	//alert(gmtHours); shows local time GMT
	//document.write("The local time zone is: GMT " + gmtHours);
	var newtime = gmtHours;
	//alert(newtime) SHOWS NEW GMT according to database.

	$.ajax({
		url : '<?php echo base_url();?>home/get_date_by_timezone',
		data : {'timezone' : newtime},
		type : 'POST',
		success : function(data){
			console.log(data);
			window.location.href = document.URL;
		}
	});

	}
	});

 </script>
 