<?php
require_once '../config/database.php';

// Requête pour obtenir les 5 produits les plus demandés
$sql = "SELECT p.nom_produit, COUNT(d.id_produit) as count 
        FROM produits p 
        LEFT JOIN devis_produits d ON p.id = d.id_produit 
        GROUP BY p.id 
        ORDER BY count DESC 
        LIMIT 5";
$result = $conn->query($sql);

$products = [];
$counts = [];

while ($row = $result->fetch_assoc()) {
    $products[] = $row['nom_produit'];
    $counts[] = $row['count'];
}

$data = [
    'labels' => $products,
    'datasets' => [[
        'label' => 'Produits les plus demandés',
        'data' => $counts,
        'backgroundColor' => [
            'rgba(46, 125, 50, 0.2)',
            'rgba(255, 102, 0, 0.2)',
            'rgba(33, 150, 243, 0.2)',
            'rgba(156, 39, 176, 0.2)',
            'rgba(255, 193, 7, 0.2)'
        ],
        'borderColor' => [
            'rgb(46, 125, 50)',
            'rgb(255, 102, 0)',
            'rgb(33, 150, 243)',
            'rgb(156, 39, 176)',
            'rgb(255, 193, 7)'
        ],
        'borderWidth' => 1
    ]]
];

echo json_encode($data);
?>