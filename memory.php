<!DOCTYPE html>
<html >
<head>
  <meta charset="UTF-8">
  <title>Memory Game</title>
  
<style class="cp-pen-styles">
@import url(http://weloveiconfonts.com/api/?family=brandico);
/* brandico */
[class*="brandico-"]:before {
  font-family: 'brandico', sans-serif;
}

* {
  box-sizing: border-box;
}

html, body {
  height: 100%;
}

body {
  background: black;
  min-height: 100%;
  font-family: "Arial", sans-serif;
}

.cntr {
display: none;
}

.wrap {
  position: relative;
  height: 100%;
  min-height: 500px;
  padding-bottom: 20px;
}

.game {
  -webkit-transform-style: preserve-3d;
          transform-style: preserve-3d;
  -webkit-perspective: 500px;
          perspective: 500px;
  min-height: 100%;
  height: 100%;
}

@-webkit-keyframes matchAnim {
  0% {
    background: #bcffcc;
  }
  100% {
    background: white;
  }
}

@keyframes matchAnim {
  0% {
    background: #bcffcc;
  }
  100% {
    background: white;
  }
}
.card {
  float: left;
  width: 16.66666%;
  height: 25%;
  padding: 5px;
  text-align: center;
  display: block;
  -webkit-perspective: 500px;
          perspective: 500px;
  position: relative;
  cursor: pointer;
  z-index: 50;
  -webkit-tap-highlight-color: transparent;
}
@media (max-width: 800px) {
  .card {
    width: 25%;
    height: 16.666%;
  }
}
.card .inside {
  width: 100%;
  height: 100%;
  display: block;
  -webkit-transform-style: preserve-3d;
          transform-style: preserve-3d;
  -webkit-transition: .4s ease-in-out;
  transition: .4s ease-in-out;
  background: white;
}
.card .inside.picked, .card .inside.matched {
  -webkit-transform: rotateY(180deg);
          transform: rotateY(180deg);
}
.card .inside.matched {
  -webkit-animation: 1s matchAnim ease-in-out;
          animation: 1s matchAnim ease-in-out;
  -webkit-animation-delay: .4s;
          animation-delay: .4s;
}
.card .front, .card .back {
  border: 1px solid black;
  -webkit-backface-visibility: hidden;
          backface-visibility: hidden;
  position: absolute;
  display:table-cell;
  vertical-align:middle;
  width: 100%;
  height: 100%;
  padding: 1px;
}
.card .front img, .card .back img {
  max-width: 100%;
  display: block;
  margin: auto auto;
  max-height: 100%;
}
.card .front {
  -webkit-transform: rotateY(-180deg);
          transform: rotateY(-180deg);
}

.card .picked .back {
    display: none;
}

@media (max-width: 800px) {
  .card .front {
    padding: 5px;
  }
}
@media (max-width: 800px) {
  .card .back {
    padding: 10px;
  }
}

.modal-overlay {
  display: none;
  background: rgba(0, 0, 0, 0.8);
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
}

.modal {
  display: none;
  position: relative;
  width: 600px;
  height: 500px;
  max-height: 90%;
  max-width: 90%;
  min-height: 380px;
  margin: 0 auto;
  background: white;
  top: 50%;
  -webkit-transform: translateY(-50%);
          transform: translateY(-50%);
  padding: 30px 10px;
}
.modal .winner {
  font-size: 80px;
  text-align: center;
  font-family: "Anton", sans-serif;
  color: #4d4d4d;
  text-shadow: 0px 3px 0 black;
}
@media (max-width: 480px) {
  .modal .winner {
    font-size: 50px;
  }
}
.modal .restart {
  font-family: "Anton", sans-serif;
  margin: 30px auto;
  padding: 20px 30px;
  display: block;
  font-size: 30px;
  border: none;
  background: #4d4d4d;
  background: -webkit-linear-gradient(#4d4d4d, #222);
  background: linear-gradient(#4d4d4d, #222);
  border: 1px solid #222;
  border-radius: 5px;
  color: white;
  text-shadow: 0px 1px 0 black;
  cursor: pointer;
}
.modal .restart:hover {
  background: -webkit-linear-gradient(#222, black);
  background: linear-gradient(#222, black);
}
.modal .message {
  text-align: center;
}
.modal .message a {
  text-decoration: none;
  color: #28afe6;
  font-weight: bold;
}
.modal .message a:hover {
  color: #56c0eb;
  border-bottom: 1px dotted #56c0eb;
}
.modal .share-text {
  text-align: center;
  margin: 10px auto;
}
.modal .social {
  margin: 20px auto;
  text-align: center;
}
.modal .social li {
  display: inline-block;
  height: 50px;
  width: 50px;
  margin-right: 10px;
}
.modal .social li:last-child {
  margin-right: 0;
}
.modal .social li a {
  display: block;
  line-height: 50px;
  font-size: 20px;
  color: white;
  text-decoration: none;
  border-radius: 5px;
}
.modal .social li a.facebook {
  background: #3b5998;
}
.modal .social li a.facebook:hover {
  background: #4c70ba;
}
.modal .social li a.google {
  background: #D34836;
}
.modal .social li a.google:hover {
  background: #dc6e60;
}
.modal .social li a.twitter {
  background: #4099FF;
}
.modal .social li a.twitter:hover {
  background: #73b4ff;
}

footer {
  height: 20px;
  position: absolute;
  bottom: 0;
  width: 100%;
  z-index: 0;
}
footer .disclaimer {
  line-height: 20px;
  font-size: 12px;
  color: #727272;
  text-align: center;
}
@media (max-width: 767px) {
  footer .disclaimer {
    font-size: 8px;
  }
}
</style>
 
 
</head>
<body onload="test();">

<?php

function console_log( $data ){
  echo '<script>';
  echo 'console.log('. json_encode( $data ) .')';
  echo '</script>';
}

$servername = "localhost";
$username = "****";
$password = "*********";
$dbname = "***";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
die ("connection failed: " . $conn->connect_error);
}

$ip=$_SERVER['REMOTE_ADDR'];
$port= $_SERVER['REMOTE_PORT'];
$agent = $_SERVER['HTTP_USER_AGENT'];
$uri = $_SERVER['REQUEST_URI'];
$date = date('Y-m-d H:i:s');

$game=0;
$sql0 = "SELECT GAME from srlog WHERE IP = '$ip' ORDER BY GAME DESC LIMIT 1";
console_log($sql0);
$result0 = $conn->query($sql0);

if ($result0->num_rows > 0) {
    // output data of each row
    while($row = $result0->fetch_assoc()) {
        echo "Game id: " . $row["GAME"]. "<br>";
        $game =  intval($row["GAME"]) + 1;
    }
} else {
    echo "0 results";
} 

if (!$result0) {
    echo 'Could not run query: ' . mysql_error();
    exit;
}
else
{
    //console_log($result0);
    $row = mysql_fetch_row($result0);
}

echo "<div id='gnr'>$game</div>";

?>

<div class="wrap">
<div class="game">
</div>
<div class="modal-overlay">
  <div class="modal">
    <h2 id="wincnt" class="winner">Gewonnen!</h2>
    <button class="restart">Wieder spielen?</button>
    <p class="message">Developed on <a href="http://www.strudelbaum.com">Strudelbaum</a> by SBG</p>
    <p class="share-text">Teilen?</p>
    <ul class="social">
      <li><a target="_blank" class="twitter" href="https://twitter.com/share?url=http://www.strudelbaum.com//memory.php"><span class="brandico-twitter-bird"></span></a></li>
      <li><a target="_blank" class="facebook" href="https://www.facebook.com/sharer.php?u=http://www.strudelbaum.com//memory.php"><span class="brandico-facebook"></span></a></li>
      <li><a target="_blank" class="google" href="https://plus.google.com/share?url=http://www.strudelbaum.com//memory.php"><span class="brandico-googleplus-rect"></span></a></li>
      </ul>
    </div>
  </div>
  <footer>
    <p class="disclaimer">All logos are property of their respective owners, No Copyright infringement intended.</p>
    </footer>
  </div><!-- End Wrap -->

<script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
<script src="memory.js"></script>
</body>
</html>
