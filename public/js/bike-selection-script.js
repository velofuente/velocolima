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

var date = document.getElementById('date').innerHTML;
var splitDate = date.split(" ");
var day = splitDate[0].charAt(0).toUpperCase();
var month = splitDate[3].charAt(0).toUpperCase();

var modifiedDate = day + splitDate[0].slice(1) +" "+ splitDate[1]+" "+ splitDate[2]+" "+ month + splitDate[3].slice(1) +" "+ splitDate[4]+" "+ splitDate[5];
document.getElementById('date').innerHTML = modifiedDate;


