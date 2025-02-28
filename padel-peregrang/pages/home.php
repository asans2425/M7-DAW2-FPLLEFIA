<?php
// Get user data
$user = getUserData($_SESSION['user_id']);

// Get user leagues
$leagues = getUserLeagues($_SESSION['user_id']);

// Get recent matches
$query = "SELECT m.*, l.name as league_name 
          FROM matches m 
          JOIN leagues l ON m.league_id = l.id
          JOIN league_users lu ON l.id = lu.league_id
          WHERE lu.user_id = {$_SESSION['user_id']}
          ORDER BY m.match_date DESC LIMIT 5";
$result = $conn->query($query);
$recent_matches = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $recent_matches[] = $row;
    }
}

// Get user stats
$stats = getPlayerStats($_SESSION['user_id']);
?>

<div class="max-w-4xl mx-auto">
    <div class="flex items-center mb-8">
        <div class="w-16 h-16 rounded-full overflow-hidden bg-gray-200 mr-4">
            <?php if (!empty($user['avatar'])): ?>
                <img src="uploads/avatars/<?php echo $user['avatar']; ?>" alt="Avatar" class="w-full h-full object-cover">
            <?php else: ?>
                <svg xmlns="http://www.w3.org/2000/svg" class="h-full w-full text-gray-400 p-2" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                    <circle cx="12" cy="7" r="4"></circle>
                </svg>
            <?php endif; ?>
        </div>
        <div>
            <h1 class="text-2xl font-bold text-gray-800">¡Hola, <?php echo $user['name']; ?>!</h1>
            <p class="text-gray-600">Bienvenido a Peregrang App</p>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-lg font-semibold text-gray-800">Mis Estadísticas</h2>
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-primary-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M12 20V10"></path>
                    <path d="M18 20V4"></path>
                    <path d="M6 20v-4"></path>
                </svg>
            </div>
            <div class="grid grid-cols-3 gap-4 text-center">
                <div>
                    <p class="text-2xl font-bold text-primary-600"><?php echo $stats['total_matches']; ?></p>
                    <p class="text-sm text-gray-600">Partidos</p>
                </div>
                <div>
                    <p class="text-2xl font-bold text-green-600"><?php echo $stats['wins']; ?></p>
                    <p class="text-sm text-gray-600">Victorias</p>
                </div>
                <div>
                    <p class="text-2xl font-bold text-red-600"><?php echo $stats['losses']; ?></p>
                    <p class="text-sm text-gray-600">Derrotas</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-lg font-semibold text-gray-800">Mis Ligas</h2>
                <a href="index.php?page=leagues" class="text-primary-600 hover:text-primary-700 text-sm">Ver todas</a>
            </div>
            <?php if (count($leagues) > 0): ?>
                <ul class="space-y-3">
                    <?php foreach ($leagues as $league): ?>
                        <li>
                            <a href="index.php?page=leagues&id=<?php echo $league['id']; ?>" class="flex items-center p-2 hover:bg-gray-50 rounded-md">
                                <div class="w-8 h-8 rounded-full bg-primary-100 text-primary-600 flex items-center justify-center mr-3">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M18 8h1a4 4 0 0 1 0 8h-1"></path>
                                        <path d="M2 8h16v9a4 4 0 0 1-4 4H6a4 4 0 0 1-4-4V8z"></path>
                                        <line x1="6" y1="1" x2="6" y2="4"></line>
                                        <line x1="10" y1="1" x2="10" y2="4"></line>
                                        <line x1="14" y1="1" x2="14" y2="4"></line>
                                    </svg>
                                </div>
                                <span class="text-gray-700"><?php echo $league['name']; ?></span>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php else: ?>
                <div class="text-center py-4">
                    <p class="text-gray-500">No estás en ninguna liga</p>
                    <a href="index.php?page=leagues" class="mt-2 inline-block text-sm text-primary-600 hover:text-primary-700">Unirse a una liga</a>
                </div>
            <?php endif; ?>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-lg font-semibold text-gray-800">Acciones Rápidas</h2>
            </div>
            <div class="space-y-3">
                <a href="index.php?page=matches&action=new" class="block w-full py-2 px-4 bg-primary-600 text-white text-center rounded-md hover:bg-primary-700">
                    Nuevo Partido
                </a>
                <a href="index.php?page=leagues&action=join" class="block w-full py-2 px-4 bg-white border border-gray-300 text-gray-700 text-center rounded-md hover:bg-gray-50">
                    Unirse a Liga
                </a>
                <a href="index.php?page=leagues&action=new" class="block w-full py-2 px-4 bg-white border border-gray-300 text-gray-700 text-center rounded-md hover:bg-gray-50">
                    Crear Liga
                </a>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow p-6 mb-8">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-lg font-semibold text-gray-800">Partidos Recientes</h2>
            <a href="index.php?page=matches" class="text-primary-600 hover:text-primary-700 text-sm">Ver todos</a>
        </div>

        <?php if (count($recent_matches) > 0): ?>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Fecha</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Liga</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Resultado</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <?php foreach ($recent_matches as $match): ?>
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
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    <?php echo date('d/m/Y', strtotime($match['match_date'])); ?>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    <?php echo $match['league_name']; ?>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="text-sm font-medium text-gray-900">
                                            <?php
                                            $team1_names = array_map(function ($player) {
                                                return $player['name'];
                                            }, $team1);
                                            echo implode(' / ', $team1_names);
                                            ?>
                                        </div>
                                        <div class="mx-2 text-sm font-bold">
                                            <?php echo $team1_sets; ?> - <?php echo $team2_sets; ?>
                                        </div>
                                        <div class="text-sm font-medium text-gray-900">
                                            <?php
                                            $team2_names = array_map(function ($player) {
                                                return $player['name'];
                                            }, $team2);
                                            echo implode(' / ', $team2_names);
                                            ?>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    <a href="index.php?page=matches&id=<?php echo $match['id']; ?>" class="text-primary-600 hover:text-primary-700">Ver detalles</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <div class="text-center py-8">
                <p class="text-gray-500">No hay partidos recientes</p>
                <a href="index.php?page=matches&action=new" class="mt-2 inline-block text-sm text-primary-600 hover:text-primary-700">Crear un partido</a>
            </div>
        <?php endif; ?>
    </div>
</div>