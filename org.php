
<html>

<head>
<link rel="icon" type="image/png" href='kMxOTN1.png'">
<style>
.error {
	color: #FF0000;
}
</style>

<title>Org Insertion- Martin Winton</title>
</head>

<body>






	<?php




	$i_org=$i_street = $i_city = $i_state = $i_postal = $i_country = $i_phone= "";
	$e_org=$e_street = $e_city = $e_state = $e_postal = $e_country = $e_phone= "";


	$t = time();
	$date = date("Y-m-d",$t);
	$date = str_replace("-","",$date);
	// creates updated field


	//creates error and insert variables



	if (empty($_POST["i_org"]) and isset($_POST['add'])) {
		$e_org = "You must enter org";
	}



	elseif(!empty($_POST["i_org"]) and !preg_match('/^[\(\)\sA-Za-z\d-]+$/', $_POST["i_org"])) {
		$e_org= "Invalid Org";
	}




	elseif(!empty($_POST["i_org"])) {
		$i_org= test_input($_POST["i_org"]);
	}


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



	elseif(!empty($_POST["i_country"]) and !preg_match('/^[A-Za-z\.]+$/', $_POST["i_country"])) {
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

		$auth = $_POST["auth"];
		$id = "NETBLK-ISPWIDGET".$auth;
		$mark = str_replace("/","-",$auth);

		$index = array("Org-Name: ","Street-Address: ","City: ","State: ","Postal-Code: ","Country-Code: ","Phone: ","Created: ","Updated: ");
		$key = array("$i_org ","$i_street ","$i_city ","$i_state ","$i_postal ","$i_country ","$i_phone ","$date ","$date ");
		$file = "";
		for($i = 0; $i<count($key);$i++){

			$file .= $index[$i] . $key[$i] . " \n";


		}
		// creates two arrays with field and key, merging them into one string

		echo nl2br($file);

		$i_org = strtolower($i_org);
		$i_org= str_replace(" ","",$i_org);

		$new= fopen("/usr/local/rwhoisd/net-192.168.192.0-19/data/org/". $i_org .".txt",'w');
		if(fwrite($new,$file)){
			echo "File Written successfully";
			echo shell_exec("/usr/local/rwhoisd/bin/rwhois_indexer -c rwhoisd.conf -i -s txt");

		}
		else{
			echo "FAIL";
		}



		$new= fopen("/usr/local/rwhoisd/net-10.0.0.0-8/data/org/". $i_org .".txt",'w');
		if(fwrite($new,$file)){
			echo "File Written successfully";
			echo shell_exec("/usr/local/rwhoisd/bin/rwhois_indexer -c rwhoisd.conf -i -s txt");

		}
		else{
			echo "FAIL";
		}


		//writes two org files

	}



	function test_input($data) {
		$data = trim($data);
		$data = stripslashes($data);
		$data = htmlspecialchars($data);

		return $data;
	}



	//removes crap





	?>










	<h3>Insert Org Info</h3>

	<form method="post"
		action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
		Auth Area <br> <select name="auth">
			<option value="192.168.192.0/19">192.168.192.0/19</option>
			<br>
			<option value="10.0.0.0/8">10.0.0.0/8</option>
		</select> <br>Org-Name:<br> <input type="text" name="i_org"
			value="<?php echo $i_org;?>"> <span class="error">* <?php echo $e_org;?>
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
