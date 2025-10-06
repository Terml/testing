<?php
echo "ЗАПУСК UNIT ТЕСТОВ\n";
echo "=" . str_repeat("=", 60) . "\n\n";

if (!file_exists('index.php')) {
    echo "❌ ОШИБКА: Файл index.php не найден!\n";
    exit(1);
}

echo str_repeat("-", 30) . "\n";

include 'test.php';

echo "\n" . str_repeat("=", 60) . "\n";
echo "ВСЕ ТЕСТЫ ЗАВЕРШЕНЫ\n";
?>