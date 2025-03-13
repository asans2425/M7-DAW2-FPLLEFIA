<?php
// Get current league if specified
$league_id = isset($_GET['league_id']) ? (int)$_GET['league_id'] : null;

// Get user leagues for filter
$user_leagues = getUserLeagues($_SESSION['user_id']);

// Get rankings data
function getRankings($league_id = null)
{
    global $conn;

    $league_condition = "";
    if ($league_id) {
        $league_condition = "AND m.league_id = $league_id";
    }

    // Individual rankings - corregido para contar victorias correctamente
    $query = "SELECT 
                u.id,
                u.name,
                u.username,
                u.avatar,
                COUNT(DISTINCT m.id) as total_matches,
                SUM(CASE WHEN mp.is_winner = 1 THEN 1 ELSE 0 END) as wins,
                SUM(CASE WHEN mp.is_winner = 0 THEN 1 ELSE 0 END) as losses,
                SUM(CASE 
                    WHEN mp.team = 1 THEN mr.team1_score
                    WHEN mp.team = 2 THEN mr.team2_score
                END) as games_won,
                SUM(CASE 
                    WHEN mp.team = 1 THEN mr.team2_score
                    WHEN mp.team = 2 THEN mr.team1_score
                END) as games_lost
              FROM users u
              JOIN match_players mp ON u.id = mp.user_id
              JOIN matches m ON mp.match_id = m.id
              JOIN match_results mr ON m.id = mr.match_id
              WHERE 1=1 $league_condition
              GROUP BY u.id
              ORDER BY wins DESC, games_won DESC, total_matches DESC";

    $result = $conn->query($query);
    $individual_rankings = [];

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $individual_rankings[] = $row;
        }
    }

    // Pair rankings - corregido para contar parejas correctamente
    $query = "SELECT 
                u1.id as player1_id,
                u1.name as player1_name,
                u2.id as player2_id,
                u2.name as player2_name,
                COUNT(DISTINCT m.id) as total_matches,
                SUM(CASE WHEN mp1.is_winner = 1 THEN 1 ELSE 0 END) as wins,
                SUM(CASE WHEN mp1.is_winner = 0 THEN 1 ELSE 0 END) as losses,
                SUM(CASE 
                    WHEN mp1.team = 1 THEN mr.team1_score
                    WHEN mp1.team = 2 THEN mr.team2_score
                END) as games_won,
                SUM(CASE 
                    WHEN mp1.team = 1 THEN mr.team2_score
                    WHEN mp1.team = 2 THEN mr.team1_score
                END) as games_lost
              FROM match_players mp1
              JOIN match_players mp2 ON mp1.match_id = mp2.match_id 
                AND mp1.team = mp2.team
                AND mp1.user_id < mp2.user_id
              JOIN matches m ON mp1.match_id = m.id
              JOIN match_results mr ON m.id = mr.match_id
              JOIN users u1 ON mp1.user_id = u1.id
              JOIN users u2 ON mp2.user_id = u2.id
              WHERE 1=1 $league_condition
              GROUP BY u1.id, u2.id
              ORDER BY wins DESC, games_won DESC, total_matches DESC";

    $result = $conn->query($query);
    $pair_rankings = [];

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $pair_rankings[] = $row;
        }
    }

    return [
        'individual' => $individual_rankings,
        'pairs' => $pair_rankings
    ];
}

$rankings = getRankings($league_id);
?>

<!-- El resto del archivo HTML permanece igual -->