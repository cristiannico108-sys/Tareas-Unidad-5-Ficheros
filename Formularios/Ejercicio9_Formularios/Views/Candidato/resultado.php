<?ph
    $e = static fn(mixed $v): string => htmlspecialchars((string) $v, ENT_QUOTES, 'UTF-8');

    $etiquetasCampo = [
        'nombre'    => 'Nombre',
        'apellidos' => 'Apellidos',
        'correo'    => 'Correo electrónico',
        'telefono'  => 'Teléfono',
        'situacion' => 'Situación laboral',
        'lenguajes' => 'Lenguajes',
        'url'       => 'URL de un trabajo anterior',
    ];
?>
<h2>Resultado de la validación</h2>

<?php if ($valido): ?>
    <p><strong>La candidatura es correcta.</strong></p>
<?php else: ?>
    <p><strong>Se han detectado errores en el formulario.</strong></p>
<?php endif; ?>

<h3>Datos válidos</h3>
<?php if ($datos === []): ?>
    <p>Ningún dato ha superado la validación.</p>
<?php else: ?>
    <ul>
    <?php foreach ($datos as $campo => $valor): ?>
        <li>
            <?= $e($etiquetasCampo[$campo]) ?>:
            <?php if ($campo === 'situacion'): ?>
                <?= $e($situaciones[$valor]) ?>
            <?php elseif ($campo === 'lenguajes'): ?>
                <?= $e(implode(', ', $valor)) ?>
            <?php elseif ($campo === 'url'): ?>
                <a href="<?= $e($valor) ?>" target="_blank" rel="noopener noreferrer"><?= $e($valor) ?></a>
            <?php else: ?>
                <?= $e($valor) ?>
            <?php endif; ?>
        </li>
    <?php endforeach; ?>
    </ul>
<?php endif; ?>

<h3>Errores detectados</h3>
<?php if ($errores === []): ?>
    <p>No se ha detectado ningún error.</p>
<?php else: ?>
    <ul>
    <?php foreach ($errores as $campo => $mensaje): ?>
        <li><strong><?= $e($etiquetasCampo[$campo]) ?>:</strong> <?= $e($mensaje) ?></li>
    <?php endforeach; ?>
    </ul>
<?php endif; ?>

<p><a href="index.php">Volver al formulario</a></p>
