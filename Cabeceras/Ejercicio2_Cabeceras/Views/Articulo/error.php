<?php
    $e = static fn(mixed $v): string => htmlspecialchars((string) $v, ENT_QUOTES, 'UTF-8');
?>
<h2><?= $e($titulo) ?></h2>

<p><?= $e($mensaje) ?></p>

<h3>Nueva búsqueda</h3>

<?php require __DIR__ . '/_buscador.php'; ?>
