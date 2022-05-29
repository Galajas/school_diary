
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
    <input type="text" name="selected_date" value="<?= $date ?? date('Y-m-d') ?>">
    <input type="submit" value="Rodyti">
</form>

<fieldset>
    <table class="tableStyle">
        <legend><?= $date ?? date('Y-m-d') ?></legend>
        <tr>
            <th>
                Kelinta pamoka
            </th>
            <th>
                Kuriam kabinete
            </th>
            <th>
                Kokia pamoka
            </th>
            <th>
                Kuriai klasei
            </th>
            <th>
                Veiksmas
            </th>
        </tr>

        <?php
        foreach ($teacher_schedule as $item) { ?>
            <tr>
                <td>
                    <?= $item['lesson_number'] ?>
                </td>
                <td>
                    <?= $item['cabinet'] ?>
                </td>
                <td>
                    <?= $item['title'] ?>
                </td>
                <td>
                    <?= $item['class'] ?>
                </td>
                <td>
                    <a href="<?= base_url('/teacher/teacherSchedule/' . ($date ?? date('Y-m-d')) . '/' . $item['classId']) ?>">
                        Rodyti mokinius
                    </a>
                </td>

            </tr>
        <?php } ?>
    </table>
</fieldset>

<?php
if (isset($show_class)) {
    ?>
    <legend>Mokiniu sarasas</legend>
        <table style="border-collapse:separate; border-spacing:0 10px;">
            <tr>
                <th>
                    Studentai
                </th>
                <th style="border: 0px">
                    Veiksmas
                </th>
            </tr>
    <?php
    foreach ($show_class as $item) { ?>
            <tr style="outline: thin solid; border-collapse:separate; border-spacing:0 5px;">
                <td>
                    <?= $item['firstname'] ?> <?= $item['lastname'] ?>
                </td>
                <td >
                    <input type="text">
                </td>
            </tr>
    <?php } ?>
        </table>
    </fieldset>
    <?php
}
?>