<?php

function getRandomPassword() 
{
    $sRandomString    = substr(str_shuffle('ABCDEFGHIJKLMNOPQRSTUVWXYZ'), 0, 4);
    $sRandomString   .= substr(str_shuffle('0123456789'), 0, 2);

    $sRandomPassword = str_shuffle($sRandomString);
    return $sRandomPassword;
}
