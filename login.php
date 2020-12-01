<?php
require("header.php");
?>
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
<?php
require('footer.php');
?>