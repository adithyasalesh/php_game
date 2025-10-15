<?php
session_start();

// --- Initialize game state ---
if (!isset($_SESSION['questions'])) {
    $allQuestions = [
        ["question" => "🧩 What gets wetter the more it dries?", "answer" => "towel", "hint" => "You use it after a bath."],
        ["question" => "🔥 What has hands but can’t clap?", "answer" => "clock", "hint" => "It tells time."],
        ["question" => "🧠 What has a head and a tail but no body?", "answer" => "coin", "hint" => "Heads or tails?"],
        ["question" => "💧 What runs but never walks?", "answer" => "water", "hint" => "Flows in rivers."],
        ["question" => "🌙 What can you catch but not throw?", "answer" => "cold", "hint" => "You might get it in winter."],
        ["question" => "📖 What has many words but never speaks?", "answer" => "book", "hint" => "Read me to gain knowledge."],
        ["question" => "🎹 What has keys but can’t open locks?", "answer" => "piano", "hint" => "It makes music."],
        ["question" => "🚗 What has wheels and flies but is not an aircraft?", "answer" => "garbage truck", "hint" => "It comes to pick up trash."],
        ["question" => "🕯️ The more of this you take, the more you leave behind. What is it?", "answer" => "footsteps", "hint" => "You leave me when you walk."],
        ["question" => "🐦 What kind of room has no doors or windows?", "answer" => "mushroom", "hint" => "It's fungi."],
        ["question" => "🕰️ What can travel around the world while staying in a corner?", "answer" => "stamp", "hint" => "You put it on an envelope."],
        ["question" => "⚡ What belongs to you, but other people use it more than you do?", "answer" => "name", "hint" => "People call you by this."],
        ["question" => "🥶 What goes up but never comes down?", "answer" => "age", "hint" => "Everyone has one."],
        ["question" => "🌧️ What has a neck but no head?", "answer" => "bottle", "hint" => "You pour liquids from it."],
        ["question" => "🔥 What has an eye but cannot see?", "answer" => "needle", "hint" => "Used in sewing."],
        ["question" => "🐍 I’m tall when I’m young and short when I’m old. What am I?", "answer" => "candle", "hint" => "It gives light when burning."],
        ["question" => "🐾 What goes up and down but doesn’t move?", "answer" => "stairs", "hint" => "You walk on it."],
        ["question" => "🎈 I’m full of holes but still hold water. What am I?", "answer" => "sponge", "hint" => "Used for cleaning."],
        ["question" => "💀 What kind of tree can you carry in your hand?", "answer" => "palm", "hint" => "Also part of your body."],
        ["question" => "🪞 What can’t talk but replies when spoken to?", "answer" => "echo", "hint" => "You hear it in mountains."],
    ];

    shuffle($allQuestions);
    $_SESSION['questions'] = array_slice($allQuestions, 0, 5);
    $_SESSION['index'] = 0;
    $_SESSION['score'] = 0;
    $_SESSION['total'] = count($_SESSION['questions']);
    $_SESSION['history'] = [];
    $_SESSION['highscore'] = $_SESSION['highscore'] ?? 0;
}

$message = "";
$hintMessage = "";

$roasts = [
    "😂 Bro… even Google can’t help you with that one!",
    "🤦‍♂️ I’m losing brain cells reading that answer.",
    "💀 Did you even try? My pet rock knows this.",
    "😬 Wrong! Maybe go take a nap and try again.",
    "😅 Not quite genius material yet!"
];

$praises = [
    "🎉 Correct! You’ve got some neurons firing!",
    "👏 Big brain energy detected!",
    "🥳 Smart move! You nailed it!",
    "💡 Correct! You’re actually smarter than I thought!",
    "🔥 Wow! You might just graduate this quiz alive!"
];

// --- Process submitted answer ---
if (isset($_POST['answer'])) {
    $current = $_SESSION['questions'][$_SESSION['index']];
    $userAnswer = strtolower(trim($_POST['answer']));
    $_SESSION['index']++;

    $isCorrect = ($userAnswer === strtolower($current['answer']));
    $_SESSION['history'][] = [
        'question' => $current['question'],
        'user' => $userAnswer,
        'correct' => $current['answer'],
        'status' => $isCorrect ? "✅" : "❌"
    ];

    if ($isCorrect) {
        $_SESSION['score']++;
        $message = $praises[array_rand($praises)];
    } else {
        $message = $roasts[array_rand($roasts)] . " (Answer: " . ucfirst($current['answer']) . ")";
        $hintMessage = "💡 Hint: " . $current['hint'];
    }

    // Update highscore
    if ($_SESSION['score'] > $_SESSION['highscore']) {
        $_SESSION['highscore'] = $_SESSION['score'];
    }
}

$quizOver = false;
if ($_SESSION['index'] >= $_SESSION['total']) {
    $quizOver = true;
    $finalScore = $_SESSION['score'];
    $message = "🏁 Quiz Over! You scored $finalScore out of {$_SESSION['total']}." . 
               ($finalScore > 3 ? " 🎓 Genius level unlocked!" : " 😵 Maybe stick to memes.");
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Roast My IQ 🧠</title>
    <style>
        body { font-family: 'Comic Sans MS', cursive; background: linear-gradient(135deg,#ffecd2,#fcb69f); text-align:center; padding-top:50px;}
        .game-box { background:#fff; border-radius:20px; padding:40px; width:480px; margin:auto; box-shadow:0 8px 25px rgba(0,0,0,0.25);}
        h2 { color:#ff6363; }
        input[type="text"] { padding:10px; font-size:18px; border-radius:10px; border:2px solid #ff7b7b; width:80%; text-align:center; }
        input[type="submit"], button { margin-top:20px; padding:10px 25px; font-size:18px; border-radius:10px; border:none; background:#ff7b7b; color:white; cursor:pointer; }
        input[type="submit"]:hover, button:hover { background:#ff4f4f; }
        p { font-size:18px; margin-top:20px; }
        .question { font-size:22px; margin:15px 0; }
        ul { text-align:left; margin-top:20px; }
    </style>
</head>
<body>
<div class="game-box">
    <h2>🤯 Roast My IQ Quiz</h2>
    <p>🏆 High Score: <?= $_SESSION['highscore'] ?></p>

    <?php if (!$quizOver && $_SESSION['index'] < $_SESSION['total']): ?>
        <div class="question"><?= $_SESSION['questions'][$_SESSION['index']]['question'] ?></div>
        <form method="post">
            <input type="text" name="answer" placeholder="Your answer..." required autofocus>
            <input type="submit" value="Submit">
        </form>
    <?php endif; ?>

    <p><?= $message ?></p>
    <p><?= $hintMessage ?></p>

    <?php if ($quizOver): ?>
        <h3>📝 Quiz Review:</h3>
        <ul>
            <?php foreach ($_SESSION['history'] as $h): ?>
                <li><?= $h['question'] ?> - Your answer: <?= $h['user'] ?> <?= $h['status'] ?> (Correct: <?= $h['correct'] ?>)</li>
            <?php endforeach; ?>
        </ul>
        <form method="post">
            <button type="submit">Play Again 🔁</button>
        </form>
        <?php session_destroy(); ?>
    <?php endif; ?>
</div>
</body>
</html>
