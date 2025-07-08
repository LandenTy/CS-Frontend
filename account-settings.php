<?php
session_start();

// Redirect if not logged in
if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}

// Handle logout action
if (isset($_POST['logout'])) {
    $_SESSION = [];
    session_destroy();
    header("Location: login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Account Settings</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #7f5af0;
            color: white;
            margin: 0;
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

        /* Highlight the current page link */
        .nav-links a.current {
            font-weight: 700;
            text-decoration: underline;
        }

        .user-icon {
            font-size: 20px;
            cursor: pointer;
        }

        /* Container for content */
        .container {
            background: rgba(0,0,0,0.3);
            padding: 2rem 3rem;
            border-radius: 12px;
            box-shadow: 0 8px 24px rgba(0,0,0,0.2);
            text-align: center;
            max-width: 500px;
            margin: 3rem auto;
        }

        h1 {
            margin-bottom: 1.5rem;
        }

        form button {
            background-color: #ffcc00;
            border: none;
            padding: 12px 24px;
            font-size: 1rem;
            font-weight: bold;
            color: black;
            border-radius: 6px;
            cursor: pointer;
            transition: background-color 0.2s ease;
        }

        form button:hover {
            background-color: #e6b800;
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
        <a href="./account-settings.php" class="current">
            <img src="images/user-icon.svg" alt="User Icon" class="user-icon" />
        </a>
    </div>
</nav>

<div class="container">
    <h1>Account Settings</h1>
    <form method="post" action="">
        <button type="submit" name="logout">Log Out</button>
    </form>
</div>

</body>
</html>
