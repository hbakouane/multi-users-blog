// When the user scrolls the page, Show a top progress bar
window.onscroll = function() {myFunction()};

function myFunction() {
    var winScroll = document.body.scrollTop || document.documentElement.scrollTop;
    var height = document.documentElement.scrollHeight - document.documentElement.clientHeight;
    var scrolled = (winScroll / height) * 100;
    document.getElementById("myBar").style.width = scrolled + "%";
}
function checkUsername(value) {
    if (value.indexOf(' ') >= 0) {
        document.getElementById("username_warning").style.display="block";
        document.getElementById("submit").disabled=true;
    } else {
        document.getElementById("submit").disabled=false;
        document.getElementById("username_warning").style.display="none";
    }
}