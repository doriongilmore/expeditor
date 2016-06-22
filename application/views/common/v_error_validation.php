
<?php  
if(isset($message['info']))
    echo '<div class="info">'.$message['info'].'</div>';
if(isset($message['error']))
    echo '<div class="error">'.$message['error'].'</div>';
if(isset($message['valid']))
    echo '<div class="valid">'.$message['valid'].'</div>';
?>