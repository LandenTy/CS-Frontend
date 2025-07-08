<?php
session_start();
if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}
$practiceMode = isset($_GET["practice"]);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Code Editor | Project Name</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.16/codemirror.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.16/theme/material.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.16/addon/hint/show-hint.min.css" />
    <link rel="icon" type="image/x-icon" href="/images/Hive.ico">
    <link rel="stylesheet" href="style.css" />
    <style>
        #practice-question {
            background: rgb(28, 28, 28);
            padding: 14px;
            border-left: 4px solid #007acc;
            border-radius: 8px;
            margin-bottom: 16px;
            font-size: 14px;
            max-height: 220px;
            overflow-y: auto;
            color: #ddd;
        }
        #practice-question code {
            background: #444;
            color: #eee;
            padding: 2px 5px;
            border-radius: 3px;
            font-family: monospace;
        }
        #practice-question ul {
            padding-left: 18px;
            color: #ccc;
        }
        .file-list li {
            cursor: pointer;
            padding: 6px 10px;
            border-radius: 4px;
        }
        .file-list li:hover {
            background: #333;
        }
        .file-list li.active {
            background: #555;
            font-weight: bold;
        }
    </style>
</head>
<body>

<div class="vscode-layout">

    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <?php if ($practiceMode): ?>
            <div id="practice-question">Loading practice question...</div>
        <?php endif; ?>
        
        <h2>Files</h2>
        <ul class="file-list"></ul>
    </div>

    <div class="vertical-resizer" id="sidebar-resizer"></div>

    <!-- Main Editor Area -->
    <div class="main-panel">
        <div class="editor-header">
            <span>main.py</span>
            <button class="run-btn">▶ Run</button>
        </div>

        <div id="editor-wrapper">
            <textarea id="code"></textarea>
        </div>

        <div class="horizontal-resizer" id="terminal-resizer"></div>

        <div class="output-tabs">
            <button id="terminal-tab" class="tab-button active">Terminal</button>
        </div>

        <div class="output-container" id="terminal">
            <pre id="output">> Output will appear here...</pre>
        </div>

        <div class="output-container hidden" id="shell">
            <div class="terminal-line">
                <span class="terminal-prompt">$</span>
                <span class="terminal-input" contenteditable="true" spellcheck="false"></span>
            </div>
        </div>
    </div>
</div>

<!-- CodeMirror scripts -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.16/codemirror.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.16/mode/python/python.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.16/addon/hint/show-hint.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.16/addon/hint/anyword-hint.min.js"></script>
<script>
    window.CURRENT_USER_ID = <?php echo json_encode($_SESSION["user_id"]); ?>;
</script>
<script type="module" src="./js/main.js"></script>

<?php if ($practiceMode): ?>
    <script type="module" src="./js/practice.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            import('./js/practice.js').then(module => {
                module.loadPracticeQuestion();
            });
        });
    </script>
<?php endif; ?>

</body>
</html>
