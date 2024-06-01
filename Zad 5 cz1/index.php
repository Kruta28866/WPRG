<?php
session_start();

function render_form($form_html) {
    echo $form_html;
}

// Zadanie 1: Obsługa formularzy i sesji
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['step']) && $_POST['step'] == '1') {
        // Pierwszy formularz
        $_SESSION['nr_karty'] = $_POST['nr_karty'];
        $_SESSION['zamawiajacy'] = $_POST['zamawiajacy'];
        $_SESSION['ilosc_osob'] = $_POST['ilosc_osob'];
        $_SESSION['osoby'] = [];
    } elseif (isset($_POST['step']) && $_POST['step'] == '2') {
        // Drugi formularz
        $ilosc_osob = $_SESSION['ilosc_osob'];
        $osoby = [];
        for ($i = 0; $i < $ilosc_osob; $i++) {
            $osoba = [
                'imie' => $_POST["imie_$i"],
                'nazwisko' => $_POST["nazwisko_$i"]
            ];
            $osoby[] = $osoba;
        }
        $_SESSION['osoby'] = $osoby;
    }
}

// Zadanie 2 i 3: Obsługa cookies
if (!isset($_SESSION['visited'])) {
    if (isset($_COOKIE['unique_visits'])) {
        $visits = $_COOKIE['unique_visits'] + 1;
    } else {
        $visits = 1;
    }
    setcookie('unique_visits', $visits, time() + 60*60*24*365*2); // cookie ważne przez 2 lata
    $_SESSION['visited'] = true;
} else {
    $visits = $_COOKIE['unique_visits'];
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Strona główna</title>
</head>
<body>
<?php if (!isset($_SESSION['nr_karty'])): ?>
    <!-- Pierwsza podstrona -->
    <form method="post">
        <input type="hidden" name="step" value="1">
        Nr karty: <input type="text" name="nr_karty" required><br>
        Zamawiający: <input type="text" name="zamawiajacy" required><br>
        Ilość osób: <input type="number" name="ilosc_osob" required><br>
        <button type="submit">Dalej</button>
    </form>
<?php elseif (!isset($_SESSION['osoby']) || empty($_SESSION['osoby'])): ?>
    <!-- Druga podstrona -->
    <form method="post">
        <input type="hidden" name="step" value="2">
        <?php
        $ilosc_osob = $_SESSION['ilosc_osob'];
        for ($i = 0; $i < $ilosc_osob; $i++):
            ?>
            Imię osoby <?= $i + 1 ?>: <input type="text" name="imie_<?= $i ?>" required><br>
            Nazwisko osoby <?= $i + 1 ?>: <input type="text" name="nazwisko_<?= $i ?>" required><br><br>
        <?php endfor; ?>
        <button type="submit">Zapisz i przejdź dalej</button>
    </form>
<?php else: ?>
    <!-- Trzecia podstrona -->
    <h2>Podsumowanie</h2>
    Nr karty: <?= htmlspecialchars($_SESSION['nr_karty']) ?><br>
    Zamawiający: <?= htmlspecialchars($_SESSION['zamawiajacy']) ?><br>
    Ilość osób: <?= htmlspecialchars($_SESSION['ilosc_osob']) ?><br><br>
    <h3>Dane osób:</h3>
    <ul>
        <?php foreach ($_SESSION['osoby'] as $osoba): ?>
            <li><?= htmlspecialchars($osoba['imie']) ?> <?= htmlspecialchars($osoba['nazwisko']) ?></li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>

<!-- Zadanie 2 i 3: Wyświetlanie liczby odwiedzin -->
<p>Liczba unikalnych odwiedzin: <?= $visits ?></p>
<?php if ($visits >= 10): ?>
    <p>Odwiedziłeś stronę 10 razy!</p>
<?php endif; ?>
</body>
</html>
