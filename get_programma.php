<?php
// URL van de gepubliceerde Google Spreadsheet
$html_url = 'https://docs.google.com/spreadsheets/d/1AAiOu8JNrL71YzaDhErr5FjhY8_-IadQpoQDYwAjzV4/pubhtml?gid=24064065&single=true';

// Voeg een tijdstempel toe aan de URL om caching te voorkomen
$html_url_with_timestamp = $html_url . '&t=' . time();  // Elke keer een andere querystring

// Haal de HTML van de spreadsheet op met de tijdstempel in de URL
$html_data = file_get_contents($html_url_with_timestamp);

if ($html_data !== false) {
    // Laad de HTML in DOMDocument
    $dom = new DOMDocument();
    libxml_use_internal_errors(true);  // Onderdruk HTML-parserfouten
    $dom->loadHTML($html_data);
    libxml_clear_errors();

    // Zoek naar alle tabellen in de HTML
    $tables = $dom->getElementsByTagName('table');

    if ($tables->length > 0) {
        // Selecteer de eerste tabel
        $table = $tables->item(0);

        // Haal alle rijen op
        $rows = $table->getElementsByTagName('tr');

        // Maak een array om de gegevens op te slaan
        $data = [];
        $headers = [];

        // Loop door elke rij
        foreach ($rows as $index => $row) {
            // Haal alle cellen (kolommen) op
            $cells = $row->getElementsByTagName('td');

            // Maak een array voor deze rij
            $rowData = [];

            // Loop door elke cel in de rij
            foreach ($cells as $cell) {
                // Voeg de inhoud van de cel toe aan de rij
                $rowData[] = $cell->nodeValue;
            }

            // Als dit de eerste rij is, behandel het als headers
            if ($index === 0) {
                $headers = $rowData;
            } else {
                // Voeg de rij toe aan de gegevens array
                if (!empty($rowData)) {
                    $data[] = $rowData;
                }
            }
        }

        // Stuur de headers en de gegevens terug als JSON
        echo json_encode(['headers' => $headers, 'data' => $data]);
    } else {
        echo json_encode(["error" => "Geen tabel gevonden in de HTML."]);
    }
} else {
    echo json_encode(["error" => "Kon de HTML niet ophalen."]);
}
?>
