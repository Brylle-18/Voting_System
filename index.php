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
<style>
.meme-popup {
  position: fixed;
  top:0;
  left:0;
  width:100%;
  height:100%;
  display:none;
  justify-content:center;
  align-items:center;
  background: rgba(0,0,0,0.6);
  z-index: 9999;
}
.meme-content {
  background:white;
  padding:20px;
  border-radius:12px;
  text-align:center;
  animation: popIn 0.3s ease;
}
.meme-content img { width:200px; height:auto; }
@keyframes popIn { from {transform:scale(0.5);opacity:0;} to {transform:scale(1);opacity:1;} }

#fakeError {
  position: fixed;
  top:0; left:0;
  width:100%; height:100vh;
  background:#0078D7;
  color:white;
  font-family: Consolas, monospace;
  display:none;
  justify-content:center;
  align-items:center;
  text-align:left;
  z-index:99999;
  padding:40px;
}
.error-box { max-width:600px; }
.sad-face { font-size:90px; margin-bottom:20px; }
#errorCountdown { margin-top:20px; font-size:20px; }

.falling-text {
  position: absolute;
  font-size: 28px;
  font-weight: bold;
  color: red;
  pointer-events: none;
  animation: floatDown 2s forwards;
}

@keyframes floatDown {
  0% { transform: translateY(0); opacity:1; }
  100% { transform: translateY(300px); opacity:0; }
}

@keyframes bounceFall {
  0% { transform: translateY(0); }
  50% { transform: translateY(400px); }
  70% { transform: translateY(350px); }
  90% { transform: translateY(380px); }
  100% { transform: translateY(400px); }
}

.um-logo-container, .cce-logo-container {
  position: fixed;
  top: 10px;
  z-index: 10000;
}
.um-logo-container { left: 10px; display: flex; align-items: center; gap: 10px; }
.cce-logo-container { right: 10px; }

.um-logo { width: 60px; height: 60px; }
.um-text { font-size: 23px; font-weight: 500; font-family: Georgia, serif; color: #c30808; line-height: 60px; }
.cce-logo { width: 60px; height: auto; }
</style>
</head>
<body class="voting-body">

<div class="um-logo-container">
  <img src="umlogo.png" alt="UM Logo" class="um-logo">
  <span class="um-text">University of Mindanao</span>   
</div>

<div class="cce-logo-container">
  <img src="ccelogo.png" alt="CCE Logo" class="cce-logo">
</div>

<div class="container">
  <div class="card" id="mainCard">
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

<div id="memePopup" class="meme-popup">
  <div class="meme-content">
    <img src="therock.jpg" alt="Rock Eyebrow Meme">
    <p>Wrong answer detected :]</p>
  </div>
</div>

<div id="fakeError">
  <div class="error-box">
    <div class="sad-face">:(</div>
    <p>Your PC ran into a problem and needs to restart.</p>
    <p>Error Code: BUTTON_TOO_FAST</p>
    <p id="errorCountdown">Restarting in 5...</p>
  </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function() {
const button = document.getElementById('submit-btn');
const form = document.querySelector('form[name="voteForm"]');
const memePopup = document.getElementById("memePopup");
const card = document.querySelector(".card");
const umContainer = document.querySelector(".um-logo-container");
const cceContainer = document.querySelector(".cce-logo-container");

let isPython = true;
let allowSubmit = false;

let chaseTimer = null;
let chaseTime = 0;
const MAX_CHASE_TIME = 10000;

let idleTimer = null;
const IDLE_TIME = 15000;

const gravityComponents = [card, umContainer, cceContainer];

function startIdleTimer() {
  clearTimeout(idleTimer);
  idleTimer = setTimeout(triggerGravityFall, IDLE_TIME);
}

function triggerGravityFall() {
  gravityComponents.forEach((el, index)=>{
    el.style.position = "fixed";
    el.style.animation = `bounceFall 1s ${index*0.1}s forwards`;
  });
  showFallingText();
}

function showFallingText() {
  const text = document.createElement("div");
  text.className = "falling-text";
  text.textContent = "Oops, the voting system collapsed!";
  text.style.left = Math.random() * (window.innerWidth - 300) + "px"; 
  text.style.top = "50px";
  document.body.appendChild(text);
  setTimeout(() => { document.body.removeChild(text); }, 2000);
}

function resetGravity() {
  gravityComponents.forEach(el=>{
    el.style.animation="";
    el.style.transform="";
    el.style.position="";
  });
}

document.addEventListener("mousemove", startIdleTimer);
document.addEventListener("keydown", startIdleTimer);
document.addEventListener("click", startIdleTimer);
startIdleTimer();

function startChaseTimer() {
  if(chaseTimer) return;
  chaseTimer = setInterval(()=>{ 
    chaseTime +=100;
    if(chaseTime>=MAX_CHASE_TIME){ triggerFakeCrash(); }
  },100);
}

function stopChaseTimer() { clearInterval(chaseTimer); chaseTimer=null; chaseTime=0; }

function triggerFakeCrash() {
  stopChaseTimer();
  const errorScreen = document.getElementById("fakeError");
  const countdownText = document.getElementById("errorCountdown");
  errorScreen.style.display="flex";
  let timeLeft=5;
  const countdown = setInterval(()=>{
    timeLeft--;
    countdownText.textContent = "Restarting in " + timeLeft + "...";
    if(timeLeft<=0){ clearInterval(countdown); location.reload(); }
  },1000);
}

function teleportButton() {
  const maxX = window.innerWidth-button.offsetWidth;
  const maxY = window.innerHeight-button.offsetHeight;
  const randomX = Math.floor(Math.random()*maxX);
  const randomY = Math.floor(Math.random()*maxY);
  button.style.position='fixed';
  button.style.left=randomX+'px';
  button.style.top=randomY+'px';
  button.style.width='150px';
  button.style.height='45px';
  startChaseTimer();
}

function resetButton() {
  button.style.position='static';
  button.style.left='';
  button.style.top='';
  button.style.width='100%';
  button.style.height='45px';
  stopChaseTimer();
  resetGravity();
}

button.addEventListener('mouseenter',()=>{ if(!isPython) teleportButton(); });

document.querySelectorAll('input[name="vote"]').forEach(radio=>{
  radio.addEventListener('change',()=>{
    const selected=document.querySelector('input[name="vote"]:checked');
    if(!selected) return;
    if(selected.value==="Python"){
      isPython=true;
      resetButton();
    } else {
      isPython=false;
      chaseTime=0;
      allowSubmit=false;
      memePopup.style.display="flex";
      setTimeout(()=>{
        memePopup.style.display="none";
        allowSubmit=true;
        teleportButton();
      },2000); 
    }
    clearTimeout(idleTimer);
  });
});

form.addEventListener("submit",function(e){
  if(!allowSubmit) e.preventDefault();
});

button.addEventListener('click',()=>{ stopChaseTimer(); });

});
</script>

</body>
</html>