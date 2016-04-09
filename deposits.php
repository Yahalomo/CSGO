<?
@include_once('set.php');
$rss = mysql_query("SELECT * FROM `pool1` ORDER BY `id` DESC LIMIT 50") or die(logmysqlerror(mysql_error()));
	while($row = mysql_fetch_array($rss)) {
		$counter++;
		$name = $row['name']." ";
		$img = $row['img'];
		$color = $row['color'];
		$amount = $row['amount'];
		$amounttext = $amount." skin";
		if($amount > 1) $amounttext = $amount." skins";
		$summ = $row['tickets']/100;
		$type = $row['type'];
		if($type > 0){
			$num = $row['num'];
			$hash = $row['hash'];
			$winticket = $row['winticket'];
			$ticketsamount = $summ*100;

			echo '<li class="game-info-block">
					<span class="hash">New round hash is <font color="#9ec16c">'.$hash.'</font></span><br>
					<span class="winner-info">
					<span class="winner-name">'.$name.'</span> 
					won <font color="#9ec16c">'.$summ.'$</font> with ticket <font color="#9ec16c">'.$winticket.'</font> out of <font color="#9ec16c">'.$ticketsamount.'</font> using <font color="#9ec16c">'.$num.'.</font> <i><a id="faircheck" href="javascript:void(0)" style="color: inherit;" onclick="faircheck(\''.md5($num).'\', '.$num.', '.$winticket.', '.$ticketsamount.');">Check!</a></i></span>
				  </li>';
		} else {
			echo '<li><img src="'.$img.'" alt=""> 
				<p>'.$name.'</p> 
				<span class="user-dep-info">Deposited '.$amounttext.'</span> 
				<span class="price-bet1">'.$summ.'$</span></li>';
		}
	}
    
?>