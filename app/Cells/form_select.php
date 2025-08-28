<div class="form-floating mb-3">
    <?php
    $messaje = validation_show_error($name);
    $oldValue = old($name, $default);
    $id = 'select-' . esc($name);
    ?>
    <select
        class="form-select <?= $messaje ? 'is-invalid' : '' ?>"
        name="<?= esc($name) ?>"
        id="<?= $id ?>"
        aria-label="<?= $label ?>"
        <?= $onchange ? "onchange='{$onchange}'" : '' ?>
        <?= $readonly ? 'disabled' : '' ?>>
        <?php foreach ($options as $value => $text): ?>
            <option
                <?= set_select($name, $value, ($value === $default)) ?>
                value="<?= esc($value) ?>">
                <?= esc($text) ?>
            </option>
        <?php endforeach; ?>
    </select>
    <label for="<?= $id ?>"><?= esc($label) ?></label>
    <?php if ($messaje): ?>
        <div class="invalid-feedback"><?= $messaje ?></div>
    <?php endif; ?>
</div>