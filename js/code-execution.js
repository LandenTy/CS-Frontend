import {
  outputEl,
  currentURL,
  promptInputs
} from './terminal.js';

// Expected output for the Daily Step Count Analysis problem (example)
const expectedOutputLines = [
  "Total steps: 49180",
  "Average steps per day: 7025.714285714285",
  "Day with highest steps (0-based): 5",
  "Days with more than 7000 steps: [2, 3, 5]"
];

// Check correctness by comparing output lines exactly
function checkOutputCorrectness(studentOutput) {
  const outputLines = studentOutput.trim().split('\n').map(line => line.trim());
  if (expectedOutputLines.length !== outputLines.length) return false;
  for (let i = 0; i < expectedOutputLines.length; i++) {
    if (outputLines[i] !== expectedOutputLines[i]) return false;
  }
  return true;
}

// Display output and correctness feedback in terminal
function displayOutputWithCheck(studentOutput) {
  outputEl.innerHTML = ""; // Clear previous output

  // Print student's raw output with > prefix on each line
  studentOutput.trim().split('\n').forEach(line => {
    outputEl.innerHTML += `<br>> ${line}`;
  });

  // Check if output matches expected answer
  const isCorrect = checkOutputCorrectness(studentOutput);

  const resultLine = document.createElement('div');
  resultLine.style.marginTop = '12px';
  resultLine.style.fontWeight = 'bold';
  resultLine.style.color = isCorrect ? 'limegreen' : 'crimson';
  resultLine.textContent = isCorrect ? '✅ Correct!' : '❌ Incorrect. Please try again.';

  outputEl.appendChild(resultLine);
}

async function executeCode(code, inputs = []) {
  outputEl.textContent = "🔄 " + currentURL + "/main.py";

  let inputIndex = 0;
  code = code.replace(/input\((?:'|"|`)(.*?)(?:'|"|`)\)/g, function() {
    const val = inputs[inputIndex++] || "";
    return `"${val.replace(/"/g, '\\"')}"`;
  });

  try {
    const response = await fetch("https://emkc.org/api/v2/piston/execute", {
      method: "POST",
      headers: {
        "Content-Type": "application/json"
      },
      body: JSON.stringify({
        language: "python",
        version: "3.10.0",
        files: [{ content: code }]
      })
    });

    if (!response.ok) throw new Error("⚠ Error executing code!");

    const result = await response.json();
    const output = result.run.output || "⚠ No output!";

    // Check if practice mode is enabled by URL param
    const urlParams = new URLSearchParams(window.location.search);
    const practiceMode = urlParams.get("practice") === "true";

    if (practiceMode) {
      // Show output + correctness feedback
      displayOutputWithCheck(output);
    } else {
      // Normal output display for non-practice runs
      outputEl.innerHTML += `<br>> ${output}`;
    }

  } catch (error) {
    outputEl.innerHTML += `<br>⚠ Error: ${error.message}`;
  }
}

async function compileCode(editor) {
  const code = editor.getValue();
  outputEl.innerHTML = "";

  const inputPattern = /input\((?:'|"|`)(.*?)(?:'|"|`)\)/g;
  const inputPrompts = [...code.matchAll(inputPattern)].map(match => match[1]);

  if (inputPrompts.length === 0) {
    await executeCode(code);
    return;
  }

  promptInputs(inputPrompts, executeCode, outputEl, code);
}

export {
  compileCode,
  executeCode
};
