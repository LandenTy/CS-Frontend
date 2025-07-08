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
    <title>My Projects</title>
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

        /* New project card specific */
        .project-card.new-project {
            color: #33AED0;
            font-weight: bold;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            cursor: pointer;
        }

        .new-project .plus {
            font-size: 32px;
            margin-bottom: 8px;
            user-select: none;
        }

        .project-card, .project-card.new-project {
            height: 160px; /* shorter height */
            width: 220px;  /* wider */
            box-sizing: border-box;
            display: flex;
            flex-direction: column; /* vertical stack for left content */
            padding: 12px;
            position: relative; /* needed for absolute menu */
            background-color: white;
            color: black;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.2);
            cursor: pointer;
            user-select: none;
            transition: box-shadow 0.3s ease;
        }

        .project-card:hover {
            box-shadow: 0 6px 14px rgba(0,0,0,0.3);
        }

        .project-content {
            flex: 1 1 auto;
            display: flex;
            flex-direction: column;
            justify-content: flex-start;
            align-items: stretch;
        }

        /* Placeholder image on top */
        .project-image {
            width: 100%;
            height: 70px; /* smaller height */
            background-color: #ddd;
            border-radius: 6px;
            margin-bottom: 6px;
            display: flex;
            justify-content: center;
            align-items: center;
            color: #999;
            font-size: 40px; /* smaller */
            user-select: none;
        }

        /* Divider line */
        .project-divider {
            height: 1px;
            background-color: #ccc;
            margin-bottom: 6px;
        }

        /* Project info text below divider */
        .project-info {
            display: flex;
            flex-direction: column;
            gap: 2px;
            color: #333;
        }

        .project-title {
            font-weight: 600;
            font-size: 14px;
            color: black;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .project-author {
            font-size: 12px;
            color: #666;
        }

        /* Vertical dots container on bottom right */
        .project-menu {
            position: absolute;
            bottom: 8px;
            right: 8px;
            width: 24px;
            height: 24px;
            display: flex;
            justify-content: center;
            align-items: center;
            cursor: pointer;
            user-select: none;
        }

        .project-menu::before {
            content: '\22EE';
            font-size: 20px;
            color: #666;
            line-height: 1;
        }

        /* Adjust project grid gap a bit */
        .project-grid {
            display: flex;
            gap: 24px;
            padding: 40px;
            flex-wrap: wrap;
            justify-content: flex-start;
        }

        /* Popup menu styling */
        .project-menu-popup {
            position: absolute;
            bottom: 36px; /* above the dots */
            right: 0;
            background: white;
            color: black;
            border-radius: 6px;
            box-shadow: 0 2px 6px rgba(0,0,0,0.2);
            width: 140px;
            font-size: 14px;
            z-index: 1000;
            display: none;
            flex-direction: column;
            user-select: none;
        }

        .project-menu-popup.visible {
            display: flex;
        }

        .project-menu-popup button {
            background: none;
            border: none;
            padding: 10px 16px;
            text-align: left;
            cursor: pointer;
            width: 100%;
            border-radius: 6px;
            transition: background-color 0.2s;
        }

        .project-menu-popup button:hover {
            background-color: #eee;
        }
    </style>
</head>
<body>

<script>
  const USER_ID = <?php echo json_encode($_SESSION["user_id"]); ?>;
</script>

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

<div class="project-grid" id="projectGrid">

    <!-- New Project Card FIRST -->
    <div class="project-card new-project" id="newProjectCard">
        <div class="plus">+</div>
        <p>New Project</p>
    </div>

</div>

<script>
    async function fetchProjects() {
        try {
            const response = await fetch('https://files.steelecs.org/projects/' + encodeURIComponent(USER_ID));
            if (!response.ok) throw new Error('Failed to fetch projects');
            const projects = await response.json();
            displayProjects(projects);
        } catch (e) {
            alert('Error loading projects: ' + e.message);
        }
    }

    function displayProjects(projects) {
        const projectGrid = document.getElementById('projectGrid');

        // Remove old project cards except the "New Project"
        Array.from(projectGrid.querySelectorAll('.project-card:not(.new-project)')).forEach(el => el.remove());

        if (!Array.isArray(projects) || projects.length === 0) {
            const noProjectsMsg = document.createElement('p');
            noProjectsMsg.textContent = "No projects found.";
            noProjectsMsg.style.color = "white";
            projectGrid.appendChild(noProjectsMsg);
            return;
        }

        projects.forEach(item => {
            let owner, projectName;
            if (typeof item === 'string') {
                projectName = item;
                owner = USER_ID;
            } else if (typeof item === 'object') {
                owner = item.owner || item.user || USER_ID;
                projectName = item.projectName || item.name || 'Untitled Project';
            } else {
                return;
            }

            const link = document.createElement('a');
            link.className = 'project-link';
            link.href = 'editor.php?owner=' + encodeURIComponent(owner) + '&project=' + encodeURIComponent(projectName);

            const card = document.createElement('div');
            card.className = 'project-card';

            // Left side content container
            const content = document.createElement('div');
            content.className = 'project-content';

            // Placeholder image div
            const img = document.createElement('div');
            img.className = 'project-image';
            img.textContent = '🗂'; // Folder emoji placeholder

            // Divider line
            const divider = document.createElement('div');
            divider.className = 'project-divider';

            // Project info container
            const info = document.createElement('div');
            info.className = 'project-info';

            const title = document.createElement('div');
            title.className = 'project-title';
            title.textContent = projectName;

            const author = document.createElement('div');
            author.className = 'project-author';
            author.textContent = `Author: ${owner}`;

            info.appendChild(title);
            info.appendChild(author);

            content.appendChild(img);
            content.appendChild(divider);
            content.appendChild(info);

            // Right side vertical dots menu
            const menu = document.createElement('div');
            menu.className = 'project-menu';

            // Popup menu container
            const popup = document.createElement('div');
            popup.className = 'project-menu-popup';

            // Delete button
            const deleteBtn = document.createElement('button');
            deleteBtn.textContent = 'Delete project';
            deleteBtn.addEventListener('click', (evt) => {
                evt.stopPropagation();
                popup.classList.remove('visible');
                if (confirm(`Are you sure you want to delete project "${projectName}"? This cannot be undone.`)) {
                    deleteProject(owner, projectName);
                }
            });

            // Rename button
            const renameBtn = document.createElement('button');
            renameBtn.textContent = 'Rename project';
            renameBtn.addEventListener('click', (evt) => {
                evt.stopPropagation();
                popup.classList.remove('visible');
                const newName = prompt('Enter new project name:', projectName);
                if (newName && newName.trim() && newName !== projectName) {
                    renameProject(owner, projectName, newName.trim());
                }
            });

            popup.appendChild(deleteBtn);
            popup.appendChild(renameBtn);

            menu.appendChild(popup);

            // Toggle popup on menu click
            menu.addEventListener('click', (evt) => {
                evt.preventDefault();
                evt.stopPropagation();
                // Close any other open menus
                document.querySelectorAll('.project-menu-popup.visible').forEach(openPopup => {
                    if (openPopup !== popup) openPopup.classList.remove('visible');
                });
                popup.classList.toggle('visible');
            });

            // Clicking card or link closes menu
            card.addEventListener('click', () => {
                popup.classList.remove('visible');
            });

            card.appendChild(content);
            card.appendChild(menu);

            link.appendChild(card);
            projectGrid.appendChild(link);
        });
    }

    // Close popup menus when clicking outside
    document.addEventListener('click', () => {
        document.querySelectorAll('.project-menu-popup.visible').forEach(popup => {
            popup.classList.remove('visible');
        });
    });

    // Placeholder delete function
    async function deleteProject(owner, projectName) {
        const url = `https://files.steelecs.org/projects/${encodeURIComponent(USER_ID)}/owner/${encodeURIComponent(owner)}/project/${encodeURIComponent(projectName)}`;
        console.log("Attempting to delete:", url);

        try {
            const response = await fetch(url, {
                method: 'DELETE'
            });

            const data = await response.json();

            if (response.ok && data.success) {
                console.log('Deleted project:', projectName);
                alert(`Project "${projectName}" deleted.`);
                fetchProjects(); // Refresh list
            } else {
                alert('Error deleting project: ' + (data.error || 'Unknown error'));
            }
        } catch (err) {
            console.error('Failed to delete project:', err);
            alert('Server error while deleting project.');
        }
    }

    // Placeholder rename function
    async function renameProject(owner, oldName, newName) {
        alert(`Rename project from "${oldName}" to "${newName}" by ${owner}\n\nImplement your rename API call here.`);
        // After successful rename, refresh projects list:
        // await fetchProjects();
    }

    document.getElementById('newProjectCard').addEventListener('click', async function () {
        const projectName = prompt("Enter project name:");
        if (!projectName || projectName.indexOf('/') !== -1 || projectName.trim().length === 0) {
            alert("Invalid project name.");
            return;
        }
        try {
            const response = await fetch('https://files.steelecs.org/projects/' + encodeURIComponent(USER_ID), {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ projectName: projectName.trim() })
            });
            const data = await response.json();
            if (response.ok && data.success) {
                alert('Project created!');
                fetchProjects(); // refresh project list
            } else {
                alert('Error: ' + (data.error || 'Unknown error'));
            }
        } catch {
            alert('Server error while creating project.');
        }
    });

    // On page load
    fetchProjects();
</script>
</body>
</html>
