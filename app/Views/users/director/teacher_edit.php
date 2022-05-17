<h1>Mokytojo redagavimas</h1>
<? if (isset($errors)) { ?>
    <?= $errors ?>
<? } ?>
<? if (isset($success)) { ?>
    <?= $success ?>
<? } ?>

<form action="<?= base_url('/director/updateTeacher/' . $teacher['id']) ?>" method="post">
    <fieldset>
        <legend>Pridėti mokytoją:</legend>
        Email: <input type="text" name="email" value="<?= $teacher['email'] ?>"><br>
        Slaptažodis: <input type="text" name="password"><br>
        Vardas: <input type="text" name="firstname" value="<?= $teacher['firstname'] ?>"><br>
        Pavardė: <input type="text" name="lastname" value="<?= $teacher['lastname'] ?>"><br>
        Pamoka: <select name="lesson_id">
            <option value="">-</option>
            <? foreach ($lessons as $lesson) { ?>
                <option value="<?= $lesson['id'] ?>" <? if($teacher['lesson_id'] == $lesson['id']) { echo 'selected'; }?> ><?= $lesson['title'] ?></option>
            <? } ?>
        </select><br/>
        Klasė: <select name="class_id">
            <option value="">-</option>
            <? foreach ($classes as $class) { ?>
                <option value="<?= $class['id'] ?>" <? if($teacher['class_id'] == $class['id']) { echo 'selected'; }?> ><?= $class['title'] ?></option>
            <? } ?>
        </select><br/>
        <input type="submit" value="Išsaugoti">
    </fieldset>
</form>