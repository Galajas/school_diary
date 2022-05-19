<style>
    .tableStyle, th, td {
        border: 1px solid black;
    }
</style>

<?php if (isset($errors)) { ?>
    <?= $errors ?>
<?php } ?>
<?php if (isset($success)) { ?>
    <?= $success ?>
<?php } ?>

<a href="<?= base_url('/director/index') ?>">Gryzti atgal</a>

<h3>
    Pamoku valdymas
</h3>

<?php if (isset($lesson)) { ?>
    <form action="<?= base_url('/director/updateLesson/' . $lesson['id']) ?>" method="post">
        <fieldset>
            <legend>Redaguoti Pamoka:</legend>
            Pamoka: <input type="text" name="lesson" value="<?= $lesson['title'] ?>"><br>
            <input type="submit" value="Išsaugoti">
        </fieldset>
    </form>
    <hr>
<?php } ?>

<form action="<?= base_url('/director/createLesson') ?>" method="post">
    <fieldset>
        <legend>Pridėti Pamoka:</legend>
        Pamoka: <input type="text" name="lesson">
        <input type="submit" value="Sukurti">
    </fieldset>
</form>

<table class="tableStyle">
    <h4>
        Pamoku sarasas
    </h4>
    <tr>
        <th>Pavadinimas</th>
        <th>Veiksmas</th>
    </tr>
    <?php
    foreach ($lessons as $lesson) { ?>
        <tr>
            <td>
                <?= $lesson['title'] ?>
            </td>
            <td>
                <a href="<?= base_url('/director/lessons/' . $lesson['id']) ?>">REDAGUOTI</a> |
                <a href="<?= base_url('/director/deleteLesson/' . $lesson['id']) ?>">Ištrinti</a>
            </td>
        </tr>

        <?php
    }
    ?>
</table>

