<?php

include "Uploaded.php";

if (isset($_FILES['file_1']))
{
    $up = new Uploaded();
    $up->setAllowedTypes(Uploaded::$TYPES['image']);
    $up->setAllowedSize(1024*20); //20ko
    $up->setUploadDir("upload");

    $up->setFile($_FILES['file_1']);
    echo '<h1>File 1</h1>';
    echo '<pre>';
        echo "<b>Name file:</b> " . $up->name() . '<br /><br />';
        echo "<b>Type file:</b> " . $up->type() . '<br /><br />';
        echo "<b>Size file:</b> " . $up->size() . '<br /><br />';

        echo "<b>Is uploaded :</b> " . ($up->up() ? 'YES' : 'NO') . '<br /><br />';

        echo '<b>Details after uploaded:</b> '; var_dump($up->details());

        echo '<br /><b>Errors after uploaded:</b> ' . Uploaded::$ERRORS[$up->error()];

    echo '</pre>';




    $up->setFile($_FILES['file_2']);
    $up->setAllowedSize(1024*40); // 40Ko
    $up->setAllowedTypes(); // all types

    echo '<h1>File 2</h1>';
    echo '<pre>';
        echo "<b>Name file:</b> " . $up->name() . '<br /><br />';
        echo "<b>Type file:</b> " . $up->type() . '<br /><br />';
        echo "<b>Size file:</b> " . $up->size() . '<br /><br />';

        echo "<b>Is uploaded :</b> " . ($up->up() ? 'YES' : 'NO') . '<br /><br />';

        echo '<b>Details after uploaded:</b> '; var_dump($up->details());

        echo '<br /><b>Errors after uploaded:</b> ' . Uploaded::$ERRORS[$up->error()];

    echo '</pre>';
}

?>

<br /><br />
<form method='post' enctype='multipart/form-data'>

    <input type='file' name='file_1' /> <br />
    <input type='file' name='file_2' />
    <input type='submit' />

</form>
