<?php
if (empty($_SESSION['LOGIN']['ID']))
    header('Location:login');
else
    header('Location:index');
?>