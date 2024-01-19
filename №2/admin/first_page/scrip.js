function updateTimeAndDate() {
  var timeElement = document.getElementById("time");
  var dateElement = document.getElementById("date");

  var currentTime = new Date();

  var hours = currentTime.getHours().toString().padStart(2, "0");
  var minutes = currentTime.getMinutes().toString().padStart(2, "0");
  var seconds = currentTime.getSeconds().toString().padStart(2, "0");

  var month = (currentTime.getMonth() + 1).toString().padStart(2, "0");
  var day = currentTime.getDate().toString().padStart(2, "0");
  var year = currentTime.getFullYear();

  var timeString = hours + ":" + minutes + ":" + seconds;
  var dateString = day + "/" + month + "/" + year;

  timeElement.innerHTML = timeString;
  dateElement.innerHTML = dateString;
}

setInterval(updateTimeAndDate, 1000);

//скрипт на переход на другие страницы
function goToPage(page) {
 window.location.href = page;
}