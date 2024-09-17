<?php
session_start();

// Se o índice da pergunta não estiver definido, redireciona para start.php
if (!isset($_SESSION['current_question_index'])) {
    header('Location: start.php');
    exit();
}

// Certifique-se de que as perguntas estão sendo incluídas corretamente
$questions = include 'questions.php';

session_start();

// Certifique-se de que as perguntas estão sendo incluídas corretamente
$questions = include 'questions.php';

// Inicialize o índice da pergunta, se não estiver definido
if (!isset($_SESSION['current_question_index'])) {
    $_SESSION['current_question_index'] = 0;
}

// Verificar se o tempo final da prova já foi salvo na sessão
if (!isset($_SESSION['end_time'])) {
    // Definir o tempo final da prova (45 minutos a partir de agora)
    $_SESSION['end_time'] = time() + 45 * 60;
}

$current_question_index = $_SESSION['current_question_index'];
$current_question = $questions[$current_question_index] ?? null;

if ($current_question === null) {
    header('Location: result.php');
    exit();
}

// Atualizar o índice da pergunta para a próxima
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $_SESSION['answers'][$current_question_index] = $_POST['answer'] ?? null;
    $_SESSION['current_question_index']++;
    
    if ($_SESSION['current_question_index'] >= count($questions)) {
        header('Location: result.php');
        exit();
    } else {
        $current_question_index = $_SESSION['current_question_index'];
        $current_question = $questions[$current_question_index];
    }
}

$end_time = $_SESSION['end_time'];
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pergunta</title>
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
        .question {
            font-size: 22px;
            margin: 20px 0;
        }
        .timer {
            font-size: 19px;
            color: #ff6600;
            margin-bottom: 20px;
        }
        .answers {
            margin: 10px 0;
            display: flex;
            flex-direction: column;
            align-items: flex-start;
        }
        .answers label {
            display: flex;
            align-items: center;
            width: 100%;
            max-width: 100%;
            margin-bottom: 8px;
            padding: 10px;
            border-radius: 5px;
            background-color: #f8f8f8;
            border: 1px solid #ddd;
            box-sizing: border-box;
        }
        .answers input[type="radio"] {
            margin-right: 10px;
            margin-left: 0;
        }
        .answers span {
            flex: 0 0 20px;
            font-weight: bold;
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
        .error-message {
            color: red;
            font-size: 16px;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Pergunta <?php echo $current_question_index + 1; ?></h1>
        <div class="timer">
            Tempo restante: <span id="timer"></span>
        </div>
        <div class="question">
            <p><?php echo $current_question['question']; ?></p>
        </div>
        <form id="questionForm" action="index.php" method="post">
            <div class="answers">
                <?php 
                $letters = ['A', 'B', 'C', 'D', 'E'];
                foreach ($current_question['answers'] as $index => $answer): 
                ?>
                    <label>
                        <input type="radio" name="answer" value="<?php echo $index; ?>" id="answer<?php echo $index; ?>">
                        <span><?php echo $letters[$index]; ?>.</span> <?php echo $answer; ?>
                    </label>
                <?php endforeach; ?>
            </div>
            <input type="button" class="button" value="Próxima" onclick="validateForm()">
        </form>
        <div id="error-message" class="error-message"></div>
    </div>

    <script>
        var endTime = <?php echo $end_time * 1000; ?>; // Tempo final da prova em milissegundos
        var timerElement = document.getElementById('timer');

        function updateTimer() {
            var now = new Date().getTime();
            var distance = endTime - now;

            if (distance < 0) {
                clearInterval(timerInterval);
                timerElement.innerHTML = "Tempo esgotado!";
                document.getElementById('questionForm').submit(); // Enviar o formulário automaticamente
                return;
            }

            var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            var seconds = Math.floor((distance % (1000 * 60)) / 1000);

            minutes = ("0" + minutes).slice(-2);
            seconds = ("0" + seconds).slice(-2);

            timerElement.innerHTML = minutes + ":" + seconds;
        }

        var timerInterval = setInterval(updateTimer, 1000);

        function validateForm() {
            var form = document.getElementById('questionForm');
            var radios = document.getElementsByName('answer');
            var isAnswerSelected = false;
            
            for (var i = 0; i < radios.length; i++) {
                if (radios[i].checked) {
                    isAnswerSelected = true;
                    break;
                }
            }

            if (!isAnswerSelected) {
                document.getElementById('error-message').innerHTML = "Por favor, selecione uma resposta.";
            } else {
                form.submit();
            }
        }
    </script>
</body>
</html>

