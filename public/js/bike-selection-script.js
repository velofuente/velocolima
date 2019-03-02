var bikes = $('.bikes');
$(bikes).click(function() {
    $(this).toggleClass('bikes');
    $(this).toggleClass('selected');
    $('#placeNum').html(bikes.text());
});
