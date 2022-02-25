$(function () {
    $('#change_total_outcomes').click(function () {
        // send ajax post request to include/utils.php with the data in the form
        
        $.ajax({
            type: 'POST',
            url: "include/utils.php",
            data: {
                "request": "update_total_outcome",
                "deal_id": $('#opened_deal_id').text(),
                "total_outcome": $('#total_outcome').val()
            },
            success: function (response) {
                $("#responsepre").html(response);
            }
        });
    });
});