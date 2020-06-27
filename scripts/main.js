// DISPLAY NUMBER OF UPLOADS
$("body").on("change", function(){
    var something = document.getElementById("files")
    var numFiles = $(something,this)[0].files.length;
    document.getElementById("number").innerHTML=numFiles;
});