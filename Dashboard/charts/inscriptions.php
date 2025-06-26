<?php
require_once '../config/database.php';

// Requête pour obtenir le nombre d'inscriptions par mois
$sql = "SELECT DATE_FORMAT(date_inscription, '%Y-%m') as month, COUNT(*) as count 
        FROM users 
        GROUP BY DATE_FORMAT(date_inscription, '%Y-%m') 
        ORDER BY month DESC 
        LIMIT 6";
$result = $conn->query($sql);

$months = [];
$counts = [];

while ($row = $result->fetch_assoc()) {
    $months[] = $row['month'];
    $counts[] = $row['count'];
}

// Inverser les tableaux pour avoir l'ordre chronologique
$months = array_reverse($months);
$counts = array_reverse($counts);

$data = [
    'labels' => $months,
    'datasets' => [[
        'label' => 'Nombre d\'inscriptions par mois',
        'data' => $counts,
        'backgroundColor' => 'rgba(255, 102, 0, 0.2)',
        'borderColor' => 'rgb(255, 102, 0)',
        'borderWidth' => 1
    ]]
];

echo json_encode($data);
?>