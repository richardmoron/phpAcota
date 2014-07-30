<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html>
<head>
  <title>Buscar Archivo</title>
  <script type="text/javascript">
        var var_path;
        var var_file;
        function terminate(path,file){
              var o = new Object();
              //alert(path);
              o.file = file;
              o.path = path;
//              window.returnValue = o;
              opener.truncPath(o);
              window.close();
        }
    </script>
    <link rel="stylesheet" href="../media/css/4forms.css" type="text/css" media="screen" />
    <style type="text/css">
        .error{ color:red; font-weight:bold; }
        .title_panel{
            margin-top: 10px;
            box-shadow: 0 1px 0 rgba(255, 255, 255, 0) inset, 0 1px 2px #000000;
        }
      </style>
    <!--style type="text/css" media="screen">
        h2{
            background-image: url("../media/img/panel-title-background.png");
            border-color: #DAE4E9 #DAE4E9 -moz-use-text-color;
            border-image: none;
            border-style: solid solid none;
            border-width: 2px 2px medium;
            color: #7392A2;
            font-family: Verdana,Arial;
            font-size: 10pt;
            font-weight: bold;
            height: 25px;
            margin: 15px 15px 0px 15px;
            padding-left: 10px;
            padding-top: 5px;
            vertical-align: middle;
            width: 90%;
        }
        div{
            background-color: #FFFFFF;
            border-color: #DAE4E9;
            border-image: none;
            border-style: none solid solid;
            border-width: medium 2px 2px;
            font-family: Verdana,Arial;
            font-size: 10pt;
            list-style: none outside none;
            margin-top: 0;
            margin-left: 15px;
            padding-bottom: 10px;
            padding-left: 10px;
            padding-top: 15px;
            width: 90%;
        }
    </style-->
</head>
    <body>

<?php
  include_once dirname(dirname(__FILE__))."/conf/configure.php";
  // Explore the files via a web interface.
  $script = basename(__FILE__); // the name of this script
  $path = !empty($_REQUEST['path']) ? $_REQUEST['path'] : ROOT_FOLDER; // the path the script should access

  $directories = array();
  $files = array();

  // Check we are focused on a dir
  if (is_dir($path)) {
    chdir($path); // Focus on the dir
   if ($handle = opendir('.')) {
      while (($item = readdir($handle)) !== false) {
        // Loop through current directory and divide files and directorys
        if(is_dir($item)){
          array_push($directories, realpath($item));
        }
        else
        {
          array_push($files, ($item));
        }
   }
   closedir($handle); // Close the directory handle
   }
    else {
      echo "<p class=\"error\">Directory handle could not be obtained.</p>";
    }
  }
  else
  {
    echo "<p class=\"error\">Path is not a directory</p>";
  }

  // There are now two arrays that contians the contents of the path.

  // List the directories as browsable navigation
  echo '<div id="" name="" class="title_panel">';
  echo '<div class="panel_title_label" id="fields_title_panel" name="fields_title_panel">Directorios</div>';
  //echo "<ul>";
  $count = 0;
  foreach( $directories as $directory ){
    $img = "folder_yellow.png";
    $margin = "30px";
    if($count == 1){
        $img = "folder_explore.png";
        $margin = "15px";
    }
    echo ($directory != $path) ? "<span style=\"margin-left:$margin;\"><img src=\"../media/img/filebrowser/$img\" border=\"0\" style=\"margin-right:5px;\"/><a href=\"{$script}?path={$directory}\" target=\"_self\">{$directory}</a></span><br />" : "";
    $count++;
  }
  if($count == 2)
    echo "<span style=\"margin-left:40px;\"><img src=\"../media/img/filebrowser/folder_yellow.png\" border=\"0\" style=\"margin-right:5px;\"/><a href=\"{$script}?path={$path}\">{$path}</a></span><br />";
  //echo "</ul>";

  echo '</div>';
  echo '<div id="" name="" class="title_panel">';
  echo '<div class="panel_title_label" id="fields_title_panel" name="fields_title_panel">Archivos</div>';
  //echo "<ul>";
  foreach( $files as $file ){
    // Comment the next line out if you wish see hidden files while browsing
    if(preg_match("/^\./", $file) || $file == $script): continue; endif; // This line will hide all invisible files.
    $img = "page.png";
    if(strpos($file, ".php")>0)
        $img = "page_white_php.png";
    echo '<span style="margin-left:15px;"><a href="#" onclick="terminate(\''.str_replace('\\', "/",$path).'\',\'' . basename($file) . '\')" target="_self"><img src="../media/img/filebrowser/'.$img.'" border="0" style="margin-right:5px;"/>' . $file . '</a></span><br />';
  }
  echo "</div>";
?>

</body>
</html>