var bikes = $('.bikes');
var selected;
bikes.click(function() {
    if ($(this).hasClass('bikes')) {
        selected = $('.selected');
        selected.removeClass('selected');
        selected.addClass('bikes');
        $(this).removeClass('bikes');
        $(this).addClass('selected');
        $('#placeNum').html($(this).text());
    } else {
        $(this).removeClass('selected');
        $(this).addClass('bikes');
        $('#placeNum').html('--');
    }
});

document.getElementById('date').innerHTML = document.getElementById('date').innerHTML.toLocaleUpperCase();

document.getElementById('branch').innerHTML = document.getElementById('branch').innerHTML.toLocaleUpperCase();

$('#profilePic').click(function(){
    document.location.href = "/instructors";
});
