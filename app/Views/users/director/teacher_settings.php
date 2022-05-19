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

    <h3>
        Mokytoju valdymas
    </h3>

    <form action="<?= base_url('/director/createTeacher') ?>" method="post">
        <fieldset>
            <legend>Pridėti mokytoją:</legend>
            Email: <input type="text" name="email"><br>
            Slaptažodis: <input type="text" name="password"><br>
            Vardas: <input type="text" name="firstname"><br>
            Pavardė: <input type="text" name="lastname"><br>
            Pamoka: <select name="lesson_id">
                <option value="">-</option>
                <? foreach ($lessons as $lesson) { ?>
                    <option value="<?= $lesson['id'] ?>"><?= $lesson['title'] ?></option>
                <? } ?>
            </select><br/>
            Klasė: <select name="class_id">
                <option value="">-</option>
                <? foreach ($classes as $class) { ?>
                    <option value="<?= $class['id'] ?>"><?= $class['title'] ?></option>
                <? } ?>
            </select><br/>
            <input type="submit" value="Sukurti">
        </fieldset>
    </form>

    <div class="sectionTables">
            <h4>
                Mokytoju sarasas
            </h4>
            <table class="tableStyle">
                <tr>
                    <th>ID</th>
                    <th>el. Pastas</th>
                    <th>Vardas</th>
                    <th>Pavarde</th>
                    <th>Klases aukletojas</th>
                    <th>Pamoka</th>
                    <th>Veiksmas</th>
                </tr>
                <? foreach ($teachers as $teacher) { ?>
                    <tr>
                        <td><?= $teacher['id'] ?></td>
                        <td><?= $teacher['email'] ?? null ?></td>
                        <td><?= $teacher['firstname'] ?? null ?></td>
                        <td><?= $teacher['lastname'] ?? null ?></td>
                        <td><?= $teacher['class'] ?? null ?></td>
                        <td><?= $teacher['lesson'] ?? null ?></td>
                        <td>
                            <a href="<?= base_url('/director/editTeacher/' . $teacher['id']) ?>">REDAGUOTI</a> |
                            <a href="<?= base_url('/director/deleteTeacher/' . $teacher['id']) ?>">Ištrinti</a>
                        </td>
                    </tr>
                <? } ?>
            </table>
    </div>