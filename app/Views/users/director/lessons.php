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
        Pamoku sarasas
    </h4>
    <tr>
        <th>Pavadinimas</th>
    </tr>
    <?php
    foreach ($lessons as $lesson) { ?>
        <tr>
            <td><?= $lesson['title'] ?></td>
        </tr>
        <?php
    }
    ?>
</table>

