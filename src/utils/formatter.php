<?php

    function validName($name)
    {
        $name = preg_replace('([^A-Za-z0-9\-_])', '', $name);
        $name = 'files/'.trim($name).'.txt';
        return $name;
    }   

    function getFileDate($path){
        return gmdate("d/m/Y H:i:s", stat($path)["mtime"]);
    }
