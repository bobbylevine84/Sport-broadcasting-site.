<?php
?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script> 
 <script>
//FOR DATE
formatAMPMd();


function formatAMPMd() {
var d = new Date(),

    minutes2 = d.getMinutes().toString().length == 1 ? '0'+d.getMinutes() : d.getMinutes(),
    hours2 = d.getHours().toString().length == 1 ? '0'+d.getHours() : d.getHours(),
   // ampm2 = d.getHours() >= 12 ? ' PM' : ' AM';
  months = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'],
   days = ['Sun','Mon','Tue','Wed','Thu','Fri','Sat'];
	var my_date = months[d.getMonth()]+' '+d.getDate()+' '+d.getFullYear();
	var my_time = months[d.getMonth()]+' '+d.getDate()+' '+d.getFullYear()+' '+hours2+':'+minutes2;
	//alert(my_date);
	
	$.post("<?php echo base_url();?>event/manage_event/get_date/",{
				date : my_date,
				date_time : my_time
			}).done(function(data){
				window.location.href = document.URL;
				//console.log(data)
				
			});
			
return days[d.getDay()]+' '+months[d.getMonth()]+' '+d.getDate()+' '+d.getFullYear()+' '+hours+':'+minutes+ampm;

}
 </script>
 