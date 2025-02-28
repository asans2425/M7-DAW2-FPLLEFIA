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

    // Individual rankings
    $query = "SELECT 
                u.id,
                u.name,
                u.username,
                u.avatar,
                COUNT(DISTINCT m.id) as total_matches,
                COUNT(CASE WHEN mp.is_winner = 1 THEN 1 END) as wins,
                COUNT(CASE WHEN mp.is_winner = 0 THEN 1 END) as losses
              FROM users u
              JOIN match_players mp ON u.id = mp.user_id
              JOIN matches m ON mp.match_id = m.id
              WHERE 1=1 $league_condition
              GROUP BY u.id
              ORDER BY wins DESC, total_matches DESC";

    $result = $conn->query($query);
    $individual_rankings = [];

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $individual_rankings[] = $row;
        }
    }

    // Pair rankings
    $query = "SELECT 
                u1.id as player1_id,
                u1.name as player1_name,
                u2.id as player2_id,
                u2.name as player2_name,
                COUNT(DISTINCT m.id) as total_matches,
                COUNT(CASE WHEN mp1.is_winner = 1 THEN 1 END) as wins,
                COUNT(CASE WHEN mp1.is_winner = 0 THEN 1 END) as losses
              FROM match_players mp1
              JOIN match_players mp2 ON mp1.match_id = mp2.match_id 
                AND mp1.team = mp2.team
                AND mp1.user_id < mp2.user_id
              JOIN matches m ON mp1.match_id = m.id
              JOIN users u1 ON mp1.user_id = u1.id
              JOIN users u2 ON mp2.user_id = u2.id
              WHERE 1=1 $league_condition
              GROUP BY u1.id, u2.id
              HAVING total_matches >= 2
              ORDER BY wins DESC, total_matches DESC
              LIMIT 10";

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

<div class="max-w-4xl mx-auto">
    <div class="mb-6 flex items-center justify-between">
        <h1 class="text-2xl font-bold text-gray-800">Rankings</h1>

        <?php if (count($user_leagues) > 0): ?>
            <div class="relative">
                <select onchange="window.location.href='index.php?page=rankings&league_id=' + this.value" class="appearance-none px-4 py-2 pr-8 border border-gray-300 rounded-md bg-white focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                    <option value="">Todas las ligas</option>
                    <?php foreach ($user_leagues as $league): ?>
                        <option value="<?php echo $league['id']; ?>" <?php echo $league_id == $league['id'] ? 'selected' : ''; ?>>
                            <?php echo $league['name']; ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                        <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z" />
                    </svg>
                </div>
            </div>
        <?php endif; ?>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Individual Rankings -->
        <div class="bg-white rounded-lg shadow overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-lg font-semibold text-gray-800">Ranking Individual</h2>
            </div>

            <div class="divide-y divide-gray-200">
                <?php foreach ($rankings['individual'] as $index => $player): ?>
                    <div class="px-6 py-4">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 w-10 text-center">
                                <span class="text-lg font-bold <?php echo $index < 3 ? 'text-primary-600' : 'text-gray-600'; ?>">
                                    #<?php echo $index + 1; ?>
                                </span>
                            </div>

                            <div class="flex-shrink-0 h-10 w-10 rounded-full overflow-hidden bg-gray-200 ml-4">
                                <?php if (!empty($player['avatar'])): ?>
                                    <img src="uploads/avatars/<?php echo $player['avatar']; ?>" alt="Avatar" class="h-full w-full object-cover">
                                <?php else: ?>
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-full w-full text-gray-400 p-2" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                        <circle cx="12" cy="7" r="4"></circle>
                                    </svg>
                                <?php endif; ?>
                            </div>

                            <div class="ml-4 flex-1">
                                <div class="text-sm font-medium text-gray-900"><?php echo $player['name']; ?></div>
                                <div class="text-sm text-gray-500">@<?php echo $player['username']; ?></div>
                            </div>

                            <div class="ml-4 flex items-center space-x-4 text-sm">
                                <div class="text-center">
                                    <div class="font-medium text-gray-900"><?php echo $player['total_matches']; ?></div>
                                    <div class="text-gray-500">Partidos</div>
                                </div>
                                <div class="text-center">
                                    <div class="font-medium text-green-600"><?php echo $player['wins']; ?></div>
                                    <div class="text-gray-500">Victorias</div>
                                </div>
                                <div class="text-center">
                                    <div class="font-medium text-red-600"><?php echo $player['losses']; ?></div>
                                    <div class="text-gray-500">Derrotas</div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>

                <?php if (empty($rankings['individual'])): ?>
                    <div class="px-6 py-8 text-center">
                        <p class="text-gray-500">No hay datos disponibles</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Pair Rankings -->
        <div class="bg-white rounded-lg shadow overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-lg font-semibold text-gray-800">Mejores Parejas</h2>
            </div>

            <div class="divide-y divide-gray-200">
                <?php foreach ($rankings['pairs'] as $index => $pair): ?>
                    <div class="px-6 py-4">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 w-10 text-center">
                                <span class="text-lg font-bold <?php echo $index < 3 ? 'text-primary-600' : 'text-gray-600'; ?>">
                                    #<?php echo $index + 1; ?>
                                </span>
                            </div>

                            <div class="ml-4 flex-1">
                                <div class="text-sm font-medium text-gray-900">
                                    <?php echo $pair['player1_name']; ?> / <?php echo $pair['player2_name']; ?>
                                </div>
                            </div>

                            <div class="ml-4 flex items-center space-x-4 text-sm">
                                <div class="text-center">
                                    <div class="font-medium text-gray-900"><?php echo $pair['total_matches']; ?></div>
                                    <div class="text-gray-500">Partidos</div>
                                </div>
                                <div class="text-center">
                                    <div class="font-medium text-green-600"><?php echo $pair['wins']; ?></div>
                                    <div class="text-gray-500">Victorias</div>
                                </div>
                                <div class="text-center">
                                    <div class="font-medium text-red-600"><?php echo $pair['losses']; ?></div>
                                    <div class="text-gray-500">Derrotas</div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>

                <?php if (empty($rankings['pairs'])): ?>
                    <div class="px-6 py-8 text-center">
                        <p class="text-gray-500">No hay datos disponibles</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>