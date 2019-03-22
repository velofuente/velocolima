
var packages = $('.content-n');

packages.on({
    mouseenter: function(ev){
        $(this).animate({
            backgroundColor: "#3accd5",
            color: "#c4f0f2"
          }, 500 );
    },
    mouseleave: function(ev){
        $(this).animate({
            backgroundColor: "#ffffff",
            color: "#000000"
          }, 0 );
    }
});

function classQuantity(x) {
    if (x >= 3) {
        document.getElementById("exampleModalLongTitle").innerHTML = "Comprar "+x+" clases";
    } else {
        document.getElementById("exampleModalLongTitle").innerHTML = "Comprar "+x+" clase";
    }
}