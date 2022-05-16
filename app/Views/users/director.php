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

<h1>Direktoriaus aplinka</h1>

<? if (isset($errors)) { ?>
    <?= $errors ?>
<? } ?>
<? if (isset($success)) { ?>
    <?= $success ?>
<? } ?>

<section>
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

        <div>
            <h4>
                Mokytoju sarasas
            </h4>
            <table class="tableStyle">
                <tr>
                    <th>Vardas</th>
                    <th>Pavarde</th>
                    <th>Pamoka</th>
                    <th>Klase</th>
                    <th>Veiksmas</th>
                </tr>
                <? foreach ($teachers as $teacher) { ?>
                    <tr>
                        <td><?= $teacher['id'] ?></td>
                        <td><?= $teacher['class_id'] ?? null ?></td>
                        <td><?= $teacher['lesson_id'] ?? null ?></td>
                        <td>
                            <a href="<?= base_url('/director/editTeacher/' . $teacher['id']) ?>">REDAGUOTI</a>
                        </td>
                    </tr>
                <? } ?>

            </table>
        </div>

        <div>
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
        </div>
        <div>
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
        </div>
    </div>
</section>