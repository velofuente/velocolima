function tableCreate(){
    var table = $("<table>").attr("id", "tableBicis").attr("class", "table");
    var number_of_rows = 8;
    var number_of_cols = 8;
    var tbody = $("<tbody>").attr("id", "bodyTableBicis");
    var firstChar = "a";
    for (var i = 0; i < number_of_rows; i++){
        var trow = $("<tr>").attr("id", firstChar);
        for (var j = 0; j < number_of_cols; j++){
            var td = $("<td>").attr("id", firstChar + "" + j);
            var bicycle = $("<p>").attr("class", "bikes").text(firstChar + "" + j);
            td.append(bicycle);
            trow.append(td);
        }
        firstChar = nextChar(firstChar);
        tbody.append(trow);

    }

    function nextChar(c) {
        return String.fromCharCode(c.charCodeAt(0) + 1);
    }



    table.append(tbody);
    $("#dinamicTable").append(table);
    

    // for(var i = 0; i < 3; i++){
    //     var tr = tbl.insertRow();
    //     for(var j = 0; j < 2; j++){
    //         if(i == 2 && j == 1){
    //             break;
    //         } else {
    //             var td = tr.insertCell();
    //             td.appendChild(document.createTextNode('Cell'));
    //             td.style.border = '1px solid transparent';
    //             if(i == 1 && j == 1){
    //                 td.setAttribute('rowSpan', '2');
    //                 td.id = 12;
    //             }
    //         }
    //     }
    // }
    // body.appendChild(tbl);
}
tableCreate();



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
        location.href='#packages';
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
