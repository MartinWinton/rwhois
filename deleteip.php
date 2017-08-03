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




	$d_ip = $_GET["d_ip"];
	$mark = strtolower(test_input($_GET["d_ip"]).'.txt');
	$mark = str_replace("/","-",$mark);
	$d_ip = str_replace("/","-",$d_ip);
	//initializes and removes '/' from ip name and txt version of ip.


	$auth = strtolower(test_input($_GET["auth"]));
	$auth = str_replace("/","-",$auth);




	//var_dump($ipfiles);




	// checks database for ip and dies if not found

	if(!isset($_POST["add"])){
		echo "Delete IP $mark?";
	}


	if(isset($_POST["add"])){




		if($string = file_get_contents("/usr/local/rwhoisd/net-$auth/data/network/$mark")){








			if(@unlink("/usr/local/rwhoisd/net-$auth/data/network/" . $mark)){
				echo "File Deleted";
				echo "<td><a href = \"viewip.php\">Home! </a></td>";
				echo exec("/usr/local/rwhoisd/bin/rwhois_indexer -c /usr/local/rwhoisd/rwhoisd.conf -i -s txt 2>&1");
			}






			else{
die("Error deleting File");
}







		}

		else{

			echo "IP does not exist!";
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
		action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>?d_ip=<?php echo "$d_ip"?>&auth=<?php echo "$auth"?>">

		<br> <input name="add" type="submit" id="add" value="Delete">

	</form>













</body>
</html>
