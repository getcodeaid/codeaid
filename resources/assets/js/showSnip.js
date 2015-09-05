var editor = ace.edit("editor");
editor.setTheme("ace/theme/monokai");

var commentButton = $( "#btn-comment" );
var modificationButton = $( "#btn-modification" );

var commentPanel = $( "#panel-comment" );
var modificationPanel = $( "#panel-modification" );

var commentSubmitButton = $( "#btn-comment-submit" );
var modificationSubmitButton = $( "#btn-modification-submit" );

function changeScore(data, status, voteElement){
    var scoreText = voteElement.find(".score");
    console.log(data);
    scoreText.text(data);
}

function displayVote(voteElement, voteType, replyId){
    var notType;
    switch (voteType){
        case ("+"):
            voteType = "up";
            notType = "down";
            break;
        case ("-"):
            voteType = "down";
            notType = "up";
            break;
    }

    var voteButton = voteElement.find("[data-type='" + voteType + "']").find('i');
    var otherVoteButton = voteElement.find("[data-type='" + notType + "']").find('i');

    if (voteType == "up"){
        voteButton.addClass('text-success');
        otherVoteButton.removeClass('text-danger');
    }else{
        voteButton.addClass('text-danger');
        otherVoteButton.removeClass('text-success');
    }

    var url = '/vote/' + replyId + '/score';

    $.ajax({
        method: "GET",
        url: url,
        success: function(data, status){
            changeScore(data, status, voteElement)
        }
    });

}

function submitReply(data){
    $.ajax({
        url: "/s/" + data["slug"] + "/reply",
        type: 'POST',
        contentType: "application/x-www-form-urlencoded",
        data: data,
        headers: {
            'X-CSRF-Token': data["_token"]
        },
        success: function(data, textStatus ){
            location.reload();

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
}

commentButton.click(function(){
    modificationPanel.hide();
    commentPanel.fadeIn()
    getField("message").focus();
});

modificationButton.click(function(){
    commentPanel.hide();
    modificationPanel.fadeIn();
    editor.focus();
});

commentSubmitButton.click(function(){
    console.log("comment submit");
    var submission = {};
    submission["_token"] = $('input[name=_token]').val();
    submission["message"] = getField("message").val();
    submission["modification"] = false;
    submission["slug"] = getField("slug").val();

    submitReply(submission);
});

modificationSubmitButton.click(function(){
    var submission = {};
    console.log("modification submit");
    submission["_token"] = $('input[name=_token]').val();
    submission["code"] = editor.getValue();
    submission["message"] = getField("modification-message").val();
    submission["modification"] = true;
    submission["slug"] = getField("slug").val();

    submitReply(submission);
});


$( ".vote" ).click(function(){
    var voteButton = $(this);
    var replyId = voteButton.data('id');
    var voteType = voteButton.data('type');
    var url = "/vote/" + replyId + "/" + voteType;

    $.ajax({
        method: "GET",
        url: url,
        success: function(data){
            displayVote(voteButton.parent(), data.type, replyId);
        }
    });


});