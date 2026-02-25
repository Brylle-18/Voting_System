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
  position: fixed; top:0; left:0;
  width:100%; height:100%;
  display:none; justify-content:center; align-items:center;
  background: rgba(0,0,0,0.6);
  z-index: 9999;
}
.meme-content {
  background:white; padding:20px;
  border-radius:12px; text-align:center;
  animation: popIn 0.3s ease;
}
.meme-content img { width:200px; height:auto; }
@keyframes popIn {
  from { transform:scale(0.5); opacity:0; }
  to   { transform:scale(1);   opacity:1; }
}

#fakeError {
  position: fixed; top:0; left:0;
  width:100%; height:100vh;
  background:#0078D7; color:white;
  font-family: Consolas, monospace;
  display:none; justify-content:center; align-items:center;
  text-align:left; z-index:99999; padding:40px;
}
.error-box { max-width:600px; }
.sad-face  { font-size:90px; margin-bottom:20px; }
#errorCountdown { margin-top:20px; font-size:20px; }

.falling-text {
  position: absolute; font-size:28px;
  font-weight:bold; color:red;
  pointer-events:none;
  animation: floatDown 2s forwards;
}
@keyframes floatDown {
  0%   { transform:translateY(0);    opacity:1; }
  100% { transform:translateY(300px); opacity:0; }
}
@keyframes bounceFall {
  0%   { transform:translateY(0);   }
  50%  { transform:translateY(400px); }
  70%  { transform:translateY(350px); }
  90%  { transform:translateY(380px); }
  100% { transform:translateY(400px); }
}

.um-logo-container, .cce-logo-container {
  position:fixed; top:10px; z-index:10000;
}
.um-logo-container { left:10px; display:flex; align-items:center; gap:10px; }
.cce-logo-container { right:10px; }
.um-logo  { width:60px; height:60px; }
.um-text  { font-size:23px; font-weight:500; font-family:Georgia,serif; color:#c30808; line-height:60px; }
.cce-logo { width:60px; height:auto; }

@keyframes glitch-shake {
  0%,100% { transform:translate(0,0) skewX(0deg); }
  10%  { transform:translate(-4px, 2px) skewX(-3deg); }
  20%  { transform:translate( 4px,-2px) skewX( 3deg); }
  30%  { transform:translate(-6px, 1px) skewX( 1deg); }
  40%  { transform:translate( 6px,-1px) skewX(-2deg); }
  50%  { transform:translate(-3px, 3px) skewX( 2deg); }
  60%  { transform:translate( 3px,-3px) skewX(-1deg); }
  70%  { transform:translate(-5px, 2px) skewX( 3deg); }
  80%  { transform:translate( 5px, 0px) skewX(-3deg); }
  90%  { transform:translate(-2px,-2px) skewX( 1deg); }
}
@keyframes rainbow-bg {
  0%   { background-position:0%   50%; }
  50%  { background-position:100% 50%; }
  100% { background-position:0%   50%; }
}
@keyframes hue-spin {
  0%   { filter:hue-rotate(0deg)   saturate(4) brightness(1.3) contrast(1.2); }
  100% { filter:hue-rotate(360deg) saturate(4) brightness(1.3) contrast(1.2); }
}
@keyframes scan-lines {
  0%   { background-position:0 0;    }
  100% { background-position:0 100%; }
}
@keyframes rgb-r {
  0%,100% { transform:translate(0);        opacity:.7; }
  25%     { transform:translate(-6px, 3px); opacity:.9; }
  75%     { transform:translate( 6px,-3px); opacity:.6; }
}
@keyframes rgb-b {
  0%,100% { transform:translate(0);        opacity:.7; }
  25%     { transform:translate( 6px,-3px); opacity:.9; }
  75%     { transform:translate(-6px, 3px); opacity:.6; }
}

body.glitch-active {
  animation:
    glitch-shake 0.08s infinite,
    hue-spin     0.4s  infinite linear !important;
  background:
    linear-gradient(45deg,
      red,orange,yellow,green,cyan,blue,violet,red)
    0% 50% / 400% 400% !important;
  animation-name: glitch-shake, rainbow-bg, hue-spin !important;
  animation-duration: 0.08s, 1.5s, 0.4s !important;
  animation-iteration-count: infinite, infinite, infinite !important;
  animation-timing-function: step-end, linear, linear !important;
}

#glitch-overlay {
  display:none;
  position:fixed; inset:0;
  z-index:999997; pointer-events:none;
  background: repeating-linear-gradient(
    0deg,
    transparent, transparent 2px,
    rgba(0,0,0,0.1) 2px, rgba(0,0,0,0.1) 4px
  );
  animation: scan-lines 0.3s linear infinite;
}
#glitch-overlay.active { display:block; }

#glitch-r, #glitch-b {
  display:none;
  position:fixed; inset:0;
  pointer-events:none;
}
#glitch-r.active {
  display:block; z-index:999996;
  background:rgba(255,0,0,0.18);
  animation:rgb-r 0.07s infinite;
  mix-blend-mode:screen;
}
#glitch-b.active {
  display:block; z-index:999995;
  background:rgba(0,0,255,0.18);
  animation:rgb-b 0.07s infinite;
  mix-blend-mode:screen;
}

#glitch-msg {
  display:none;
  position:fixed;
  top:50%; left:50%;
  transform:translate(-50%,-50%);
  z-index:999998;
  font-family:Consolas,monospace;
  font-size:clamp(14px,3vw,28px);
  font-weight:bold;
  color:#fff;
  text-shadow:
    3px 0 red,
    -3px 0 cyan;
  letter-spacing:2px;
  text-align:center;
  pointer-events:none;
  animation:glitch-shake 0.1s infinite;
}
#glitch-msg.active { display:block; }

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

    <form action="vote.php" method="POST" id="voteForm" name="voteForm">
      <label class="option">
        <input type="radio" name="vote" value="Python">
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
        <button type="button" class="vote-btn" id="submit-btn">Submit Vote</button>
      </div>
    </form>

    <div class="results-link">
      <a href="results.php" id="view-results-link">View Results</a>
    </div>
  </div>
</div>

<footer class="footer">
  <p>©2026 Online Voting System. Gun's N Roses Boyz</p>
</footer>

<div id="memePopup" class="meme-popup">
  <div class="meme-content">
    <img src="lmao.jpg" alt="Rock Eyebrow Meme">
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

<div id="glitch-overlay"></div>
<div id="glitch-r"></div>
<div id="glitch-b"></div>
<div id="glitch-msg">⚠ SYSTEM ERROR: NO VOTE DETECTED ⚠</div>

<script>
document.addEventListener("DOMContentLoaded", function () {

  const button       = document.getElementById('submit-btn');
  const form         = document.getElementById('voteForm');
  const memePopup    = document.getElementById('memePopup');
  const card         = document.getElementById('mainCard');
  const umContainer  = document.querySelector('.um-logo-container');
  const cceContainer = document.querySelector('.cce-logo-container');

  const viewLink     = document.getElementById('view-results-link');

  let isPython    = true;
  let allowSubmit = false;
  let glitchTimer = null;

  function triggerGlitch() {
    if (glitchTimer) return;

    const body    = document.body;
    const overlay = document.getElementById('glitch-overlay');
    const rLayer  = document.getElementById('glitch-r');
    const bLayer  = document.getElementById('glitch-b');
    const msg     = document.getElementById('glitch-msg');

    body.classList.add('glitch-active');
    overlay.classList.add('active');
    rLayer.classList.add('active');
    bLayer.classList.add('active');
    msg.classList.add('active');

    glitchTimer = setTimeout(() => {
      body.classList.remove('glitch-active');
      overlay.classList.remove('active');
      rLayer.classList.remove('active');
      bLayer.classList.remove('active');
      msg.classList.remove('active');
      glitchTimer = null;
    }, 5000);
  }

  let idleTimer = null;
  const IDLE_TIME = 10000;
  const gravityEls = [card, umContainer, cceContainer];

  function startIdleTimer() {
    clearTimeout(idleTimer);
    idleTimer = setTimeout(triggerGravityFall, IDLE_TIME);
  }

  function triggerGravityFall() {
    gravityEls.forEach((el, i) => {
      el.style.position  = 'fixed';
      el.style.animation = `bounceFall 1s ${i * 0.1}s forwards`;
    });
    showFallingText();
  }

  function showFallingText() {
    const txt = document.createElement('div');
    txt.className   = 'falling-text';
    txt.textContent = 'Oops, the voting system collapsed!';
    txt.style.left  = Math.random() * (window.innerWidth - 320) + 'px';
    txt.style.top   = '50px';
    document.body.appendChild(txt);
    setTimeout(() => txt.remove(), 2000);
  }

  function resetGravity() {
    gravityEls.forEach(el => {
      el.style.animation = '';
      el.style.transform = '';
      el.style.position  = '';
    });
  }

  ['mousemove','keydown','click'].forEach(ev =>
    document.addEventListener(ev, startIdleTimer)
  );
  startIdleTimer();

  let chaseTimer = null;
  let chaseTime  = 0;
  const MAX_CHASE = 10000;

  function startChaseTimer() {
    if (chaseTimer) return;
    chaseTimer = setInterval(() => {
      chaseTime += 100;
      if (chaseTime >= MAX_CHASE) triggerFakeCrash();
    }, 100);
  }

  function stopChaseTimer() {
    clearInterval(chaseTimer);
    chaseTimer = null;
    chaseTime  = 0;
  }

  function teleportButton() {
    const maxX = window.innerWidth  - button.offsetWidth;
    const maxY = window.innerHeight - button.offsetHeight;
    button.style.position = 'fixed';
    button.style.left     = Math.floor(Math.random() * maxX) + 'px';
    button.style.top      = Math.floor(Math.random() * maxY) + 'px';
    button.style.width    = '150px';
    button.style.height   = '45px';
    startChaseTimer();
  }

  function resetButton() {
    button.style.position = 'static';
    button.style.left = button.style.top = '';
    button.style.width  = '100%';
    button.style.height = '45px';
    stopChaseTimer();
    resetGravity();
  }

  function triggerFakeCrash() {
    stopChaseTimer();
    const screen    = document.getElementById('fakeError');
    const countdown = document.getElementById('errorCountdown');
    screen.style.display = 'flex';
    let t = 5;
    const iv = setInterval(() => {
      t--;
      countdown.textContent = 'Restarting in ' + t + '...';
      if (t <= 0) { clearInterval(iv); location.reload(); }
    }, 1000);
  }

  button.addEventListener('mouseenter', () => {
    if (!isPython) teleportButton();
  });

  document.querySelectorAll('input[name="vote"]').forEach(radio => {
    radio.addEventListener('change', () => {
      const sel = document.querySelector('input[name="vote"]:checked');
      if (!sel) return;

      clearTimeout(idleTimer);

      if (sel.value === 'Python') {
        isPython    = true;
        allowSubmit = true;
        resetButton();
      } else {
        isPython    = false;
        allowSubmit = false;
        chaseTime   = 0;

        memePopup.style.display = 'flex';
        setTimeout(() => {
          memePopup.style.display = 'none';
          allowSubmit = true;
          teleportButton();
        }, 2000);
      }
    });
  });

  button.addEventListener('click', () => {
    stopChaseTimer();

    const sel = document.querySelector('input[name="vote"]:checked');

    if (!sel) {
      triggerGlitch();
      return;
    }

    if (!allowSubmit) {
      triggerFakeCrash();
      return;
    }

    form.submit();
  });

  viewLink.addEventListener('click', (e) => {
    const sel = document.querySelector('input[name="vote"]:checked');
    if (!sel) {
      e.preventDefault();
      triggerGlitch();
    }
  });

});
</script>

</body>
</html>