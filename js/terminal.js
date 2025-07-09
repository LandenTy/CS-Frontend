// Example: expected output for your problem (you can customize this per problem)
const expectedOutputLines = [
  "Total steps: 49180",
  "Average steps per day: 7025.714285714285",
  "Day with highest steps (0-based): 5",
  "Days with more than 7000 steps: [2, 3, 5]"
];

// Helper: simple output checker (string match or more advanced parsing possible)
function checkOutputCorrectness(studentOutput) {
  // Normalize outputs (trim, ignore case, etc.)
  const outputLines = studentOutput.trim().split('\n').map(line => line.trim());

  // Basic check: all expected lines appear somewhere in output (order matters here)
  if (expectedOutputLines.length !== outputLines.length) return false;
  for (let i = 0; i < expectedOutputLines.length; i++) {
    if (outputLines[i] !== expectedOutputLines[i]) return false;
  }
  return true;
}

// Call this function after your code execution completes and you get `studentOutput`
function displayOutputWithCheck(studentOutput) {
  outputEl.textContent = studentOutput;

  const isCorrect = checkOutputCorrectness(studentOutput);

  const resultLine = document.createElement('div');
  resultLine.style.marginTop = '12px';
  resultLine.style.fontWeight = 'bold';
  resultLine.style.color = isCorrect ? 'limegreen' : 'crimson';
  resultLine.textContent = isCorrect ? '✅ Correct!' : '❌ Incorrect. Please try again.';

  outputEl.appendChild(resultLine);
}

const outputEl = document.getElementById('output');
const currentURL = window.location.href;
document.addEventListener('keydown', function(event) {
    if ((event.ctrlKey || event.metaKey) && event.key === 's') {
        event.preventDefault()
    }
});
outputEl.addEventListener('mousedown', function(e) {
    const isClickInsideInput = e.target.classList.contains('terminal-input');
    const active = document.activeElement;
    if (!isClickInsideInput && active && active.classList.contains('terminal-input')) {
        e.preventDefault()
    }
});
outputEl.addEventListener('click', function(e) {
    const inputs = [...document.querySelectorAll('.terminal-input')];
    const last = inputs[inputs.length - 1];
    if (!last) return;
    if (!last.isContentEditable || document.activeElement === last) return;
    if (e.target === outputEl || e.target.classList.contains('terminal-line')) {
        last.focus()
    }
});
document.addEventListener('keydown', function(e) {
    if (['ArrowUp', 'ArrowDown', 'PageUp', 'PageDown'].includes(e.key) && document.activeElement.classList.contains('terminal-input')) {
        e.preventDefault()
    }
});

function promptInputs(inputPrompts, executeCode, outputElement, code) {
    let currentPrompt = 0;
    const inputs = [];

    function showNextPrompt() {
        if (currentPrompt >= inputPrompts.length) {
            executeCode(code, inputs);
            return
        }
        const prompt = inputPrompts[currentPrompt];
        const line = document.createElement('div');
        line.classList.add('terminal-line');
        const label = document.createElement('span');
        label.textContent = `> ${prompt}: `;
        label.classList.add('terminal-prompt');
        const inputSpan = document.createElement('span');
        inputSpan.classList.add('terminal-input');
        inputSpan.contentEditable = !0;
        inputSpan.spellcheck = !1;
        inputSpan.addEventListener('keydown', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                const inputValue = inputSpan.textContent.trim();
                inputs.push(inputValue);
                inputSpan.contentEditable = !1;
                currentPrompt++;
                showNextPrompt()
            }
        });
        line.appendChild(label);
        line.appendChild(inputSpan);
        outputElement.appendChild(line);
        inputSpan.focus()
    }
    showNextPrompt()
}
export {
    outputEl,
    currentURL,
    promptInputs
}