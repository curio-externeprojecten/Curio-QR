<?php
require __DIR__.'./../init.php';

// if ($_POST['formtype'] == 'create') {
	
// 	$brand         = $_POST['brand'];
// 	$model          = $_POST['type'];
// 	$color         = $_POST['color'];
// 	$license_plate = $_POST['license_plate'];
// 	$categories_id  = $_POST['categorie_id'];

// 	if (strlen(trim($brand)) <= 2){
// 		redirect('../../public/index.php');
// 	}

// 	query("INSERT INTO cars (brand, model, color, license_plate, categories_id)
// 		VALUES (:brand, :model, :color, :license_plate, :categories_id)" ,[
// 			':brand'         => $brand,
// 			':model'          => $model,
// 			':color'         => $color,
// 			':license_plate' => $license_plate,
// 			':categories_id'  => $categories_id
// 		]);

// 	redirect('../../public/index.php');
// }

 if($_SERVER['REQUEST_METHOD'] != 'POST'){
    $msg = "Je kunt deze pagina alleen bereiken via een veilige form-invoer.";
    header("location: ../index.php?msg=$msg");
    exit;
}

 if ( $_POST['formType'] == 'register') {
 	$email = $_POST ['email'];
 	$password = $_POST['password'];
 	$username = $_POST['username'];
 	$starterrank = 0;

 	$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

 	#wachtwoord checken op hoofdletters kleine letters en cijfers
 	$uppercase  = preg_match('@[A-Z]@', $password);
	$lowercase  = preg_match('@[a-z]@', $password);
	$number     = preg_match('@[0-9]@', $password);
	$whitespace = preg_match('[/\s/]', $password); 

	if(!$uppercase || !$lowercase || !$number || $whitespace || strlen($password) < 8) {
  		exit('Het wachtwoord moet minimaal 8 tekens hebben en er moet een hoofdletter, kleine letter en cijfer in je wachtwoord zitten.');
	}
	#nieuwe speler in database zetten
 	
	query("INSERT INTO users (id, username, email, password, rank)
		VALUES (NULL, :username, :email, :password, :rank)" ,[
			':username'         => $username,
			':email'          => $email,
			':password'         => $hashedPassword,
			'rank' => $starterrank
		]);

	header('location: ../../login.php');


 } 
 // else if ($_POST['formType'] == 'login') {
 // 	$email = $_POST ['email'];
 // 	$password = $_POST['password'];
 // 	$sql = "SELECT * FROM players WHERE email = :email";
 // 	$query = $db->prepare($sql);
 // 	$query->execute([
 // 		'email' => $email
 // 	]);

 // 	# checken of de gebruiker in de database zit
 // 	$userExits = $query->rowCount();
 // 	echo $userExits;
 // 	if ($userExits) {
 // 		$user = $query->fetch();
 // 		$verified = password_verify( $password, $user['password']);


 // 		if (!$verified) {
 // 			exit('Gebruikersnaam / wachtwoord onjuist');
 // 		}

 // 		$_SESSION['id'] = $user['id'];
 // 		$_SESSION['email'] = $users['email'];
 		
 // 		# CHecken of de persoon een admin is
 // 		if ($user['admin'] == 1) {
 // 			header("location: ../admin/adminWebsite.php");
 // 			exit();
 // 		}


 // 		 header('location: ../dashboard.php');;
 // 		 exit();
 // 	}



      

 // }

