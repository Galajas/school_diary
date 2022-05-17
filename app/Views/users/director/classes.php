<style>
    .tableStyle, th, td {
        border: 1px solid black;
    }
</style>

<? if (isset($errors)) { ?>
    <?= $errors ?>
<? } ?>
<? if (isset($success)) { ?>
    <?= $success ?>
<? } ?>

<a href="<?= base_url('/director/index') ?>">Gryzti atgal</a>

<table class="tableStyle">
    <h4>
        Klasiu sarasas
    </h4>
    <tr>
        <th>Klase</th>
        <th>Max pamoku</th>
    </tr>
    <?php
    foreach ($classes as $class) { ?>
        <tr>
            <td><?= $class['title'] ?></td>
            <td><?= $class['max_week_lessons'] ?></td>
        </tr>
        <?php
    }
    ?>
</table>
