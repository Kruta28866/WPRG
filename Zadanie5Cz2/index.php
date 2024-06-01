<?php
// Konfiguracja połączenia z bazą danych
$host = 'localhost';
$db = 'mojaBaza';
$user = 'root';
$pass = '';

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Połączenie nieudane: " . $conn->connect_error);
}
function render_main_page($conn) {
    $sql = "SELECT id, marka, model, cena FROM samochody ORDER BY cena ASC LIMIT 5";
    $result = $conn->query($sql);

    echo '<h2>Pięć samochodów z najniższą ceną</h2>';
    echo '<table border="1"><tr><th>ID</th><th>Marka</th><th>Model</th><th>Cena</th></tr>';
    while ($row = $result->fetch_assoc()) {
        echo '<tr>';
        echo '<td>' . $row['id'] . '</td>';
        echo '<td>' . $row['marka'] . '</td>';
        echo '<td>' . $row['model'] . '</td>';
        echo '<td>' . $row['cena'] . '</td>';
        echo '</tr>';
    }
    echo '</table>';
}

function render_all_cars($conn) {
    $sql = "SELECT id, marka, model, cena FROM samochody ORDER BY rok DESC";
    $result = $conn->query($sql);

    echo '<h2>Wszystkie samochody</h2>';
    echo '<table border="1"><tr><th>ID</th><th>Marka</th><th>Model</th><th>Cena</th><th>Szczegóły</th></tr>';
    while ($row = $result->fetch_assoc()) {
        echo '<tr>';
        echo '<td>' . $row['id'] . '</td>';
        echo '<td>' . $row['marka'] . '</td>';
        echo '<td>' . $row['model'] . '</td>';
        echo '<td>' . $row['cena'] . '</td>';
        echo '<td><a href="?action=details&id=' . $row['id'] . '">Szczegóły</a></td>';
        echo '</tr>';
    }
    echo '</table>';
}

function render_add_car_form() {
    echo '<h2>Dodaj nowy samochód</h2>';
    echo '<form method="post" action="?action=add">';
    echo 'Marka: <input type="text" name="marka" required><br>';
    echo 'Model: <input type="text" name="model" required><br>';
    echo 'Cena: <input type="number" step="0.01" name="cena" required><br>';
    echo 'Rok: <input type="number" name="rok" required><br>';
    echo 'Opis: <textarea name="opis" required></textarea><br>';
    echo '<button type="submit">Dodaj</button>';
    echo '</form>';
}

function add_car($conn) {
    $marka = $_POST['marka'];
    $model = $_POST['model'];
    $cena = $_POST['cena'];
    $rok = $_POST['rok'];
    $opis = $_POST['opis'];

    $sql = "INSERT INTO samochody (marka, model, cena, rok, opis) VALUES ('$marka', '$model', '$cena', '$rok', '$opis')";
    if ($conn->query($sql) === TRUE) {
        echo "Nowy samochód został dodany pomyślnie.";
    } else {
        echo "Błąd: " . $sql . "<br>" . $conn->error;
    }
}

function render_car_details($conn, $id) {
    $sql = "SELECT * FROM samochody WHERE id = $id";
    $result = $conn->query($sql);

    if ($row = $result->fetch_assoc()) {
        echo '<h2>Szczegóły samochodu</h2>';
        echo 'ID: ' . $row['id'] . '<br>';
        echo 'Marka: ' . $row['marka'] . '<br>';
        echo 'Model: ' . $row['model'] . '<br>';
        echo 'Cena: ' . $row['cena'] . '<br>';
        echo 'Rok: ' . $row['rok'] . '<br>';
        echo 'Opis: ' . $row['opis'] . '<br>';
        echo '<a href="?action=main">Powrót do strony głównej</a>';
    } else {
        echo "Samochód nie został znaleziony.";
    }
}

?>
<!DOCTYPE html>
<html>
<head>
    <title>Portal z samochodami</title>
</head>
<body>
<table>
    <tr>
        <td><a href="?action=main">Strona główna</a></td>
        <td><a href="?action=all">Wszystkie samochody</a></td>
        <td><a href="?action=add_form">Dodaj samochód</a></td>
    </tr>
</table>

<?php
if (isset($_GET['action'])) {
    switch ($_GET['action']) {
        case 'main':
            render_main_page($conn);
            break;
        case 'all':
            render_all_cars($conn);
            break;
        case 'add_form':
            render_add_car_form();
            break;
        case 'add':
            add_car($conn);
            render_main_page($conn);
            break;
        case 'details':
            $id = intval($_GET['id']);
            render_car_details($conn, $id);
            break;
        default:
            render_main_page($conn);
            break;
    }
} else {
    render_main_page($conn);
}
?>

</body>
</html>

<?php
$conn->close();
?>
