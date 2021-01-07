$(document).ready(function() {
    var recordCount         =       2;
    $("#viewSitesButton").click(function() {
        $.ajax({
                    type: "POST",
                    url: "dataloader/loadSitesInfo-html.php",
                    //data: $('#displayViewSites').serialize(),
					data: {},
                    dataType: "html",
                    success: function(response) {                        
                        $('#SitesTable').html(response);
                    }
            });  
    });        
});