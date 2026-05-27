<?php

/** @var \App\Model\Wheels $wheel */
/** @var \App\Service\Router $router */

$title = 'Create Wheels';
$bodyClass = "edit";

ob_start(); ?>
    <h1>Create Wheels</h1>
    <form action="<?= $router->generatePath('wheels-create') ?>" method="post" class="edit-form">
        <?php require __DIR__ . DIRECTORY_SEPARATOR . '_form.html.php'; ?>
        <input type="hidden" name="action" value="wheels-create">
    </form>

    <a href="<?= $router->generatePath('wheels-index') ?>">Back to list</a>
<?php $main = ob_get_clean();

include __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'base.html.php';
