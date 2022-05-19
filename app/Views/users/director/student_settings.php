<style>
    .tableStyle, th, td {
        border: 1px solid black;
    }

    .sectionTables {
        display: flex;
    }

    .sectionTables, div {
        margin-right: 20px;
    }
</style>

<? if (isset($errors)) { ?>
    <?= $errors ?>
<? } ?>
<? if (isset($success)) { ?>
    <?= $success ?>
<? } ?>

<a href="<?= base_url('/director/index') ?>">Gryzti atgal</a>

<section>
    <h3>
        Mokiniu valdymas
    </h3>

    <? if (isset($student)) { ?>
        <form action="<?= base_url('/director/updateStudent/' . $student['id']) ?>" method="post">
            <fieldset>
                <legend>Redaguoti moksleivį:</legend>
                Email: <input type="text" name="email" value="<?= $student['email'] ?>"><br>
                Slaptažodis: <input type="text" name="password"><br>
                Vardas: <input type="text" name="firstname" value="<?= $student['firstname'] ?>"><br>
                Pavardė: <input type="text" name="lastname" value="<?= $student['lastname'] ?>"><br>
                Klasė: <select name="class_id">
                    <option value="">-</option>
                    <? foreach ($classes as $class) { ?>
                        <option value="<?= $class['id'] ?>" <? if ($student['class_id'] == $class['id']) {
                            echo 'selected';
                        } ?> ><?= $class['title'] ?></option>
                    <? } ?>
                </select><br/>
                <input type="submit" value="Išsaugoti">
            </fieldset>
        </form>
        <hr>
    <? } ?>

    <form action="<?= base_url('/director/createStudent') ?>" method="post">
        <fieldset>
            <legend>Pridėti mokini:</legend>
            Email: <input type="text" name="email"><br>
            Slaptažodis: <input type="text" name="password"><br>
            Vardas: <input type="text" name="firstname"><br>
            Pavardė: <input type="text" name="lastname"><br>
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
        <div>
            <h4>
                Mokiniu sarasas
            </h4>
            <table class="tableStyle">
                <tr>
                    <th>ID</th>
                    <th>el. Pastas</th>
                    <th>Vardas</th>
                    <th>Pavarde</th>
                    <th>Klase</th>
                    <th>Veiksmas</th>
                </tr>
                <? foreach ($students as $student) { ?>
                    <tr>
                        <td><?= $student['id'] ?></td>
                        <td><?= $student['email'] ?? null ?></td>
                        <td><?= $student['firstname'] ?? null ?></td>
                        <td><?= $student['lastname'] ?? null ?></td>
                        <td><?= $student['class'] ?? null ?></td>
                        <td>
                            <a href="<?= base_url('/director/studentSettings/' . $student['id']) ?>">REDAGUOTI</a> |
                            <a href="<?= base_url('/director/deleteStudent/' . $student['id']) ?>">Ištrinti</a>
                        </td>
                    </tr>
                <? } ?>
            </table>
        </div>
    </div>
</section>
