<a href="<?= base_url('/teacher/index') ?>">Gryzti atgal</a><br>

<? if (isset($errors)) { ?>
    <?= $errors ?>
<? } ?>
<? if (isset($success)) { ?>
    <?= $success ?>
<? } ?>

<?php if (isset($class)) { ?>

    <h1>Tvarkarasčio kūrimas</h1>

    <form action="<?= base_url('/teacher/addLesson') ?>" method="post">
        <fieldset>
            <legend>Pridėti pamoka į tvarkaraštį:</legend>
            <table>
                <tr>
                    <td>
                        Pamoka:
                    </td>
                    <td>
                        <select name="teacher_id">
                            <option>-</option>
                            <? foreach ($teachers as $teacher) { ?>
                                <option value="<?= $teacher['id'] ?>"><?= $teacher['lesson'] ?>
                                    (<?= $teacher['firstname'] ?> <?= $teacher['lastname'] ?>)
                                </option>
                            <? } ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>
                        Kelinta bus pamoka:
                    </td>
                    <td>
                        <select name="lesson_number">
                            <option>-</option>
                            <? for ($i = 1; $i <= round($class['max_week_lessons'] / 5); $i++) { ?>
                                <option value="<?= $i ?>"><?= $i ?></option>
                            <? } ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>
                        Kuria savaitės diena:
                    </td>
                    <td>
                        <select name="week_day">
                            <option>-</option>
                            <? foreach ($week_days as $week_day) { ?>
                                <option value="<?= $week_day[0] ?>"><?= $week_day[1] ?></option>
                            <? } ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>
                        Kabinetas:
                    </td>
                    <td>
                        <input type="text" name="cabinet">
                    </td>
                </tr>
            </table>
            <input type="submit" value="Sukurti">
        </fieldset>
    </form>

    Tvarkaraščio užpildymas: <?= $count_lessons ?> / <?= $class['max_week_lessons'] ?>
    <br/>
    <br/>

    <table border="1">
        <tr>
            <? foreach ($week_days as $week_day) { ?>
                <th>
                    <?= $week_day[1] ?>
                </th>
            <? } ?>
        </tr>
        <tr>
            <? foreach ($week_days as $week_day) {
                if ($schedule[$week_day[0]]) {
                    ?>
                    <td>
                        <table>
                            <? foreach ($schedule[$week_day[0]] as $item) { ?>
                                <tr>
                                    <td>(<?= $item['lesson_number'] ?>)</td>
                                    <td><?= $item['title'] ?></td>
                                </tr>
                            <? } ?>
                        </table>
                    </td>

                <? }
            } ?>
        </tr>
        <tr>
            <? foreach ($week_days as $week_day) {
                if ($schedule[$week_day[0]]) {
                    ?>
                    <td>
                        <table>
                            <form action="<?= base_url('/teacher/deleteLesson') ?>" method="post">
                                <select name="delete_lesson">
                                    <option>-</option>
                                    <? foreach ($schedule[$week_day[0]] as $item) { ?>
                                        <option value="<?= $item['id'] ?>">(<?= $item['lesson_number'] ?>) <?= $item['title'] ?></option>
                                    <? } ?>
                                </select>
                                <input type="submit" value="Istrinti">
                            </form>
                        </table>
                    </td>
                <? }
            } ?>
        </tr>
    </table>

<?php } ?>