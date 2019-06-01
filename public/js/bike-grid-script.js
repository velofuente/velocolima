function drawMainBikes(rows,cols){
    var bikesContainer = $("#bikes-div");

    var number_of_rows = rows;
    var number_of_cols = cols;
    var count = 1;
    for (var i = 0; i < number_of_rows; i++){
        var divr = $("<div>").attr("id", "divr" + i).attr("class", "col-md-12");
        for (var j = 0; j < number_of_cols; j++){
            var classes = "bikes common";
            var ball = $("<span>").attr("class", classes).attr("id", "ball-" + count).text(count);
            divr.append(ball);
            count++;
        }
        bikesContainer.append(divr);
    }
}

//IMPORTANTE
drawMainBikes();

var selected;
$(document).on("click", ".common", function(e) {
    e.preventDefault();
    if ($(this).hasClass('bikes')) {
        $(this).removeClass('bikes');
        $(this).addClass('disabled');
    } else if ($(this).hasClass('disabled')) {
        $(this).removeClass('disabled');
        $(this).addClass('instructor');
    } else if($(this).hasClass('instructor')){
        $(this).removeClass('instructor');
        $(this).addClass('bikes');
    }
});

function sendGrid(){
    var disabled_bikes = $( ".disabled" );
    var instructor_bike = $( ".instructor" );
}
