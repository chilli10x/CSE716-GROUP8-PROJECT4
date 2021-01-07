

	function sitePopulateClick(){
		$number_of_sites_id = document.getElementById("number_of_sites_id").value;
		$sites_div_id = document.getElementById("sites_div_id").innerHTML; 
		$one_entry_div_id = document.getElementById("one_entry_div_id").innerHTML; 
		$("#sites-div-main").show(1200);
		//$("#one_entry_div_id").hide();
		$total = $one_entry_div_id; 
		for (let i = 1; i < $number_of_sites_id; i++) {
			$total = $total+$one_entry_div_id; 
		} 
		if($number_of_sites_id>0)
			document.getElementById("sites_div_id").innerHTML = document.getElementById("sites_div_id").innerHTML + $total;
	}
	function queryPopulateClick(){
		$number_of_queries_id = document.getElementById("number_of_queries_id").value;
		$queries_div_id = document.getElementById("queries_div_id").innerHTML; 
		$one_entry_queries_div_id = document.getElementById("one_entry_queries_div_id").innerHTML; 
		$("#queries-div-main").show(1200); 
		$("#one_entry_queries_div_id").hide();
		$total = $one_entry_queries_div_id; 
		for (let i = 1; i < $number_of_queries_id; i++) {
			$total = $total+$one_entry_queries_div_id; 
		} 
		if($number_of_queries_id>0)
			document.getElementById("queries_div_id").innerHTML = document.getElementById("queries_div_id").innerHTML + $total;
	}

	// Used to toggle the menu on small screens when clicking on the menu button
	function myFunction() {
	  var x = document.getElementById("nav");
	  if (x.className.indexOf("w3-show") == -1) {
		x.className += " w3-show";
	  } else { 
		x.className = x.className.replace(" w3-show", "");
	  }
	}

	// When the user clicks anywhere outside of the modal, close it
	var modal = document.getElementById('ticketModal');
	window.onclick = function(event) {
	  if (event.target == modal) {
		modal.style.display = "none";
	  }
	}



$('#setsessionbutton').on('click', function(e){ $.ajax({
    type: 'POST',
    url: 'setsession.php',
    data: {sendCellValue: $(this).text()}
}); });
