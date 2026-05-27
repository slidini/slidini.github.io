<?php

/** @var \App\Model\Wheels $wheel */
/** @var \App\Service\Router $router */

$title = "{$wheel->getBrand()}, {$wheel->getSize()}, {$wheel->getColor()}, ({$wheel->getId()})";
$bodyClass = 'show';

ob_start(); ?>
    <h1>Make: <?= $wheel->getBrand() ?></h1>
    <article>
        <?= $wheel->getSize();?>
        <?= $wheel->getColor();?>
    </article>

    <ul class="action-list">
        <li> <a href="<?= $router->generatePath('wheels-index') ?>">Back to list</a></li>
        <li><a href="<?= $router->generatePath('wheels-edit', ['id'=> $wheel->getId()]) ?>">Edit</a></li>
    </ul>
<?php $main = ob_get_clean();

include __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'base.html.php';
