// js/practice.js
export function loadPracticeQuestion() {
  const questionBox = document.getElementById("practice-question");
  if (!questionBox) return;

  const urlParams = new URLSearchParams(window.location.search);
  const lessonParam = urlParams.get("lesson");
  console.log("lesson param from URL:", lessonParam);

  const lessonId = parseInt(lessonParam, 10);
  console.log("Parsed lessonId:", lessonId);

  if (isNaN(lessonId)) {
    questionBox.innerHTML = `<strong>Invalid or missing lesson ID in URL.</strong>`;
    return;
  }

  const templates = {
    3: [ // Lesson 3
      {
        title: "Daily Step Count Analysis",
        description: `Jasmine wants to analyze her daily step counts...<br>
          <code>steps = [5234, 6891, 7342, 8123, 4567, 10234, 6789]</code><br><br>
          <strong>Task:</strong>
          <ul>
            <li>Print total steps</li>
            <li>Find average</li>
            <li>Find highest day</li>
            <li>Days with &gt;7000 steps</li>
          </ul>`,
        starterCode: `steps = [5234, 6891, 7342, 8123, 4567, 10234, 6789]

# Your code here
`
      },
      {
        title: "Even and Odd Counter",
        description: `You are given a list of numbers...<br>
          <code>nums = [12, 43, 25, 16, 37, 48, 59]</code><br><br>
          <ul>
            <li>Count evens/odds</li>
            <li>Print totals</li>
            <li>Sum even numbers</li>
          </ul>`,
        starterCode: `nums = [12, 43, 25, 16, 37, 48, 59]

# Your code here
`
      }
    ],
    4: [ // Lesson 4
      {
        title: "Finding the Longest Word",
        description: `Given a list of words:<br><code>["hello", "fantastic", "world", "python", "amazing"]</code><br>
          <ul>
            <li>Print longest word</li>
            <li>Print its length</li>
            <li>All words &gt; 6 characters</li>
          </ul>`,
        starterCode: `words = ["hello", "fantastic", "world", "python", "amazing"]

# Your code here
`
      }
    ]
  };

  const lessonTemplates = templates[lessonId];
  if (!lessonTemplates) {
    questionBox.innerHTML = `<strong>No practice problems available for lesson ${lessonId}.</strong>`;
    return;
  }

  // Pick a random problem from the lesson
  const template = lessonTemplates[Math.floor(Math.random() * lessonTemplates.length)];

  questionBox.innerHTML = `
    <h3>${template.title}</h3>
    <p>${template.description}</p>
  `;

  // Wait for editor to be ready, then set starter code
  const checkEditorReady = setInterval(() => {
    if (window.editor && typeof window.editor.setValue === "function") {
      window.editor.setValue(template.starterCode);
      clearInterval(checkEditorReady);
    }
  }, 100);
}
