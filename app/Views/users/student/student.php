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

<h1>Studento aplinka</h1>
<a href="<?= base_url('home/logout') ?>">Atsijungti</a>

<? if (isset($errors)) { ?>
    <?= $errors ?>
<? } ?>
<? if (isset($success)) { ?>
    <?= $success ?>
<? } ?>

<div class="sectionTables">
    <table class="tableStyle">
        <div>
            <tr>
                <th>
                    Studento Email
                </th>
                <th>
                    Studento Vardas
                </th>
                <th>
                    Studento Pavarde
                </th>
                <th>
                    Studento Klase
                </th>
            </tr>
            <tr>
                <td>
                    <?= $student['email'] ?>
                </td>
                <td>
                    <?= $student['firstname'] ?>
                </td>
                <td>
                    <?= $student['lastname'] ?>
                </td>
                <td>
                    <?= $student['class'] ?>
                </td>
            </tr>
        </div>
    </table>
    <table class="tableStyle">
        <div>
            <tr>
                <th>
                    Studento Mokytojo Email
                </th>
                <th>
                    Studento Mokytojo vardas
                </th>
                <th>
                    Studento Mokytojo Pavarde
                </th>
                <th>
                    Studento Mokytojo destoma pamoka
                </th>
            </tr>
            <tr>
                <td>
                    <?= $teacher['email'] ?>
                </td>
                <td>
                    <?= $teacher['firstname'] ?>
                </td>
                <td>
                    <?= $teacher['lastname'] ?>
                </td>
                <td>
                    <?= $teacher['lesson'] ?>
                </td>
            </tr>
        </div>
    </table>
</div>