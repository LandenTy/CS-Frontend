<?php
session_start();

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
    <meta charset="UTF-8">
    <style>
        body {
            margin: 0;
            font-family: 'Segoe UI', sans-serif;
            background-color: #7f5af0;
            color: white;
        }

        /* Nav bar */
        nav {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 16px 32px;
            background-color: #6a4de8;
            box-shadow: 0 2px 4px rgba(0,0,0,0.2);
        }

        .logo {
            display: flex;
            align-items: center;
            gap: 10px;
            font-weight: bold;
            font-size: 20px;
        }

        .logo img {
            width: 28px;
            height: 28px;
            border-radius: 4px;
        }

        .nav-links {
            display: flex;
            align-items: center;
            gap: 24px;
            font-size: 16px;
        }

        .nav-links a {
            color: white;
            text-decoration: none;
            font-weight: 500;
        }

        .user-icon {
            font-size: 20px;
        }
    </style>
</head>
<body>

    <nav>
        <div class="logo">
        <img src="images/logo.svg" alt="CS Club Logo" width="28" />
        <strong>CS Club</strong>
        </div>
        <div class="nav-links">
        <a href="./index.php">Home</a>
        <a href="./dashboard.php">Dashboard</a>
        <a href="./projects.php">My Projects</a>
        <a href="./account-settings.php">
            <img src="images/user-icon.svg" alt="User Icon" class="user-icon" />
        </a>
        </div>
    </nav>

</body>
</html>
