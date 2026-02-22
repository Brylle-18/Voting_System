<?php
session_start();
include 'db.php';

$languages = ["Python", "Java", "C++", "JavaScript"];

$counts = [];
$total = 0;

foreach ($languages as $lang) {
    $stmt = mysqli_prepare($conn, "SELECT COUNT(*) as count FROM votes WHERE language = ?");
    mysqli_stmt_bind_param($stmt, "s", $lang);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_assoc($result);
    $counts[$lang] = $row['count'];
    $total += $row['count'];
    mysqli_stmt_close($stmt);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Results</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<div class="container">
    <div class="card">
        <h1>📊 Voting Results</h1>
        <p class="subtitle">Total votes: <?= $total ?></p>

        <?php if (isset($_GET['msg'])): ?>
            <?php if ($_GET['msg'] === 'success'): ?>
                <p style="color:green; margin-bottom:15px;">✅ Vote submitted!</p>
            <?php elseif ($_GET['msg'] === 'already_voted'): ?>
                <p style="color:orange; margin-bottom:15px;">⚠️ You already voted.</p>
            <?php endif; ?>
        <?php endif; ?>

        <?php foreach ($counts as $lang => $count): ?>
            <?php $percent = $total > 0 ? round(($count / $total) * 100) : 0; ?>
            <div style="margin-bottom: 15px; text-align:left;">
                <div style="display:flex; justify-content:space-between; margin-bottom:4px;">
                    <span><strong><?= htmlspecialchars($lang) ?></strong></span>
                    <span><?= $count ?> votes (<?= $percent ?>%)</span>
                </div>
                <div style="background:#f0f0f0; border-radius:8px; height:14px;">
                    <div style="width:<?= $percent ?>%; background:#1bf917; height:14px; border-radius:8px; transition:0.3s;"></div>
                </div>
            </div>
        <?php endforeach; ?>

        <div class="results-link">
            <a href="index.html">← Back to voting</a>
        </div>
    </div>
</div>
</body>
</html>
