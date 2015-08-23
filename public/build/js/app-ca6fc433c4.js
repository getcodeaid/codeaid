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
hljs.initHighlightingOnLoad();

//# sourceMappingURL=app.js.map