<?php

$is_invalid = false;

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    
    $mysqli = require __DIR__ . "/database.php";
    
    $sql = sprintf("SELECT * FROM user
                    WHERE email = '%s'",
                   $mysqli->real_escape_string($_POST["email"]));
    
    $result = $mysqli->query($sql);
    
    $user = $result->fetch_assoc();
    
    if ($user && $user["account_activation_hash"] === null) {
        
        if (password_verify($_POST["password"], $user["password_hash"])) {
            
            session_start();
            
            session_regenerate_id();
            
            $_SESSION["user_id"] = $user["id"];
            
            header("Location: dashboard.php");
            exit;
        }
    }
    
    $is_invalid = true;
}

?>
<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Fredoka:wght@400;600&display=swap">
    <link rel="stylesheet" href="./signup.css">
    <style>
      body {
        display: flex;
        flex-direction: column;
        background-image: url('images/line-up.svg');
        background-repeat: no-repeat;
        background-position: center 5%;
        background-size: cover;
      }
    </style>
</head>
<body>

    <nav>
        <div class="logo">
        <img src="images/logo.svg" alt="CS Club Logo" width="28">
        <strong>CS Club</strong>
        </div>
        <div class="nav-links">
        <a href="./index.php">Home</a>
        <a href="#">About Us</a>
        <a href="#">Roadmap</a>
        <a href="#">Testimonials</a>
        <img src="images/user-icon.svg" alt="User Icon" class="user-icon">
        </div>
    </nav>

    <div class="main-container">
        <div class="login-card">
            <h1>Login</h1>

            <?php if ($is_invalid): ?>
                <div class="error-message">Invalid login</div>
            <?php endif; ?>

            <form method="post">
                <label for="email">Email</label>
                <input type="email" name="email" id="email"
                       value="<?= htmlspecialchars($_POST["email"] ?? "") ?>">

                <label for="password">Password</label>
                <input type="password" name="password" id="password">

                <button>Log in</button>
            </form>
            <a href="forgot-password.php">Forgot Password?</a>
        </div>
    </div>

</body>
</html>








