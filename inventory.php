<? @include_once('set.php');
    $token = substr(fetchinfo('tradelink', 'users', 'steamid', $_GET['steamid']), -8);
    $owner = fetchinfo('id', 'users', 'steamid', $_GET['steamid']);
    $clst = fetchinfo('clst', 'users', 'steamid', $_GET['steamid']);
    $steamidnew = str_replace("76", "", $_GET['steamid']);
    
    $rs = mysql_query("SELECT * FROM items WHERE owner ='".$owner."' AND status='0'");
    $counter = 0;
    
    while($row = mysql_fetch_array($rs)) {
        $counter++;
		$id = $row['assetid'];
		$cid = $row['classid'];
        $iid = $row['instanceid'];
        $price = $row['price'];
        $itemname = $row['name'];
        $key = $cid."_".$iid;
        $img = $row['img'];
        if(stristr($itemname, 'Sticker') == NULL && stristr($itemname, 'Case') == NULL) {
            echo '<!--script>$("#invamount").text('.$counter.');</script--><li class="inventory-item-bg" id="'.$id.'" onclick="addWithdraw('.$id.');">
                <img src="http://steamcommunity-a.akamaihd.net/economy/image/'.$img.'/360fx360f">
                <p class="itme-price">'.$price.'$</p>
            </li>';
        } else {
            echo '<!--script>$("#invamount").text('.$counter.');</script--><li class="inventory-item-bg" id="'.$id.'" onclick="addWithdraw('.$id.');">
                <img src="http://steamcommunity-a.akamaihd.net/economy/image/'.$img.'" style="margin-top:0px;margin-left: -7px;height: 65px; width: 80px;">
                <p class="itme-price">'.$price.'$</p>
            </li>';
        }
        
    }
	echo '<script>counter = '.$counter.'</script>';

?>