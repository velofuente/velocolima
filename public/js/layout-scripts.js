
$(function () {
//   $('[data-toggle="tooltip"]').tooltip()
})

// var packages = $('.content-n');

// packages.on({
//     mouseenter: function(ev){
//         $(this).animate({
//             backgroundColor: "linear-gradient(0.25turn, #F70E0E, #9100FF);",
//             color: "#c4f0f2"
//           }, 500 );
//     },
//     mouseleave: function(ev){
//         $(this).animate({
//             backgroundColor: "#ffffff",
//             color: "#000000"
//           }, 0 );
//     }
// });

function classQuantity(x) {
    if (x >= 3) {
        document.getElementById("exampleModalLongTitle").innerHTML = "Comprar "+x+" clases";
    } else {
        document.getElementById("exampleModalLongTitle").innerHTML = "Comprar "+x+" clase";
    }
}
var hamburger = $('.hamburger');
hamburger.css("padding", "0em .9em");
hamburger.css("z-index", "3");
hamburger.click(function(){
    $(this).toggleClass('is-active');

    if($('#hambBtn').hasClass('is-active')){
        $('#myNav').height('100%');
    }
    else{
        $('#myNav').height('0%');
    }
});
