<?php
if (!isset($_GET['id'])) {
    header('Location: index.php?page=matches');
    exit;
}

$match_id = (int)$_GET['id'];

// Get match data
$query = "SELECT m.*, l.name as league_name 
          FROM matches m 
          JOIN leagues l ON m.league_id = l.id 
          WHERE m.id = $match_id";
$result = $conn->query($query);

if ($result->num_rows === 0) {
    header('Location: index.php?page=matches');
    exit;
}

$match = $result->fetch_assoc();
$match_players = getMatchPlayers($match_id);
$match_results = getMatchResults($match_id);

$team1 = array_filter($match_players, function ($player) {
    return $player['team'] == 1;
});
$team2 = array_filter($match_players, function ($player) {
    return $player['team'] == 2;
});

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $match_date = sanitize($_POST['match_date']);
    $location = sanitize($_POST['location']);

    // Get set scores
    $set1_team1 = (int)$_POST['set1_team1'];
    $set1_team2 = (int)$_POST['set1_team2'];
    $set2_team1 = (int)$_POST['set2_team1'];
    $set2_team2 = (int)$_POST['set2_team2'];
    $set3_team1 = isset($_POST['set3_team1']) ? (int)$_POST['set3_team1'] : 0;
    $set3_team2 = isset($_POST['set3_team2']) ? (int)$_POST['set3_team2'] : 0;

    // Determine winner
    $team1_sets = 0;
    $team2_sets = 0;

    if ($set1_team1 > $set1_team2) $team1_sets++;
    else $team2_sets++;

    if ($set2_team1 > $set2_team2) $team1_sets++;
    else $team2_sets++;

    if ($set3_team1 > 0 || $set3_team2 > 0) {
        if ($set3_team1 > $set3_team2) $team1_sets++;
        else $team2_sets++;
    }

    $team1_winner = $team1_sets > $team2_sets;

    // Update match
    $query = "UPDATE matches SET match_date = '$match_date', location = '$location' WHERE id = $match_id";

    if ($conn->query($query)) {
        // Update players (winner status)
        foreach ($match_players as $player) {
            $is_winner = ($player['team'] == 1 && $team1_winner) || ($player['team'] == 2 && !$team1_winner) ? 1 : 0;
            $query = "UPDATE match_players SET is_winner = $is_winner 
                     WHERE match_id = $match_id AND user_id = {$player['id']}";
            $conn->query($query);
        }

        // Update results
        $conn->query("DELETE FROM match_results WHERE match_id = $match_id");

        $results = [
            ['set_number' => 1, 'team1_score' => $set1_team1, 'team2_score' => $set1_team2],
            ['set_number' => 2, 'team1_score' => $set2_team1, 'team2_score' => $set2_team2]
        ];

        if ($set3_team1 > 0 || $set3_team2 > 0) {
            $results[] = ['set_number' => 3, 'team1_score' => $set3_team1, 'team2_score' => $set3_team2];
        }

        foreach ($results as $result) {
            $query = "INSERT INTO match_results (match_id, set_number, team1_score, team2_score) 
                     VALUES ($match_id, {$result['set_number']}, {$result['team1_score']}, {$result['team2_score']})";
            $conn->query($query);
        }

        $success_message = "Partido actualizado correctamente.";

        // Refresh match data
        $match_results = getMatchResults($match_id);
    } else {
        $error_message = "Error al actualizar el partido: " . $conn->error;
    }
}
?>

<div class="max-w-4xl mx-auto">
    <?php if (!empty($error_message)): ?>
        <div class="bg-red-50 text-red-600 p-4 rounded-md mb-6">
            <?php echo $error_message; ?>
        </div>
    <?php endif; ?>

    <?php if (!empty($success_message)): ?>
        <div class="bg-green-50 text-green-600 p-4 rounded-md mb-6">
            <?php echo $success_message; ?>
        </div>
    <?php endif; ?>

    <div class="bg-white rounded-lg shadow p-6 mb-8">
        <div class="mb-6 flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Editar Partido</h1>
                <p class="text-gray-600">Liga: <?php echo $match['league_name']; ?></p>
            </div>
            <a href="index.php?page=matches&id=<?php echo $match_id; ?>" class="text-gray-500 hover:text-gray-700">
                Volver a detalles
            </a>
        </div>

        <form method="POST" action="">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <label for="match_date" class="block text-sm font-medium text-gray-700 mb-2">Fecha del Partido</label>
                    <input type="date" id="match_date" name="match_date" value="<?php echo $match['match_date']; ?>" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500" required>
                </div>

                <div>
                    <label for="location" class="block text-sm font-medium text-gray-700 mb-2">Ubicación</label>
                    <input type="text" id="location" name="location" value="<?php echo $match['location']; ?>" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                </div>
            </div>

            <div class="mb-6">
                <h3 class="text-lg font-medium text-gray-800 mb-4">Jugadores</h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="bg-gray-50 p-4 rounded-md">
                        <h4 class="text-md font-medium text-gray-800 mb-3">Equipo 1</h4>
                        <?php foreach ($team1 as $player): ?>
                            <div class="flex items-center mb-2 last:mb-0">
                                <div class="w-8 h-8 rounded-full overflow-hidden bg-gray-200 mr-2">
                                    <?php if (!empty($player['avatar'])): ?>
                                        <img src="uploads/avatars/<?php echo $player['avatar']; ?>" alt="Avatar" class="w-full h-full object-cover">
                                    <?php else: ?>
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-full w-full text-gray-400 p-1" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                            <circle cx="12" cy="7" r="4"></circle>
                                        </svg>
                                    <?php endif; ?>
                                </div>
                                <span class="text-sm font-medium text-gray-900"><?php echo $player['name']; ?></span>
                            </div>
                        <?php endforeach; ?>
                    </div>

                    <div class="bg-gray-50 p-4 rounded-md">
                        <h4 class="text-md font-medium text-gray-800 mb-3">Equipo 2</h4>
                        <?php foreach ($team2 as $player): ?>
                            <div class="flex items-center mb-2 last:mb-0">
                                <div class="w-8 h-8 rounded-full overflow-hidden bg-gray-200 mr-2">
                                    <?php if (!empty($player['avatar'])): ?>
                                        <img src="uploads/avatars/<?php echo $player['avatar']; ?>" alt="Avatar" class="w-full h-full object-cover">
                                    <?php else: ?>
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-full w-full text-gray-400 p-1" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                            <circle cx="12" cy="7" r="4"></circle>
                                        </svg>
                                    <?php endif; ?>
                                </div>
                                <span class="text-sm font-medium text-gray-900"><?php echo $player['name']; ?></span>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>

            <div class="mb-6">
                <h3 class="text-lg font-medium text-gray-800 mb-4">Resultado</h3>

                <div class="space-y-4">
                    <div class="grid grid-cols-5 gap-4 items-center">
                        <div class="col-span-2 text-right font-medium">Equipo 1</div>
                        <div class="text-center">-</div>
                        <div class="col-span-2 font-medium">Equipo 2</div>
                    </div>

                    <?php foreach ($match_results as $index => $result): ?>
                        <div class="grid grid-cols-5 gap-4 items-center">
                            <div class="col-span-2">
                                <input type="number"
                                    id="set<?php echo $result['set_number']; ?>_team1"
                                    name="set<?php echo $result['set_number']; ?>_team1"
                                    value="<?php echo $result['team1_score']; ?>"
                                    min="0"
                                    max="7"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500"
                                    required>
                            </div>
                            <div class="text-center font-medium">Set <?php echo $result['set_number']; ?></div>
                            <div class="col-span-2">
                                <input type="number"
                                    id="set<?php echo $result['set_number']; ?>_team2"
                                    name="set<?php echo $result['set_number']; ?>_team2"
                                    value="<?php echo $result['team2_score']; ?>"
                                    min="0"
                                    max="7"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500"
                                    required>
                            </div>
                        </div>
                    <?php endforeach; ?>

                    <?php if (count($match_results) < 3): ?>
                        <div class="grid grid-cols-5 gap-4 items-center">
                            <div class="col-span-2">
                                <input type="number" id="set3_team1" name="set3_team1" min="0" max="7" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                            </div>
                            <div class="text-center font-medium">Set 3</div>
                            <div class="col-span-2">
                                <input type="number" id="set3_team2" name="set3_team2" min="0" max="7" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <div class="flex justify-end space-x-4">
                <a href="index.php?page=matches&id=<?php echo $match_id; ?>" class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50">
                    Cancelar
                </a>
                <button type="submit" class="px-4 py-2 bg-primary-600 text-white rounded-md hover:bg-primary-700">
                    Guardar Cambios
                </button>
            </div>
        </form>
    </div>
</div>