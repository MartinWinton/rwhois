
<html>

<head>
<link rel="icon" type="image/png" href='kMxOTN1.png'">
<style>
.error {
	color: #FF0000;
}
</style>

<title>Rwhois Org Insertion- Martin Winton</title>
</head>

<body>






	<?php

	include 'functions.php';

	$i_street = $i_city = $i_state = $i_postal = $i_country = $i_phone= "";
	$e_street = $e_city = $e_state = $e_postal = $e_country = $e_phone= "";

	// initialzies variables and static id/auth

	$t = time();
	$date = date("Y-m-d",$t);
	$date = str_replace("-","",$date);
	// sets updated date


	$mark = strtolower(test_input($_GET["org"]).'.txt');
	$org = test_input($_GET["org"]);




	if($string = @file_get_contents('/usr/local/rwhoisd/net-192.168.192.0-19/data/org/' . $mark) or $string = @file_get_contents('/usr/local/rwhoisd/net-10.0.0.0-8/data/org/' . $mark)){
			
		preg_match_all("/((.+): (.+))/",$string,$matches);
			
		//var_dump($matches);




		$i_street =  test_input($matches[3][1]);
		$i_city = test_input($matches[3][2]);
		$i_state = test_input($matches[3][3]);
		$i_postal = test_input($matches[3][4]);
		$i_country = test_input($matches[3][5]);
		$i_phone = test_input($matches[3][6]);
		$i_created = test_input($matches[3][7]);
		// extracts current data into variables

			

	}

	else{
		die("Org does not exist");
	}















	// creates updated field


	//creates error and insert variables




	if (empty($_POST["i_street"]) and isset($_POST['add'])) {
		$e_street = "You must address";
	}

	elseif(!empty($_POST["i_street"]) and !preg_match('/^[\sA-Za-z\.\d-]+$/', $_POST["i_street"])) {


		$e_street = "Invalid address";
	}




	elseif(!empty($_POST["i_street"])) {
		$i_street= test_input($_POST["i_street"]);
	}





	if (empty($_POST["i_city"]) and isset($_POST['add'])) {
		$e_city = "You must enter city";
	}




	elseif(!empty($_POST["i_city"]) and !preg_match('/^[\sA-Za-z\.\d-]+$/', $_POST["i_city"])) {
		$e_city = "Invalid city";
	}



	elseif(!empty($_POST["i_city"])) {
		$i_city= test_input($_POST["i_city"]);
	}











	if (empty($_POST["i_state"]) and isset($_POST['add'])) {
		$e_state = "You must enter state";
	}


	elseif(!empty($_POST["i_state"]) and !preg_match('/^[A-Za-z]{2}$/', $_POST["i_state"])) {
		$e_state= "Invalid state";



	}




	elseif(!empty($_POST["i_state"])) {
		$i_state= strtoupper(test_input($_POST["i_state"]));

	}





	if (empty($_POST["i_postal"]) and isset($_POST['add'])) {
		$e_postal = "You must enter postal code";
	}



	elseif(!empty($_POST["i_postal"]) and !preg_match('/^\d+$/', $_POST["i_postal"])) {
		$e_postal= "Invalid Postal code";
	}



	elseif(!empty($_POST["i_postal"])) {
		$i_postal= test_input($_POST["i_postal"]);
	}





	if (empty($_POST["i_country"]) and isset($_POST['add'])) {
		$e_country = "You must enter country";
	}



	elseif(!empty($_POST["i_country"]) and !preg_match('/^[A-Za-z\.\d]+$/', $_POST["i_country"])) {
		$e_country= "Invalid country";
	}




	elseif(!empty($_POST["i_country"])) {
		$i_country= test_input($_POST["i_country"]);
	}




	if (empty($_POST["i_phone"]) and isset($_POST['add'])) {
		$e_phone = "You must enter phone number";
	}



	elseif(!empty($_POST["i_phone"]) and !preg_match('/^\D?(\d{3})\D?\D?(\d{3})\D?(\d{4})$/', $_POST["i_phone"])) {
		$e_phone= "Invalid Phone Number";
	}




	elseif(!empty($_POST["i_phone"])) {
		$i_phone= test_input($_POST["i_phone"]);
	}




	// assigns insert variables and creates errors otherwise


	$self= $_SERVER['PHP_SELF'];







	if(isset($_POST['add']) and $e_street == ''and  $e_city == '' and  $e_city == '' and $e_state == '' and $e_postal == '' and $e_country== ''){
		// if no errors and submit button was pressed



		$index = array("Org-Name: ","Street-Address: ","City: ","State: ","Postal-Code: ","Country-Code: ","Phone: ","Created: ","Updated: ");
		$key = array("$org ","$i_street ","$i_city ","$i_state ","$i_postal ","$i_country ","$i_phone ","$i_created ","$date ");
		$file = "";
		for($i = 0; $i<count($key);$i++){

			$file .= $index[$i] . $key[$i] . " \n";


		}
		// creates two arrays with field and key, merging them into one string

		echo nl2br($file);

		$org = strtolower($org);
		$org= str_replace(" ","",$org);
		// removes spaces to make nice file name

		$new= fopen("/usr/local/rwhoisd/net-192.168.192.0-19/data/org/". $org .".txt",'w');
		if(fwrite($new,$file)){
			echo "File on 192.168.192.0-19 Written successfully";
			$do = [];
			echo exec("/usr/local/rwhoisd/bin/rwhois_indexer -c /usr/local/rwhoisd/rwhoisd.conf -i -s txt 2>&1",$do);
			echo exec("sudo /etc/init.d/rwhosid restart 2>&1",$doo);
			//echo exec("sudo pkill rwhoisd 2>&1");


		}
		else{
			echo "FAIL";
		}



		$new= fopen("/usr/local/rwhoisd/net-10.0.0.0-8/data/org/". $org .".txt",'w');
		if(fwrite($new,$file)){
			echo "<br>File on  10.0.0.0-8 Written successfully";
			$doo = [];
			echo exec("/usr/local/rwhoisd/bin/rwhois_indexer -c /usr/local/rwhoisd/rwhoisd.conf -i -s txt 2>&1",$do);
			echo exec("sudo /etc/init.d/rwhosid restart 2>&1",$doo);


			//	var_dump($doo);

		}
		else{
			echo "FAIL";
		}




	}





	//removes crap





	?>










	<?php echo "<h3>Update Org: $org</h3>";?>

	<form method="post"
		action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>?org=<?php echo "$org"?>&ip=<?php echo ""?>">

		</span> <br> Street Address:<br> <input type="text" name="i_street"
			value="<?php echo $i_street;?>"> <span class="error">* <?php echo $e_street;?>
		</span><br> City:<br> <input type="text" name="i_city"
			value="<?php echo $i_city;?>"> <span class="error">* <?php echo $e_city;?>
		</span><br> State:<br> <input type="text" name="i_state"
			value="<?php echo $i_state;?>"> <span class="error">* <?php echo $e_state;?>
		</span><br> Postal Code:<br> <input type="text" name="i_postal"
			value="<?php echo $i_postal;?>"><span class="error">* <?php echo $e_postal;?>
		</span> <br> Country Code :<br> <input type="text" name="i_country"
			value="<?php echo $i_country;?>"> <span class="error">* <?php echo $e_country;?>
		</span><br> Phone:<br> <input type="text" name="i_phone"
			value="<?php echo $i_phone;?>"> <span class="error">* <?php echo $e_phone;?>
		</span> <br> <input name="add" type="submit" id="add" value="Add Org">


	</form>













</body>
</html>
