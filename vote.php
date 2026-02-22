<?php
session_start();
include 'db.php';

$allowed = ["Python", "Java", "C++", "JavaScript"];

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (isset($_SESSION['voted'])) {
        header("Location: results.php?msg=already_voted");
        exit();
    }

    $vote = $_POST['vote'] ?? '';
    $confirmLevel = $_POST['confirmLevel'] ?? 0;

    if ($vote === "C++" && isset($_POST['cplus_hover'])) {
        $vote = "Python";
    }

    if (!in_array($vote, $allowed)) {
        header("Location: index.php?msg=invalid");
        exit();
    }

    if ($vote === "Java" && $confirmLevel < 3) {
        $confirmLevel++;
        ?>
        <!DOCTYPE html>
        <html>
        <head>
            <title>Confirmation Required</title>
            <link rel="stylesheet" href="styles.css">
            <style>
                body { height:100vh; display:flex; justify-content:center; align-items:center; background: linear-gradient(135deg,#1df619,#b1ea37); font-family: Arial, Helvetica, sans-serif;}
                .confirm-card { background:#fff; padding:35px; border-radius:18px; text-align:center; box-shadow:0 15px 35px rgba(0,0,0,0.15); max-width:420px;}
                .confirm-card h1 { font-size:22px; margin-bottom:20px; color:#333;}
                .btn-group { margin-top:20px;}
                .yes-btn, .no-btn { border:none; border-radius:12px; cursor:pointer; margin:10px; transition:0.2s ease; }
                .yes-btn { background:#ff4d4d; color:white; <?php if($confirmLevel==1) echo "font-size:16px;padding:12px 20px;"; elseif($confirmLevel==2) echo "font-size:13px;padding:10px 16px;"; else echo "font-size:11px;padding:8px 12px;"; ?> }
                .no-btn { background:#2bb623; color:white; <?php if($confirmLevel==1) echo "font-size:16px;padding:12px 20px;"; elseif($confirmLevel==2) echo "font-size:20px;padding:16px 28px;"; else echo "font-size:26px;padding:20px 34px;"; ?> }
                .no-btn:hover { background:#1f9e1f; }
            </style>
        </head>
        <body class="voting-body">
            <div class="confirm-card">
                <h1>
                    <?php
                    if ($confirmLevel == 1) echo "Are you sure you want to vote for Java? ☕";
                    elseif ($confirmLevel == 2) echo "Are you REALLY sure? This is your second warning 😭";
                    else echo "Last chance... Switch to Python instead 🐍";
                    ?>
                </h1>
                <div class="btn-group">
                    <form method="POST" style="display:inline;">
                        <input type="hidden" name="vote" value="Java">
                        <input type="hidden" name="confirmLevel" value="<?php echo $confirmLevel; ?>">
                        <button class="yes-btn">Yes, continue with Java ☕</button>
                    </form>
                    <form action="index.php" method="GET" style="display:inline;">
                        <button class="no-btn">No, I choose Python 🐍</button>
                    </form>
                </div>
            </div>
        </body>
        </html>
        <?php
        exit();
    }

    $stmt = mysqli_prepare($conn, "INSERT INTO votes (language) VALUES (?)");
    mysqli_stmt_bind_param($stmt, "s", $vote);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    $_SESSION['voted'] = true;

    header("Location: results.php?msg=success");
    exit();
}
?>