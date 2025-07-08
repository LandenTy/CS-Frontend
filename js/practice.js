// js/practice.js
export function loadPracticeQuestion() {
  const questionBox = document.getElementById("practice-question");
  if (!questionBox) return;

  // List of practice templates
  const templates = [
    {
      title: "Daily Step Count Analysis",
      description: `Jasmine wants to analyze her daily step counts using a list of data she collected over a week.<br>
      <br><code>steps = [5234, 6891, 7342, 8123, 4567, 10234, 6789]</code><br><br>
      <strong>Task:</strong>
      <ul>
        <li>Print the total number of steps Jasmine took that week.</li>
        <li>Find and print the average number of steps per day.</li>
        <li>Print the day with the highest number of steps.</li>
        <li>Print all days where she walked more than 7000 steps.</li>
      </ul>`,
      starterCode: `steps = [5234, 6891, 7342, 8123, 4567, 10234, 6789]

# Print total number of steps
# Print average steps per day
# Print the day with the highest steps
# Print all days with more than 7000 steps
`
    },
    {
      title: "Even and Odd Counter",
      description: `You are given a list of numbers:<br>
      <br><code>nums = [12, 43, 25, 16, 37, 48, 59]</code><br><br>
      <strong>Task:</strong>
      <ul>
        <li>Count and print how many numbers are even.</li>
        <li>Count and print how many are odd.</li>
        <li>Print the sum of all even numbers.</li>
      </ul>`,
      starterCode: `nums = [12, 43, 25, 16, 37, 48, 59]

# Count even and odd numbers
# Print the total number of even and odd numbers
# Print the sum of all even numbers
`
    },
    {
      title: "Finding the Longest Word",
      description: `Given a list of words:<br>
      <br><code>words = ["hello", "fantastic", "world", "python", "amazing"]</code><br><br>
      <strong>Task:</strong>
      <ul>
        <li>Print the longest word in the list.</li>
        <li>Print its length.</li>
        <li>Print all words longer than 6 characters.</li>
      </ul>`,
      starterCode: `words = ["hello", "fantastic", "world", "python", "amazing"]

# Find and print the longest word
# Print its length
# Print all words longer than 6 characters
`
    }
  ];

  // Select a random template
  const template = templates[Math.floor(Math.random() * templates.length)];

  // Display it
  questionBox.innerHTML = `
    <h3>${template.title}</h3>
    <p>${template.description}</p>
  `;

  // If CodeMirror editor is ready, set starter code
  const checkEditorReady = setInterval(() => {
    if (window.editor && typeof window.editor.setValue === "function") {
      window.editor.setValue(template.starterCode);
      clearInterval(checkEditorReady);
    }
  }, 100);
}
