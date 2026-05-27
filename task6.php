<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Обратная польская запись</title>
</head>
<body>
<div>
    <h2>Обратная польская запись</h2>
    <form method="post">
        <input type="text" name="expression" placeholder="Пример: 8 9 + 1 7 - *" value="<?php echo isset($_POST['expression']) ? htmlspecialchars($_POST['expression']) : ''; ?>" required>
        <button type="submit">Вычислить</button>
    </form>

    <?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['expression'])) {
        $expression = trim($_POST['expression']);
        
        function evaluateRPN($expr) {
            $stack = [];
            $tokens = explode(' ', $expr);
            
            for ($i = 0; $i < count($tokens); $i++) {
                $token = $tokens[$i];
                
                if (is_numeric($token)) {
                    array_push($stack, (int)$token);
                } else if ($token === '+' || $token === '-' || $token === '*') {
                    if (count($stack) < 2) {
                        return null;
                    }
                    $b = array_pop($stack);
                    $a = array_pop($stack);
                    
                    if ($token === '+') {
                        $result = $a + $b;
                    } else if ($token === '-') {
                        $result = $a - $b;
                    } else if ($token === '*') {
                        $result = $a * $b;
                    }
                    
                    array_push($stack, $result);
                } else {
                    return null;
                }
            }
            
            if (count($stack) === 1) {
                return $stack[0];
            }
            return null;
        }
        
        $result = evaluateRPN($expression);
        
        echo '<div>';
        if ($result !== null) {
            echo '<strong>Результат:</strong> ' . $result;
        } else {
            echo '<div><strong>Ошибка:</strong> Некорректное выражение в постфиксной записи</div>';
        }
        echo '</div>';
    }
    ?>
</div>
</body>
</html>