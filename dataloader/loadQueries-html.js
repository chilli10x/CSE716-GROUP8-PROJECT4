$(document).ready(function() {
    var recordCount         =       2;
    $("#viewQueriesButton").click(function() {
        $.ajax({
                    type: "POST",
                    url: "dataloader/loadQueries-html.php",
                    //data: $('#displayViewSites').serialize(),
					data: {},
                    dataType: "html",
                    success: function(response) {                        
                        $('#QueriesTable').html(response);
                    }
            });  
    });        
});