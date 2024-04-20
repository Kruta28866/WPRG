<?php

if(isset($_POST['submit_calc'])) {
    $num1 = $_POST['num1'];
    $num2 = $_POST['num2'];
    $operation = $_POST['operation'];
    $result = 0;

    switch ($operation) {
        case 'add':
            $result = $num1 + $num2;
            break;
        case 'subtract':
            $result = $num1 - $num2;
            break;
        case 'multiply':
            $result = $num1 * $num2;
            break;
        case 'divide':
            if($num2 != 0) {
                $result = $num1 / $num2;
            } else {
                $result = "Nie można dzielić przez zero!";
            }
            break;
        default:
            $result = "Wybierz działanie";
            break;
    }
    echo "Wynik: " . $result;
}

if(isset($_POST['submit_reservation'])) {
    $guests = $_POST['guests'];
    $name = $_POST['name'];
    $surname = $_POST['surname'];
    $address = $_POST['address'];
    $credit_card = $_POST['credit_card'];
    $email = $_POST['email'];
    $date = $_POST['date'];
    $arrival_time = $_POST['arrival_time'];
    $child_bed = isset($_POST['child_bed']) ? "Tak" : "Nie";
    $amenities = isset($_POST['amenities']) ? $_POST['amenities'] : array();

    echo "<h2>Podsumowanie rezerwacji:</h2>";
    echo "<p>Liczba gości: $guests</p>";
    echo "<p>Imię: $name</p>";
    echo "<p>Nazwisko: $surname</p>";
    echo "<p>Adres: $address</p>";
    echo "<p>Numer karty kredytowej: $credit_card</p>";
    echo "<p>Email: $email</p>";
    echo "<p>Data pobytu: $date</p>";
    echo "<p>Godzina przyjazdu: $arrival_time</p>";
    echo "<p>Potrzeba łóżka dla dziecka: $child_bed</p>";
    echo "<p>Udogodnienia: " . implode(", ", $amenities) . "</p>";
}

function isPrime($number) {
    if($number <= 1) return false;
    if($number <= 3) return true;

    if($number % 2 == 0 || $number % 3 == 0) return false;

    $i = 5;
    while($i * $i <= $number) {
        if($number % $i == 0 || $number % ($i + 2) == 0) {
            return false;
        }
        $i += 6;
    }
    return true;
}

if(isset($_POST['submit_prime'])) {
    $number = isset($_POST['number']) ? $_POST['number'] : 0;
    $iterations = 0;

    if(is_numeric($number) && $number > 0) {
        $is_prime = isPrime($number);
        echo "<h2>Czy $number jest liczbą pierwszą?</h2>";
        echo $is_prime ? "Tak" : "Nie";


        $i = 2;
        while($i * $i <= $number) {
            $iterations++;
            $i++;
        }
        echo "<p>Liczba iteracji: $iterations</p>";
    } else {
        echo "Podana wartość nie jest poprawną liczbą całkowitą dodatnią.";
    }
}
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Zadania PHP</title>
</head>
<body>
<h2>Prosty kalkulator</h2>
<form method="POST">
    <input type="number" name="num1" required>
    <select name="operation" required>
        <option value="add">Dodawanie</option>
        <option value="subtract">Odejmowanie</option>
        <option value="multiply">Mnożenie</option>
        <option value="divide">Dzielenie</option>
    </select>
    <input type="number" name="num2" required>
    <button type="submit" name="submit_calc">Oblicz</button>
</form>

<h2>Formularz rezerwacji hotelu</h2>
<form method="POST">
    <label for="guests">Liczba gości:</label>
    <select name="guests" id="guests" required>
        <?php for($i = 1; $i <= 4; $i++): ?>
            <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
        <?php endfor; ?>
    </select>

    <button type="submit" name="submit_reservation">Zarezerwuj</button>
</form>

<h2>Czy dana liczba jest liczbą pierwszą?</h2>
<form method="POST">
    <label for="number">Podaj liczbę całkowitą dodatnią:</label>
    <input type="number" name="number" id="number" required>
    <button type="submit" name="submit_prime">Sprawdź</button>
</form>
</body>
</html>
