<html>

<head>
<title>RWHois- Martin Winton</title>
<link rel="icon" type="image/png" href='kMxOTN1.png'>
<link rel="shortcut icon" href="/kMxOTN1.png" />

<style>
a {
	padding: 0px 10px;
	word-wrap: normal;
	display: inline-block;
}
</style>

</head>

<body>

	<h1>Welcome to Deleter</h1>



	<?php


	$self= $_SERVER['PHP_SELF'];

	$d_org = test_input($_GET["choose"]);


	$mark = strtolower(test_input($_GET["choose"]).'.txt');
	$mark = str_replace("/","-",$mark);
	$mark = str_replace(" ","",$mark);
	$d_org = str_replace("/","-",$d_org);
	//initializes and removes '/' from ip name and txt version of ip.


	if(isset($_GET["choose"])){

		$ip = $_GET["delete"];
		$ip = str_replace("/","-",$ip);

		//gets ip file to delete



		$dir = "/usr/local/rwhoisd/net-$ip/data/network/";

		if (is_dir($dir)){
			if ($dh = opendir($dir)){

				$ipfiles = [];

				// initializes extraction variables

				while (($file = readdir($dh)) !== false){
					//	echo $ip;
					$string = file_get_contents("/usr/local/rwhoisd/net-$ip/data/network/" . $file);
					preg_match_all("/((.+): (.+))/",$string,$matches2);
					//var_dump($matches2);

					if(isset($matches2[3][5]) and trim($matches2[3][5]) == trim($d_org)){
						echo $matches2[3][5];

						// gets ipfiles relating to org
						array_push($ipfiles,$file);

					}

				}

				closedir($dh);
			}
		}


		for($k = 0; $k<count($ipfiles);$k++){
			$markk = strtolower(test_input($ipfiles[$k]));

			echo"<br>";
			echo	"This will delete $markk";

			echo"<br>";

			//prints out related ipfiles


		}
	}

	// checks database for org/ip and gives eror if not found

	if(isset($_POST["add"])){


		for($k = 0; $k<count($ipfiles);$k++){

			$markk = strtolower(test_input($ipfiles[$k]));



			if(unlink("/usr/local/rwhoisd/net-$ip/data/network/" . $markk)){
				echo "File Deleted";
				echo "<td><a href = \"viewip.php\">Home! </a></td>";
				echo exec("/usr/local/rwhoisd/bin/rwhois_indexer -c /usr/local/rwhoisd/rwhoisd.conf -i -s txt 2>&1",$do);
				echo exec("sudo /etc/init.d/rwhosid restart 2>&1",$doo);
			}




			else{
				echo "Failure Deleting. This IP must not exist!";
			}

		}

			
		if(@unlink("/usr/local/rwhoisd/net-$ip/data/org/" . $mark)){
			echo "File Deleted";
			echo exec("/usr/local/rwhoisd/bin/rwhois_indexer -c /usr/local/rwhoisd/rwhoisd.conf -i -s txt 2>&1",$do);
			echo exec("sudo pkill rwhoisd 2>&1",$doo);
			echo exec("sudo /usr/local/rwhoisd/rwhoisd -c /usr/local/rwhoisd/rwhoisd.conf 2>&1",$doo);
		}


		else{
			echo "Failure Deleting. This Org must not exist!";
		}



	}


	function test_input($data) {
					$data = trim($data);
					$data = stripslashes($data);
					$data = htmlspecialchars($data);
					return $data;
				}


				?>


	<form method="post"
		action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>?delete=<?php echo "$ip"?>&choose=<?php echo "$d_org"?>">

		<br> <input name="add" type="submit" id="add" value="Delete">

	</form>



</body>
</html>
