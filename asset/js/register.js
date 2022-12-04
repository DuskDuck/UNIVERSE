$(document).ready(function() {
    //On clikc sign up hide login and show register form
    $("#signup").click(function() {
        $("#first").slideUp("slow",function() {
            $("#second").slideDown("slow");
        });
    });
    $("#signin").click(function() {
        $("#second").slideUp("slow",function() {
            $("#first").slideDown("slow");
        });
    });
});