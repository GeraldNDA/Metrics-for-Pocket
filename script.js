var count;
var intervalID;
function countAnimate(speed, total)
{
  speed = speed/0.05;
  var increment = Math.floor(total/speed);
  if(interval < 1) {
	  interval = 1;
  }
  intervalID = setInterval(incrementTest, 50, increment, total);
  document.getElementById("swag").innerHTML = 0;
}
function incrementTest(amount, total)
{
  
  count = parseInt(document.getElementById("swag").innerHTML);
  if(amount > 1) {
  amount = Math.floor((Math.random() * amount));
  } else {
	  amount = 1;
  }
  if (total - count < amount)
    {
       amount = Math.floor((Math.random() * (total - count)));
    }
  if(count < total){
  document.getElementById("swag").innerHTML = count + amount;
  }
  else
    {
      clearInterval(intervalID);
      if(count === 0 && location.search == "?redirect=done")
      {
        document.getElementById("swag").style.color = "#E94055";
      }
      else
      {
        document.getElementById("swag").style.color = "rgb(128, 255, 128)";
      }
    }
}
window.onload = function(){
	document.getElementById("swag").innerHTML = pocketCount;
	countAnimate(2, pocketCount);
	//band-aid
	window.history.replaceState("", "Metrics for Pocket", location.href.split("?")[0]);
	//TO-DO:
	//Save time of last update ...
	//Save count as default number
	// Add improved parsing for increased info (i.e. info about tags etc.)
};