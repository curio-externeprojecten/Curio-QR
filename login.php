<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/login.css">
    <title>Login page</title>
</head>
<body>
    <header>
       <?php
            require("header.php");
        ?> 
    </header>
    <main>
        <div class="banner">
            <div class="container">
                <div class="bannertext">
                    <h1>Login pagina</h1>
                </div>
            </div>
        </div>
        <div class="login">
         <h1>Login</h1>
             <form action="backend/controllers/users.php" method="post">
                <input type="hidden" name="formType" value="login">
                <input class="email" type="email" name="email" placeholder="email" id="email" required>
                <input class="password" type="password" name="password" placeholder="Password" id="password" required>
             <input type="submit" value="Login">
             </form>
        </div>
    </main>
    <footer>
        <?php
            require('footer.php');
        ?>
    </footer>
</body>
</html>