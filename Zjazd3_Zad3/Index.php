<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formularz</title>
</head>
<body>
<h2>Formularz</h2>
<form action="" method="GET">
    Podaj datę urodzenia (RRRR-MM-DD): <input type="date" name="birthdate">
    <input type="submit" value="Wyślij">
</form>

<?php
if (isset($_GET['birthdate'])) {
    $birthdate = $_GET['birthdate'];


    function dayOfWeek($birthdate) {
        $dayOfWeek = date('l', strtotime($birthdate));
        echo "Urodziłeś się w dniu tygodnia: $dayOfWeek<br>";
    }

    function calculateAge($birthdate) {
        $now = time();
        $birthDate = strtotime($birthdate);
        $age = date('Y', $now) - date('Y', $birthDate);
        if (date('md', $now) < date('md', $birthDate)) {
            $age--;
        }
        echo "Masz $age lat<br>";
    }

    function daysToNextBirthday($birthdate) {
        $nextBirthday = date('Y-m-d', strtotime('+' . (date('Y') - date('Y', strtotime($birthdate))) . ' years', strtotime($birthdate)));
        $daysUntilNextBirthday = ceil((strtotime($nextBirthday) - time()) / (60 * 60 * 24));
        echo "Pozostało $daysUntilNextBirthday dni do Twoich najbliższych urodzin<br>";
    }

    dayOfWeek($birthdate);
    calculateAge($birthdate);
    daysToNextBirthday($birthdate);
}
?>

<h2>Algorytmy</h2>
<form action="" method="GET">
    Wybierz algorytm:
    <select name="algorithm">
        <option value="factorial">Silnia</option>
        <option value="fibonacci">Ciąg Fibonacciego</option>
    </select>
    Podaj argument: <input type="number" name="argument">
    <input type="submit" value="Oblicz">
</form>

<?php
if (isset($_GET['algorithm']) && isset($_GET['argument'])) {
    $algorithm = $_GET['algorithm'];
    $argument = $_GET['argument'];

    function recursiveFactorial($n) {
        if ($n <= 1) {
            return 1;
        }
        return $n * recursiveFactorial($n - 1);
    }

    function nonRecursiveFactorial($n) {
        $result = 1;
        for ($i = 2; $i <= $n; $i++) {
            $result *= $i;
        }
        return $result;
    }

    function recursiveFibonacci($n) {
        if ($n <= 1) {
            return $n;
        }
        return recursiveFibonacci($n - 1) + recursiveFibonacci($n - 2);
    }

    function nonRecursiveFibonacci($n) {
        $fib = [0, 1];
        for ($i = 2; $i <= $n; $i++) {
            $fib[$i] = $fib[$i - 1] + $fib[$i - 2];
        }
        return $fib[$n];
    }

    $start = microtime(true);
    if ($algorithm === 'factorial') {
        echo "Silnia z $argument rekurencyjnie: " . recursiveFactorial($argument) . "<br>";
    } elseif ($algorithm === 'fibonacci') {
        echo "Wartość $argument-tego wyrazu ciągu Fibonacciego rekurencyjnie: " . recursiveFibonacci($argument) . "<br>";
    }
    $end = microtime(true);
    $recursiveTime = $end - $start;

    $start = microtime(true);
    if ($algorithm === 'factorial') {
        echo "Silnia z $argument nierekurencyjnie: " . nonRecursiveFactorial($argument) . "<br>";
    } elseif ($algorithm === 'fibonacci') {
        echo "Wartość $argument-tego wyrazu ciągu Fibonacciego nierekurencyjnie: " . nonRecursiveFibonacci($argument) . "<br>";
    }
    $end = microtime(true);
    $nonRecursiveTime = $end - $start;

    echo "Czas wykonania rekurencyjnej funkcji: " . number_format($recursiveTime, 10) . " sekund<br>";
    echo "Czas wykonania nierekurencyjnej funkcji: " . number_format($nonRecursiveTime, 10) . " sekund<br>";
    echo "Nierekurencyjna funkcja działała " . number_format($recursiveTime / $nonRecursiveTime, 2) . " razy szybciej<br>";
}
?>

<h2>Struktura plików</h2>
<form action="" method="GET">
    Ścieżka: <input type="text" name="path">
    Nazwa katalogu: <input type="text" name="dirname">
    Operacja:
    <select name="operation">
        <option value="read">Odczyt</option>
        <option value="delete">Usuń</option>
        <option value="create">Stwórz</option>
    </select>
    <input type="submit" value="Wykonaj">
</form>

<?php
function manageDirectory($path, $dirname, $operation = 'read') {
    if (substr($path, -1) !== '/') {
        $path .= '/';
    }

    switch ($operation) {
        case 'read':
            if (is_dir($path . $dirname)) {
                $files = scandir($path . $dirname);
                echo "Zawartość katalogu $dirname:<br>";
                foreach ($files as $file) {
                    echo "$file<br>";
                }
            } else {
                echo "Katalog $dirname nie istnieje<br>";
            }
            break;
        case 'delete':
            if (is_dir($path . $dirname)) {
                if (count(scandir($path . $dirname)) === 2) {
                    rmdir($path . $dirname);
                    echo "Katalog $dirname został usunięty<br>";
                } else {
                    echo "Katalog $dirname nie jest pusty<br>";
                }
            } else {
                echo "Katalog $dirname nie istnieje<br>";
            }
            break;
        case 'create':
            if (!is_dir($path . $dirname)) {
                mkdir($path . $dirname);
                echo "Katalog $dirname został utworzony<br>";
            } else {
                echo "Katalog $dirname już istnieje<br>";
            }
            break;
        default:
            echo "Niepoprawna operacja<br>";
    }
}

if (isset($_GET['path']) && isset($_GET['dirname']) && isset($_GET['operation'])) {
    $path = $_GET['path'];
    $dirname = $_GET['dirname'];
    $operation = $_GET['operation'];

    manageDirectory($path, $dirname, $operation);
}
?>

</body>
</html>
