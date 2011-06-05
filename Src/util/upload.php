<?php 

uploader(1, array("png"),10000,"");

function uploader($num_of_uploads = 1, $file_types_array=array("txt"), $max_file_size=1048576, $upload_dir="Photos"){ 
  if(!is_numeric($max_file_size)){ 
    $max_file_size = 1048576; 
  } 
  if(!isset($_POST["submitted"])){ 
    $form = "<form action='".$_SERVER['PHP_SELF']."' method='post' enctype='multipart/form-data'>Upload files:<br /><input type='hidden' name='submitted' value='TRUE' id='".time()."'><input type='hidden' name='MAX_FILE_SIZE' value='".$max_file_size."'>"; 
    for($x=0;$x<$num_of_uploads;$x++){ 
      $form .= "<input type='file' name='file[]'><font color='red'>*</font><br />"; 
    } 
    $form .= "<input type='submit' value='Upload'><br /><font color='red'>*</font>Maximum file length (minus extension) is 15 characters. Anything over that will be cut to only 15 characters. Valid file type(s): "; 
    for($x=0;$x<count($file_types_array);$x++){ 
      if($x<count($file_types_array)-1){ 
        $form .= $file_types_array[$x].", "; 
      }else{ 
        $form .= $file_types_array[$x]."."; 
      } 
    } 
    $form .= "</form>"; 
    echo($form); 
  }else{ 
    foreach($_FILES["file"]["error"] as $key => $value){ 
      if($_FILES["file"]["name"][$key]!=""){ 
        if($value==UPLOAD_ERR_OK){ 
          $origfilename = $_FILES["file"]["name"][$key]; 
          $filename = explode(".", $_FILES["file"]["name"][$key]); 
          $filenameext = $filename[count($filename)-1]; 
          unset($filename[count($filename)-1]); 
          $filename = implode(".", $filename); 
          $filename = substr($filename, 0, 15).".".$filenameext; 
          $file_ext_allow = FALSE; 
          for($x=0;$x<count($file_types_array);$x++){ 
            if($filenameext==$file_types_array[$x]){ 
              $file_ext_allow = TRUE; 
            } 
          } 
          if($file_ext_allow){ 
            if($_FILES["file"]["size"][$key]<$max_file_size){ 
              if(move_uploaded_file($_FILES["file"]["tmp_name"][$key], $upload_dir.$filename)){ 
                echo("File uploaded successfully. - <a href='".$upload_dir.$filename."' target='_blank'>".$filename."</a><br />"); 
              }else{ 
                echo($origfilename." was not successfully uploaded<br />"); 
              } 
            }else{ 
              echo($origfilename." was too big, not uploaded<br />"); 
            } 
          }else{ 
            echo($origfilename." had an invalid file extension, not uploaded<br />"); 
          } 
        }else{ 
          echo($origfilename." was not successfully uploaded<br />"); 
        } 
      } 
    } 
  } 
} 
?> 