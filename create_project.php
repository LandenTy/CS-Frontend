<?php
session_start();

header('Content-Type: application/json');

if (!isset($_SESSION["user_id"])) {
    echo json_encode(['success' => false, 'message' => 'Not authenticated']);
    exit;
}

$user_id = $_SESSION["user_id"];

// Get JSON input
$input = json_decode(file_get_contents('php://input'), true);
if (!$input || !isset($input['project_name'])) {
    echo json_encode(['success' => false, 'message' => 'No project name provided']);
    exit;
}

$project_name = trim($input['project_name']);

// Sanitize project name: allow only letters, numbers, spaces, dashes, underscores
if (!preg_match('/^[a-zA-Z0-9 _-]+$/', $project_name)) {
    echo json_encode(['success' => false, 'message' => 'Invalid project name characters']);
    exit;
}

// Base directory for projects (adjust this path as needed)
$base_dir = __DIR__ . "/user_projects/" . $user_id;

// Make sure user directory exists
if (!is_dir($base_dir)) {
    mkdir($base_dir, 0755, true);
}

// Project folder path
$project_dir = $base_dir . "/" . $project_name;

if (file_exists($project_dir)) {
    echo json_encode(['success' => false, 'message' => 'Project already exists']);
    exit;
}

// Create the project folder
// Create the project folder
if (mkdir($project_dir, 0755)) {

    // Create a default main.py file inside the new project folder
    $default_code = <<<EOD
# main.py
def main():
    print("Hello, world!")

if __name__ == "__main__":
    main()
EOD;

    file_put_contents($project_dir . '/main.py', $default_code);

    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => 'Failed to create project']);
}
