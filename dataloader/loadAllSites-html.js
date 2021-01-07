$(document).ready(function() {
    var recordCount         =       2;
    $("#viewAllSitesButton").click(function() {
        $.ajax({
                    type: "POST",
                    url: "dataloader/loadAllSitesData-html.php",
                    //data: $('#displayViewSites').serialize(),
					data: {},
                    dataType: "html",
                    success: function(response) {                        
                        $('#AllSitesTable').html(response);
                    }
            });  
    });        
});