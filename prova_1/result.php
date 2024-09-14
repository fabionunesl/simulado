<?php
session_start();

if (!isset($_SESSION['answers'])) {
    header('Location: index.php');
    exit();
}

$answers = $_SESSION['answers'];
$questions = include 'questions.php';

$score = 0;
$results = [];

foreach ($questions as $index => $question) {
    $is_correct = isset($answers[$index]) && $answers[$index] == $question['correct'];
    if ($is_correct) {
        $score++;
    }

    $results[] = [
        'question' => $question['question'],
        'answer' => $question['answers'][$answers[$index] ?? -1],
        'correct' => $question['answers'][$question['correct']],
        'is_correct' => $is_correct
    ];
}

// Limpar dados da sessão
session_destroy();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resultado</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f0f4f8;
            color: #333;
            text-align: center;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 80%;
            max-width: 800px;
            margin: 40px auto;
            padding: 20px;
            background: #ffffff;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        .question-result {
            margin: 20px 0;
            text-align: left;
            display: flex;
            flex-direction: column;
            align-items: flex-start;
        }
        .question-result h2 {
            font-size: 18px;
            color: #ff6600;
        }
        .question-result p {
            margin: 5px 0;
        }
        .question-result .answer {
            display: flex;
            align-items: center;
            width: 100%;
        }
        .question-result .answer label {
            display: block;
            width: 100%;
            max-width: 100%;
            margin-bottom: 8px;
            padding: 10px;
            border-radius: 5px;
            background-color: #f8f8f8;
            border: 1px solid #ddd;
            box-sizing: border-box; /* Inclui padding e border na largura total */
        }
        .button {
            padding: 10px 20px;
            font-size: 16px;
            color: #fff;
            background-color: #ff6600;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        .button:hover {
            background-color: #e65c00;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Resultado da Prova</h1>
        <p>Você acertou <?php echo $score; ?> de <?php echo count($questions); ?> perguntas.</p>
        
        <?php foreach ($results as $result): ?>
            <div class="question-result">
                <h2><?php echo $result['question']; ?></h2>
                <div class="answer">
                    <label><strong>Sua resposta:</strong> <?php echo $result['answer']; ?></label>
                </div>
                <div class="answer">
                    <label><strong>Resposta correta:</strong> <?php echo $result['correct']; ?></label>
                </div>
                <p><strong><?php echo $result['is_correct'] ? 'Correta 😊' : 'Incorreta 😢'; ?></strong></p>
            </div>
        <?php endforeach; ?>
        
        <a href="index.php" class="button">Voltar para a primeira pergunta</a>
    </div>
</body>
</html>
