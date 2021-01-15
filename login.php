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
<<<<<<< Updated upstream
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
        <div class="container">
          <div id="card">
            <div id="card-content">
              <div id="card-title">
                <h2>LOGIN</h2>
                <div class="underline-title"></div>
            </div>
            <form method="post" class="form" action="backend/controllers/users.php">
                <input type="hidden" name="formType" value="login">
                <label for="user-email" style="padding-top:13px">
                    &nbsp;Email
                </label>
                <input id="user-email" class="form-content" type="email" name="email" autocomplete="on" required />
                <div class="form-border"></div>
                <label for="user-password" style="padding-top:22px">&nbsp;Password
                </label>
                <input id="user-password" class="form-content" type="password" name="password" required />
                <div class="form-border"></div>
                <input id="submit-btn" type="submit" name="submit" value="login" />
                <a href="register.php" id="signup">Don't have account yet?</a>
            </form>
        </div>
    </div>
</div>
</div>




</main>
<footer>
    <?php
    require('footer.php');
    ?>
</footer>
=======
       <?php
            require("header.php");
        ?> 
    </header>
    <main class="loginmain">
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
>>>>>>> Stashed changes
</body>
</html>