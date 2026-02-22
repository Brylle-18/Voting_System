<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Online Voting System LOL</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body class="voting-body">

<div class="container">
    <div class="card">
        <h1>🗳 Online Voting System</h1>
        <p class="subtitle">Vote for your favorite programming language</p>

        <form action="vote.php" method="POST" name="voteForm">
            <label class="option">
                <input type="radio" name="vote" value="Python" required>
                <span>Python</span>
            </label>

            <label class="option">
                <input type="radio" name="vote" value="Java">
                <span>Java</span>
            </label>

            <label class="option cplusplus">
                <input type="radio" name="vote" value="C++">
                <span class="real-text">C++</span>
                <span class="hover-text">Python</span>
            </label>
            
            <input type="hidden" name="cplus_hover" value="1">

            <label class="option">
                <input type="radio" name="vote" value="JavaScript">
                <span>JavaScript</span>
            </label>

            <div class="vote-container">
                <button type="submit" class="vote-btn" id="submit-btn">Submit Vote</button>
            </div>
        </form>

        <div class="results-link">
            <a href="results.php">View Results</a>
        </div>
    </div>
</div>

<footer class="footer">
    <p>©2026 Online Voting System. Gun's N Roses Boyz</p>
</footer>

<script>
const button = document.getElementById('submit-btn');
let isPython = true; 

const originalParent = button.parentElement;
const originalNextSibling = button.nextElementSibling;

function teleportButton() {
    const maxX = window.innerWidth - button.offsetWidth;
    const maxY = window.innerHeight - button.offsetHeight;

    const randomX = Math.floor(Math.random() * maxX);
    const randomY = Math.floor(Math.random() * maxY);

    button.style.position = 'fixed';
    button.style.left = randomX + 'px';
    button.style.top = randomY + 'px';
    button.style.width = '150px';  
    button.style.height = '45px';   
}

function resetButton() {
    button.style.position = 'static';
    button.style.left = '';
    button.style.top = '';
    button.style.width = '100%';
    button.style.height = '45px';

    if (button.parentElement !== originalParent) {
        originalParent.insertBefore(button, originalNextSibling);
    }
}
button.addEventListener('mouseenter', () => {
    if (!isPython) {
        teleportButton();
    }
});

document.querySelectorAll('input[name="vote"]').forEach(radio => {
    radio.addEventListener('change', () => {
        const selected = document.querySelector('input[name="vote"]:checked');
        if (!selected) return;

        if (selected.value === "Python") {
            isPython = true;
            resetButton();
        } else {
            isPython = false;
        }
    });
});
</script>

</body>
</html>