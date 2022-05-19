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

<h1>Mokytojo aplinka</h1>

<? if (isset($errors)) { ?>
    <?= $errors ?>
<? } ?>
<? if (isset($success)) { ?>
    <?= $success ?>
<? } ?>

<?php if (isset($class)) { ?>
    <h4>
        Mano klase: <?= $class['title'] ?>
    </h4>
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
                </tr>
                <? foreach ($students as $student) { ?>
                    <tr>
                        <td><?= $student['id'] ?></td>
                        <td><?= $student['email'] ?? null ?></td>
                        <td><?= $student['firstname'] ?? null ?></td>
                        <td><?= $student['lastname'] ?? null ?></td>
                    </tr>
                <? } ?>
            </table>
        </div>
    </div>
<?php } ?>