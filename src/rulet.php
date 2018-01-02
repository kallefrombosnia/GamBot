<?php

require("../config.php");


//return of real integer value from mysql
mysqli_options($con, MYSQLI_OPT_INT_AND_FLOAT_NATIVE, 1);

if (mysqli_connect_errno())  
{
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

//FRAMEWORK
$filename = 'library/TeamSpeak3/TeamSpeak3.php';

if (file_exists($filename)) {
    require_once($filename);
} else {
    die ("The file $filename does not exist");
}



$ts3_VirtualServer = TeamSpeak3::factory("serverquery://".$login_name.":".$login_password."@".$ip.":".$query_port."/?server_port=".$virtualserver_port."&nickname=R4P3&blocking=0");
$ts3_id_bota = $ts3_VirtualServer->whoamiGet('client_id');
$ts3_VirtualServer->clientMove($ts3_id_bota, $register_chanel);
$ts3_VirtualServer->selfUpdate(array("client_nickname" => $bot_name));


TeamSpeak3_Helper_Signal::getInstance()->subscribe("serverqueryWaitTimeout", "onWaitTimeout");
TeamSpeak3_Helper_Signal::getInstance()->subscribe("notifyTextmessage", "onTextMessage");

$ts3_VirtualServer->notifyRegister("server");
$ts3_VirtualServer->notifyRegister("channel");
$ts3_VirtualServer->notifyRegister("textserver");
$ts3_VirtualServer->notifyRegister("textchannel");
$ts3_VirtualServer->notifyRegister("textprivate");

while(1) 
{
    $ts3_VirtualServer->getAdapter()->wait();
}

//spin function
 function spin($color)
        {

            $num = rand(1, 38);
            if($num==1 || $num==3 || $num==5 || $num==7 || $num==9 || $num==12 || $num==14 || $num==16 || $num==18 || $num==19 || $num==21 || $num==23 || $num==25 || $num==27 || $num==30 || $num==32 || $num==34 || $num==36)
            {
                $wincolor = "red";
            }
            elseif ($num == 37 || $num == 38) 
            {
                $wincolor = "green";
            }
            else
            {
                $wincolor = "black";
            }

            if($color==$wincolor)
            {
              return true;
            }
            else
            {
              return false;
            }
        }




function onWaitTimeout($time, TeamSpeak3_Adapter_Abstract $adapter)
{
    if($adapter->getQueryLastTimestamp() < time()-300)
    {
        $adapter->request('clientupdate');
    }
}

function onTextMessage(TeamSpeak3_Adapter_ServerQuery_Event $event, TeamSpeak3_Node_Host $host) 
{
    require('lang.php'); 
    require('config.php');
    global $con;
	global $srv;
    $info = $event->getData();
    $srv = $host->serverGetSelected();
    if($info["targetmode"] == 2)
    {
		//tnx hASVAN for this part 
		$mystring = $info["msg"];
        $pos1 = strpos($mystring, " ");

        if($pos1 > 0)
        {
            $rijec = substr($mystring, 0, $pos1);
        }
        else
        {  
            $rijec = $mystring;
        }



        if($rijec == "!start")
        {
            $uid = $srv->clientGetByName($info["invokername"])->client_unique_identifier;
            $sql = ("SELECT `uid` FROM `users` WHERE `uid` = '".$uid."'");
           
            if ($result = mysqli_query($con,$sql))
            {     
                $count = mysqli_num_rows($result); 
                if($count!=0){
                    $srv->clientGetByName($info["invokername"]->toString())->message
                    ("". $start['regalready'] ."");
                }
                else
                {       
                    $ip = $srv->clientGetByName($info["invokername"])->connection_client_ip;
                    $uid = $srv->clientGetByName($info["invokername"])->client_unique_identifier;
                    
        
                    $sql = "INSERT INTO users(uid, ip, points) 
                            VALUES ('".$uid."','".$ip."','".$points."')";

                    if (mysqli_query($con, $sql)) 
                    {
                        $srv->clientGetByName($info["invokername"]->toString())->message
                                ("". $start['ok']. "");
                    }
                    else 
                    {
                        $srv->clientGetByName($info["invokername"]->toString())->message
                        ("". $start['bad'] ."");
                    }
                }
            }

        }
        elseif($rijec == "!bet")
        {            
            $uid = $srv->clientGetByName($info["invokername"])->client_unique_identifier;
            $sql = ("SELECT `uid`, `points` FROM `users` WHERE `uid` = '".$uid."'");   
            if ($result = mysqli_query($con,$sql))
            {      
                $count = mysqli_num_rows($result);              
                if($count!=0)
                {
                   $srv->clientGetByName($info["invokername"]->toString())->message
                                        ("". $bet['ok'] ."");
                }
                else
                {
                $srv->clientGetByName($info["invokername"]->toString())->message
                ("". $ntr ."");  
                }
            }           
        }
        else 
        {
            $srv->clientGetByName($info["invokername"]->toString())->message("". $uc ."");
        }
    }
    //PM PART
    if($info['targetmode'] == 1)
    {
        $mystring = $info["msg"];
        $pos1 = strpos($mystring, " ");

        if($pos1 > 0)
        {
            $rijec = substr($mystring, 0, $pos1);
        }
        else
        {  
            $rijec = $mystring;
        }

        if($rijec == "!red")
        {
            $uid = $srv->clientGetByName($info["invokername"])->client_unique_identifier;
            $sql = ("SELECT `uid`, `points`  FROM `users` WHERE `uid` = '".$uid."'");
           
           
            if ($result = mysqli_query($con,$sql))
            {
                
                $count = mysqli_num_rows($result);
                $row = mysqli_fetch_assoc($result);


                settype($row["points"], integer);

                $allcoins = $row["points"];


                if($count!=0)
                {
                    $bet = str_replace('!red ','', $info["msg"]);

                    if(is_numeric($bet))
                    {
                         
                        if($bet > $allcoins || $bet = 0)
                        {
                            
                            $srv->clientGetByName($info["invokername"]->toString())->message
                                        ("". $gamble['coins'] ."");
                               
                        }
                        else
                        {

                            if(spin(red))
                            {  
                              
                                $bet1 = str_replace('!red ','', $info["msg"]);
                                
                                $won = $bet1 * $red;

                                $wincoins = $won + $allcoins;
 
                                $sql = "UPDATE users SET points='".$wincoins."' WHERE uid='".$uid."'";

                                if (mysqli_query($con, $sql)) 
                                {
                                   
                                     $srv->clientGetByName($info["invokername"]->toString())->message
                                        ("". $gamble['won'] . "" . $wincoins); 
                                }
                                else 
                                {
                                     echo "Error updating record: " . mysqli_error($conn);
                                }     
                            }
                            else
                            {

                                $bet1 = str_replace('!red ','', $info["msg"]);
                                $lost = $allcoins-$bet1;
                               
                                $sql = "UPDATE users SET points='".$lost."' WHERE uid='".$uid."'";
                                if (mysqli_query($con, $sql)) 
                                {
                                    
                                    $srv->clientGetByName($info["invokername"]->toString())->message
                                        ("" . $gamble['lost'] . "" .$lost);
                                }
                                else 
                                {
                                    echo "Error updating record: " . mysqli_error($conn);
                                }   
                            }
                        }
                    }   
                    else
                    {
                        $srv->clientGetByName($info["invokername"]->toString())->message
                                        ("". $gamble['number'] . "");
                    }

                }
                else
                {
                      $srv->clientGetByName($info["invokername"]->toString())->message
                ("" . $ntr . "");
                }
            }

        }
        elseif ($rijec == "!black") 
        {
            $uid = $srv->clientGetByName($info["invokername"])->client_unique_identifier;
            $sql = ("SELECT `uid`, `points`  FROM `users` WHERE `uid` = '".$uid."'");
           
           
            if ($result = mysqli_query($con,$sql))
            {
                
                $count = mysqli_num_rows($result);
                $row = mysqli_fetch_assoc($result);


                settype($row["points"], integer);

                $allcoins = $row["points"];


                if($count!=0)
                {
                    $bet = str_replace('!black ','', $info["msg"]);

                    if(is_numeric($bet))
                    {
                         
                        if($bet > $allcoins || $bet = 0)
                        {
                            
                            $srv->clientGetByName($info["invokername"]->toString())->message
                                        ("". $gamble['coins'] ."");
                               
                        }
                        else
                        {

                            if(spin(black))
                            {  
                              
                                $bet1 = str_replace('!black ','', $info["msg"]);
                                
                                $won = $bet1 * $black;

                                $wincoins = $won + $allcoins;
 
                                $sql = "UPDATE users SET points='".$wincoins."' WHERE uid='".$uid."'";

                                if (mysqli_query($con, $sql)) 
                                {
                                    $srv->clientGetByName($info["invokername"]->toString())->message
                                        ("". $gamble['won'] . "" . $wincoins); 
                                }
                                else 
                                {
                                    echo "Error updating record: " . mysqli_error($conn);
                                }     
                            }
                            else
                            {

                                $bet1 = str_replace('!black ','', $info["msg"]);
                                $lost = $allcoins-$bet1;
                              
                                $sql = "UPDATE users SET points='".$lost."' WHERE uid='".$uid."'";
                                if (mysqli_query($con, $sql)) 
                                {
                                 
                                   $srv->clientGetByName($info["invokername"]->toString())->message
                                        ("" . $gamble['lost'] . "" .$lost);
                                }
                                else 
                                {
                                    echo "Error updating record: " . mysqli_error($conn);
                                }   
                            }
                        }
                    }   
                    else
                    {
                        $srv->clientGetByName($info["invokername"]->toString())->message
                                        ("".$gamble['number']."");
                    }

                }
                else
                {
                    $srv->clientGetByName($info["invokername"]->toString())->message
                ("" . $ntr . "");
                }
            }
        }
        elseif ($rijec == "!random")
        {
            
            $uid = $srv->clientGetByName($info["invokername"])->client_unique_identifier;
            $sql = ("SELECT `uid`, `points`  FROM `users` WHERE `uid` = '".$uid."'");
           
           
            if ($result = mysqli_query($con,$sql))
            {
                
                $count = mysqli_num_rows($result);
                $row = mysqli_fetch_assoc($result);


                settype($row["points"], integer);

                $allcoins = $row["points"];


                if($count!=0)
                {
                    $bet = str_replace('!random ','', $info["msg"]);

                    if(is_numeric($bet))
                    {
                         
                        if($bet > $allcoins || $bet = 0)
                        {
                            
                             $srv->clientGetByName($info["invokername"]->toString())->message
                                        ("". $gamble['coins'] ."");
                               
                               
                        }
                        else
                        {   


                            $color = "random";
                            if($color=="random")
                            {
                                
                                $myrand = rand(1,2);

                                $color = "black";

                                if($myrand==2)
                                {
                                  $color = "red";
                                }
                            }

                            if(spin($color))
                            {  
                              
                                $bet1 = str_replace('!random ','', $info["msg"]);
                                
                                $won = $bet1 * $random;

                                $wincoins = $won + $allcoins;

                               
 
                                $sql = "UPDATE users SET points='".$wincoins."' WHERE uid='".$uid."'";

                                if (mysqli_query($con, $sql)) 
                                {
                                   
                                     $srv->clientGetByName($info["invokername"]->toString())->message
                                        ("". $gamble['won'] . "" . $wincoins); 
                                }
                                else 
                                {
                                    echo "Error updating record: " . mysqli_error($conn);
                                }     
                            }
                            else
                            {

                                $bet1 = str_replace('!random ','', $info["msg"]);
                                $lost = $allcoins-$bet1;
                                
                                $sql = "UPDATE users SET points='".$lost."' WHERE uid='".$uid."'";
                                if (mysqli_query($con, $sql)) 
                                {
                                    
                                      $srv->clientGetByName($info["invokername"]->toString())->message
                                        ("" . $gamble['lost'] . "" .$lost);
                                }
                                else 
                                {
                                    echo "Error updating record: " . mysqli_error($conn);
                                }   
                            }
                        }
                    }   
                    else
                    {
                        $srv->clientGetByName($info["invokername"]->toString())->message
                                        ("".$gamble['number']."");
                    }

                }
                else
                {
                    $srv->clientGetByName($info["invokername"]->toString())->message
                    ("" . $ntr . "");
                }
            }
        }
        elseif ($rijec == "!green")
        {
            $uid = $srv->clientGetByName($info["invokername"])->client_unique_identifier;
            $sql = ("SELECT `uid`, `points`  FROM `users` WHERE `uid` = '".$uid."'");
           
           
            if ($result = mysqli_query($con,$sql))
            {
                
                $count = mysqli_num_rows($result);
                $row = mysqli_fetch_assoc($result);


                settype($row["points"], integer);

                $allcoins = $row["points"];


                if($count!=0)
                {
                    $bet = str_replace('!green ','', $info["msg"]);

                    if(is_numeric($bet))
                    {
                         
                        if($bet > $allcoins || $bet = 0)
                        {
                            
                            $srv->clientGetByName($info["invokername"]->toString())->message
                                        ("".$gamble['coins']."");
                               
                        }
                        else
                        {   
                            if(spin(green))
                            {  
                              
                                $bet1 = str_replace('!green ','', $info["msg"]);
                                
                                $won = $bet1 * $green;

                                $wincoins = $won + $allcoins;
 
                                $sql = "UPDATE users SET points='".$wincoins."' WHERE uid='".$uid."'";

                                if (mysqli_query($con, $sql)) 
                                {
                                    
                                     $srv->clientGetByName($info["invokername"]->toString())->message
                                        ("". $gamble['won'] . "" . $wincoins); 
                                }                               
                                else 
                                {
                                    echo "Error updating record: " . mysqli_error($conn);
                                }     
                            }
                            else
                            {
                                $bet1 = str_replace('!green ','', $info["msg"]);
                                $lost = $allcoins-$bet1;
                                
                                $sql = "UPDATE users SET points='".$lost."' WHERE uid='".$uid."'";
                                if (mysqli_query($con, $sql)) 
                                {
                                    
                                    $srv->clientGetByName($info["invokername"]->toString())->message
                                        ("" . $gamble['lost'] . "" .$lost);
                                }
                                else 
                                {
                                    echo "Error updating record: " . mysqli_error($conn);
                                }   
                            }
                        }
                    }   
                    else
                    {
                       $srv->clientGetByName($info["invokername"]->toString())->message
                                        ("".$gamble['number']."");
                    }
                }
                else
                {
                     $srv->clientGetByName($info["invokername"]->toString())->message
                        ("" . $ntr . "");
                }
            }
        }
        else
        {
            $srv->clientGetByName($info["invokername"]->toString())->message("". $uc ."");  
        }
    }     
}

?>
