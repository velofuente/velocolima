function classQuantity(x) {
    if (x >= 3) {
        document.getElementById("exampleModalLongTitle").innerHTML = "Comprar " + x + " clases";
    } else {
        document.getElementById("exampleModalLongTitle").innerHTML = "Comprar " + x + " clase";
    }
}
var hamburger = $('.hamburger');
hamburger.css("padding", "0em .9em");
hamburger.css("z-index", "3");
hamburger.click(function () {
    $(this).toggleClass('is-active');

    if ($('#hambBtn').hasClass('is-active')) {
        $('#myNav').height('100%');
        $('body').css('overflow-y', 'hidden');
    } else {
        $('#myNav').height('0%');
        $('body').css('overflow-y', 'auto');
    }
});

$(document).on("click", ".overlay-content", function () {
    hamburger.toggleClass('is-active')
    $('#myNav').height('0%');
    $('body').css('overflow-y', 'auto');
});
