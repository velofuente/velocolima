import { selectAll } from "css-select";

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