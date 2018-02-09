<html>
<head>
<link rel="stylesheet" href="./css/main.css">
<script src="./javascript/script.js"></script>

</head>

<body>

  <?php
  session_start();
    require_once ($_SERVER['DOCUMENT_ROOT'] . "/chat/classes/class_chat.php");

    $chat = new chat();

    if(isset($_SESSION['login'])) {

    	echo "<p>Willkommen, <b><a href='./profil.php'>";
      echo $chat->getBenutzerName($_SESSION['login']);
      echo "</a></b>, Ihre IP-Adresse lautet: ".$_SERVER["REMOTE_ADDR"];
      echo "</p>";

  ?>

	<p>Nachricht: <input type="text" name="msg" id="msg" maxlength="300" minlength="3" autocomplete="off" autofocus />
								<input type="button" id="senden" value="Senden" onclick="ajax_post();" />
  </p>


  <div id='chat'></div>

<?php
} else {
  echo "
  <p>Nicht angemeldet! <a href='./login.php'>Anmelden?</a></p>";
}
  ?>

</body>
</html>
