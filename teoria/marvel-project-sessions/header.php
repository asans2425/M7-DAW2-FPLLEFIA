<?php
session_start(); 
?>
<div style="background:#eee;padding:10px;margin-bottom:20px;">
    <?php if (isset($_SESSION["user"])): ?>
        👋 Benvingut, <b><?php echo htmlspecialchars($_SESSION["user"]); ?></b> |
        <a href="home.php">🏠 Home</a> |
        <a href="personajes.php">🦸 Personatges</a> |
        <a href="logout.php">🚪 Tancar sessió</a>
    <?php else: ?>
        <a href="index.php">🔑 Inicia sessió</a>
    <?php endif; ?>
</div>

