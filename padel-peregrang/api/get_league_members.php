<?php
require_once '../config/database.php';
require_once '../includes/functions.php';

header('Content-Type: application/json');

if (!isset($_GET['league_id'])) {
    echo json_encode(['error' => 'League ID is required']);
    exit;
}

$league_id = (int)$_GET['league_id'];

$query = "SELECT u.id, u.name, u.username 
          FROM users u 
          JOIN league_users lu ON u.id = lu.user_id 
          WHERE lu.league_id = $league_id 
          ORDER BY u.name";

$result = $conn->query($query);
$members = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $members[] = $row;
    }
}

echo json_encode($members);
