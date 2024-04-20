<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>

<?php


$animal = array("pies", "kot", "wielblad", "hipopotam");

foreach ($animal as $animals) {
    echo "<br>";
    echo $animals . "<br>"; // Wyświetlenie zwierzęcia

    // Odwrócenie liter w słowie i wyświetlenie ich
    for ($i = strlen($animals) - 1; $i >= 0; $i--) {
        echo $animals[$i];
    }
    echo "<br>";
}
function liczbyPierwsze($zakres) {
    $liczbyPierwsze = [];

    for ($i = 2; $i <= $zakres; $i++) {
        if (isPrime($i)) {
            $liczbyPierwsze[] = $i;
        }
    }

    return $liczbyPierwsze;
}

function isPrime($liczba) {
    if ($liczba <= 1) {
        return false;
    }

    for ($i = 2; $i <= sqrt($liczba); $i++) {
        if ($liczba % $i == 0) {
            return false;
        }
    }

    return true;
}

$zakres = 100;
$liczbyPierwsze = liczbyPierwsze($zakres);

echo "Zadanie 2: Liczby pierwsze z zakresu 1 do $zakres: ";
echo implode(", ", $liczbyPierwsze);
echo "<br><br>";

// Zadanie 3: Wyliczenie N-tej liczby Fibonacciego

function fibonacci($n) {
    if ($n <= 1) {
        return $n;
    }

    return fibonacci($n - 1) + fibonacci($n - 2);
}

$n = 10;
$liczbaFibonacciego = fibonacci($n);

echo "Zadanie 3: N-ta liczba Fibonacciego, gdzie N = $n: $liczbaFibonacciego";
echo "<br><br>";

// Zadanie 4: Usunięcie znaków interpunkcyjnych z tekstu i utworzenie tablicy asocjacyjnej

$tekst = "Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged, It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.";

$slowa = explode(" ", $tekst);

// Usuwanie znaków interpunkcyjnych
foreach ($slowa as $key => $slowo) {
    $znakiInterpunkcyjne = ['.', ',', '!', '?', ':', ';', '(', ')', '[', ']', '{', '}', '"', "'"];

    foreach ($znakiInterpunkcyjne as $znak) {
        $slowo = str_replace($znak, '', $slowo);
    }

    $slowa[$key] = $slowo;
}

// Tworzenie tablicy asocjacyjnej
$tablicaAsocjacyjna = [];

foreach ($slowa as $key => $slowo) {
    if ($key % 2 == 1) {
        $tablicaAsocjacyjna[$slowo] = $slowa[$key + 1];
    }
}


echo "Zadanie 4";
echo "<br>";

foreach ($tablicaAsocjacyjna as $klucz => $wartosc) {
    echo "$klucz: $wartosc<br>";
}
?>

</body>
</html>