<?php
// Check if we're viewing a specific league
$league_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$action = isset($_GET['action']) ? $_GET['action'] : '';

// Handle league actions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        // Join league
        if ($_POST['action'] === 'join') {
            $code = sanitize($_POST['code']);

            $query = "SELECT id FROM leagues WHERE code = '$code'";
            $result = $conn->query($query);

            if ($result->num_rows > 0) {
                $league = $result->fetch_assoc();
                $league_id = $league['id'];
                $user_id = $_SESSION['user_id'];

                // Check if user is already in the league
                $check_query = "SELECT * FROM league_users WHERE league_id = $league_id AND user_id = $user_id";
                $check_result = $conn->query($check_query);

                if ($check_result->num_rows === 0) {
                    $join_query = "INSERT INTO league_users (league_id, user_id, joined_at) VALUES ($league_id, $user_id, NOW())";
                    if ($conn->query($join_query)) {
                        $success_message = "Te has unido a la liga correctamente.";
                    } else {
                        $error_message = "Error al unirse a la liga: " . $conn->error;
                    }
                } else {
                    $error_message = "Ya eres miembro de esta liga.";
                }
            } else {
                $error_message = "Código de liga no válido.";
            }
        }

        // Create league
        if ($_POST['action'] === 'create') {
            $name = sanitize($_POST['name']);
            $description = sanitize($_POST['description']);
            $code = substr(md5(uniqid(rand(), true)), 0, 8); // Generate a unique code

            $query = "INSERT INTO leagues (name, description, code, created_by, created_at) 
                      VALUES ('$name', '$description', '$code', {$_SESSION['user_id']}, NOW())";

            if ($conn->query($query)) {
                $new_league_id = $conn->insert_id;

                // Add creator to the league
                $join_query = "INSERT INTO league_users (league_id, user_id, joined_at) 
                               VALUES ($new_league_id, {$_SESSION['user_id']}, NOW())";
                $conn->query($join_query);

                $success_message = "Liga creada correctamente. Código de invitación: $code";
                $league_id = $new_league_id;
            } else {
                $error_message = "Error al crear la liga: " . $conn->error;
            }
        }
    }
}

// If viewing a specific league
if ($league_id > 0) {
    $query = "SELECT l.*, u.name as creator_name 
              FROM leagues l 
              JOIN users u ON l.created_by = u.id 
              WHERE l.id = $league_id";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        $league = $result->fetch_assoc();

        // Get league members
        $members = getLeagueMembers($league_id);

        // Get league matches
        $matches = getLeagueMatches($league_id);

        // Check if user is a member
        $is_member = false;
        foreach ($members as $member) {
            if ($member['id'] == $_SESSION['user_id']) {
                $is_member = true;
                break;
            }
        }

        // If not a member, redirect to leagues page
        if (!$is_member) {
            header('Location: index.php?page=leagues');
            exit;
        }
    } else {
        header('Location: index.php?page=leagues');
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

    <?php if ($action === 'join'): ?>
        <!-- Join League Form -->
        <div class="bg-white rounded-lg shadow p-6 mb-8">
            <h2 class="text-xl font-bold text-gray-800 mb-6">Unirse a una Liga</h2>

            <form method="POST" action="">
                <input type="hidden" name="action" value="join">

                <div class="mb-6">
                    <label for="code" class="block text-sm font-medium text-gray-700 mb-2">Código de la Liga</label>
                    <input type="text" id="code" name="code" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500" required>
                    <p class="mt-2 text-sm text-gray-500">Introduce el código de invitación que te han proporcionado.</p>
                </div>

                <div class="flex justify-end">
                    <a href="index.php?page=leagues" class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 mr-2 hover:bg-gray-50">Cancelar</a>
                    <button type="submit" class="px-4 py-2 bg-primary-600 text-white rounded-md hover:bg-primary-700">Unirse</button>
                </div>
            </form>
        </div>
    <?php elseif ($action === 'new'): ?>
        <!-- Create League Form -->
        <div class="bg-white rounded-lg shadow p-6 mb-8">
            <h2 class="text-xl font-bold text-gray-800 mb-6">Crear Nueva Liga</h2>

            <form method="POST" action="">
                <input type="hidden" name="action" value="create">

                <div class="mb-6">
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Nombre de la Liga</label>
                    <input type="text" id="name" name="name" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500" required>
                </div>

                <div class="mb-6">
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-2">Descripción</label>
                    <textarea id="description" name="description" rows="3" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500"></textarea>
                </div>

                <div class="flex justify-end">
                    <a href="index.php?page=leagues" class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 mr-2 hover:bg-gray-50">Cancelar</a>
                    <button type="submit" class="px-4 py-2 bg-primary-600 text-white rounded-md hover:bg-primary-700">Crear Liga</button>
                </div>
            </form>
        </div>
    <?php elseif ($league_id > 0): ?>
        <!-- League Details -->
        <div class="mb-6 flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-800"><?php echo $league['name']; ?></h1>
                <p class="text-gray-600"><?php echo $league['description']; ?></p>
            </div>
            <div>
                <button onclick="copyCode()" class="flex items-center px-4 py-2 bg-primary-600 text-white rounded-md hover:bg-primary-700">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <rect x="9" y="9" width="13" height="13" rx="2" ry="2"></rect>
                        <path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"></path>
                    </svg>
                    Copiar Código
                </button>
                <input type="hidden" id="leagueCode" value="<?php echo $league['code']; ?>">
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="md:col-span-2">
                <div class="bg-white rounded-lg shadow p-6 mb-6">
                    <div class="flex items-center justify-between mb-6">
                        <h2 class="text-lg font-semibold text-gray-800">Partidos</h2>
                        <a href="index.php?page=matches&action=new&league_id=<?php echo $league_id; ?>" class="text-primary-600 hover:text-primary-700 text-sm">Nuevo Partido</a>
                    </div>

                    <?php if (count($matches) > 0): ?>
                        <div class="space-y-4">
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
                                <a href="index.php?page=matches&id=<?php echo $match['id']; ?>" class="block bg-gray-50 hover:bg-gray-100 rounded-lg p-4">
                                    <div class="flex justify-between items-center">
                                        <div class="text-sm text-gray-500"><?php echo date('d/m/Y', strtotime($match['match_date'])); ?></div>
                                        <div class="text-sm font-medium text-gray-700">
                                            <?php echo $team1_sets > $team2_sets ? 'Victoria Equipo 1' : 'Victoria Equipo 2'; ?>
                                        </div>
                                    </div>
                                    <div class="mt-2 flex items-center justify-between">
                                        <div class="flex-1">
                                            <div class="text-sm font-medium text-gray-900">
                                                <?php
                                                $team1_names = array_map(function ($player) {
                                                    return $player['name'];
                                                }, $team1);
                                                echo implode(' / ', $team1_names);
                                                ?>
                                            </div>
                                        </div>
                                        <div class="px-4 py-1 bg-white rounded-full shadow-sm text-sm font-bold">
                                            <?php echo $team1_sets; ?> - <?php echo $team2_sets; ?>
                                        </div>
                                        <div class="flex-1 text-right">
                                            <div class="text-sm font-medium text-gray-900">
                                                <?php
                                                $team2_names = array_map(function ($player) {
                                                    return $player['name'];
                                                }, $team2);
                                                echo implode(' / ', $team2_names);
                                                ?>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            <?php endforeach; ?>
                        </div>
                    <?php else: ?>
                        <div class="text-center py-8">
                            <p class="text-gray-500">No hay partidos en esta liga</p>
                            <a href="index.php?page=matches&action=new&league_id=<?php echo $league_id; ?>" class="mt-2 inline-block text-sm text-primary-600 hover:text-primary-700">Crear un partido</a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <div>
                <div class="bg-white rounded-lg shadow p-6">
                    <h2 class="text-lg font-semibold text-gray-800 mb-4">Miembros</h2>

                    <ul class="space-y-3">
                        <?php foreach ($members as $member): ?>
                            <li class="flex items-center p-2 hover:bg-gray-50 rounded-md">
                                <div class="w-8 h-8 rounded-full overflow-hidden bg-gray-200 mr-3">
                                    <?php if (!empty($member['avatar'])): ?>
                                        <img src="uploads/avatars/<?php echo $member['avatar']; ?>" alt="Avatar" class="w-full h-full object-cover">
                                    <?php else: ?>
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-full w-full text-gray-400 p-1" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                            <circle cx="12" cy="7" r="4"></circle>
                                        </svg>
                                    <?php endif; ?>
                                </div>
                                <div>
                                    <div class="text-sm font-medium text-gray-900"><?php echo $member['name']; ?></div>
                                    <div class="text-xs text-gray-500">@<?php  ?></div>
                                    <div class="text-xs text-gray-500">@<?php echo $member['username']; ?></div>
                                </div>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
        </div>

        <script>
            function copyCode() {
                const codeInput = document.getElementById('leagueCode');
                navigator.clipboard.writeText(codeInput.value);
                alert('Código copiado: ' + codeInput.value);
            }
        </script>
    <?php else: ?>
        <!-- Leagues List -->
        <div class="mb-6 flex items-center justify-between">
            <h1 class="text-2xl font-bold text-gray-800">Mis Ligas</h1>
            <div class="space-x-2">
                <a href="index.php?page=leagues&action=join" class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50">Unirse a Liga</a>
                <a href="index.php?page=leagues&action=new" class="px-4 py-2 bg-primary-600 text-white rounded-md hover:bg-primary-700">Crear Liga</a>
            </div>
        </div>

        <?php
        // Get user leagues
        $leagues = getUserLeagues($_SESSION['user_id']);
        ?>

        <?php if (count($leagues) > 0): ?>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <?php foreach ($leagues as $league): ?>
                    <?php
                    // Get league members count
                    $query = "SELECT COUNT(*) as count FROM league_users WHERE league_id = {$league['id']}";
                    $result = $conn->query($query);
                    $members_count = $result->fetch_assoc()['count'];

                    // Get league matches count
                    $query = "SELECT COUNT(*) as count FROM matches WHERE league_id = {$league['id']}";
                    $result = $conn->query($query);
                    $matches_count = $result->fetch_assoc()['count'];
                    ?>
                    <a href="index.php?page=leagues&id=<?php echo $league['id']; ?>" class="bg-white rounded-lg shadow p-6 hover:shadow-md transition-shadow">
                        <h2 class="text-xl font-bold text-gray-800 mb-2"><?php echo $league['name']; ?></h2>
                        <p class="text-gray-600 mb-4"><?php echo $league['description']; ?></p>
                        <div class="flex items-center justify-between text-sm text-gray-500">
                            <div class="flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                                    <circle cx="9" cy="7" r="4"></circle>
                                    <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                                    <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                                </svg>
                                <?php echo $members_count; ?> miembros
                            </div>
                            <div class="flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                                    <line x1="16" y1="2" x2="16" y2="6"></line>
                                    <line x1="8" y1="2" x2="8" y2="6"></line>
                                    <line x1="3" y1="10" x2="21" y2="10"></line>
                                </svg>
                                <?php echo $matches_count; ?> partidos
                            </div>
                            <div>Código: <?php echo $league['code']; ?></div>
                        </div>
                    </a>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="bg-white rounded-lg shadow p-8 text-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto text-gray-400 mb-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M18 8h1a4 4 0 0 1 0 8h-1"></path>
                    <path d="M2 8h16v9a4 4 0 0 1-4 4H6a4 4 0 0 1-4-4V8z"></path>
                    <line x1="6" y1="1" x2="6" y2="4"></line>
                    <line x1="10" y1="1" x2="10" y2="4"></line>
                    <line x1="14" y1="1" x2="14" y2="4"></line>
                </svg>
                <h2 class="text-xl font-bold text-gray-800 mb-2">No estás en ninguna liga</h2>
                <p class="text-gray-600 mb-6">Únete a una liga existente o crea una nueva para empezar a jugar.</p>
                <div class="flex justify-center space-x-4">
                    <a href="index.php?page=leagues&action=join" class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50">Unirse a Liga</a>
                    <a href="index.php?page=leagues&action=new" class="px-4 py-2 bg-primary-600 text-white rounded-md hover:bg-primary-700">Crear Liga</a>
                </div>
            </div>
        <?php endif; ?>
    <?php endif; ?>
</div>