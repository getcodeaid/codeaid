var editor = ace.edit("editor");
editor.setTheme("ace/theme/monokai");

var snipCreateButton = $( "#snipcreatebutton" );

function getField(name)
{
    return $( "#field-" + name );
}

function showErrors(errors)
{
    var errorText;
    var errorLocation = $( "#errors" );

    $(errorLocation).html('');

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

$(snipCreateButton).on('click', function(){
    var createButton = $(this);
    editor.setReadOnly(true);
    $(this).prop('disabled', true);
    var prevText = loadingButton($(this),"Creating Snip...")

    var submission = {};
    var tokenField = $('input[name=_token]');
    submission['title'] = getField('title').val();
    submission['message'] = getField('message').val();
    submission['code'] = editor.getValue();
    submission['category_id'] = getField('category').val();
    submission['language_id'] = getField('language').val();
    submission['_token'] =  tokenField.val();

    $.ajax({
        url: '/s',
        type: 'POST',
        contentType: "application/x-www-form-urlencoded",
        data: submission,
        headers: {
            'X-CSRF-Token': tokenField.val()
        },
        success: function(data, textStatus ){
            window.location.replace("/s/" + data.slug);

        },
        error: function(data, textStatus, errorThrown){
            if (data.status == 422) {
                showErrors(data.responseText);
            }else{
                var errorText;

                switch (data.status){
                    case 401:
                        errorText = "Unauthorised! Your login session may have expired";
                        break;
                    default:
                        errorText = "An unknown error occured. Please try again later.";
                        break;

                }
                showErrors(JSON.stringify([errorText]));
            }
            editor.setReadOnly(false);
            restoreButton(createButton, prevText);
        }
    });
});
//# sourceMappingURL=createSnip.js.map