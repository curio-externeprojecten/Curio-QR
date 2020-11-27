<?php
require("header.php");
?>
<main class="loginmain">
    <div class="login">
        <h1>register</h1>
        <form action="backend/controllers/users.php" method="post">
            <input type="hidden" name="formType" value="register">
            <input class="email" type="email" name="email" placeholder="Email" id="email" required>
            <input class="password" type="password" name="password" placeholder="Password" id="password" required>
            <input class="username" type="text" name="username" placeholder="Username" id="username" required>
            <input type="submit" value="register">
        </form>
    </div>
</main>


<?php
require('footer.php');
?>
