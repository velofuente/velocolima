function scheduleByInstructor() {
  var selectInstructor = document.getElementById("ScheduleInstructor").value;
  console.log(selectInstructor);
  var scheduleBox = document.getElementsByClassName("scheduleItem");

  if (selectInstructor == "allInstructors"){
      for (let item of scheduleBox){
          item.style.display = 'block';
      }
  } else {
      for (let item of scheduleBox){
          if (selectInstructor === item.id){
              item.style.display = 'block';
          }
          else {
              item.style.display = 'none';
          }
      }
  }
}