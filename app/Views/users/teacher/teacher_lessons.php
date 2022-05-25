<style>
    .tableStyle, th, td {
        border: 1px solid black;
    }
</style>

<a href="<?= base_url('/teacher/index') ?>">Gryzti atgal</a><br>

<? if (isset($errors)) { ?>
    <?= $errors ?>
<? } ?>
<? if (isset($success)) { ?>
    <?= $success ?>
<? } ?>


<h1>Mano pamokos</h1>

<form action="<?= base_url('/teacher/showLessons') ?>" method="post">
    <label for="selected_date">Įveskite data: </label>
    <input name="selected_date" type="date" data-date-format="YYYY-MM-DD" value="<?= $date ?>">
    <input type="submit" value="Rodyti">
</form>


<fieldset>
    <table class="tableStyle">
        <legend>Pirmadienis</legend>
        <tr>
            <th>
                Kuriam kabinete
            </th>
            <th>
                Kuriai klasei
            </th>
        </tr>
        <tr>
            <td>
                203
            </td>
            <td>
                5A
            </td>
        </tr>
    </table>
</fieldset>

<?php

?>
