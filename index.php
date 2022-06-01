<?php
if (isset($_POST["crr"])) {
  $contact = new PDO("mysql:host=localhost;dbname=game;", "root", "");
  $room = $contact->prepare("INSERT INTO `play` (room , Pone) VALUE (:room , :pone)");
  $room->bindParam("room", $_POST["room"]);
  $room->bindParam("pone", $_POST["Pone"]);
  $room->execute();
  $chkPwo = "";
  echo "<div class='start loa'>
        <div class='load'></div>
      </div>";
  while ($chkPwo == "") {
    sleep(5);
    $name = $contact->prepare("SELECT Ptwo FROM play Where Pone = :pone AND room = :room");
    $name->bindParam("pone", $_POST["Pone"]);
    $name->bindParam("room", $_POST["room"]);
    $name->execute();
    foreach ($name as $key) {
      if ($key["Ptwo"] != "") {
        $chkPwo = $key["Ptwo"];
      }
    }
  }
  header("Location:http://localhost:8012/XO/online.php?done=1&create=1&room=" . $_POST["room"] . "&Pone=" . $_POST["Pone"]);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="initial-scale=1.0">
  <link rel="stylesheet" href="./XO.css">
  <title>XO-GAME</title>
</head>

<body>
  <div class="player" id="player">
    <span class="one" id="one">
      <span id="reso">0</span>
    </span><br />
    <span class="two" id="two">
      <span id="resx">0</span>
    </span>
  </div>
  <div class="start" id="start">
    <form class="line" id="line">
      <button type="submit" class="btn" id="on">Oline</button><br />
      <button type="submit" class="btn" id="off">Offline</button>
    </form>
    <form action="index.php" class="on" id="online" method="post">
      <button type="submit" class="btn" id="cr" name="cr">Create Room</button><br />
      <a href="http://localhost:8012/XO/online.php?join=2" class="btn a">Join Room</a>
    </form>
    <form action="index.php" method="post" class="create" id="create">
      Room Name <input type="text" name="room" id="room" required><br />
      Your Name <input type="text" name="Pone" id="Pone" required><br />
      <button type="submit" class="btn" name="crr" id="crr">Create Room</button>
    </form>
    <form class="off" id="offline">
      Player-O <input type="text" id="nameO"><br />
      Player-X <input type="text" id="nameX"><br />
      <button type="submit" class="btn" id="btn">Start</button>
    </form>
  </div>
  <div class="body">
    <div class="area" data-num="1"><span class="sub">-</span></div>
    <div class="area" data-num="2"><span class="sub">-</span></div>
    <div class="area" data-num="3"><span class="sub">-</span></div>
    <div class="area" data-num="4"><span class="sub">-</span></div>
    <div class="area" data-num="5"><span class="sub">-</span></div>
    <div class="area" data-num="6"><span class="sub">-</span></div>
    <div class="area" data-num="7"><span class="sub">-</span></div>
    <div class="area" data-num="8"><span class="sub">-</span></div>
    <div class="area" data-num="9"><span class="sub">-</span></div>
  </div>
  <div class="over" id="over"></div>
  <div class="end" id="endW">
    The player
    <span id="winner"></span>
    is the winner
    <br>
    <form action="" method="get">
      <form method="get">
        <button type="submit" class="btn">New Mathch</button>
        <button type="submit" class="btn" id="AgainW">Same Player's</button>
      </form>
    </form>
  </div>
  <div class="end" id="endE">
    Equality
    <form action="" method="get">
      <button type="submit" class="btn">New Mathch</button>
      <button type="submit" class="btn" id="AgainE">Same Player's</button>
    </form>
  </div>
</body>
<script src="./XO.js"></script>

</html>