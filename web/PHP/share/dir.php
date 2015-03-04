<?php
 	  $dirName=".";
      $dir=opendir($dirName) or die("couldn't open current dir");
      echo "<ul>��ǰĿ¼";
      while(!(($file=readdir($dir))===false)){
          	echo   "<li><a href=".$file." target='_blank' title=".$file.">".$file."</a></li>";
        }
        echo "</ul>";
      
?>

 