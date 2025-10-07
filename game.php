<?php
session_start();

// Generate random number if not already set
if (!isset($_SESSION['number'])) {
    $_SESSION['number'] = rand(1, 50);
    $_SESSION['attempts'] = 0;
}

$message = "";

// Funny insults
$tooLow = [
    "😂 My grandma guesses higher numbers than that!",
    "Bro, that’s lower than your GPA!",
    "Try something higher before I fall asleep...",
    "You call that a guess? Aim higher!"
];

$tooHigh = [
    "🚀 Chill! You just overshot the moon.",
    "Too high! You think I’m that generous?",
    "Bruh, that’s higher than your electricity bill!",
    "Nope. That number’s in another galaxy."
];

$correct = [
    "🎉 FINALLY! You got it!",
    "👏 Miracles do happen!",
    "Correct! I was starting to lose hope.",
    "🥳 You actually did it! I owe you a cookie."
];
// When form is submitted
if (isset($_POST['guess'])) {
    $guess = intval($_POST['guess']);
    $_SESSION['attempts']++;

    if ($guess < $_SESSION['number']) {
        $message = $tooLow[array_rand($tooLow)];
    } elseif ($guess > $_SESSION['number']) {
        $message = $tooHigh[array_rand($tooHigh)];
    } else {
        $msg = $correct[array_rand($correct)];
        $message = "$msg You found it in {$_SESSION['attempts']} attempts!";
        unset($_SESSION['number']); // Reset for new game
        unset($_SESSION['attempts']);
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Roast My Guess 😈</title>
    <style>
        body {
            font-family: 'Comic Sans MS', cursive;
            background: linear-gradient(135deg, #ff9a9e, #fad0c4);
            text-align: center;
            padding-top: 70px;
            color: #333;
        }
        .game-box {
            background: #fff;
            border-radius: 20px;
            padding: 40px;
            width: 400px;
            margin: auto;
            box-shadow: 0 8px 20px rgba(0,0,0,0.2);
        }
        input[type="number"] {
            padding: 10px;
            font-size: 18px;
            border-radius: 10px;
            border: 2px solid #ff7b7b;
        }
        input[type="submit"], button {
            margin-top: 15px;
            padding: 10px 25px;
            font-size: 18px;
            border-radius: 10px;
            border: none;
            background: #ff7b7b;
            color: white;
            cursor: pointer;
        }
        input[type="submit"]:hover, button:hover {
            background: #ff4f4f;
        }
        p {
            font-size: 18px;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="game-box">
        <h2>🔥 Roast My Guess (1–50) 🔥</h2>

        <form method="post">
            <input type="number" name="guess" placeholder="Your guess..." required>
            <input type="submit" value="Submit">
        </form>

        <p><?= $message ?></p>

        <?php if (empty($_SESSION['number'])): ?>
            <form method="post">
                <button type="submit">Play Again 😎</button>
            </form>
        <?php endif; ?>
    </div>
</body>
</html>
