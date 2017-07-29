<?php
$servername = "localhost";
$username = "*****";
$password = "*****";
$dbname = "****";
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
echo "ERROR CONNECTING";
die ("connection failed: " . $conn->connect_error);
echo "ERROR CONNECTING";
}

$sql = "SELECT IP, COUNT(*) as TOT FROM srlog s GROUP BY IP ORDER BY TOT DESC;";

$ret = "{ 
  \"cols\": [
         {\"id\":\"\",\"label\":\"IP\",\"pattern\":\"\",\"type\":\"string\"},
         {\"id\":\"\",\"label\":\"TOT\",\"pattern\":\"\",\"type\":\"number\"}
       ],
  \"rows\": [
";

$result = $conn->query($sql);
$cnt  = 0;

if ($result->num_rows > 0) {
  while($row = $result->fetch_assoc()) {
  $cnt = $cnt + 1;
  if ($cnt > 1 ) $ret = $ret . ",";
  $ret =  $ret . "{\"c\":[{\"v\":\"". $row["IP"] . "\",\"f\":null},{\"v\":". $row["TOT"]. ",\"f\":null}]}";
  }
} else {
  echo "0 results";
}
  $ret =  $ret . "]
}";

$conn->close();
echo $ret;
?>

