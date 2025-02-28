<?php
// Check if we're viewing a specific match
$match_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$action = isset($_GET['action']) ? $_GET['action'] : '';
$league_id = isset($_GET['league_id']) ? (int)$_GET['league_id'] : 0;

// Handle match actions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        // Create match
        if ($_POST['action'] === 'create') {
            $league_id = (int)$_POST['league_id'];
            $match_date = sanitize($_POST['match_date']);
            $location = sanitize($_POST['location']);

            // Get team players
            $team1_player1 = (int)$_POST['team1_player1'];
            $team1_player2 = (int)$_POST['team1_player2'];
            $team2_player1 = (int)$_POST['team2_player1'];
            $team2_player2 = (int)$_POST['team2_player2'];

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

            // Insert match
            $query = "INSERT INTO matches (league_id, match_date, location, created_by, created_at) 
                      VALUES ($league_id, '$match_date', '$location', {$_SESSION['user_id']}, NOW())";

            if ($conn->query($query)) {
                $match_id = $conn->insert_id;

                // Insert players
                $players = [
                    ['user_id' => $team1_player1, 'team' => 1, 'is_winner' => $team1_winner ? 1 : 0],
                    ['user_id' => $team1_player2, 'team' => 1, 'is_winner' => $team1_winner ? 1 : 0],
                    ['user_id' => $team2_player1, 'team' => 2, 'is_winner' => $team1_winner ? 0 : 1],
                    ['user_id' => $team2_player2, 'team' => 2, 'is_winner' => $team1_winner ? 0 : 1]
                ];

                foreach ($players as $player) {
                    $player_query = "INSERT INTO match_players (match_id, user_id, team, is_winner) 
                                     VALUES ($match_id, {$player['user_id']}, {$player['team']}, {$player['is_winner']})";
                    $conn->query($player_query);
                }

                // Insert results
                $results = [
                    ['set_number' => 1, 'team1_score' => $set1_team1, 'team2_score' => $set1_team2],
                    ['set_number' => 2, 'team1_score' => $set2_team1, 'team2_score' => $set2_team2]
                ];

                if ($set3_team1 > 0 || $set3_team2 > 0) {
                    $results[] = ['set_number' => 3, 'team1_score' => $set3_team1, 'team2_score' => $set3_team2];
                }

                foreach ($results as $result) {
                    $result_query = "INSERT INTO match_results (match_id, set_number, team1_score, team2_score) 
                                     VALUES ($match_id, {$result['set_number']}, {$result['team1_score']}, {$result['team2_score']})";
                    $conn->query($result_query);
                }

                $success_message = "Partido creado correctamente.";
            } else {
                $error_message = "Error al crear el partido: " . $conn->error;
            }
        }
    }
}

// If viewing a specific match
if ($match_id > 0) {
    $query = "SELECT m.*, l.name as league_name 
              FROM matches m 
              JOIN leagues l ON m.league_id = l.id 
              WHERE m.id = $match_id";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        $match = $result->fetch_assoc();

        // Get match players
        $match_players = getMatchPlayers($match_id);
        $team1 = array_filter($match_players, function ($player) {
            return $player['team'] == 1;
        });
        $team2 = array_filter($match_players, function ($player) {
            return $player['team'] == 2;
        });

        // Get match results
        $match_results = getMatchResults($match_id);
    } else {
        header('Location: index.php?page=matches');
        exit;
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

    <?php if ($action === 'new'): ?>
        <!-- Create Match Form -->
        <div class="bg-white rounded-lg shadow p-6 mb-8">
            <h2 class="text-xl font-bold text-gray-800 mb-6">Nuevo Partido</h2>

            <form method="POST" action="">
                <input type="hidden" name="action" value="create">

                <div class="mb-6">
                    <label for="league_id" class="block text-sm font-medium text-gray-700 mb-2">Liga</label>
                    <select id="league_id" name="league_id" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500" required>
                        <option value="">Selecciona una liga</option>
                        <?php
                        $leagues = getUserLeagues($_SESSION['user_id']);
                        foreach ($leagues as $league) {
                            $selected = $league_id == $league['id'] ? 'selected' : '';
                            echo "<option value='{$league['id']}' $selected>{$league['name']}</option>";
                        }
                        ?>
                    </select>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <label for="match_date" class="block text-sm font-medium text-gray-700 mb-2">Fecha del Partido</label>
                        <input type="date" id="match_date" name="match_date" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500" required>
                    </div>

                    <div>
                        <label for="location" class="block text-sm font-medium text-gray-700 mb-2">Ubicación</label>
                        <input type="text" id="location" name="location" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                    </div>
                </div>

                <div class="mb-6">
                    <h3 class="text-lg font-medium text-gray-800 mb-4">Jugadores</h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="bg-gray-50 p-4 rounded-md">
                            <h4 class="text-md font-medium text-gray-800 mb-3">Equipo 1</h4>

                            <div class="mb-4">
                                <label for="team1_player1" class="block text-sm font-medium text-gray-700 mb-2">Jugador 1</label>
                                <select id="team1_player1" name="team1_player1" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500" required>
                                    <option value="">Selecciona un jugador</option>
                                </select>
                            </div>

                            <div>
                                <label for="team1_player2" class="block text-sm font-medium text-gray-700 mb-2">Jugador 2</label>
                                <select id="team1_player2" name="team1_player2" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500" required>
                                    <option value="">Selecciona un jugador</option>
                                </select>
                            </div>
                        </div>

                        <div class="bg-gray-50 p-4 rounded-md">
                            <h4 class="text-md font-medium text-gray-800 mb-3">Equipo 2</h4>

                            <div class="mb-4">
                                <label for="team2_player1" class="block text-sm font-medium text-gray-700 mb-2">Jugador 1</label>
                                <select id="team2_player1" name="team2_player1" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500" required>
                                    <option value="">Selecciona un jugador</option>
                                </select>
                            </div>

                            <div>
                                <label for="team2_player2" class="block text-sm font-medium text-gray-700 mb-2">Jugador 2</label>
                                <select id="team2_player2" name="team2_player2" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500" required>
                                    <option value="">Selecciona un jugador</option>
                                </select>
                            </div>
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

                        <div class="grid grid-cols-5 gap-4 items-center">
                            <div class="col-span-2">
                                <input type="number" id="set1_team1" name="set1_team1" min="0" max="7" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500" required>
                            </div>
                            <div class="text-center font-medium">Set 1</div>
                            <div class="col-span-2">
                                <input type="number" id="set1_team2" name="set1_team2" min="0" max="7" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500" required>
                            </div>
                        </div>

                        <div class="grid grid-cols-5 gap-4 items-center">
                            <div class="col-span-2">
                                <input type="number" id="set2_team1" name="set2_team1" min="0" max="7" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500" required>
                            </div>
                            <div class="text-center font-medium">Set 2</div>
                            <div class="col-span-2">
                                <input type="number" id="set2_team2" name="set2_team2" min="0" max="7" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500" required>
                            </div>
                        </div>

                        <div class="grid grid-cols-5 gap-4 items-center">
                            <div class="col-span-2">
                                <input type="number" id="set3_team1" name="set3_team1" min="0" max="7" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                            </div>
                            <div class="text-center font-medium">Set 3</div>
                            <div class="col-span-2">
                                <input type="number" id="set3_team2" name="set3_team2" min="0" max="7" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex justify-end">
                    <a href="index.php?page=matches" class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 mr-2 hover:bg-gray-50">Cancelar</a>
                    <button type="submit" class="px-4 py-2 bg-primary-600 text-white rounded-md hover:bg-primary-700">Guardar Partido</button>
                </div>
            </form>
        </div>

        <script>
            // Load league members when league is selected
            document.getElementById('league_id').addEventListener('change', function() {
                const leagueId = this.value;
                if (leagueId) {
                    fetch(`api/get_league_members.php?league_id=${leagueId}`)
                        .then(response => response.json())
                        .then(data => {
                            const playerSelects = [
                                document.getElementById('team1_player1'),
                                document.getElementById('team1_player2'),
                                document.getElementById('team2_player1'),
                                document.getElementById('team2_player2')
                            ];

                            // Clear options
                            playerSelects.forEach(select => {
                                select.innerHTML = '<option value="">Selecciona un jugador</option>';
                            });

                            // Add options
                            data.forEach(player => {
                                playerSelects.forEach(select => {
                                    const option = document.createElement('option');
                                    option.value = player.id;
                                    option.textContent = player.name;
                                    select.appendChild(option);
                                });
                            });
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            alert('Error al cargar los jugadores de la liga');
                        });
                }
            });

            // Trigger change event if league is preselected
            window.addEventListener('load', function() {
                const leagueSelect = document.getElementById('league_id');
                if (leagueSelect && leagueSelect.value) {
                    leagueSelect.dispatchEvent(new Event('change'));
                }
            });
        </script>
    <?php elseif ($match_id > 0): ?>
        <!-- Match Details -->
        <div class="mb-6 flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Detalles del Partido</h1>
                <p class="text-gray-600">Liga: <?php echo $match['league_name']; ?></p>
            </div>
            <div class="text-sm text-gray-500">
                <?php echo date('d/m/Y', strtotime($match['match_date'])); ?>
                <?php if (!empty($match['location'])): ?>
                    - <?php echo $match['location']; ?>
                <?php endif; ?>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow overflow-hidden mb-8">
            <div class="p-6">
                <div class="grid grid-cols-7 gap-4 items-center">
                    <div class="col-span-3">
                        <div class="flex flex-col items-center">
                            <div class="flex space-x-2 mb-4">
                                <?php foreach ($team1 as $player): ?>
                                    <div class="flex flex-col items-center">
                                        <div class="w-16 h-16 rounded-full overflow-hidden bg-gray-200 mb-2">
                                            <?php if (!empty($player['avatar'])): ?>
                                                <img src="uploads/avatars/<?php echo $player['avatar']; ?>" alt="Avatar" class="w-full h-full object-cover">
                                            <?php else: ?>
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-full w-full text-gray-400 p-2" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                                    <circle cx="12" cy="7" r="4"></circle>
                                                </svg>
                                            <?php endif; ?>
                                        </div>
                                        <div class="text-sm font-medium text-center"><?php echo $player['name']; ?></div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                            <div class="text-lg font-bold">Equipo 1</div>
                            <?php if ($team1[array_key_first($team1)]['is_winner']): ?>
                                <div class="mt-2 px-3 py-1 bg-green-100 text-green-800 rounded-full text-sm font-medium">Ganador</div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="col-span-1 flex flex-col items-center">
                        <div class="text-2xl font-bold mb-2">VS</div>
                        <div class="bg-gray-200 h-16 w-px"></div>
                    </div>

                    <div class="col-span-3">
                        <div class="flex flex-col items-center">
                            <div class="flex space-x-2 mb-4">
                                <?php foreach ($team2 as $player): ?>
                                    <div class="flex flex-col items-center">
                                        <div class="w-16 h-16 rounded-full overflow-hidden bg-gray-200 mb-2">
                                            <?php if (!empty($player['avatar'])): ?>
                                                <img src="uploads/avatars/<?php echo $player['avatar']; ?>" alt="Avatar" class="w-full h-full object-cover">
                                            <?php else: ?>
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-full w-full text-gray-400 p-2" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                                    <circle cx="12" cy="7" r="4"></circle>
                                                </svg>
                                            <?php endif; ?>
                                        </div>
                                        <div class="text-sm font-medium text-center"><?php echo $player['name']; ?></div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                            <div class="text-lg font-bold">Equipo 2</div>
                            <?php if ($team2[array_key_first($team2)]['is_winner']): ?>
                                <div class="mt-2 px-3 py-1 bg-green-100 text-green-800 rounded-full text-sm font-medium">Ganador</div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-gray-50 p-6">
                <h3 class="text-lg font-medium text-gray-800 mb-4">Resultado</h3>

                <div class="space-y-4">
                    <?php foreach ($match_results as $result): ?>
                        <div class="grid grid-cols-7 gap-4 items-center">
                            <div class="col-span-3 text-right">
                                <div class="inline-block px-4 py-2 bg-white rounded-lg shadow-sm text-xl font-bold">
                                    <?php echo $result['team1_score']; ?>
                                </div>
                            </div>
                            <div class="col-span-1 text-center text-sm font-medium text-gray-500">
                                Set <?php echo $result['set_number']; ?>
                            </div>
                            <div class="col-span-3">
                                <div class="inline-block px-4 py-2 bg-white rounded-lg shadow-sm text-xl font-bold">
                                    <?php echo $result['team2_score']; ?>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>

        <div class="flex justify-between">
            <a href="index.php?page=matches" class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50">Volver a Partidos</a>
            <!-- Continuing from the previous code -->
        </div>
    <?php else: ?>
        <!-- Matches List -->
        <div class="mb-6 flex items-center justify-between">
            <h1 class="text-2xl font-bold text-gray-800">Partidos</h1>
            <a href="index.php?page=matches&action=new" class="px-4 py-2 bg-primary-600 text-white rounded-md hover:bg-primary-700">Nuevo Partido</a>
        </div>

        <?php
        // Get user's leagues
        $leagues = getUserLeagues($_SESSION['user_id']);

        // Get matches from user's leagues
        $league_ids = array_map(function ($league) {
            return $league['id'];
        }, $leagues);

        $league_ids_str = implode(',', $league_ids);

        if (!empty($league_ids)) {
            $query = "SELECT m.*, l.name as league_name 
                      FROM matches m 
                      JOIN leagues l ON m.league_id = l.id 
                      WHERE m.league_id IN ($league_ids_str)
                      ORDER BY m.match_date DESC";
            $result = $conn->query($query);
            $matches = [];

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $matches[] = $row;
                }
            }
        }
        ?>

        <?php if (!empty($matches)): ?>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <?php foreach ($matches as $match): ?>
                    <?php
                    $match_players = getMatchPlayers($match['id']);
                    $team1 = array_filter($match_players, function ($player) {
                        return $player['team'] == 1;
                    });
                    $team2 = array_filter($match_players, function ($player) {
                        return $player['team'] == 2;
                    });

                    $match_results = getMatchResults($match['id']);
                    $team1_sets = 0;
                    $team2_sets = 0;

                    foreach ($match_results as $result) {
                        if ($result['team1_score'] > $result['team2_score']) {
                            $team1_sets++;
                        } else {
                            $team2_sets++;
                        }
                    }
                    ?>

                    <a href="index.php?page=matches&id=<?php echo $match['id']; ?>" class="block bg-white rounded-lg shadow hover:shadow-md transition-shadow">
                        <div class="p-6">
                            <div class="flex items-center justify-between mb-4">
                                <div class="text-sm font-medium text-primary-600"><?php echo $match['league_name']; ?></div>
                                <div class="text-sm text-gray-500"><?php echo date('d/m/Y', strtotime($match['match_date'])); ?></div>
                            </div>

                            <div class="grid grid-cols-7 gap-4 items-center">
                                <div class="col-span-3">
                                    <div class="space-y-1">
                                        <?php foreach ($team1 as $player): ?>
                                            <div class="flex items-center">
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

                                <div class="col-span-1 flex flex-col items-center">
                                    <div class="text-lg font-bold mb-1"><?php echo $team1_sets; ?> - <?php echo $team2_sets; ?></div>
                                    <div class="text-xs text-gray-500">Sets</div>
                                </div>

                                <div class="col-span-3">
                                    <div class="space-y-1">
                                        <?php foreach ($team2 as $player): ?>
                                            <div class="flex items-center justify-end">
                                                <span class="text-sm font-medium text-gray-900"><?php echo $player['name']; ?></span>
                                                <div class="w-8 h-8 rounded-full overflow-hidden bg-gray-200 ml-2">
                                                    <?php if (!empty($player['avatar'])): ?>
                                                        <img src="uploads/avatars/<?php echo $player['avatar']; ?>" alt="Avatar" class="w-full h-full object-cover">
                                                    <?php else: ?>
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-full w-full text-gray-400 p-1" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                                            <circle cx="12" cy="7" r="4"></circle>
                                                        </svg>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            </div>

                            <?php if (!empty($match['location'])): ?>
                                <div class="mt-4 text-sm text-gray-500">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 inline-block mr-1" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path>
                                        <circle cx="12" cy="10" r="3"></circle>
                                    </svg>
                                    <?php echo $match['location']; ?>
                                </div>
                            <?php endif; ?>

                            <div class="mt-4 pt-4 border-t border-gray-100">
                                <div class="grid grid-cols-3 gap-2 text-center text-xs">
                                    <?php foreach ($match_results as $result): ?>
                                        <div class="bg-gray-50 rounded-md py-1">
                                            <span class="font-medium"><?php echo $result['team1_score']; ?> - <?php echo $result['team2_score']; ?></span>
                                            <span class="text-gray-500 ml-1">Set <?php echo $result['set_number']; ?></span>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>
                    </a>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="bg-white rounded-lg shadow p-8 text-center">
                <?php if (empty($leagues)): ?>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto text-gray-400 mb-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="12" cy="12" r="10"></circle>
                        <path d="M12 8v4"></path>
                        <path d="M12 16h.01"></path>
                    </svg>
                    <h2 class="text-xl font-bold text-gray-800 mb-2">No estás en ninguna liga</h2>
                    <p class="text-gray-600 mb-6">Únete a una liga para poder registrar partidos.</p>
                    <a href="index.php?page=leagues" class="inline-flex items-center justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-primary-600 hover:bg-primary-700">
                        Ir a Ligas
                    </a>
                <?php else: ?>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto text-gray-400 mb-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                        <line x1="16" y1="2" x2="16" y2="6"></line>
                        <line x1="8" y1="2" x2="8" y2="6"></line>
                        <line x1="3" y1="10" x2="21" y2="10"></line>
                    </svg>
                    <h2 class="text-xl font-bold text-gray-800 mb-2">No hay partidos registrados</h2>
                    <p class="text-gray-600 mb-6">Comienza registrando tu primer partido.</p>
                    <a href="index.php?page=matches&action=new" class="inline-flex items-center justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-primary-600 hover:bg-primary-700">
                        Nuevo Partido
                    </a>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    <?php endif; ?>
</div>