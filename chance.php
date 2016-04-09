<?
@include_once('set.php');
@include_once('steamauth/steamauth.php');

if(isset($_SESSION['steamid'])){
    $owner = fetchinfo('id', 'users', 'steamid', $_SESSION["steamid"]);
    
    $game = fetchinfo('value', 'info_pool1', 'info', 'currentgame');
    $bank = fetchinfo('value', 'info_pool1', 'info', 'tickets');

    $rs = mysql_query("SELECT * FROM pool1 WHERE playerid ='".$owner."' AND game = '".$game."'");
    
    $tickets = 0;
    
    while($row = mysql_fetch_array($rs)) {
        $tickets += $row['tickets'];
        
    }
    echo round($tickets/$bank*100, 2);
} else echo '0';