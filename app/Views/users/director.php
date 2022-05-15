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

<h1>
    Direktorius
</h1>

<section>
    <h3>
        Mokytoju valdymas
    </h3>

    <div class="sectionTables">
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