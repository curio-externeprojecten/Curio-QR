<?php
require __DIR__.'./../init.php';


if($_SERVER['REQUEST_METHOD'] != 'POST'){
    $msg = "Je kunt deze pagina alleen bereiken via een veilige form-invoer.";
    header("location: ../index.php?msg=$msg");
    exit;
}

else if ( $_POST['formType'] == 'register') {
 	$email = $_POST ['email'];
 	$password = $_POST['password'];
 	$username = $_POST['username'];

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
 	
	query("INSERT INTO users (username, email, password)
		VALUES (:username, :email, :password)" ,[
			':username'         => $username,
			':email'          => $email,
			':password'         => $hashedPassword
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
        $user = selectOne("SELECT * FROM users WHERE email = :email",
            [
                ':email'    => $email,
            ]
        );
        $check = password_verify($password, $user['password']);

        if (!$check) {
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
       
} 
else if ($_POST['formType'] == 'logout') {
    // als iemand wilt uitloggen
    session_destroy();
    unset($_SESSION);
    header('location: ../../login.php');
}





?>
