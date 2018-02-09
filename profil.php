<hmtl>
<head>
<title>Profil</title>
<meta charset="utf-8" />
<link rel="stylesheet" href="./css/main.css">
</head>

<body>

<?php
session_start();

if(isset($_SESSION['login'])) {
require_once ($_SERVER['DOCUMENT_ROOT'] . "/chat/classes/class_chat.php");

$chat = new chat();

echo "<p>";
echo "Profil von ";
echo $chat->getBenutzerName($_SESSION['login']);
echo "</p>";

echo "
<form method='post'>
<table>
<tr>
<td>Namen ändern:</td>
<td><input type='button' name='umbennen' value='Start' /></td>
</tr>

<tr>
<td>Passwort ändern:</td>
<td><input type='button' name='pass_aendern' value='Start' /></td>
</tr>

</table>
</form>
";
echo "<form method='post'><input type='submit' value='Ausloggen' name='ausloggen' /></p></form>";

if(isset($_POST['ausloggen'])) {
  $chat->abmelden();
}
echo "<p><a href='chat.php'>Zurück zum Chat</a></p>";


}else{
header("Location: ./login.php");
}

?>

</body>

  </html>
