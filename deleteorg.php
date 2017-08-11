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

	include 'functions.php';
	
	
	$self= $_SERVER['PHP_SELF'];

	$d_org = test_input($_GET["org"]);
	$mark = strtolower(test_input($_GET["org"]).'.txt');
	$mark = str_replace("/","-",$mark);
	$mark = str_replace(" ","",$mark);
	$d_org = str_replace("/","-",$d_org);
	//initializes and removes '/' from ip name and txt version of ip.


	if(isset($_GET["choose"])){

		$ip = test_input($_GET["delete"]);
		$ip = str_replace("/","-",$ip);



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
						array_push($ipfiles,$file);

					}

				}

				closedir($dh);
			}
		}


	}



	// checks database for ip and dies if not found


				?>


	<form method="get" action="/delete2.php">


		<br>
		Auth:<br> <select name="delete">

			<?php 
			$auths = get_auths();
			for($k = 0; $k<count($auths);$k++){

			$autho = $auths[$k];
			$autho= test_input($autho);

			echo "<option value = \"{$auths[$k]}\" >$autho</option>";
	}

	?>
		</select>
		
		
		
		
		Choose IP and click button to delete <br> <input
			name="choose" type="submit" id="choose" value="<?php echo $d_org;?>">



	</form>

</body>
</html>
