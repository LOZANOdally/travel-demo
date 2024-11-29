<?php
header('Content-Type: application/json');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

// Connexion à la base de données
$servername = "localhost";
$username = "root";  
$password = "";     
$dbname = "travel-demo";  

// Créer la connexion
$conn = new mysqli($servername, $username, $password, $dbname);

// Vérifier la connexion
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Récupérer la catégorie et le terme de recherche à partir de la requête GET
$category = isset($_GET['category']) ? $_GET['category'] : 'nature';  
$searchQuery = isset($_GET['searchQuery']) ? $_GET['searchQuery'] : '';

// Préparer la requête SQL pour éviter les injections SQL
$sql = "SELECT * FROM activities WHERE category = ?";

// Si un terme de recherche est fourni, l'ajouter à la requête
if (!empty($searchQuery)) {
    $sql .= " AND name LIKE ?";
}

// Préparer la requête
$stmt = $conn->prepare($sql);

// Si un terme de recherche est donné, on l'ajoute comme paramètre
if (!empty($searchQuery)) {
    $searchQuery = "%".$searchQuery."%";  // Ajouter les % pour la recherche PARTIELLE
    $stmt->bind_param("ss", $category, $searchQuery);
} else {
    // Si aucun terme de recherche, uniquement la catégorie
    $stmt->bind_param("s", $category);
}

// Exécuter la requête
$stmt->execute();

// Récupérer les résultats
$result = $stmt->get_result();

$activities = [];

if ($result->num_rows > 0) {
    // Récupérer chaque ligne et ajouter dans un tableau
    while($row = $result->fetch_assoc()) {
        $activities[] = $row;
    }
} else {
    $activities = [];
}

// Convertir le tableau des activités en JSON
echo json_encode($activities);

// Fermer la connexion
$conn->close();
?>
