var editor = ace.edit("editor");
editor.setTheme("ace/theme/monokai");

function getField(name)
{
    return $( "#field-" + name );
}

function showErrors(errors)
{
    var errorText;
    var errorLocation = $( "#errors" );

    errors = JSON.parse(errors);

    console.log(errors);

    $.each(errors, function(location, error){
       errorText = "<li>" + error + "</li>";
        errorLocation.append(errorText);
    });

    $('html, body').animate({ scrollTop: 0 }, 'slow');
    errorLocation.fadeIn();

}


$( getField('language') ).change(function() {
    var langSelect = $( getField('language') ).find('option:selected');
    var aceName = langSelect.data('ace-name');
    var languageId = langSelect.attr('value');
    editor.getSession().setMode("ace/mode/" + aceName);

});

$( '#snipcreatebutton' ).on('click', function(){
    editor.setReadOnly(true);
    $(this).prop('disabled', true);
    $(this).html('<i class="fa fa-refresh fa-spin"></i> Creating Snip...');

    var submission = [];
    submission['title'] = getField('title').val();
    submission['message'] = getField('message').val();
    submission['code'] = editor.getValue();
    submission['category_id'] = getField('category').val();
    submission['language_id'] = getField('language').val();
    submission['_token'] =  $('input[name=_token]').val();

    console.log(submission);

    $.ajax({
        url: '/s',
        type: 'POST',
        contentType: 'application/json',
        data: {submission:submission},
        headers: {
            'X-CSRF-Token': $('input[name=_token]').val()
        },
        success: function(data, textStatus ){
            var returnData = JSON.parse(data.responseText);
            window.location.replace('/s/' + returnData.slug);
        },
        error: function(data, textStatus, errorThrown){
            showErrors(data.responseText);
        }
    });
});

