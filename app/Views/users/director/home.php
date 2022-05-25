<h1>Direktoriaus aplinka</h1>
<a href="<?= base_url('home/logout') ?>">Atsijungti</a>

<? if (isset($errors)) { ?>
    <?= $errors ?>
<? } ?>
<? if (isset($success)) { ?>
    <?= $success ?>
<? } ?>

<ul>
    <li>
        <a href="<?= base_url('/director/teacherSettings') ?>">Mokytoju valdymas</a>
    </li>
    <li>
        <a href="<?= base_url('/director/studentSettings') ?>">Mokiniu valdymas</a>
    </li>
    <li>
        <a href="<?= base_url('/director/lessons') ?>">Pamokos</a>
    </li>
    <li>
        <a href="<?= base_url('/director/classes') ?>">Klasės</a>
    </li>
</ul>
