document.getElementById("buy").onclick = function() {packages()};
var packs = document.getElementById("packages");
function packages() {
    window.location.href="/home";
    packs.scrollIntoView();
}

function classQuantity(x) {
    if (x >= 3) {
        document.getElementById("exampleModalLongTitle").innerHTML = "Comprar "+x+" clases";
    } else {
        document.getElementById("exampleModalLongTitle").innerHTML = "Comprar "+x+" clase";
    }
}