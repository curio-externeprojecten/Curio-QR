<?php
require __DIR__.'/./header.php';
require __DIR__.'/./backend/init.php';

if(isset($_SESSION['userId'])){
    $user = selectOne(
        //username
        //rank user/admin/superadmin
        "SELECT id, username, rank FROM users WHERE id = :id",
        [":id" => $_SESSION['userId']]
    );
}else{
    header("Location: login.php"); 
}
?>
<head>
    <title>Instructie aanmaken</title>
    <link rel="stylesheet" href="css/login.css">
</head>
<main class="loginmain">
<div class="banner">
        <div class="container">
            <div class="bannertext">
                <h1>Instructie aanmaken</h1>
            </div>
        </div>
    </div>
    <div class="login">
        <div class="container">
          <div id="card">
            <div id="card-content">
              <div id="card-title">
                <h2>Nieuwe instructie</h2>
            </div>
            <form class="form createForm" action="backend/controllers/informationController.php" method="POST">
                <input type="hidden" name="formtype" value="Create">
                <label class="form-content" for="title">Title</label>
                <input class="form-content" type="text" name="title" required>
                <div class="form-border"></div>
                <label class="form-content" for="description">Descriptie</label>
                <input class="form-content" type="text" name="description">
                <div class="form-border"></div>
                <input id="submit-btn" type="submit" value="bevestigen">
            </form>
            </div>
        </div>
        </div>
    </div>
</main>
<?php
require __DIR__.'\footer.php';
?>