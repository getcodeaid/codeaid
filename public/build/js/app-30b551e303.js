function getField(name)
{
    return $( "#field-" + name );
}

function showErrors(errors) {
    var errorText;
    var errorLocation = $("#errors");

    $(errorLocation).html('');

    errors = JSON.parse(errors);

    console.log(errors);

    $.each(errors, function (location, error) {
        errorText = "<li>" + error + "</li>";
        errorLocation.append(errorText);
    });

    $('html, body').animate({scrollTop: 0}, 'slow');
    errorLocation.fadeIn();
}

function loadingButton(button, text) {
    var prevText = button.html();
    button.prop('disabled', true);
    button.html("<i class=\"fa fa-refresh fa-spin\"></i> " + text);
    return prevText;
}

function restoreButton(button, text) {
    button.prop('disabled', false);
    button.html(text);
}

hljs.initHighlightingOnLoad();
//# sourceMappingURL=app.js.map