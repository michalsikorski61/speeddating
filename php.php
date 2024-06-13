<?php
//check extension loaded imagick
if (!extension_loaded('imagick')) {
    echo 'imagick not installed';
    exit;
}
$przeniesiono      = false;                                        // Inicjalizacja
$komunikat         = '';                                           // Inicjalizacja
$blad              = '';                                           // Inicjalizacja
$sciezka_docelowa  = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'wyslane'  . DIRECTORY_SEPARATOR; // Docelowa ścieżka
$max_rozmiar       = 5242880;                                      // Max file size
$dozwolone_typy    = ['image/jpeg', 'image/png', 'image/gif','image/webp'];    // Dozwolone typy plików
$dozwolone_roz     = ['jpeg', 'jpg', 'png', 'gif', 'webp'];               // Dozwolone rozszerzenia

function utworz_miniature($tymczasowy, $docelowy)
{
    $obraz = new Imagick($tymczasowy);                             // Obiekt reprezentujący obraz
    $obraz->thumbnailImage(200, 200, true);                        // Utwórz miniaturę
    $obraz->writeImage($docelowy);                                 // Zapisz plik
    return true;                                                   // Zwróć true w przypadku powodzenia
}

function utworz_nazwepliku($nazwapliku, $sciezka_docelowa)         // Funkcja tworząca nazwę pliku
{
    $nazwa   = pathinfo($nazwapliku, PATHINFO_FILENAME);           // Pobierz nazwę
    $rozszerzenie  = pathinfo($nazwapliku, PATHINFO_EXTENSION);    // Pobierz rozszerzenie
    $nazwa   = preg_replace('/[^A-z0-9]/', '-', $nazwa);           // Oczyść nazwę
    $i          = 0;                                               // Licznik
    while (file_exists($sciezka_docelowa . $nazwapliku)) {         // Jeśli plik istnieje...
        $i        = $i + 1;                                        // Zaktualizuj licznik
        $nazwapliku = $nazwa . $i . '.' . $rozszerzenie;           // Nowa ścieżka
    }
    return $nazwapliku;                                            // Zwróć ścieżkę
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {                        // Jeśli formularz został przesłany
    $blad = ($_FILES['obraz']['error'] === 1) ? 'za duży ' : '';   // Sprawdź obraz pod kątem rozmiaru

    if ($_FILES['obraz']['error'] == 0) {                          // Jeśli nie ma błędów
        $blad  .= ($_FILES['obraz']['size'] <= $max_rozmiar) ? '' : 'za duży '; // Sprawdź rozmiar
        // Sprawdź typ MIME w tablicy $dozwolone_typy
        $typ   = mime_content_type($_FILES['obraz']['tmp_name']);        
        $blad .= in_array($typ, $dozwolone_typy) ? '' : 'nieobsługiwany typ ';
        // Sprawdź rozszerzenie w tablicy $dozwolone_roz
        $roz    = strtolower(pathinfo($_FILES['obraz']['name'], PATHINFO_EXTENSION));
        $blad .= in_array($roz, $dozwolone_roz) ? '' : 'nieobsługiwane rozszerzenie ';

        // Jeśli nie ma błędów, utwórz nową ścieżkę i spróbuj przenieść plik
		
        if (!$blad) {
          $nazwapliku    = utworz_nazwepliku($_FILES['obraz']['name'], $sciezka_docelowa);
          $docelowy = $sciezka_docelowa . $nazwapliku;
          $przeniesiono       = move_uploaded_file($_FILES['obraz']['tmp_name'], $docelowy);
          $sciezkamin   = $sciezka_docelowa . 'min_' . $nazwapliku;
          $miniatura       = utworz_miniature($docelowy, $sciezkamin); // Utwórz miniaturę
        }
    }
    if ($przeniesiono === true and $miniatura === true) {                         // Jeśli został przeniesiony
        $komunikat = 'Przesłano:<br><img src="wyslane/min_' . $nazwapliku . '">'; // Wyświetl obraz
    } else {                                                                      // W przeciwnym razie
        $komunikat = '<b>Nie udało się przesłać pliku:</b> ' . $blad;             // Wyświetl błędy
    }
}
?>

<?= $komunikat ?>
  <form method="POST" action="" enctype="multipart/form-data">
    <label for="obraz"><b>Prześlij plik:</b></label>
    <input type="file" name="obraz" id="obraz" accept="image/*"><br>
    <input type="submit" value="Wyślij">
  </form>
