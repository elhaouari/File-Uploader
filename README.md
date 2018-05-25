# uploaded
<h3>
upload class to ensure that upload files are safe on php
</h3>
<br />
<p>
  <strong>$up = new Uploaded();</strong> create object<br />
  <strong>$up->setAllowedTypes(Uploaded::$TYPES['image']);</strong> set mime type<br />
  <strong>$up->setAllowedSize(1024*20);</strong> set allowd size<br />
  <strong>$up->up()</strong> upload file <br />
</p>

<h1>Examples</h1>
<h1>File 1</h1>

    $up = new Uploaded();<br />
    $up->setAllowedTypes(Uploaded::$TYPES['image']);<br />
    $up->setAllowedSize(1024*20); //20ko <br />
    $up->setUploadDir("upload"); // create folder under name "upload" for uploaded in <br />
    $up->setFile($_FILES['file_1']);<br />
    echo '<h1>File 1</h1>';
    echo '<pre>';
        echo "<b>Name file:</b> " . $up->name() . '<br /><br />';
        echo "<b>Type file:</b> " . $up->type() . '<br /><br />';
        echo "<b>Size file:</b> " . $up->size() . '<br /><br />';
        echo "<b>Is uploaded :</b> " . ($up->up() ? 'YES' : 'NO') . '<br /><br />';
        echo '<b>Details after uploaded:</b> '; var_dump($up->details());
        echo '<br /><b>Errors after uploaded:</b> ' . Uploaded::$ERRORS[$up->error()];
    echo '</pre>';
 
 <h1>File 2</h1>
 
    $up->setFile($_FILES['file_2']);<br />
    $up->setAllowedSize(1024*40); // 40Ko<br />
    $up->setAllowedTypes(); // all types<br />
    echo '<h1>File 2</h1>';<br />
    echo '<pre>';
        echo "<b>Name file:</b> " . $up->name() . '<br /><br />';
        echo "<b>Type file:</b> " . $up->type() . '<br /><br />';
        echo "<b>Size file:</b> " . $up->size() . '<br /><br />';
        echo "<b>Is uploaded :</b> " . ($up->up() ? 'YES' : 'NO') . '<br /><br />';
        echo '<b>Details after uploaded:</b> '; var_dump($up->details());
        echo '<br /><b>Errors after uploaded:</b> ' . Uploaded::$ERRORS[$up->error()];
    echo '</pre>';
  
