<?php
ob_start();
require_once 'index.php';
ob_end_clean();

class StringProcessorTest {
    
    private $testCount = 0;
    private $passedTests = 0;
    private $failedTests = 0;
    
    public function runTest($testName, $expected, $actual) {
        $this->testCount++;
        echo "Тест {$this->testCount}: {$testName}\n";
        
        if ($expected === $actual) {
            echo "ПРОЙДЕН\n";
            $this->passedTests++;
        } else {
            echo "ПРОВАЛЕН\n";
            echo "   Ожидалось: '{$expected}'\n";
            echo "   Получено:  '{$actual}'\n";
            $this->failedTests++;
        }
        echo "\n";
    }
    
    public function runAllTests() {
        echo "=== ЗАПУСК UNIT ТЕСТОВ ===\n\n";
        $this->testMbStrrev();
        $this->testMbStrrevPunctuation();
        $this->testMbStrrevHyphensApostrophes();
        $this->showResults();
    }

    private function testMbStrrev() {
        echo "--- ТЕСТЫ ФУНКЦИИ ---\n";
        $this->runTest(
            "Сохранение регистра: Cat -> Tac",
            "Tac",
            mb_strrev("Cat")
        );
        $this->runTest(
            "Сохранение регистра: Мышь -> Ьшым",
            "Ьшым",
            mb_strrev("Мышь")
        );
        $this->runTest(
            "Сохранение регистра: houSe -> esuOh",
            "esuOh",
            mb_strrev("houSe")
        );
        $this->runTest(
            "Сохранение регистра: домИК -> кимОД",
            "кимОД",
            mb_strrev("домИК")
        );
        $this->runTest(
            "Сохранение регистра: elEpHant -> tnAhPele",
            "tnAhPele",
            mb_strrev("elEpHant")
        );
    }

    private function testMbStrrevPunctuation() {
        echo "--- ТЕСТЫ СОХРАНЕНИЯ ПУНКТУАЦИИ ---\n";
        $this->runTest(
            "Сохранение пунктуации: \"cat,\" -> \"tac,\"",
            "tac,",
            implode(array_map('mb_strrev', splitStringWithSeparators("cat,")))
        );
        $this->runTest(
            "Сохранение пунктуации: \"Зима:\" -> \"Амиз:\"",
            "Амиз:",
            implode(array_map('mb_strrev', splitStringWithSeparators("Зима:")))
        );
        $this->runTest(
            "Сохранение пунктуации: \"is 'cold' now\" -> \"si 'dloc' won\"",
            "si 'dloc' won",
            implode(array_map('mb_strrev', splitStringWithSeparators("is 'cold' now")))
        );
        $this->runTest(
            "Сохранение пунктуации: 'это «Так» \"просто\"' -> 'отэ «Кат» \"отсорп\"'",
            'отэ «Кат» "отсорп"',
            implode(array_map('mb_strrev', splitStringWithSeparators('это «Так» "просто"')))
        );
    }

    private function testMbStrrevHyphensApostrophes() {
        echo "--- ТЕСТЫ С ДЕФИСАМИ И АПОСТРОФАМИ ---\n";
        $this->runTest(
            "Дефисы и апострофы: third-part -> driht-trap",
            "driht-trap",
            implode(array_map('mb_strrev', splitStringWithSeparators("third-part")))
        );
        $this->runTest(
            "Дефисы и апострофы: can`t -> nac`t",
            "nac`t",
            implode(array_map('mb_strrev', splitStringWithSeparators("can`t")))
        );
    }

    private function showResults() {
        echo "=== РЕЗУЛЬТАТЫ ТЕСТИРОВАНИЯ ===\n";
        echo "Всего тестов: {$this->testCount}\n";
        echo "Пройдено: {$this->passedTests}\n";
        echo "Провалено: {$this->failedTests}\n";
        if ($this->failedTests === 0) {
            echo "ВСЕ ТЕСТЫ ПРОЙДЕНЫ УСПЕШНО!\n";
        } else {
            echo "ЕСТЬ ПРОВАЛЕННЫЕ ТЕСТЫ\n";
        }
        $percentage = round(($this->passedTests / $this->testCount) * 100, 2);
        echo "Процент успешности: {$percentage}%\n";
    }
}

$tester = new StringProcessorTest();
$tester->runAllTests();
?>

