<?php

/** @var \App\Model\Wheels[] $wheels */
/** @var \App\Service\Router $router */

$title = 'Wheels List';
$bodyClass = 'index';

ob_start(); ?>
    <h1>Wheels List</h1>

    <a href="<?= $router->generatePath('wheels-create') ?>">Create new</a>

    <ul class="index-list">
        <?php foreach ($wheels as $wheel): ?>
            <li><h3><?= $wheel->getBrand()?> - <?= $wheel->getSize()?> - <?= $wheel->getColor()?></h3>
                <ul class="action-list">
                    <li><a href="<?= $router->generatePath('wheels-show', ['id' => $wheel->getId()]) ?>">Details</a></li>
                    <li><a href="<?= $router->generatePath('wheels-edit', ['id' => $wheel->getId()]) ?>">Edit</a></li>
                </ul>
            </li>
        <?php endforeach; ?>
    </ul>

<?php $main = ob_get_clean();

include __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'base.html.php';
