<html>

<head>
<title>Login</title>
<meta charset="utf-8" />
<link rel="stylesheet" href="./css/main.css">
</head>

<body>

<?php
session_start();

require_once ($_SERVER['DOCUMENT_ROOT'] . "/chat/classes/class_chat.php");

$chat = new chat();

  if(!isset($_SESSION["login"])) {
    echo "
    <form method=post>
    <table>
    <tr><td>Nutzername:</td><td><input type='text' name='nutzername' required/></td></tr>
    <td>Passwort: </td><td><input type='password' name='passwort' required/></td></tr>

    <tr><td><input type='submit' name='anmelden' value='Senden' /></td></tr>
    </table>
    </form>
    <p>Nicht registriert? Erstelle dein Account einfach <a href=./registrieren.php>hier</a>!</p>
    ";
  } else {
  header("Location: ./chat.php");
}

if(isset($_POST['nutzername'], $_POST['passwort'])) {
  $nutzername = $_POST['nutzername'];
  $passwort = $_POST['passwort'];

  $chat->anmeldung($nutzername, $passwort);
}


?>

</body>


</html>
