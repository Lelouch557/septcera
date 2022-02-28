<?php
 $bla = password_hash("KoekjesZijnGemaaktVanDeeg", PASSWORD_DEFAULT);
echo $bla;
var_dump(password_verify("KoekjesZijnGemaaktVanDeeg", $bla));
echo"sdtgr";
?>