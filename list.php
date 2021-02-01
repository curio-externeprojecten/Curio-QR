<?php
require __DIR__ . '/./header.php';
require __DIR__ . '/./backend/init.php';

if (isset($_SESSION['userId'])) {
    $user = selectOne(
        //username
        //rank user/admin/superadmin
        "SELECT `id`, `username`, `rank` FROM users WHERE `id` = :id",
        [":id" => $_SESSION['userId']]
    );
} else {
    header("Location: login.php");
}
?>

<head>
    <link rel="stylesheet" href="css/login.css">
</head>
<main>
    <div class="banner">
        <div class="container">
            <div class="bannertext">
                <h1>All uw instructies</h1>
            </div>
        </div>
    </div>
    <div class="login">
        <div class="container">
          <div id="list">
            <div id="card-content">
            <table>
                <thead>
                    <th>Title</th>
                    <th>Descriptie</th>
                </thead>
                <tbody>
                    <?php
                        $instructions = select("SELECT id, title, description FROM instructions WHERE creator = :id", [":id" => $_SESSION['userId']]);
                        foreach($instructions as $instruction){
                            echo "<tr>";
                            echo "<td> <a href='instructions.php?id=". $instruction['id'] ."'>". $instruction['title']. "</a></td>";
                            echo "<td>". $instruction['description']. "</td>";
                            echo "</tr>";
                        }
                    ?>
                </tbody>
            </table>
            </div>
        </div>
        </div>
    </div>
</main>
<?php
require __DIR__ . '/./footer.php';
?>