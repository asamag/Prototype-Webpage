$.PostComment = function(){
    var headline = document.getElementById("headline").value;
    var txt = document.getElementById("txt").value;
    var img = document.getElementById("img").files[0];
    var fd = new FormData();
    fd.append("headline", headline);
    fd.append("img", img);
    fd.append("txt", txt);
    $.ajax({
        type: "POST",
        url: 'process-comment.php',
        data: fd,
        contentType: false,
        processData: false,
        success: function(data){
            if(data == 0){
                $("#recipe").hide();
                $.get("comments.php", function(comments){
                   $("#comments").html(comments);
                   $("#headline").val("");
                   $("#txt").val("");
                   $("#img").val("");
                });
            }
            else {
                alert("Bilden gick inte att ladda upp! Välj en annan fil");
            }
        }
    });
}
function ValidatePost(){
    if(validatePostForm()){
        $.PostComment();
    }
    else{
        return false;
    }
}