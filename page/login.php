<?php 
	require("../functions.php");
	
    require("../class/Helper.class.php");
	$Helper = new Helper();
	
	require("../class/User.class.php");
	$User = new User($mysqli);
	
	// kui kasutaja on sisseloginud, siis suuna data lehele
	if(isset ($_SESSION["userId"])) {
		header("Location: data.php");
		exit();
	}
	//var_dump($_GET);
	//echo "<br>";
	//var_dump($_POST);
		
	$signupEmailError = "";
	$signupEmail = "";
	
	//kas on �ldse olemas
	if (isset ($_POST["signupEmail"])) {
		
		// oli olemas, ehk keegi vajutas nuppu
		// kas oli t�hi
		if (empty ($_POST["signupEmail"])) {
			
			//oli t�esti t�hi
			$signupEmailError = "See v�li on kohustuslik";
			
		} else {
				
			// k�ik korras, email ei ole t�hi ja on olemas
			$signupEmail = $_POST["signupEmail"];
		}
		
	}
	
	$signupPasswordError = "";
	
	//kas on �ldse olemas
	if (isset ($_POST["signupPassword"])) {
		
		// oli olemas, ehk keegi vajutas nuppu
		// kas oli t�hi
		if (empty ($_POST["signupPassword"])) {
			
			//oli t�esti t�hi
			$signupPasswordError = "See v�li on kohustuslik";
			
		} else {
			
			// oli midagi, ei olnud t�hi
			
			// kas pikkus v�hemalt 8
			if (strlen ($_POST["signupPassword"]) < 8 ) {
				
				$signupPasswordError = "Parool peab olema v�hemalt 8 tm pikk";
				
			}
			
		}
		
	}
	
	
	$gender = "";
	if(isset($_POST["gender"])) {
		if(!empty($_POST["gender"])){
			
			//on olemas ja ei ole t�hi
			$gender = $_POST["gender"];
		}
	}
	
	if ( isset($_POST["signupEmail"]) &&
		 isset($_POST["signupPassword"]) &&
		 $signupEmailError == "" && 
		 empty($signupPasswordError)
	   ) {
		
		// �htegi viga ei ole, k�ik vajalik olemas
		echo "salvestan...<br>";
		echo "email ".$signupEmail."<br>";
		echo "parool ".$_POST["signupPassword"]."<br>";
		
		$password = hash("sha512", $_POST["signupPassword"]);
		
		echo "r�si ".$password."<br>";
		
		//kutsun funktsiooni, et salvestada
		$User->signup($signupEmail, $password);
		
	}	
	
	
	$notice = "";
	// m�lemad login vormi v�ljad on t�idetud
	if (	isset($_POST["loginEmail"]) && 
			isset($_POST["loginPassword"]) && 
			!empty($_POST["loginEmail"]) && 
			!empty($_POST["loginPassword"]) 
	) {
		$notice = $User->login($_POST["loginEmail"], $_POST["loginPassword"]);
		
		if(isset($notice->success)){
			header("Location: login.php");
			exit();
		}else {
			$notice = $notice->error;
			var_dump($notice->error);
		}
		
	}
	
?>

<?php require("../header.php");?>

<div class="container">
	<div class="row">
	
		<div class="col-sm-4 col-md-3">
	
			<h1>Logi sisse</h1>
			<p style="color:red;"><?php echo $notice; ?></p>
			<form method="POST">
				
				<label>E-post</label><br>
				<div class="form-group">
				<input class="form-control" name="loginEmail" type="email">
				</div>
				
				<br><br>
				
				<label>Parool</label><br>
				<input name="loginPassword" type="password">
							
				<br><br>
				
				<input class="btn btn-success btn-sm hidden-xs" type="submit" value="Logi sisse1">
				<input class="btn btn-success btn-sm btn-block visible-xs-block" type="submit" value="Logi sisse2">
			
			</form>
		</div>
		
		<div class="col-sm-4 col-md-3 col-sm-offset-4 col-md-offset-3">
			<h1>Loo kasutaja</h1>
						
			<form method="POST">
				
				<label>E-post</label><br>
				<input name="signupEmail" type="email" value="<?=$signupEmail;?>" > <?php echo $signupEmailError; ?>
				
				<br><br>
				
				<input placeholder="Parool" name="signupPassword" type="password"> <?php echo $signupPasswordError; ?>
							
				<br><br>
				
				<?php if ($gender == "male") { ?>
					<input type="radio" name="gender" value="male" checked > Mees<br>
				<?php } else { ?>
					<input type="radio" name="gender" value="male"> Mees<br>
				<?php } ?>
				
				<?php if ($gender == "female") { ?>
					<input type="radio" name="gender" value="female" checked > Naine<br>
				<?php } else { ?>
					<input type="radio" name="gender" value="female"> Naine<br>
				<?php } ?>
				
				<?php if ($gender == "other") { ?>
					<input type="radio" name="gender" value="other" checked > Muu<br>
				<?php } else { ?>
					<input type="radio" name="gender" value="other"> Muu<br>
				<?php } ?>
				
				<input class="btn btn-success btn-sm" type="submit" value="Loo kasutaja">
			
			</form>
		</div>	
	
	
	</div>
</div>
		
<?php require("../footer.php");?>

	