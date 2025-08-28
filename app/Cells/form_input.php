<div class="form-floating mb-3">
    <?php
    $messaje = validation_show_error($name);
    $oldValue = old($name, $default);
    $id = 'input-' . esc($name);
    ?>
    <input
        type="<?= $type ?>"
        name="<?= esc($name) ?>"
        id="<?= $id ?>"
        <?= $required ? 'required' : '' ?>
        <?= $readonly ? 'readonly' : '' ?>
        class="form-control <?= $messaje ? 'is-invalid' : '' ?>"
        <?= $oldValue ? "value='{$oldValue}'" : '' ?>
        <?= isset($min) ? "min='{$min}'" : '' ?>
        <?= isset($max) ? "max='{$max}'" : '' ?>
        <?= isset($step) ? "step='{$step}'" : '' ?>
        <?= isset($placeholder) ? "placeholder='{$placeholder}'" : '' ?>
        <?= isset($list) ? "list='{$name}-list'" : '' ?>>
    <label for="<?= $id ?>"><?= esc($label) ?></label>
    <?php if ($messaje): ?>
        <div class="invalid-feedback"><?= $messaje ?></div>
    <?php endif; ?>
    <?php if (isset($list)): ?>
        <datalist id="<?= $name ?>-list">
            <?php foreach ($list as $option): ?>
                <option value="<?= $option ?>">
                <?php endforeach; ?>
        </datalist>
    <?php endif; ?>

</div>