function ajax_post() {
  var hr = new XMLHttpRequest();
  var url = "send.php";
  var fn = document.getElementById("msg").value;
  var vars = "msg=" + fn;
  hr.open("POST", url, true);
  hr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  hr.onreadystatechange = function() {
    if (hr.readyState == 4 && hr.status == 200) {
      var return_data = hr.responseText;
      document.getElementById("chat").innerHTML = return_data;
    }
  }
  hr.send(vars);
  //var snd = new Audio('../chat/sounds/msn.mp3');
  //snd.play();
  document.getElementById("msg").value = "";
}

function loadChat() {
  setInterval(function() {
    showChat();
  }, 500);
}

function showChat() {
  var hr = new XMLHttpRequest();
  var url = "send.php";
  hr.open("POST", url, true);
  hr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  hr.onreadystatechange = function() {
    if (hr.readyState == 4 && hr.status == 200) {
      var return_data = hr.responseText;
      localStorage.setItem("msg", return_data);
      if(localStorage.getItem("msg") != localStorage.getItem("oldmsg")) {
        var snd = new Audio('./sounds/msn.mp3');
        snd.play();
        localStorage.setItem("oldmsg", localStorage.getItem("msg"));
      }else if(localStorage.getItem("oldmsg") == null) {
        localStorage.setItem("oldmsg", localStorage.getItem("msg"));
      }

      document.getElementById("chat").innerHTML = return_data;
    }
  }
  hr.send();
}

function events() {
  document.getElementById("msg")
    .addEventListener("keyup", function(event) {
      event.preventDefault();
      if (event.keyCode == 13) {
        document.getElementById("senden").click();
      }
    });
  loadChat();

}

window.addEventListener("load", events);
