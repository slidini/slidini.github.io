<?php
    /** @var $wheel ?\App\Model\Wheels */
?>

<div class="form-group">
    <label for="brand">Brand</label>
    <input type="text" id="brand" name="wheel[brand]" value="<?= $wheel ? $wheel->getBrand() : '' ?>">
</div>

<div class="form-group">
    <label for="size">Size</label>
    <input type="number" id="size" name="wheel[size]" <?= $wheel? $wheel->getSize() : '' ?>>
</div>

<div class="form-group">
    <label for="color">Color</label>
    <input type="text" id="color" name="wheel[color]" value="<?= $wheel ? $wheel->getColor() : '' ?>">
</div>

<div class="form-group">
    <label></label>
    <input type="submit" value="Submit">
</div>
