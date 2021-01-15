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

else if ( $_POST['formType'] == 'register') {
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

else if ($_POST['formType'] == 'login') {
    // 1. plaats $_POST waarden in een mooie variabele
    $email = $_POST['email'];
    $password = $_POST['password'];
    
    // 2. Valideren van ingekomen gegevens (optimalisatie)

// onhash het wachtwoord??


    // 3. check of account met combinatie password en email bestaat
        // a. probeer de user te selecteren met dit wachtwoord en email combinatie
        $user = selectOne("SELECT * FROM users WHERE email = :email AND password = :password",
            [
                ':email'    => $email,
                ':password' => $password
            ]
        );
        echo $user;

        if ($user == false) {
            echo "email of wachtwoord niet goed";
            exit;
        }

        // welke conclusie kunnen we nu trekken?
            // ingevoerde gebruikersnaam en wachtwoord zijn bij ons bekend in systeem
        
        // b. De sessie vullen met gegevens
        $_SESSION['username'] = $user['name'];
        $_SESSION['loggedIn'] = true;
        $_SESSION['userId'] = $user['id'];

        // c. de gebruiker redirecten naar secret.php
        header('location: ../../dashboard.php');;
         exit();
       
    // het login script verder maken.
} 
else if ($_POST['formType'] == 'logout') {
    // als iemand wilt uitloggen
    session_destroy();
    unset($_SESSION);
    redirect('../../public/auth/login.php');
}





?>
