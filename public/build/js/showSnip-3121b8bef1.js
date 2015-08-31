var editor = ace.edit("editor");
editor.setTheme("ace/theme/monokai");

var commentButton = $( "#btn-comment" );
var modificationButton = $( "#btn-modification" );

var commentPanel = $( "#panel-comment" );
var modificationPanel = $( "#panel-modification" );

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
//# sourceMappingURL=showSnip.js.map