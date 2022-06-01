<!-- <?php
$contact = new PDO("mysql:host=localhost;dbname=game;", "root", "");
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="./XO.css">
  <title>Document</title>
</head>

<body>
  <div class="over" id="over"></div>
  <div class="player" id="player">
    <?php
    $result = $contact->prepare("SELECT winner FROM `play` WHERE room=:r AND (Pone=:o or Ptwo=:t)");
    $result->bindParam("r", $_GET["room"]);
    $result->bindParam("o", $_GET["Pone"]);
    $result->bindParam("t", $_GET["Ptwo"]);
    $result->execute();
    foreach ($result as $res) {
      $thefinal = str_split($res["winner"]);
      $o = 0;
      $t = 0;
      for ($i = 0; $i < count($thefinal); $i++) {
        if ($thefinal[$i] == 1)
          $o++;
        elseif ($thefinal[$i] == 2)
          $t++;
      }
      echo '<span class="one" id="one">
      <span id="resO">' . $o . '</span>
    </span><br />
    <span class="two" id="two">
      <span id="resX">' . $t . '</span>
    </span>';
    }

    ?>
  </div>
  <script>
  let po = document.getElementById("one");
  let px = document.getElementById("two");
  let O = [];
  let X = [];
  over = document.getElementById("over");

  function up() {
    if (typeof p_o == "undefined" && typeof p_x == "undefined") {
      if (p_o == "") {
        p_o = "Player ONE-O";
      } else po.prepend(p_o + " :");
      if (p_x == "") {
        p_x = "Player TWO-X";
        px.prepend(p_x + " :");
      } else px.prepend(p_x + " :");
    } else {
      start.style.display = "none";
      po.prepend(p_o + " :");
      px.prepend(p_x + " :");
    }
  }

  function allow(n) {
    if (n % 2 == 0) {
      over.style.display = "block";
    }
    if (n % 2 == 1) {
      over.style.display = "none";
    }
  }
  </script>
  <div class="start" id="start">
    <form action="online.php" method="post" class="join" id="join">
      <?php
      if (isset($_GET["join"])) {
        echo 'Your Name : <input type="text" name="Ptwo" id="Ptwo" required><br>';
        $room = $contact->prepare("SELECT room FROM play");
        $room->execute();
        echo "<div class='ul'>";
        foreach ($room as $value) {
          $str = "<input type='radio' requird name='room' value='" . $value["room"] . "' id='tables' class='tables'> " .
            $value["room"] . "<br>";
          echo $str;
        }
        echo "</div>";
        echo "<button type='submit' class='btn' id='enter' name='enter'>Enter</button>";
      }
      if (isset($_POST["enter"])) {
        $sesionRome = $_POST["room"];
        $sesionPtwo = $_POST["Ptwo"];
        $other = $contact->prepare("UPDATE `play` SET `Ptwo`= :ptwo WHERE room = :room");
        $other->bindParam("ptwo", $_POST["Ptwo"]);
        $other->bindParam("room", $sesionRome);
        $other->execute();
        header("Location:http://localhost:8012/XO/online.php?join=2&done=1&room=$sesionRome&Ptwo=$sesionPtwo");
      }
      if (isset($_GET["done"])) {
        $ingo = $contact->prepare("SELECT * FROM play WHERE room = :r AND Ptwo = :t");
        $ingo->bindParam("r", $_GET["room"]);
        $ingo->bindParam("t", $_GET["Ptwo"]);
        $ingo->execute();
        foreach ($ingo as $val) {
          echo "<script>
          let p_o = '" . $val["Pone"] . "',
            p_x = '" . $val["Ptwo"] . "';
          start.style.display = 'none';
          up();
          </script>";
          if (checkwiner($_GET["room"], $val["Pone"], $val["Ptwo"]) == 2) {
            $thewinner = $contact->prepare("UPDATE play SET winner=CONCAT(winner , 2) WHERE room=:r AND Pone=:o AND Ptwo=:t");
            $thewinner->bindParam("r", $_GET["room"]);
            $thewinner->bindParam("o", $val["Pone"]);
            $thewinner->bindParam("t", $val["Ptwo"]);
            $thewinner->execute();
          }
          chkAlo($val["Pone"], $val["Ptwo"]);
          if (isset($_POST["one"])) {
            changedb($_GET["room"], $val["Pone"], $val["Ptwo"], 1, 2);
          } else if (isset($_POST["two"])) {
            changedb($_GET["room"], $val["Pone"], $val["Ptwo"], 2, 2);
          } else if (isset($_POST["three"])) {
            changedb($_GET["room"], $val["Pone"], $val["Ptwo"], 3, 2);
          } else if (isset($_POST["four"])) {
            changedb($_GET["room"], $val["Pone"], $val["Ptwo"], 4, 2);
          } else if (isset($_POST["five"])) {
            changedb($_GET["room"], $val["Pone"], $val["Ptwo"], 5, 2);
          } else if (isset($_POST["six"])) {
            changedb($_GET["room"], $val["Pone"], $val["Ptwo"], 6, 2);
          } else if (isset($_POST["seven"])) {
            changedb($_GET["room"], $val["Pone"], $val["Ptwo"], 7, 2);
          } else if (isset($_POST["eight"])) {
            changedb($_GET["room"], $val["Pone"], $val["Ptwo"], 8, 2);
          } else if (isset($_POST["nine"])) {
            changedb($_GET["room"], $val["Pone"], $val["Ptwo"], 9, 2);
          }
          if (isset($_POST["AgainW-online"]) || isset($_POST["AgainE-online"])) {
            $raiseReset = $contact->prepare("UPDATE play set resetTwo=1");
            $raiseReset->execute();
            reset_game($_GET["room"], $val["Pone"], $val["Ptwo"], 2);
          }
        }
        finalize($_GET["room"], $_GET["Ptwo"], 2);
      }
      ?>
    </form>
  </div>

  <form method="post">
    <div class="body">
      <?php
      echo "
      <button class='ddd' data-num='1' name='one'>
        <div class='area1' data-num='1'><span class='sub'>-</span></div>
      </button>
      <button class='ddd' data-num='2' name='two'>
        <div class='area1' data-num='2'><span class='sub'>-</span></div>
      </button>
      <button class='ddd' data-num='3' name='three'>
        <div class='area1' data-num='3'><span class='sub'>-</span></div>
      </button>
      <button class='ddd' data-num='4' name='four'>
        <div class='area1' data-num='4'><span class='sub'>-</span></div>
      </button>
      <button class='ddd' data-num='5' name='five'>
        <div class='area1' data-num='5'><span class='sub'>-</span></div>
      </button>
      <button class='ddd' data-num='6' name='six'>
        <div class='area1' data-num='6'><span class='sub'>-</span></div>
      </button>
      <button class='ddd' data-num='7' name='seven'>
        <div class='area1' data-num='7'><span class='sub'>-</span></div>
      </button>
      <button class='ddd' data-num='8' name='eight'>
        <div class='area1' data-num='8'><span class='sub'>-</span></div>
      </button>
      <button class='ddd' data-num='9' name='nine'>
        <div class='area1' data-num='9'><span class='sub'>-</span></div>
      </button>"
      ?>
    </div>
  </form>
  <div class="end" id="endW">
    The player
    <span id="winner"></span>
    is the winner
    <br>
    <form action method="post">
      <button type="submit" class="btn" name="Wnew_online">New Mathch</button>
      <button type="submit" class="btn" id="AgainW-online" name="AgainW-online">Same Player's</button>
    </form>
  </div>
  <div class="end" id="endE">
    Equality
    <form action method="post">
      <button type="submit" class="btn" name="Enew_online">New Mathch</button>
      <button type="submit" class="btn" id="AgainE-online" name="AgainE-online">Same Player's</button>
    </form>
  </div>
</body>
<script src="./XO.js"></script>
<script src="./online.js"></script>
<script>
time()
</script>

</html>
<?php
if (isset($_GET["done"])) {
  if ($_GET["done"] == 1) {
    $ingo = $contact->prepare("SELECT * FROM play WHERE room = :r AND Pone = :t");
    $ingo->bindParam("r", $_GET["room"]);
    $ingo->bindParam("t", $_GET["Pone"]);
    $ingo->execute();
    foreach ($ingo as $val) {
      echo "<script>
          let p_o = '" . $val["Pone"] . "',
            p_x = '" . $val["Ptwo"] . "';
          start.style.display = 'none';
          up();
          </script>";
      chkAlo($val["Pone"], $val["Ptwo"]);
      if (checkwiner($_GET["room"], $val["Pone"], $val["Ptwo"]) == 1) {
        $thewinner = $contact->prepare("UPDATE play SET winner=CONCAT(winner , 1) WHERE room=:r AND Pone=:o AND Ptwo=:t");
        $thewinner->bindParam("r", $_GET["room"]);
        $thewinner->bindParam("o", $val["Pone"]);
        $thewinner->bindParam("t", $val["Ptwo"]);
        $thewinner->execute();
      }
      if (isset($_POST["one"])) {
        changedb($_GET["room"], $val["Pone"], $val["Ptwo"], 1, 1);
      } else if (isset($_POST["two"])) {
        changedb($_GET["room"], $val["Pone"], $val["Ptwo"], 2, 1);
      } else if (isset($_POST["three"])) {
        changedb($_GET["room"], $val["Pone"], $val["Ptwo"], 3, 1);
      } else if (isset($_POST["four"])) {
        changedb($_GET["room"], $val["Pone"], $val["Ptwo"], 4, 1);
      } else if (isset($_POST["five"])) {
        changedb($_GET["room"], $val["Pone"], $val["Ptwo"], 5, 1);
      } else if (isset($_POST["six"])) {
        changedb($_GET["room"], $val["Pone"], $val["Ptwo"], 6, 1);
      } else if (isset($_POST["seven"])) {
        changedb($_GET["room"], $val["Pone"], $val["Ptwo"], 7, 1);
      } else if (isset($_POST["eight"])) {
        changedb($_GET["room"], $val["Pone"], $val["Ptwo"], 8, 1);
      } else if (isset($_POST["nine"])) {
        changedb($_GET["room"], $val["Pone"], $val["Ptwo"], 9, 1);
      }

      if (isset($_POST["AgainW-online"]) || isset($_POST["AgainE-online"])) {
        $raiseRest = $contact->prepare("UPDATE play SET resetOne=1");
        $raiseRest->execute();
        reset_game($_GET["room"], $val["Pone"], $val["Ptwo"], 1);
      }
    }
    finalize($_GET["room"], $_GET["Pone"], 1);
  }
}
function chkAlo($o, $t)
{
  $contactF = new PDO("mysql:host=Localhost;dbname=game", "root", "");
  $alo = $contactF->prepare("SELECT * FROM play WHERE room=:r AND Pone=:one AND Ptwo=:two");
  $alo->bindParam("r", $_GET["room"]);
  $alo->bindParam("one", $o);
  $alo->bindParam("two", $t);

  $alo->execute();
  foreach ($alo as $temp) {
    if (isset($_GET["create"])) {
      if ($_GET["create"] == 1) {
        echo "<script>
          allow(" . $temp["dataO"] . ");
        </script>";
      }
    }
    if (isset($_GET["join"])) {
      if ($_GET["join"] == 2) {
        echo "<script>
          allow(" . $temp["dataX"] . ");
        </script>";
      }
    }
  }
}
function changedb($r, $o, $t, $i, $a)
{
  $contact = new PDO("mysql:host=localhost;dbname=game;", "root", "");
  if ($a == 1) {
    $data = $contact->prepare(
      "
      UPDATE play SET finalizeO=CONCAT(finalizeO , $i) WHERE room =:r AND Pone=:one AND Ptwo=:two;
      UPDATE play SET  dataO=0 WHERE room =:r AND Pone=:one AND Ptwo=:two;
      UPDATE play SET  dataX=1 WHERE room =:r AND Pone=:one AND Ptwo=:two;"
    );
  } else {
    $data = $contact->prepare(
      "
      UPDATE play SET finalizeX=CONCAT(finalizeX , $i) WHERE room =:r AND Pone=:one AND Ptwo=:two;
      UPDATE play SET  dataO=1 WHERE room =:r AND Pone=:one AND Ptwo=:two;
      UPDATE play SET  dataX=0 WHERE room =:r AND Pone=:one AND Ptwo=:two;"
    );
  }
  $data->bindParam("r", $r);
  $data->bindParam("one", $o);
  $data->bindParam("two", $t);
  $data->execute();
  if ($a == 1) {
    header("Location: " . $_SERVER['PHP_SELF'] . "?done=1&create=1&room=$r&Pone=$o");
  } else {
    header("Location: " . $_SERVER['PHP_SELF'] . "?join=2&done=1&room=$r&Ptwo=$t");
  }
}
function finalize($r, $p, $i)
{
  global $contact;
  if ($i == 1) {
    $play_O = $contact->prepare("SELECT finalizeO FROM play WHERE room='$r' AND Pone='$p'");
    $play_X = $contact->prepare("SELECT finalizeX FROM play WHERE room='$r' AND Pone='$p'");
  } else if ($i == 2) {
    $play_O = $contact->prepare("SELECT finalizeO FROM play WHERE room='$r' AND Ptwo='$p'");
    $play_X = $contact->prepare("SELECT finalizeX FROM play WHERE room='$r' AND Ptwo='$p'");
  }
  $play_O->execute();
  $play_X->execute();
  foreach ($play_O as $val_O) {
    for ($i = 0; $i < strlen($val_O["finalizeO"]); $i++) {
      echo "<script>
          O.push(" . $val_O["finalizeO"][$i] . ")
          </script>";
    }
  }
  foreach ($play_X as $val_X) {
    for ($i = 0; $i < strlen($val_X["finalizeX"]); $i++) {
      echo "<script>
          X.push(" . $val_X["finalizeX"][$i] . ")
          </script>";
    }
  }
}
function reset_game($r, $o, $t, $p)
{
  global $contact;
  $checkReset = $contact->prepare("SELECT resetOne,resetTwo from play WHERE room='$r' AND Pone='$o' AND Ptwo='$t'");
  $checkReset->execute();
  foreach ($checkReset as $value) {
    if ($value["resetOne"] == 1 && $value["resetTwo"] == 1) {
      $theReset = $contact->prepare("UPDATE play set dataO=1,dataX=0,finalizeO='',finalizeX='',resetOne=0,resetTwo=0 WHERE room='$r' AND Pone='$o' AND Ptwo='$t'");
      $theReset->execute();
      echo "<script>reset()</script>";
    }
  }
}
function checkwiner($r, $o, $t)
{
  global $contact;
  $chechO = $contact->prepare("SELECT finalizeO FROM play WHERE room='$r' AND Pone='$o' AND Ptwo='$t'");
  $chechO->execute();
  $finalizeO = [];
  foreach ($chechO as $value) {
    $value = strval($value["finalizeO"]);
    for ($i = 0; $i < strlen($value); $i++) {
      array_push($finalizeO, $value[$i]);
    }
  }
  $chechX = $contact->prepare("SELECT finalizeX FROM play WHERE room='$r' AND Pone='$o' AND Ptwo='$t'");
  $chechX->execute();
  $finalizeX = [];
  foreach ($chechX as $value) {
    $value = strval($value["finalizeX"]);
    for ($i = 0; $i < strlen($value); $i++) {
      array_push($finalizeX, $value[$i]);
    }
  }
  if (in_array(1, $finalizeO) && in_array(2, $finalizeO) && in_array(3, $finalizeO)) {
    return true;
  } else if (in_array(1, $finalizeO) && in_array(2, $finalizeO) && in_array(3, $finalizeO)) {
    return "1";
  } else if (in_array(4, $finalizeO) && in_array(5, $finalizeO) && in_array(6, $finalizeO)) {
    return "1";
  } else if (in_array(7, $finalizeO) && in_array(8, $finalizeO) && in_array(9, $finalizeO)) {
    return "1";
  } else if (in_array(1, $finalizeO) && in_array(4, $finalizeO) && in_array(7, $finalizeO)) {
    return "1";
  } else if (in_array(2, $finalizeO) && in_array(5, $finalizeO) && in_array(8, $finalizeO)) {
    return "1";
  } else if (in_array(3, $finalizeO) && in_array(6, $finalizeO) && in_array(9, $finalizeO)) {
    return "1";
  } else if (in_array(1, $finalizeO) && in_array(5, $finalizeO) && in_array(9, $finalizeO)) {
    return "1";
  } else if (in_array(3, $finalizeO) && in_array(5, $finalizeO) && in_array(7, $finalizeO)) {
    return "1";
  }

  if (in_array(1, $finalizeX) && in_array(2, $finalizeX) && in_array(3, $finalizeX)) {
    return "2";
  } else if (in_array(1, $finalizeX) && in_array(2, $finalizeX) && in_array(3, $finalizeX)) {
    return "2";
  } else if (in_array(4, $finalizeX) && in_array(5, $finalizeX) && in_array(6, $finalizeX)) {
    return "2";
  } else if (in_array(7, $finalizeX) && in_array(8, $finalizeX) && in_array(9, $finalizeX)) {
    return "2";
  } else if (in_array(1, $finalizeX) && in_array(4, $finalizeX) && in_array(7, $finalizeX)) {
    return "2";
  } else if (in_array(2, $finalizeX) && in_array(5, $finalizeX) && in_array(8, $finalizeX)) {
    return "2";
  } else if (in_array(3, $finalizeX) && in_array(6, $finalizeX) && in_array(9, $finalizeX)) {
    return "2";
  } else if (in_array(1, $finalizeX) && in_array(5, $finalizeX) && in_array(9, $finalizeX)) {
    return "2";
  } else if (in_array(3, $finalizeX) && in_array(5, $finalizeX) && in_array(7, $finalizeX)) {
    return "2";
  }
} -->