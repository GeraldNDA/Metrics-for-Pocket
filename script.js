var count, test;
function increment(speed, total)
{
  speed = speed/0.05;
  increment = Math.floor(total/speed);
  test = setInterval(incrementTest, 50, increment, total);
  document.getElementById("swag").innerHTML = 0;
}
function incrementTest(amount, total)
{
  
  count = parseInt(document.getElementById("swag").innerHTML);
  amount = Math.floor((Math.random() * amount))
  if (total - count < amount)
    {
       amount = Math.floor((Math.random() * (total - count)))
    }
  if(count < total){
  document.getElementById("swag").innerHTML = count + amount;
  }
  else
    {
      clearInterval(test);
      if(count === 0 && location.search == "?redirect=done")
      {
        document.getElementById("swag").style.color = "#E94055"
      }
      else
      {
        document.getElementById("swag").style.color = "rgb(128, 255, 128)"
      }
    }
}
function addList(){
    var list = document.getElementById("courses");
    var course = document.getElementById("CourseAdd").value;
    if (course && student.courses.indexOf(course) == -1) {
        student.courses.push(course);
        var entry = document.createElement('li');
        var revEntry = document.createElement('li');

        var del = document.createElement("button");
        del.setAttribute("class", "remove");
        del.onclick = function() {
            // same content other than button tag? Deleted.
            var course = this.parentNode.innerHTML.slice(0, -32);
            this.parentNode.parentNode.removeChild(this.parentNode);
            for (var i = 0; i < $("#revCourses")[0].children.length; i++) {
                if ($("#revCourses li")[i].innerHTML == course) {
                    $("#revCourses")[0].removeChild($("#revCourses li")[i]);
                    student.courses.splice(i,1);
                    break;
                }
            }
        };

        entry.innerHTML = course;
        revEntry.innerHTML = course;

        entry.appendChild(del);
        list.appendChild(entry);
        $("#revCourses")[0].appendChild(revEntry);
    }

}
window.onload = function(){
  
  document.getElementById("swag").innerHTML = pocketCount;
  increment(2, document.getElementById("swag").innerHTML);
  //band-aid
  window.history.replaceState( {} , "Metrics for Pocket", "/");
 //TO-DO:
   //Save time of last update ...
   //Save count as default number
   // Add improved parsing for increased info (i.e. info about tags etc.)
   
}