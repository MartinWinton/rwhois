
<html>

<head>
<link rel="icon" type="image/png" href='kMxOTN1.png'">
<style>
.error {
	color: #FF0000;
}
</style>

<title>RWHois- Martin Winton</title>
</head>

<body>










	<?php

	include 'functions.php';


	$ip= $email = $tech_contact = $admin_contact = $organization="";
	$e_email = $e_tech = $e_admin = $e_organization = $e_ip = '';





	$authos=get_auths();
	$orgs = [];

	for($i=0;$i<count($authos);$i++){

		$autho = $authos[$i];

		$dir = "/usr/local/rwhoisd/net-$autho/data/org/";

		if (is_dir($dir)){
			if ($dh = opendir($dir)){



				// initializes extraction variables

				while (($file = readdir($dh)) !== false){
					if (preg_match('/\.txt/',$file)){



						$string = file_get_contents("/usr/local/rwhoisd/net-$autho/data/org/" . $file);
						preg_match_all("/((.+): (.+))/",$string,$matches);

						$test = test_input($matches[3][0]);
						$ips = test_input($matches[3][4]);
						$test = strtolower($test);



						if(!in_array($test,$orgs)){

							array_push($orgs,$test);

							//extracts orgs for dropdown box
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

	}


	$i = 0;
	$networks = [];

	$techs = [];
	$admins = [];
	$created = [];
	$auth = '';

	for($i=0;$i<count($authos);$i++){

		$autho = $authos[$i];

		$dir = "/usr/local/rwhoisd/net-$autho/data/network/";



		if (is_dir($dir)){
			if ($dh = opendir($dir)){
				$dir = scandir($dir);

				// initializes extraction variables
				for ($k = 0; $k<count($dir);$k++){
					$file = $dir[$k];

					if (preg_match('/\d+\d/',$file)){




						if (preg_match("/$autho/",$file)){


							// ignores auth file so range checker works

						}


						else{


							$string = file_get_contents("/usr/local/rwhoisd/net-$autho/data/network/" . $file);

							preg_match_all("/((.+): (.+))/",$string,$matches);
							//var_dump($matches);
							if (isset($matches[3][5]) and $matches[2][5] == "Organization"){

									
								array_push($networks,test_input($matches[3][3]));


								// extracts static created and auth data


						

								if(!in_array(trim($matches[3][6]),$techs) and trim($matches[3][6]) != ''){
									array_push($techs ,trim($matches[3][6]));
									


								}

								if(!in_array(trim($matches[3][7]),$admins) and trim($matches[3][7]) != ''){
									array_push($admins, trim($matches[3][7]));

								}




							}

						}

					}

				}


				//var_dump($techs);
				//var_dump($admins);
				closedir($dh);
			}
		}

	}





	//creates error and insert variables



	if (empty($_POST["ip"]) and isset($_POST['add'])) {
		$e_ip = "You must enter IP";
	}

	elseif(isset($_POST["ip"]) and  !preg_match('/^(([0-9]{1,3}\.){3}[0-9]{1,3})(\/([0-9]|[1-2][0-9]|3[0-2]))?$/',$_POST["ip"])) {


		$e_ip = "Invalid IP Address";
	}




	elseif(!empty($_POST["ip"])) {


		preg_match('/^(([0-9]{1,3}\.){3}[0-9]{1,3})(\/([0-9]|[1-2][0-9]|3[0-2]))?$/',$_POST["ip"],$match);

		$auths= [];
		//echo count($authos);
		for($i = 0; $i<count($authos);$i++){
			$thing = str_replace('-','/',$authos[$i]);
			array_push($auths,$thing);


		}
		//var_dump(valid_auths($match[0]));
		if(valid_auths($match[0],$auths)[0] != 0){




			//var_dump($match);

			if(in_array($match[0],$networks)){
				$e_ip = "IP already in System!";
			}


			$netmask = (netmask($match[0]));


			//echo $netmask;

			$ip_address = valid($match[0]);

			if($ip_address === False){
				$e_ip = "Invalid IP";
			}
			$ip_nmask = $netmask;

			//echo $ip_address;

			$ips =	get_both2($ip_address,$ip_nmask);

			//var_dump($ips);

			$check = TRUE;

			for($b = 0; $b< count($networks);$b++){
				//echo '<br>';
				//echo $networks[$b];

				if(ip_in_range($ips[0],$networks[$b]) or ip_in_range($ips[1],$networks[$b])){

					//echo $networks[$b];
					$check = FALSE;
					break;

				}

			}

			for($b = 0; $b< count($networks);$b++){

				//var_dump($networks);
				$thing = $networks[$b];
				$thing = trim($thing);
				preg_match('/^(([0-9]{1,3}\.){3}[0-9]{1,3})(\/([0-9]|[1-2][0-9]|3[0-2]))?$/',$thing,$match2);
				//echo $thing;
				//var_dump($match2);
				//var_dump($match2);
				$netmask = (netmask($match2[0]));

				$ip_address = valid($match2[0]);
				$ip_nmask = $netmask;

				$ips =	get_both2($ip_address,$ip_nmask);



				if(ip_in_range($ips[0],$_POST["ip"]) or ip_in_range($ips[1],$_POST["ip"])){
					echo "ew";
					$check = FALSE;
					break;

				}

			}


			// checks if entereed range is in another range or vise versa



			if($check == FALSE){

				$e_ip = "IP in range already exists";
			}




			else{
				$ip= test_input($_POST["ip"]);


			}







		}


		else{

			$e_ip = "Invalid IP for Auth";
		}


	}




	if (empty($_POST["email"]) and isset($_POST['add'])) {
		$e_email = "You must enter email";
	}

	elseif(isset($_POST["email"]) and !filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {


		$e_email = "Invalid email";
	}




	elseif(!empty($_POST["email"])) {
		$email= test_input($_POST["email"]);
	}






	if(!empty($_POST["tech_contact"])) {


		if($_POST["tech_contact"] == "new_tech"){
			$tech_contact = test_input($_POST["i_new_tech"]);
		
			if ($tech_contact == ''){
			
				$e_tech = "When choosing new, please enter a  contract";
				
				
			}

		}

		else{

			$tech_contact= test_input($_POST["tech_contact"]);
		}
	}






	if(!empty($_POST["admin_contact"])) {




		if($_POST["admin_contact"] == "new_admin"){
			$admin_contact = test_input($_POST["i_new_admin"]);
			
			if ($admin_contact == '') {
				$e_admin = "When choosing new, please enter a  contract";
			}
			

		}

		else{

			$admin_contact= test_input($_POST["admin_contact"]);
		}





	}








	if(!empty($_POST["organization"])) {





		$organization= test_input($_POST["organization"]);



	}
	// assigns variables and creates errors otherwise



	if($e_ip == "" and $e_email == '' and $e_tech == '' and $e_admin == '' and isset($_POST['add'])){


		echo $match[0];

		$auth = valid_auths($match[0],$auths)[1];

		echo $auth;

		$test_auth = str_replace('/','-',$auth);


		$dir = "/usr/local/rwhoisd/net-$test_auth/data/org/";

		if (is_dir($dir)){
			if ($dh = opendir($dir)){

				$test_orgs = [];

				// initializes extraction variables

				while (($file = readdir($dh)) !== false){
					if (preg_match('/\.txt/',$file)){



						$string = file_get_contents("/usr/local/rwhoisd/net-$test_auth/data/org/" . $file);

						echo '<br>';

						preg_match_all("/((.+): (.+))/",$string,$matches);
						//	var_dump($matches);

						$test_org = test_input($matches[3][0]);

						echo $test_org;



						if(!in_array($test_org,$test_orgs)){

							array_push($test_orgs,$test_org);

							//extracts orgs for dropdown box
						}


					}
				}
			}
		}


		var_dump($test_orgs);
		if(!in_array(trim($organization),$test_orgs)){
			die("Chosen org does not exist for auth!");
		}



		$t = time();
		$date = date("Y-m-d",$t);
		$date = str_replace("-","",$date);
		// creates updated field




		$created_index = array_search($ip,$networks);




		$created_at = $date;


		$auth = valid_auths($match[0],$auths)[1];
		$id = "NETBLK-ISPWIDGET." .$auth;

		// take auth from valid_auth function and creates ID


		preg_match('/^(([0-9]{1,3}\.){3}[0-9]{1,3})(\/([0-9]|[1-2][0-9]|3[0-2]))?$/',$ip,$match);




		$ip = $match[0];


		$netmask = (netmask($ip));
		$ip_address = valid($ip);

		$ip_nmask = $netmask;

		$block =	ipv4Breakout();
		// calculates block from ip

		$end = $match[3];


		$ip = $ip_address.$end;






		$network_name = "ISPWIDGET-" .$match[1];
		// extracts first 4 parts of IP to crate network name


		//var_dump($match);




		$index = array("ID: ", "Auth-Area: ","Network-Name: ","IP-Network: ","IP-Network-Block: ","Organization: ","Tech-Contact: ","Admin-Contact: ","Created: ","Updated: ","Updated-By: ");
		$key = array("$id ","$auth ","$network_name ","$ip ","$block ","$organization ","$tech_contact ","$admin_contact ","$created_at ","$date ","$email");
		$file = "";
		for($i = 0; $i<count($key);$i++){

			$file .= $index[$i] . $key[$i] . " \n";


		}
		// creates two arrays with field and key, merging them into one string

		echo nl2br($file);

		$name = str_replace("/","-",$ip);
		$auth = str_replace("/","-",$auth);
		// turns '/' into '-' to create valid file name

		$new= fopen("/usr/local/rwhoisd/net-$auth/data/network/". $name .".txt",'w');
		if(fwrite($new,$file)){
			echo "File Written successfully";
			echo exec("/usr/local/rwhoisd/bin/rwhois_indexer -c /usr/local/rwhoisd/rwhoisd.conf -i -s txt 2>&1",$do);
			echo exec("sudo /etc/init.d/rwhosid restart 2>&1",$doo);

		}
		else{
			echo "FAIL";

		}
		// writes data into custom-named file, creating one if necessary







	}










	//removes crap



	function ipv4Breakout () {
		global $ip_address;
		global $ip_nmask;
		//convert ip addresses to long form
		$ip_address_long = ip2long($ip_address);
		$ip_nmask_long = ip2long($ip_nmask);
		//caculate network address
		$ip_net = $ip_address_long & $ip_nmask_long;
		//caculate first usable address
		$ip_host_first = ((~$ip_nmask_long) & $ip_address_long);
		$ip_first = ($ip_address_long ^ $ip_host_first) + 1;
		//caculate last usable address
		$ip_broadcast_invert = ~$ip_nmask_long;
		$ip_last = ($ip_address_long | $ip_broadcast_invert) - 1;
		//caculate broadcast address
		$ip_broadcast = $ip_address_long | $ip_broadcast_invert;

		//Output

		$ip_first_short = long2ip($ip_first);
		$ip_last_short = long2ip($ip_last);

		$block = $ip_first_short ." - " .$ip_last_short;

		return $block;

		// returns block in string form
	}





	function get_both2 ($ip_address,$ip_nmask) {


		//convert ip addresses to long form
		$ip_address_long = ip2long($ip_address);
		$ip_nmask_long = ip2long($ip_nmask);
		//caculate network address
		$ip_net = $ip_address_long & $ip_nmask_long;
		//caculate first usable address
		$ip_host_first = ((~$ip_nmask_long) & $ip_address_long);
		$ip_first = ($ip_address_long ^ $ip_host_first) + 1;
		//caculate last usable address
		$ip_broadcast_invert = ~$ip_nmask_long;
		$ip_last = ($ip_address_long | $ip_broadcast_invert) - 1;
		//caculate broadcast address
		$ip_broadcast = $ip_address_long | $ip_broadcast_invert;

		//Output

		$ip_first_short = long2ip($ip_first);
		$ip_last_short = long2ip($ip_last);

		$ips = array($ip_first_short,$ip_last_short);

		return $ips;

		// returns first and beggining version of block for calculatoins
	}





	function ip_in_range( $ip, $range ) {


		list( $range, $netmask ) = explode( '/', $range, 2 );
		$range_decimal = ip2long( $range );
		$ip_decimal = ip2long( $ip );
		$wildcard_decimal = pow( 2, ( 32 - $netmask ) ) - 1;
		$netmask_decimal = ~ $wildcard_decimal;
		return ( ( $ip_decimal & $netmask_decimal ) == ( $range_decimal & $netmask_decimal ) );

		//checks if ip is in range of CIDR IP
	}



	function valid_auths($ip,$auths) {





		$ip_address = valid($ip);
		$netmask= netmask($ip);


		$ip_nmask = $netmask;



		$ips = get_both2($ip_address,$ip_nmask);


		//var_dump($ips);


		for($i = 1; $i<=count($auths);$i++){


			if(ip_in_range($ips[0],$auths[$i-1]) and ip_in_range($ips[1],$auths[$i-1])){
				return array($i,$auths[$i-1]);

			}


		}
		return array(0,0);

		//checks if given ip is in rnage of one of the given auths
	}

	function netmask($ip) {


		$values = explode('/',$ip);

		$cidr = $values[1];
		$bin = 0;
		for( $i = 1; $i <= 32; $i++ ){
			$bin .= $cidr >= $i ? '1' : '0';
		}



		$netmask = long2ip(bindec($bin));



		return $netmask;


		// returns netmask of ip


	}



	function valid($ip) {

		//echo $ip;
		$values = explode('/',$ip);

		$cidr = $values[1];
		$ip_address = $values[0];


		$long = ip2long($ip_address);

		if($long === False){
			return False;
		}
		$bin = decbin($long);
		$bin = str_pad($bin, 32, '0', STR_PAD_LEFT);



		//echo "<br>";
		$compare = str_repeat(1,$cidr);
		$compare = str_pad($compare, 32, '0', STR_PAD_RIGHT);




		$new = '';

		for($i = 0; $i<strlen($bin);$i++){

			if($compare[$i] == '1'){
				$new.= $bin[$i];
			}

			else{
				$new.= '0';
			}
		}





		$new = bindec($new);
		$new = long2ip($new);

		return $new;


		//creates valid IP
	}













	?>










	<h3>Insert IP Info</h3>



	<form method="post"
		action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">

		<br> IP Address:<br> <input type="text" name="ip"><span class="error">*
			<?php echo $e_ip;?>
		</span> <br> Email:<br> <input type="text" name="email"> <span
			class="error">* <?php echo $e_email;?>
		</span><br> Organization:<br> <select name="organization">

			<?php 
			for($k = 0; $k<count($orgs);$k++){

			$org = $orgs[$k];
			$org = test_input($org);

			echo "<option value = \"{$orgs[$k]}\" >$org</option>";
	}

	?>


		</select> <br> Tech Contract: <br> <select name=tech_contact>
			<?php 
			
			for($k = 0; $k<count($techs);$k++){

			$tech = $techs[$k];
			$tech = test_input($tech);





			echo "<option value = \"{$techs[$k]}\" >$tech</option>";
	}

	?>

			<option value="new_tech">Add New</option>;




		</select> <br> New Tech Contract:<br> <input type="text" name="i_new_tech"> <span class="error">*
			<?php echo $e_tech;?>
		</span><br> Admin Contract:<br> <select name=admin_contact>
			<?php 
			for($k = 0; $k<count($admins);$k++){
			$admin = $admins[$k];
			$admin = test_input($admin);




			echo "<option value = \"{$admins[$k]}\" > {$admins[$k]} </option>";
	}

	?>

			<option value="new_admin">Add New</option>;
		</select>
		<br> New Admin Contract:<br> <input type="text"
			name="i_new_admin"> <span
			class="error">* <?php echo $e_admin;?>
		</span><br> <input name="add" type="submit"
			id="add" value="Add IP">


	</form>




</body>
</html>
