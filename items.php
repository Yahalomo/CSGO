<?
@include_once('set.php');
$rs = mysql_query("SELECT * FROM items_pool1 ORDER BY price DESC");
while($row = mysql_fetch_array($rs)) {
	$itemimg = $row['img'];
	$itemname = $row['name'];
	$itemprice = $row['price'];
	$itemcolor = $row['color'];	
	if(stristr($itemname, 'Sticker') == NULL && stristr($itemname, 'Case') == NULL) {
        echo '<li id="cell"><img src="http://steamcommunity-a.akamaihd.net/economy/image/'.$itemimg.'/360fx360f"><p>'.$itemprice.'$</p></li>';
    } else {
        echo '<li id="cell"><img src="http://steamcommunity-a.akamaihd.net/economy/image/'.$itemimg.'" style="margin-top:0px;margin-left: -7px;height: 65px; width: 80px;"><p style="margin-top:45px;">'.$itemprice.'$</p></li>';
    }
}
?>