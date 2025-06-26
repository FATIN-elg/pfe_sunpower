<?php
require_once '../config/database.php';

// Requête pour obtenir le nombre de devis par jour
$sql = "SELECT DATE(date_creation) as date, COUNT(*) as count 
        FROM devis 
        GROUP BY DATE(date_creation) 
        ORDER BY date_creation DESC 
        LIMIT 7";
$result = $conn->query($sql);

$dates = [];
$counts = [];

while ($row = $result->fetch_assoc()) {
    $dates[] = $row['date'];
    $counts[] = $row['count'];
}

// Inverser les tableaux pour avoir l'ordre chronologique
$dates = array_reverse($dates);
$counts = array_reverse($counts);

$data = [
    'labels' => $dates,
    'datasets' => [[
        'label' => 'Nombre de devis par jour',
        'data' => $counts,
        'backgroundColor' => 'rgba(46, 125, 50, 0.2)',
        'borderColor' => 'rgb(46, 125, 50)',
        'borderWidth' => 1
    ]]
];

echo json_encode($data);
?>