<?php
session_start();
include 'header.php';

if (!isset($_SESSION["user"])) {
    header("Location: index.php");
    exit;
}

$personajes = $_SESSION["personajes"] ?? [];
?>

<h2>Els teus personatges Marvel</h2>

<?php if (empty($personajes)): ?>
    <p>Encara no tens cap personatge! 😢</p>
    <a href="home.php">Crea'n un</a>
<?php else: ?>
    <div style="display:flex;flex-wrap:wrap;gap:10px;">
        <?php foreach ($personajes as $p): ?>
            <div style="border:1px solid #ccc;padding:10px;width:200px;">
                <h4><?php echo htmlspecialchars($p["nom"]); ?></h4>
                <p>Poder: <?php echo htmlspecialchars($p["poder"]); ?></p>
                <a href="editar.php?id=<?php echo $p["id"]; ?>">✏️ Editar</a> |
                <a href="eliminar.php?id=<?php echo $p["id"]; ?>">🗑️ Eliminar</a>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>
