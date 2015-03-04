<?php
 	  $dirName=".";
      $dir=opendir($dirName) or die("couldn't open current dir");
    //  echo "ÈÈÃÅÈíŒþ<br>";
      while(!(($file=readdir($dir))===false)){	
      		if((strpos($file,"exe")>0)||(strpos($file,"sh")>0)||(strpos($file,"zip")>0))
            {
      			$n=strlen($file);
      			$name=substr($file,0,$n-4);
	          	echo   "<a href=http://sky/software/".$file." target='_blank' title=".$name."><img width=64 height=64 src=http://sky/software/".$name.".png  ></img><em>".$name."</em></a><br>";
          	}
        }
       
      
		
?>

 