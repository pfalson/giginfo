$(document).ready(function(){
    $(':submit').on('click', function (e) {
        e.preventDefault();
        $.ajax({
            url: '/admin/venue',
            type: 'post',
            data: {
                'name':$('input[name=name]').val(),
                'venuetype_id':$('input[name=name]').val(),
                'website':$('input[name=website]').val(),
                'facebook':$('input[name=facebook]').val(),
                'address_id':$('input[name=address_id]').val(),
                'phone':$('input[name=phone]').val(),
                '_token': $('input[name=_token]').val()
            },
            success: function(data){
                if (typeof result.errors !== 'undefined') {
                    showErrors(result.errors);
                } else {
                    $.cookie('venue', data);
                }
            },
            error: function (data) {
                var errors = jQuery.parseJSON(data.responseText);
                showErrors(errors);
            }
        });
    });
});
function showErrors(errors) {
    $('#errors_div').show();
    var cList = $('#error_list');
    clist.empty();
    jQuery.each(errors, function () {
        var li = $('<li>' + this[0] + '</li>').appendTo(cList);
    });
}