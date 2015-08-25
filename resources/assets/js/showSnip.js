var editor = ace.edit("editor");
editor.setTheme("ace/theme/monokai");

var commentButton = $( "#btn-comment" );
var modificationButton = $( "#btn-modification" );

var commentPanel = $( "#panel-comment" );
var modificationPanel = $( "#panel-modification" );

commentButton.click(function(){
    modificationPanel.hide();
    commentPanel.fadeIn()
});

modificationButton.click(function(){
    commentPanel.hide();
    modificationPanel.fadeIn();
});
