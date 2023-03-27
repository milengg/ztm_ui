function displayTime() {
    // Get the current time
    var currentTime = new Date();
  
    // Extract the current hours, minutes, and seconds
    var hours = currentTime.getHours();
    var minutes = currentTime.getMinutes();
    var seconds = currentTime.getSeconds();
  
    // Convert the hours, minutes, and seconds to strings and add leading zeros if necessary
    hours = (hours < 10) ? "0" + hours : hours;
    minutes = (minutes < 10) ? "0" + minutes : minutes;
    seconds = (seconds < 10) ? "0" + seconds : seconds;
  
    // Get the current month as a word in the Cyrillic script
    var months = ["ЯНУАРИ", "ФЕВРУАРИ", "МАРТ", "АПРИЛ", "МАЙ", "ЮНИ", "ЮЛИ", "АВГУСТ", "СЕПТЕМВРИ", "ОКТОМВРИ", "НОЕМВРИ", "ДЕКЕМВРИ"];
    var month = months[currentTime.getMonth()];
  
    // Get the current date and year in the Cyrillic script
    var date = currentTime.getDate() + " " + month + " " + currentTime.getFullYear().toLocaleString("bg-BG");
  
    // Display the time, date, and year in the appropriate element on the page
    document.getElementById("clock").innerHTML = hours + "<span class='blink'>:</span>" + minutes;
    document.getElementById("date").innerHTML = date;
}
  
// Call the displayTime function every 1000 milliseconds (1 second)
setInterval(displayTime, 1000);