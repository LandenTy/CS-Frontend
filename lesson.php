<?php
session_start();
if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}

$videoFile = basename($_GET['video'] ?? '');
$videoPath = "lessons/" . $videoFile;

$editorLesson = isset($_GET['editor']) ? intval($_GET['editor']) : null;

if (!file_exists($videoPath)) {
    die("Video not found.");
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Lesson</title>
    <meta charset="UTF-8">
    <style>
        body {
            background-color: #7f5af0;
            color: white;
            font-family: 'Segoe UI', sans-serif;
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 2rem;
        }
        video {
            width: 100%;
            max-width: 960px;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.4);
        }
        a.back-link {
            color: #ffcc00;
            margin-bottom: 1.5rem;
            font-weight: bold;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <a class="back-link" href="dashboard.php">&larr; Back to Dashboard</a>

    <video controls id="lesson-video">
        <source src="<?= htmlspecialchars($videoPath) ?>" type="video/mp4">
        Your browser does not support the video tag.
    </video>

    <?php if ($editorLesson): ?>
    <script>
        const video = document.getElementById("lesson-video");
        video.addEventListener("ended", () => {
            window.location.href = "editor.php?lesson=<?= $editorLesson ?>&practice=true";
        });
    </script>
    <?php endif; ?>
</body>
</html>
