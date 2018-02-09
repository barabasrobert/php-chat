

<html>

<head>
</head>

<body>
<?php
session_start();

require_once ($_SERVER['DOCUMENT_ROOT'] . "/chat/classes/class_chat.php");

$chat = new chat();


if(isset($_POST['msg']) && $_POST['msg'] != "") {
  $chat->sendMessage($_POST['msg']);
}

$chat->showChat();

?>



</body>


</html>
