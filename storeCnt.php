    <?php
    header('Content-Type: application/json');

    $user_agent     =   $_SERVER['HTTP_USER_AGENT'];

function getOS() {

    global $user_agent;

    $os_platform    =   "Unknown OS Platform";

    $os_array       =   array(
                            '/windows nt 10/i'     =>  'Windows 10',
                            '/windows nt 6.3/i'     =>  'Windows 8.1',
                            '/windows nt 6.2/i'     =>  'Windows 8',
                            '/windows nt 6.1/i'     =>  'Windows 7',
                            '/windows nt 6.0/i'     =>  'Windows Vista',
                            '/windows nt 5.2/i'     =>  'Windows Server 2003/XP x64',
                            '/windows nt 5.1/i'     =>  'Windows XP',
                            '/windows xp/i'         =>  'Windows XP',
                            '/windows nt 5.0/i'     =>  'Windows 2000',
                            '/windows me/i'         =>  'Windows ME',
                            '/win98/i'              =>  'Windows 98',
                            '/win95/i'              =>  'Windows 95',
                            '/win16/i'              =>  'Windows 3.11',
                            '/macintosh|mac os x/i' =>  'Mac OS X',
                            '/mac_powerpc/i'        =>  'Mac OS 9',
                            '/linux/i'              =>  'Linux',
                            '/ubuntu/i'             =>  'Ubuntu',
                            '/iphone/i'             =>  'iPhone',
                            '/ipod/i'               =>  'iPod',
                            '/ipad/i'               =>  'iPad',
                            '/android/i'            =>  'Android',
                            '/blackberry/i'         =>  'BlackBerry',
                            '/webos/i'              =>  'Mobile'
                        );

    foreach ($os_array as $regex => $value) {

        if (preg_match($regex, $user_agent)) {
            $os_platform    =   $value;
        }

    }

    return $os_platform;

}

function getBrowser() {

    global $user_agent;

    $browser        =   "Unknown Browser";

    $browser_array  =   array(
                            '/msie/i'       =>  'Internet Explorer',
                            '/firefox/i'    =>  'Firefox',
                            '/safari/i'     =>  'Safari',
                            '/chrome/i'     =>  'Chrome',
                            '/edge/i'       =>  'Edge',
                            '/opera/i'      =>  'Opera',
                            '/netscape/i'   =>  'Netscape',
                            '/maxthon/i'    =>  'Maxthon',
                            '/konqueror/i'  =>  'Konqueror',
                            '/mobile/i'     =>  'Handheld Browser'
                        );

    foreach ($browser_array as $regex => $value) {

        if (preg_match($regex, $user_agent)) {
            $browser    =   $value;
        }

    }

    return $browser;

}


    $aResult = array();

    if( !isset($_POST['functionname']) ) { $aResult['error'] = 'No function name!'; }

    if( !isset($_POST['arguments']) ) { $aResult['error'] = 'No function arguments!'; }

    if( !isset($aResult['error']) ) {

        switch($_POST['functionname']) {
	    case 'in':
                $user_os        =   getOS();
                $user_browser   =   getBrowser();
                $servername = "localhost";
                $username = "root";
                $password = "mcs#123logan";
                $dbname = "tplp";

                $conn = new mysqli($servername, $username, $password, $dbname);
                if ($conn->connect_error) {
                   die ("connection failed: " . $conn->connect_error);
                }       
                $gnr = intval($_POST['arguments'][0]);

                $ip=$_SERVER['REMOTE_ADDR'];
                $port = $_SERVER[REMOTE_PORT];
                $agent = $_SERVER['HTTP_USER_AGENT'];
                $uri = $_SERVER['REQUEST_URI'];
                $date = date('Y-m-d H:i:s');
		$lng = $_POST['arguments'][1];

                $sql0 = "INSERT INTO srlog (IP,PORT,GAME,DTB,LNG) VALUES ('$ip','$port','$gnr','$date', '$lng')";
                //console_log($sql0);

                $aResult['result'] = $conn->query($sql0);
		break;

            case 'cnt':

		$user_os        =   getOS();
		$user_browser   =   getBrowser();
		$servername = "localhost";	
    	    	$username = "root";
	    	$password = "mcs#123logan";
	    	$dbname = "tplp"; 

	    	$conn = new mysqli($servername, $username, $password, $dbname);
	    	if ($conn->connect_error) {
		   die ("connection failed: " . $conn->connect_error);
		}
	    	$cnt = intval($_POST['arguments'][0]); 
		$gnr = intval($_POST['arguments'][1]);

	    	$ip=$_SERVER['REMOTE_ADDR'];
	    	$port = $_SERVER[REMOTE_PORT];
		$agent = $_SERVER['HTTP_USER_AGENT'];
	    	$uri = $_SERVER['REQUEST_URI'];
	    	$date = date('Y-m-d H:i:s');
                $lng = $_POST['arguments'][2];
		// get initial record or create new
		// get highest IP,PORT,GAME
		$sql0 = "SELECT GAME from srlog WHERE IP='$ip' AND GAME='$gnr'";
		$bfound = 0;

		$result0 = $conn->query($sql0);
		if (!$result0) 
		{
		   echo 'Could not run query: ' . mysql_error();
    		   exit;
		}
		else
		{

			if ($result0->num_rows > 0) {
			// output data of each row
    			   while($row = $result0->fetch_assoc()) {
			   	      //echo "Game id: " . $row["GAME"]. "<br>";
				      //$game =  intval($row["GAME"]) + 1;
				      $bfound = 1;
				      }
			} else {
    			  echo "0 results";
			  $game = 1;
			}

                }

		if(!$bfound){
			//console_log("not found");

			$sql0 = "INSERT INTO srlog (IP,PORT,GAME,DTE,CNT,OS,BROWSER,LNG) VALUES ('$ip','$port','$gnr','$date','$cnt','$user_os','$user_browser','$lng')";
			//console_log($sql0);

	    		$aResult['result'] = $conn->query($sql0);
		}
		else
		{
			//console_log("found");
		        $sql0 = "UPDATE srlog SET DTE='$date',CNT='$cnt',OS='$user_os',BROWSER='$user_browser',LNG='$lng' WHERE IP='$ip' AND GAME='$gnr'";
			//console_log($sql0);
                        $aResult['result'] = $conn->query($sql0);
		}
	    	break;

            default:
               $aResult['error'] = 'Not found function '.$_POST['functionname'].'!';
               break;
        }

    }
    echo json_encode($aResult);
?>
