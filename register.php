<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/login.css">
    <title>register page</title>
</head>
<?php
require("header.php");
?>
<main class="loginmain">
    <div class="login">
        <div class="container">
          <div id="card">
            <div id="card-content">
              <div id="card-title">
                <h2>REGISTER</h2>
                <div class="underline-title"></div>
            </div>
            <form method="post" class="form" action="backend/controllers/users.php">
                <input type="hidden" name="formType" value="login">
                <label for="user-email" style="padding-top:13px">
                    &nbsp;Email
                </label>

                <input id="user-email" class="form-content" type="email" name="email" autocomplete="on" required />
                <div class="form-border"></div>

                <label for="user-password" style="padding-top:13px">&nbsp;Password
                </label>

                <input id="user-password" class="form-content" type="password" name="password" required />
                <div class="form-border"></div>
                 <label for="username" style="padding-top:13px">
                    &nbsp;Username
                </label>
                <input id="usernane" class="username form-content" type="text" name="username" id="username" required>
                <div class="form-border"></div>
                <input id="submit-btn" type="submit" name="submit" value="login" />
                <a href="login.php" id="signup">Already have a account?</a>
            </form>
        </div>
    </div>
</main>


<?php
require('footer.php');
?>
