<?php
const spacer = [' ', '-', '—', '–', '.', ',', '!', '?', ';', ':', '(', ')', '[', ']', '{', '}', '/', '\\', '|', '_', '+', '=', '*', '&', '%', '$', '#', '@', '~', '`', '«', '»'];
const quote = ['«', '»'];
function mb_strrev($str, $encoding = 'UTF-8') {
    if (empty($str)) {
        return $str;
    }
    $length = mb_strlen($str, $encoding);
    $reversed = '';
    for ($i = $length - 1; $i >= 0; $i--) {
        $reversed .= mb_substr($str, $i, 1, $encoding);
    }
    $result = '';
    for ($i = 0; $i < $length; $i++) {
        $originalChar = mb_substr($str, $i, 1, $encoding);
        $reversedChar = mb_substr($reversed, $i, 1, $encoding);
        if (in_array($originalChar, quote)) {
            $result .= $originalChar;
        } elseif (mb_strtoupper($originalChar, $encoding) === $originalChar && 
                  mb_strtolower($originalChar, $encoding) !== $originalChar) {
            $result .= mb_strtoupper($reversedChar, $encoding);
        } else {
            $result .= mb_strtolower($reversedChar, $encoding);
        }
    }
    return $result;
}
function splitStringWithSeparators($str) {
    if (!is_string($str)) {
        return ["Ошибка: параметр должен быть строкой"];
    }
    if (empty($str)) {
        return [];
    }
    $result = [];
    $currentWord = '';
    for ($i = 0; $i < strlen($str); $i++) {
        $char = $str[$i];
        if (in_array($char, spacer)) {
            if ($currentWord !== '') {
                $result[] = $currentWord;
                $currentWord = '';
            }
            $result[] = $char;
        } else {
            $currentWord .= $char;
        }
    }
    if ($currentWord !== '') {
        $result[] = $currentWord;
    }
    return $result;
}
$input = $_POST['input'] ?? '';
$output = '';
if (!empty($input)) {
    $splitResult = splitStringWithSeparators($input);
    $reversedResult = array_map('mb_strrev', $splitResult);
    $output = implode($reversedResult);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Тестовое задание</title>
</head>

<body>
  <h1>Тестовое задание</h1>
  <form method="POST">
    <input type="text" name="input" placeholder="Введите текст" value="<?php echo htmlspecialchars($input); ?>">
    <input type="text" name="output" placeholder="Результат" value="<?php echo htmlspecialchars($output); ?>" readonly>
    <input type="submit" value="Отредактировать текст">
  </form>
</body>

</html>