import { selectAll } from "css-select";

var bikes = $('.bikes');
var selected = $('.selected');

bikes.click(function() {
    $(this).toggleClass('bikes');
    $(this).toggleClass('selected');
    $('#placeNum').html($(this).text());
    selectAll
});


