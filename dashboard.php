<?php
session_start();
if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}

// Define your lessons here
$lessons = [
    ['title' => 'What is Python?',         'file' => 'lesson1.mp4', 'editor_after' => false],
    ['title' => 'Why Learn Python?',       'file' => 'lesson1.mp4', 'editor_after' => false],
    ['title' => 'Intro to For Loops',      'file' => 'lesson1.mp4', 'editor_after' => true],
    ['title' => 'If/Else Practice',        'file' => 'lesson1.mp4', 'editor_after' => true],
    ['title' => 'Installing Python',       'file' => 'lesson1.mp4', 'editor_after' => false],
    ['title' => 'Writing First Program',   'file' => 'lesson1.mp4', 'editor_after' => true],
];
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

        nav {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1rem 2rem;
            background-color: #6a4de8;
            box-shadow: 0 2px 4px rgba(0,0,0,0.2);
        }

        .logo {
            display: flex;
            align-items: center;
            gap: 10px;
            font-weight: bold;
            font-size: 1.25rem;
        }

        .logo img {
            width: 28px;
            height: 28px;
            border-radius: 4px;
        }

        .nav-links {
            display: flex;
            align-items: center;
            gap: 1.5rem;
            font-size: 1rem;
        }

        .nav-links a {
            color: white;
            text-decoration: none;
            font-weight: 500;
        }

        .user-icon {
            width: 24px;
        }

        .dashboard-container {
            max-width: 1100px;
            margin: 0 auto;
            padding: 2rem 1rem;
        }

        .top-row {
            display: flex;
            gap: 2rem;
            flex-wrap: wrap;
            margin-bottom: 2rem;
        }

        .unit-box, .progress-box {
            background: white;
            border-radius: 12px;
            color: black;
            padding: 2rem;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }

        .unit-box {
            flex: 2;
        }

        .progress-box {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .unit-box h2 {
            font-size: 1.75rem;
            font-weight: 800;
            margin-bottom: 0.5rem;
        }

        .unit-box p {
            font-size: 1.2rem;
            margin-bottom: 1.5rem;
        }

        .continue-button {
            background-color: #ffcc00;
            border: none;
            padding: 0.75rem 1.5rem;
            font-weight: bold;
            font-size: 0.9rem;
            border-radius: 6px;
            cursor: pointer;
            box-shadow: 0 2px 4px rgba(0,0,0,0.2);
        }

        .progress-ring {
            width: 120px;
            height: 120px;
            position: relative;
        }

        .progress-ring circle {
            fill: none;
            stroke-width: 12;
        }

        .progress-ring .background {
            stroke: #eee;
        }

        .progress-ring .progress {
            stroke: #9b4de0;
            stroke-linecap: round;
            stroke-dasharray: 314;
            stroke-dashoffset: calc(314 - (314 * 0 / 100));
            transform: rotate(-90deg);
            transform-origin: center;
        }

        .progress-ring-text {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            font-size: 1.1rem;
            font-weight: bold;
            text-align: center;
        }

        .lessons-title {
            font-size: 1.5rem;
            font-weight: bold;
            margin-bottom: 1rem;
        }

        .lesson-grid {
            display: flex;
            gap: 1rem;
            flex-wrap: wrap;
        }

        .lesson-grid a.lesson-card {
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            background: white;
            width: 80px;
            height: 80px;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            transition: transform 0.2s, box-shadow 0.2s;
            font-weight: bold;
            color: black;
            text-decoration: none;
        }

        .lesson-grid a.lesson-card:hover {
            transform: scale(1.05);
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        }

        @media (max-width: 768px) {
            .top-row {
                flex-direction: column;
            }
        }
    </style>
</head>
<body>

<nav>
    <div class="logo">
        <img src="images/logo.svg" alt="CS Club Logo" />
        <strong>CS Club</strong>
    </div>
    <div class="nav-links">
        <a href="./index.php">Home</a>
        <a href="./dashboard.php">Dashboard</a>
        <a href="./Projects.php">My Projects</a>
        <a href="./account-settings.php">
            <img src="images/user-icon.svg" alt="User Icon" class="user-icon" />
        </a>
    </div>
</nav>

<div class="dashboard-container">
    <div class="top-row">
        <div class="unit-box">
            <h2>UNIT 1 - INTRODUCING PYTHON</h2>
            <p>Lesson 1: What is Python?</p>
            <button class="continue-button">Continue</button>
        </div>
        <div class="progress-box">
            <div class="progress-ring">
                <svg width="120" height="120">
                    <circle class="background" cx="60" cy="60" r="50"></circle>
                    <circle class="progress" cx="60" cy="60" r="50"></circle>
                </svg>
                <div class="progress-ring-text">0%<br><small>of total</small></div>
            </div>
        </div>
    </div>

    <div class="lessons-title">Lessons:</div>
    <div class="lesson-grid">
        <?php foreach ($lessons as $i => $lesson): ?>
            <?php
                $href = "lesson.php?video=" . urlencode($lesson['file']);
                if ($lesson['editor_after']) {
                    $href .= "&editor=" . ($i + 1); // pass lesson number to redirect to editor
                }
            ?>
            <a class="lesson-card" href="<?= $href ?>">
                <?= "L" . ($i + 1) ?>
            </a>
        <?php endforeach; ?>
    </div>

    <script>
        function updateProgress(percent) {
            percent = Math.max(0, Math.min(percent, 100));
            const circle = document.querySelector('.progress-ring .progress');
            const offset = 314 - (314 * percent / 100);
            circle.style.strokeDashoffset = offset;
            const textElem = document.querySelector('.progress-ring-text');
            textElem.innerHTML = `${percent}%<br><small>of total</small>`;
        }

        updateProgress(0);
    </script>
</div>

</body>
</html>
