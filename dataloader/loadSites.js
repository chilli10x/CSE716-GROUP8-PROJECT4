$(document).ready(function() {
    var recordCount         =       2;
    $("#viewSitesButton").click(function() {
        $.ajax({
                    type: "POST",
                    url: "dataloader/loadSitesInfo.php",
                    data: $('#displayViewSites').serialize(),
                    contentType: "application/json; charset=utf-8",
                    dataType: "json", //html                    
                    cache: false,                       
                    success: function(response) {                        
                        var trHTML = '';
                            $.each(response, function (i, item) {
                                trHTML +=    '<tr><td>' + item.dbname + '</td><td>' + item.location +
								'</td></tr>';
                            });
                            $('#SitesTable').append(trHTML);
                    }
            });  
    });        
});