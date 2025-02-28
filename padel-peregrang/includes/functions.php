<?php
// Function to sanitize user input
function sanitize($data)
{
    global $conn;
    return mysqli_real_escape_string($conn, htmlspecialchars(trim($data)));
}

// Function to hash passwords
function hashPassword($password)
{
    return password_hash($password, PASSWORD_DEFAULT);
}

// Function to verify passwords
function verifyPassword($password, $hash)
{
    return password_verify($password, $hash);
}

// Function to check if user exists
function userExists($username)
{
    global $conn;
    $username = sanitize($username);
    $query = "SELECT id FROM users WHERE username = '$username'";
    $result = $conn->query($query);
    return $result->num_rows > 0;
}

// Function to get user data
function getUserData($user_id)
{
    global $conn;
    $user_id = (int)$user_id;
    $query = "SELECT * FROM users WHERE id = $user_id";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        return $result->fetch_assoc();
    }

    return null;
}

// Function to get leagues for a user
function getUserLeagues($user_id)
{
    global $conn;
    $user_id = (int)$user_id;
    $query = "SELECT l.* FROM leagues l 
              JOIN league_users lu ON l.id = lu.league_id 
              WHERE lu.user_id = $user_id";
    $result = $conn->query($query);

    $leagues = [];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $leagues[] = $row;
        }
    }

    return $leagues;
}

// Function to get league members
function getLeagueMembers($league_id)
{
    global $conn;
    $league_id = (int)$league_id;
    $query = "SELECT u.* FROM users u 
              JOIN league_users lu ON u.id = lu.user_id 
              WHERE lu.league_id = $league_id";
    $result = $conn->query($query);

    $members = [];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $members[] = $row;
        }
    }

    return $members;
}

// Function to get matches for a league
function getLeagueMatches($league_id)
{
    global $conn;
    $league_id = (int)$league_id;
    $query = "SELECT * FROM matches WHERE league_id = $league_id ORDER BY match_date DESC";
    $result = $conn->query($query);

    $matches = [];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $matches[] = $row;
        }
    }

    return $matches;
}

// Function to get match players
function getMatchPlayers($match_id)
{
    global $conn;
    $match_id = (int)$match_id;
    $query = "SELECT mp.*, u.name, u.username, u.avatar 
              FROM match_players mp 
              JOIN users u ON mp.user_id = u.id 
              WHERE mp.match_id = $match_id";
    $result = $conn->query($query);

    $players = [];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $players[] = $row;
        }
    }

    return $players;
}

// Function to get match results
function getMatchResults($match_id)
{
    global $conn;
    $match_id = (int)$match_id;
    $query = "SELECT * FROM match_results WHERE match_id = $match_id ORDER BY set_number";
    $result = $conn->query($query);

    $results = [];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $results[] = $row;
        }
    }

    return $results;
}

// Function to get player statistics
function getPlayerStats($user_id, $league_id = null)
{
    global $conn;
    $user_id = (int)$user_id;

    $league_condition = "";
    if ($league_id) {
        $league_id = (int)$league_id;
        $league_condition = "AND m.league_id = $league_id";
    }

    $query = "SELECT 
                COUNT(CASE WHEN mp.is_winner = 1 THEN 1 END) as wins,
                COUNT(CASE WHEN mp.is_winner = 0 THEN 1 END) as losses,
                COUNT(*) as total_matches
              FROM match_players mp
              JOIN matches m ON mp.match_id = m.id
              WHERE mp.user_id = $user_id $league_condition";

    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        return $result->fetch_assoc();
    }

    return ['wins' => 0, 'losses' => 0, 'total_matches' => 0];
}

// Function to get pair statistics
function getPairStats($user_id1, $user_id2, $league_id = null)
{
    global $conn;
    $user_id1 = (int)$user_id1;
    $user_id2 = (int)$user_id2;

    $league_condition = "";
    if ($league_id) {
        $league_id = (int)$league_id;
        $league_condition = "AND m.league_id = $league_id";
    }

    $query = "SELECT 
                COUNT(CASE WHEN mp1.is_winner = 1 THEN 1 END) as wins,
                COUNT(CASE WHEN mp1.is_winner = 0 THEN 1 END) as losses,
                COUNT(*) as total_matches
              FROM match_players mp1
              JOIN match_players mp2 ON mp1.match_id = mp2.match_id AND mp1.team = mp2.team
              JOIN matches m ON mp1.match_id = m.id
              WHERE mp1.user_id = $user_id1 AND mp2.user_id = $user_id2 $league_condition";

    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        return $result->fetch_assoc();
    }

    return ['wins' => 0, 'losses' => 0, 'total_matches' => 0];
}
