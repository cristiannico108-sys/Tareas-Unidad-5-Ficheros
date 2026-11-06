<?php
    $e = static fn(mixed $v): string => htmlspecialchars((string) $v, ENT_QUOTES, 'UTF-8');
?>
<h2>Artículo encontrado</h2>

<ul>
    <li>ID: <?= $e($articulo['id']) ?></li>
    <li>Nombre: <?= $e($articulo['nombre']) ?></li>
    <li>Descripción: <?= $e($articulo['descripcion']) ?></li>
    <li>Precio: <?= $e(number_format($articulo['precio'], 2, ',', '.')) ?> €</li>
</ul>

<h3>Nueva búsqueda</h3>

<?php require __DIR__ . '/_buscador.php'; ?>
