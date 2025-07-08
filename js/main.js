import { setupCodeMirror } from './codemirror-setup.js';
import { compileCode } from './code-execution.js';
import { initResizable } from './resizable.js';

let editor;
let isDirty = false;
let currentFileName = '';

function getQueryParams() {
    const params = {};
    window.location.search.substr(1).split('&').forEach(pair => {
        const [key, val] = pair.split('=');
        if (key) params[decodeURIComponent(key)] = decodeURIComponent(val);
    });
    return params;
}

function updateEditorHeader(showAsterisk = false) {
    const editorHeaderSpan = document.querySelector('.editor-header span');
    if (!currentFileName) return;
    editorHeaderSpan.textContent = showAsterisk ? `${currentFileName}*` : currentFileName;
}

async function loadProjectFiles(userId, owner, projectName) {
    try {
        const url = `https://files.steelecs.org/projects/${encodeURIComponent(userId)}/owner/${encodeURIComponent(owner)}/project/${encodeURIComponent(projectName)}/files`;
        const resp = await fetch(url);
        if (!resp.ok) throw new Error('Failed to load files');
        const data = await resp.json();

        const fileListElem = document.querySelector('.file-list');
        fileListElem.innerHTML = '';
        if (!data.files || data.files.length === 0) {
            fileListElem.innerHTML = '<li>No files found</li>';
            return;
        }

        data.files.forEach(filename => {
            const li = document.createElement('li');
            li.textContent = filename;
            li.addEventListener('click', async () => {
                document.querySelectorAll('.file-list li').forEach(el => el.classList.remove('active'));
                li.classList.add('active');
                currentFileName = filename;
                isDirty = false;
                updateEditorHeader(false);

                try {
                    const contentUrl = `https://files.steelecs.org/projects/${encodeURIComponent(userId)}/owner/${encodeURIComponent(owner)}/project/${encodeURIComponent(projectName)}/${encodeURIComponent(filename)}`;
                    const resp = await fetch(contentUrl);
                    if (!resp.ok) throw new Error('Failed to load file content');
                    const data = await resp.json();
                    editor.setValue(data.content);
                } catch (err) {
                    console.error("Failed to load file content:", err);
                    editor.setValue(`# Error loading "${filename}"`);
                }
            });
            fileListElem.appendChild(li);
        });

        // Auto-load main.py or first file
        const firstFile = data.files.includes('main.py') ? 'main.py' : data.files[0];
        const firstLi = Array.from(fileListElem.children).find(li => li.textContent === firstFile);
        if (firstLi) {
            firstLi.classList.add('active');
            currentFileName = firstFile;
            isDirty = false;
            updateEditorHeader(false);

            try {
                const defaultFileUrl = `https://files.steelecs.org/projects/${encodeURIComponent(userId)}/owner/${encodeURIComponent(owner)}/project/${encodeURIComponent(projectName)}/${encodeURIComponent(firstFile)}`;
                const resp = await fetch(defaultFileUrl);
                if (!resp.ok) throw new Error('Failed to load default file content');
                const data = await resp.json();
                editor.setValue(data.content);
            } catch (err) {
                console.error("Failed to load default file content:", err);
                editor.setValue(`# Error loading "${firstFile}"`);
            }
        }

    } catch (e) {
        console.error("Error loading project files:", e);
    }
}

document.addEventListener('DOMContentLoaded', () => {
    editor = setupCodeMirror();

    // Track changes for dirty state
    editor.on('change', () => {
        if (!isDirty) {
            isDirty = true;
            updateEditorHeader(true);
        }
    });

    document.querySelector(".run-btn").addEventListener('click', () => {
        compileCode(editor);
    });

    initResizable();

    const params = getQueryParams();
    const projectOwner = params.owner;
    const projectName = params.project;
    const currentUserId = window.CURRENT_USER_ID;

    if (projectOwner && projectName && currentUserId) {
        loadProjectFiles(currentUserId, projectOwner, projectName);
    }
});

// Handle CTRL+S (or CMD+S) to save file
document.addEventListener('keydown', async (e) => {
    if ((e.ctrlKey || e.metaKey) && e.key === 's') {
        e.preventDefault();

        const params = getQueryParams();
        const projectOwner = params.owner;
        const projectName = params.project;
        const currentUserId = window.CURRENT_USER_ID;
        const fileName = currentFileName;

        if (!fileName || !editor) {
            console.warn('No file selected or editor not ready');
            return;
        }

        const saveUrl = `https://files.steelecs.org/projects/${encodeURIComponent(currentUserId)}/owner/${encodeURIComponent(projectOwner)}/project/${encodeURIComponent(projectName)}/${encodeURIComponent(fileName)}`;

        try {
            const content = editor.getValue();

            const response = await fetch(saveUrl, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ content })
            });

            if (!response.ok) {
                const errData = await response.json();
                throw new Error(errData.error || 'Unknown error while saving file');
            }

            console.log(`Saved ${fileName} successfully`);
            isDirty = false;
            updateEditorHeader(false);
        } catch (err) {
            console.error('Failed to save file:', err);
            alert(`Failed to save ${fileName}: ${err.message}`);
        }
    }
});

window.addEventListener('beforeunload', (e) => {
    if (isDirty) {
        e.preventDefault();
        e.returnValue = ''; // Required for Chrome
    }
});