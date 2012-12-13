<?php


print("
    <div id=\"SeparationDiv\">
        <div id=\"MainSearchDiv\">
            <center>
    ");   
            //<img src=\"./Images/Separation.png\"/>   
            $_GET["fileType"]="AssigningAppointments";  
            include("./php/view/SearchGroup.php");
   print("   
            </center>                 
        </div>
    </div>
    ");



?>