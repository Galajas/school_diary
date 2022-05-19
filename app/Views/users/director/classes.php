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

<?php if (isset($class_update)) { ?>
    <form action="<?= base_url('/director/updateClass/' . $class_update['id']) ?>" method="post">
        <fieldset>
            <legend>Atnaujinti Klase:</legend>
            Klasės pavadinimas: <input type="text" name="title" value="<?= $class_update['title'] ?>"><br>
            Max pamoku: <input type="text" name="max_week_lessons" value="<?= $class_update['max_week_lessons'] ?>"><br>
            <input type="submit" value="Atnaujinti">
        </fieldset>
    </form>
    <hr>
<?php } ?>

<form action="<?= base_url('/director/createClass') ?>" method="post">
    <fieldset>
        <legend>Pridėti Klase:</legend>
        Klasės pavadinimas: <input type="text" name="title"><br>
        Max pamoku: <input type="text" name="max_week_lessons"><br>
        <input type="submit" value="Sukurti">
    </fieldset>
</form>



<table class="tableStyle">
    <h4>
        Klasiu sarasas
    </h4>
    <tr>
        <th>Klase</th>
        <th>Max pamoku</th>
        <th>Veiksmas</th>
    </tr>
    <?php
    foreach ($classes as $class) { ?>
        <tr>
            <td><?= $class['title'] ?></td>
            <td><?= $class['max_week_lessons'] ?></td>
            <td>
                <a href="<?= base_url('/director/classes/' . $class['id']) ?>">REDAGUOTI</a> |
                <a href="<?= base_url('/director/deleteClass/' . $class['id']) ?>">Ištrinti</a>
            </td>
        </tr>
        <?php
    }
    ?>
</table>
