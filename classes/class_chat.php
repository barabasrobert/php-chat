<?php

require_once ($_SERVER['DOCUMENT_ROOT'] . "/chat/includes/datenbank.php");

class chat {

  public $db, $datenbank;

  function __construct() {
    $this->datenbank = new datenbank();
    $this->db = $this->datenbank->getDB();
  }



  function registrieren($benutzername, $passwort, $passwort2) {
    $timestamp = $this->getTimeStamp();

    if($passwort2 === $passwort) {
      $hashed_password = $this->passwordEncryption($passwort);
      $sql = "INSERT INTO user_account (id, name, hashed_password, created)
      VALUES ('NULL','$benutzername','$hashed_password','$timestamp')";
    }else {
      echo "<p style='color: red;'>Passwörter stimmen nicht überein!</p>";
      return false;
    }

    if($this->db->query($sql)) {
      $nutzerID = $this->getBenutzerID($benutzername);
      $_SESSION['login'] = $nutzerID;
      header("Location: ./login.php");
      return true;
    } else {
      echo "<p style='color: red;'>Fehler! Nutzername schon vorhanden!</p>";
      return false;
    }
  }


//Funktion zum Anmelden
  function anmeldung($benutzername, $passwort) {
    $hashed_password = $this->passwordEncryption($passwort);

    $sql = "SELECT count(*)
            FROM user_account
            WHERE hashed_password = '$hashed_password'
            AND name = '$benutzername'
            AND ban_status = 0";

    $userAmountArray = $this->db->query($sql);

    while ($value = $userAmountArray->fetch_row()) {
      $auth = $value[0];
    }

    if ($auth == '1') {
      // Wenn nur ein Eintrag vorhanden ist (Nutzername und Passwort sind )
      $nutzerID = $this->getBenutzerID($benutzername);
      $_SESSION['login'] = $nutzerID;
      header("Location: ./chat.php");

    }else if ($auth == '0'){
      // Wenn kein Eintrag vorhanden ist
      echo "<script>alert('Login fehlerhaft oder das Nutzerkonto wurde gebannt!');</script>";
    } else {
      echo "<script>alert('Anderes Problem!');</script>";
    }
  }



  // Funktion zum Abmelden aus einer Session.
  function abmelden() {
    session_unset();
    session_destroy();
    header("Location: ../chat/login.php");
  }


  // Funktion zum Generieren eines Passworts
  function passwordEncryption($passwort) {
    $hashed_password = md5($passwort);
    return $hashed_password;
  }




  // Funktion zum Abfragen der Benutzer-ID zum
    function getBenutzerID($nutzername) {
      $sql = "SELECT id
              FROM user_account
              WHERE name = '$nutzername'";
      $ID_get = $this->db->query($sql);

      while ($value = $ID_get->fetch_row()) {
        $id = $value[0];
      }
      return $id;
    }



    // Funktion zum Abfragen des Benutzername durch die ID
    function getBenutzerName($nutzerID) {
      $sql = "SELECT name
              FROM user_account
              WHERE id = '$nutzerID'";
      $Name_get = $this->db->query($sql);

      while ($value = $Name_get->fetch_row()) {
        $name = $value[0];
      }
      return $name;
    }


    // Funktion zum Abfragen des Timestamps
    function getTimeStamp() {
      $timestamp = $this->db->query('SELECT CURRENT_TIMESTAMP');
        while($row = $timestamp->fetch_row()){
          $current_timestamp = $row[0];
      }
      return $current_timestamp;
    }


    function checkMessage($msg) {

      switch ($msg) {
        case strlen($msg) < 2:
          return 0;
          break;

        case strlen($msg) > 2:
          return 1;
          break;

        default:
        return 0;
          break;
      }
}

      function checkDate() {

        $user_id = $_SESSION['login'];

        $sql = "SELECT created
                FROM messages
                WHERE user_id = $user_id
                ORDER BY created
                DESC LIMIT 1";

      $getLastDate = $this->db->query($sql);
      $datum = 0;
      while ($value = $getLastDate->fetch_object()) {
        $datum = $value->created;
          }

          $zeitstempel_sql = date('l dS \o\f F Y h:i:s A', strtotime($datum." + 2 seconds"));

          $aktuelleZeit = date('l dS \o\f F Y h:i:s A', strtotime("now"));

          if($aktuelleZeit > $zeitstempel_sql) {
            return true;
          }else {
            return false;
          }


      }


    function sendMessage($msgg) {
      $msg = htmlspecialchars($msgg);

      if($this->checkMessage($msg) == '1' && $this->checkDate() == true && isset($_SESSION['login'])) {

      $benutzerID = $_SESSION['login'];
      $timestamp = $this->getTimeStamp();
      $sql = "INSERT INTO messages(user_id, message, created)
              VALUES ($benutzerID,'$msg','$timestamp')";
      $this->db->query($sql);
      }
    }


    //Zeigt den Chat an.
    function showChat() {
      $anzeige = "SELECT *
                  FROM messages
                  ORDER BY id DESC
      						LIMIT 50";

      $result = $this->db->query($anzeige);


      $user_id;

      while ($row = $result->fetch_object()){
        $userName = $this->getBenutzerName($row->user_id);
        $user_id = $row->user_id;

        echo "<p'>$row->created |
              <b>$userName:</b>
              <span>$row->message</span></p>";
              }


         $sql_zeit = "SELECT created
                      FROM messages
                      WHERE user_id = $user_id
                      ORDER BY created
                      DESC LIMIT 1";
            $getLastDate = $this->db->query($sql_zeit);

            while ($value = $getLastDate->fetch_row()) {
              $zeit = $value[0];
                }
                $aktuelleZeit = date('l dS \o\f F Y h:i:s A', strtotime("now"));
                if($zeit == $aktuelleZeit) {
                  echo "<p>Test1</p>";
                }
            }

}

?>
