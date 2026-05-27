<?php

/** @var \App\Model\Wheels $wheel */
/** @var \App\Service\Router $router */

$title = "Edit Wheels {$wheel->getBrand()}, {$wheel->getSize()}, {$wheel->getColor()}, ({$wheel->getId()})";
$bodyClass = "edit";

ob_start(); ?>
    <h1><?= $title ?></h1>
    <form action="<?= $router->generatePath('wheels-edit') ?>" method="post" class="edit-form">
        <?php require __DIR__ . DIRECTORY_SEPARATOR . '_form.html.php'; ?>
        <input type="hidden" name="action" value="wheels-edit">
        <input type="hidden" name="id" value="<?= $wheel->getId() ?>">
    </form>

    <ul class="action-list">
        <li>
            <a href="<?= $router->generatePath('wheels-index') ?>">Back to list</a></li>
        <li>
            <form action="<?= $router->generatePath('wheels-delete') ?>" method="post">
                <input type="submit" value="Delete" onclick="return confirm('Are you sure?')">
                <input type="hidden" name="action" value="wheels-delete">
                <input type="hidden" name="id" value="<?= $wheel->getId() ?>">
            </form>
        </li>
    </ul>

<?php $main = ob_get_clean();

include __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'base.html.php';
