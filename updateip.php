<html>

<head>
<title>Employee Database Mananger- Martin Winton</title>
<link rel="icon" type="image/png" href='kMxOTN1.png'>
<link rel="shortcut icon" href="/kMxOTN1.png" />

<style>
a {
	padding: 0px 10px;
	word-wrap: normal;
	display: inline-block;
}

.error {
	color: #FF0000;
}
</style>

</head>

<body>

	<h1>Welcome to Updater</h1>



	<?php






	include 'functions.php';





	$self= $_SERVER['PHP_SELF'];



	$e_email = $e_tech_contact = $e_admin_contact = $e_organization = $e_ip = '';









	$u_ip = test_input($_GET["u_ip"]);
	$auth = test_input($_GET["auth"]);




	$mark = strtolower(test_input($_GET["u_ip"]).'.txt');




	$mark = str_replace("/","-",$mark);
	$u_ip = str_replace("/","-",$u_ip);
	$auth = str_replace("/","-",$auth);
	// turn into filenames
	echo "<h3>Updating " .$mark."</h3>";


	//var_dump($ipfiles);


	$dir = "/usr/local/rwhoisd/net-$auth/data/org/";


	if (is_dir($dir)){
		if ($dh = opendir($dir)){

			$orgs = [];

			// initializes extraction variables

			while (($file = readdir($dh)) !== false){
				if (preg_match('/\.txt/',$file)){



					$string = file_get_contents("/usr/local/rwhoisd/net-$auth/data/org/" . $file);
					preg_match_all("/((.+): (.+))/",$string,$matches);

					$test = test_input($matches[3][0]);
					$test = strtolower($test);

					//var_dump($matches);

					if(!in_array($test,$orgs)){
							
						array_push($orgs,$test);

						// attains and pushes orgs relating to auth
					}


				}
			}
			//var_dump($files);
			//var_dump($orgs);
			//var_dump($techs);
			//var_dump($matches);
			closedir($dh);
		}
	}









	if($string = @file_get_contents("/usr/local/rwhoisd/net-$auth/data/network/" . $mark)){
		// finds ip files and dies otherwise


			
		preg_match_all("/((.+): (.+))/",$string,$matches);
			

		$id = $matches[3][0];
		$auth = $matches[3][1];
		$name = $matches[3][2];
		$network =  $matches[3][3];
		$block = $matches[3][4];
		$org = $matches[3][5];
		$tech = $matches[3][6];
		$admin = $matches[3][7];
		$created = $matches[3][8];
		$email = $matches[3][10];

		//extracts data to put into text boxes
			

			
		//var_dump($matches);









		if (empty($_POST["email"]) and isset($_POST['add'])) {
			$e_email = "You must enter email";
		}

		elseif(isset($_POST["email"]) and !filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {


			$e_email = "Invalid email";
		}




		elseif(!empty($_POST["email"])) {
			$email= test_input($_POST["email"]);
		}






		if(!empty($_POST["i_new_tech"])) {






			$tech= test_input($_POST["i_new_tech"]);
				
		}






		if(!empty($_POST["i_new_admin"])) {






				

			$admin= test_input($_POST["i_new_admin"]);
				





		}








		if(!empty($_POST["o"])) {





			$org= test_input($_POST["o"]);



		}
		// assigns variables and creates errors otherwise



		if($e_email == '' and isset($_POST['add'])){








			$t = time();
			$date = date("Y-m-d",$t);
			$date = str_replace("-","",$date);
			// creates updated field


			$index = array("ID: ", "Auth-Area: ","Network-Name: ","IP-Network: ","IP-Network-Block: ","Organization: ","Tech-Contact: ","Admin-Contact: ","Created: ","Updated: ","Updated-By: ");
			$key = array("$id ","$auth ","$name ","$network ","$block ","$org ","$tech ","$admin ","$created ","$date ","$email");
			$file = "";
			for($i = 0; $i<count($key);$i++){

				$file .= $index[$i] . $key[$i] . " \n";


			}
			// creates two arrays with field and key, merging them into one string

			echo nl2br($file);

			$network = str_replace("/","-",$network);
			$network = str_replace(" ","",$network);
			// turns '/' into '-' to create valid file name

			//$new= fopen("/usr/local/rwhoisd/net-192.168.192.0-19/data/network/". $network .".txt",'w');










				

			$new= fopen("/usr/local/rwhoisd/net-$auth/data/network/". $network .".txt",'w');
			if(fwrite($new,$file)){
				echo "File Written successfully";
				echo exec("/usr/local/rwhoisd/bin/rwhois_indexer -c /usr/local/rwhoisd/rwhoisd.conf -i -s txt 2>&1",$do);
				echo exec("sudo /etc/init.d/rwhosid restart 2>&1",$doo);


			}
			else{
					echo "FAIL";

				}
					


					




		}
		// writes data into custom-named file, creating one if necessary











	}

	else{
		die("Failure Reading File for Update");
	}






	?>

	<?php //	var_dump($orgs);?>


	<form method="post"
		action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>?u_ip=<?php echo "$u_ip"?>&auth=<?php echo "$auth"?>">
		<br> Email:<br> <input type="text" name="email"
			value="<?php echo test_input($email);?>"> <span class="error">* <?php echo $e_email;?>
		</span> <br> Current Org :
		<?php echo "$org"?>



		<br> Organization:<br> <select name="o">

			<?php 

			for($k = 0; $k<count($orgs);$k++){

			$orgo = $orgs[$k];
			$orgo = test_input($orgo);

			echo "<option value = \"{$orgs[$k]}\" >$orgo</option>";
	}

	?>
		</select> <br> New Tech Contract:<br> <input type="text"
			name="i_new_tech" value="<?php echo test_input($tech);?>"> <br> Admin
		Contract:<br> <input type="text" name="i_new_admin"
			value="<?php echo test_input($admin);?>"> <br> <input name="add"
			type="submit" id="add" value="Add IP">


	</form>












</body>
</html>
