document.getElementById("buy").onclick = function() {packages()};
var packs = document.getElementById("packages");
function packages() {
    window.location.href="/home";
    packs.scrollIntoView();
}