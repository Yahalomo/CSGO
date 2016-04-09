<?php

@include_once('set.php');
$loggedin = false;


require('steamauth/steamauth.php');

if(isset($_SESSION["steamid"])) {
    $loggedin = true;
    include_once('steamauth/userInfo.php');
    if(!fetchinfo('id', 'users', 'steamid', $_SESSION["steamid"])){
        if(!isset($_COOKIE['tour'])){
            setcookie("tour", true, 2147483647);
        }
        mysql_query("INSERT users (`name`,`img`,`steamid`, `clst`) VALUES ('".$steamprofile['personaname']."', '".$steamprofile['avatarfull']."', '".$_SESSION["steamid"]."', '".generateCLST()."')");
    } else {
        $clst = generateCLST();
        mysql_query("UPDATE users SET name='".$steamprofile['personaname']."', img='".$steamprofile['avatarfull']."', clst='".$clst."' WHERE steamid='".$_SESSION["steamid"]."'");
		$tradelink = fetchinfo('tradelink', 'users', 'steamid', $_SESSION["steamid"]);
        $token = substr($tradelink, -8);
        $tradelinkid = substr(substr($tradelink, 0, -15), 51);
        //echo $tradelinkid;
        $owner = fetchinfo('id', 'users', 'steamid', $_SESSION["steamid"]);
        
        $steamid3 = convertid($_SESSION["steamid"]);
        $img = fetchinfo('img', 'users', 'steamid', $_SESSION["steamid"]);
        //if($token !='nolink' && $steamid3 != $tradelinkid){
        //    Header("Location: uwotm8.php");
        //    exit;
        //}
	}

}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>CSLobby.net</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
	<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="css/style49.css">
    <script src="https://cdn.socket.io/socket.io-1.3.7.js"></script>
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
	<link rel="stylesheet" href="scrollbar/jquery.mCustomScrollbar.css" />
	<link rel="stylesheet" type="text/css" href="css/bootstrap1.css">
    <link rel="stylesheet" href="css/avgrund.css">
	<script src = "js/bootstrap.js"></script>
	<link rel="stylesheet" href="css/main121.css">
	<link rel="stylesheet" href="css/flipclock.css">
	<!-- Yandex.Metrika counter -->
<script type="text/javascript">
    (function (d, w, c) {
        (w[c] = w[c] || []).push(function() {
            try {
                w.yaCounter34433315 = new Ya.Metrika({
                    id:34433315,
                    clickmap:true,
                    trackLinks:true,
                    accurateTrackBounce:true
                });
            } catch(e) { }
        });

        var n = d.getElementsByTagName("script")[0],
            s = d.createElement("script"),
            f = function () { n.parentNode.insertBefore(s, n); };
        s.type = "text/javascript";
        s.async = true;
        s.src = "https://mc.yandex.ru/metrika/watch.js";

        if (w.opera == "[object Opera]") {
            d.addEventListener("DOMContentLoaded", f, false);
        } else { f(); }
    })(document, window, "yandex_metrika_callbacks");
</script>
<noscript><div><img src="https://mc.yandex.ru/watch/34433315" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
<!-- /Yandex.Metrika counter -->

</head>
<body>
<script src="js/notie.js"></script>
<script src="js/avgrund/jquery.avgrund.min.js"></script>


<!-- HEADER -->

		<div class="header">
			<div class="logo"></div>
			<div class="menu">
				<ul>
					<a href="#"><li id="avgrund">Jackpot</li></a>
					<a href="#"><li>Market</li></a>
					<a href="#"><li>Trades</li></a>
					<a href="#"><li>Bets</li></a>
					<a href="http://steamcommunity.com/groups/cslobbynet/discussions/0/451850213948967975/" target="_blank"><li>Support</li></a>
				</ul>
			</div>
            
            <?php
								if($loggedin){
									$ava = $steamprofile['avatar'];
									$nick = $steamprofile['personaname'];
									$steamid = $steamprofile['steamid'];
                                    $steamidnew = str_replace("76", "", $steamid);
                                    echo "<input id='steamid' type='hidden' value='".$_SESSION["steamid"]."'>";
                                    echo "<input id='clst' type='hidden' value='".$clst."'>";
                                    echo "<input id='token' type='hidden' value='".$token."'>";
                                    echo "<input id='owner' type='hidden' value='".$owner."'>";
                                    echo "<input id='img' type='hidden' value='".$img."'>";
                                    echo "<input id='nickname' type='hidden' value='".$steamprofile['personaname']."'>";
                                    echo "<script>steamidnew = ".$steamidnew.";</script>";

									echo '<div class="user" onclick="showmenu()">
                                            <img class="avatar" src="'.$ava.'" alt="">
                                            <i class="material-icons icon-list">&#xE896;</i>
                                            <div class="username">'.$nick.'</div>
                                        </div>';
								} else {
									steamlogin();
									
									echo '<div class="plug">
                                        <p>CSLOBBY.NET</p>
                                        <div class="plug-block">
                                            <div class="age">
                                                <input type="checkbox" name="checkboxG6" id="checkboxG6" class="css-checkbox" /><label for="checkboxG6" class="css-label">I am at least 18 years old and have read & agree with ToS.</label>
                                                <div class="logon-button"><a href="?login" style="text-decoration:none;color:inherit;">Sign In With Steam</a></div>
                                                </div>
                                        </div>
                                    </div>';
								}
								 ?>
			
		</div>
<div class="menu-list hidden">
    <ul>
        <li id="settings">Settings</li>
        <li><a href="steamauth/logout.php" style="text-decoration:none;color:inherit;">Log Out</a></li>
    </ul>
</div>
<aside></aside>

<!-- BOOTSTRAP -->

<div class="container-fluid">

	<div class="row">
		<div class="visible-lg-block col-lg-2 chat">
			<div class="chat-padding">

			<ul class="input-list style-4 clearfix">
          <li>
            <input id="chat-input" type="text" placeholder=" Chat">
          </li>
        </ul>
			</div>
			<div class="messages-block">
                <span id="messages">
				
				</span>
			</div>
		</div>
		<div class="col-lg-10 wrapper">
            <div class="content">
			<div class="container-fluid">
				<div class="row">
					<div class="col-lg-12 main">
						<div class="wheel">
                           <div id="timer" class="clock" style="margin:35%;"></div>
	
                            
						        <svg height="0" width="0">
        <clipPath id="c1" clipPathUnits="objectBoundingBox">
            <rect x="0" y="0" rx="0.5" ry="0.5" width="1" height="1"/>
        </clipPath>
    </svg>
    <svg id='svg' class="svg" height="250" width="250"></svg>
                    <div class="wheel-arrow" style="display:none;"></div>
						</div>
												<div class="gui">
							<div class="sprite1"></div>
							<div class="bar">
                                <div class="progress" style="height:inherit;border-radius:0px;background-color:#2e2e2e;box-shadow : 0px 2px 20px rgba(0, 0, 0, 0.6) inset;">
                                    <style>.progress-bar-warning{background-color:#D6B92E;}</style>
                                  <div id="stripe" class="progress-bar progress-bar-warning progress-bar-striped active" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width:<? echo fetchinfo('value', 'info_pool1', 'info', 'amount')*10/3;?>%;">
                                    <div class="count"><? echo fetchinfo('value', 'info_pool1', 'info', 'amount');?>/30</div>
                                  </div>
                                </div>
								
							</div>
							<div class="bank">
								<p>Bank</p>
								<span class="bank-s"><? echo fetchinfo('value', 'info_pool1', 'info', 'tickets')/100; ?>$</span>
							</div>
							<div class="add" onclick="addItems();">+</div>
                            <? 
                                $maxwin = fetchinfo("value", "info_pool1", "info", "max")/100;
                                echo '<script>var maxwin = '.$maxwin.';</script>'; ?>
							<div class="max-win">
                                
								<p>Biggest pot</p>
								<span class="max-win-s"><? echo $maxwin; ?>$</span>
							</div>
							<div class="sprite2"></div>
						</div>
						<div class="info">
								<span class="game">
									<p>Game: </p>
									<span class="gamenum"><? echo fetchinfo('value', 'info_pool1', 'info', 'currentgame'); ?></span>
								</span>
								<span class="put">
									<p>You put: </p>
									<span class="youput"><? @include_once('amount.php'); ?>$</span>
								</span>
								<span class="chance">
									<p>Chance: </p>
									<span class="yourchance"><? @include_once('chance.php'); ?>%</span>
								</span>
						</div>
					</div>
				</div>

					<div class="row">
						<div class="hidden-xs col-lg-12 item-list">
							<div class="lol1"><div class="arrow-bg1" onclick="move_left()"><div class="arrow1"></div></div></div>
							<div class="item-icons-block">
								<div class="showed-items">
                                    <div class="item-icons">
                                            <? @include_once('items.php'); ?>
                                    </div>
								</div>
							</div>
							<div class="lol">
							<div class="arrow-bg2" onclick="move_right()"><div class="arrow2"></div></div>
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-lg-5 deposits">
							<div class="dep-block">
								<p>POOL DEPOSITS</p>
								<div class="block"></div>
								<div class="game-deposits-block">
									<span id="deps">
                                    <ul>
										<? @include_once('deposits.php'); ?>
									</ul>
                                    </span>
								</div>
							</div>
						</div>

					<div class="col-lg-7 inventory">
						<div class="inv-block">
							<p>INVENTORY</p>
							<div class="item-block">
                                <span id="inv">
								<ul>
                                    
                                    <?
                                    @include('inventory.php');
                                    ?>
									
									<li style='visibility:hidden'></li>
									<li style='visibility:hidden'></li>
									<li style='visibility:hidden'></li>
									<li style='visibility:hidden'></li>
									<li style='visibility:hidden'></li>
									<li style='visibility:hidden'></li>
									<li style='visibility:hidden'></li>
								</ul>
                                </span>
							</div>
						</div>

						<div class="button-inv-block">
                            <span id="deposit-on-site-button"><div class="deposit-on-site-button" onclick="blablabla;">ADD MORE</div></span>
							<span id="withdraw-button"><div class="withdraw-button" onclick="withdrawal();">WITHDRAW</div></span>
						</div>

					</div>
				</div>

			</div>
		</div>
        </div>
	</div>

</div>



<script src="scrollbar/jquery.mCustomScrollbar.concat.min.js"></script>

<style>
.custom {
    background:#333;
    border: 1px solid #ffe66d;
    color: #ffe66d;
}
</style>
<script>
    (function($){
        $(window).load(function(){
            $('#settings').avgrund({
                height: 175,
                showClose: true,
                showCloseText: 'X',
                enableStackAnimation: true,
                holderClass: 'custom',
                template: '<br><p>You can update your tradelink below: </p>' +
                '<div class="style-4"><form action="./updatelink.php" method="get"><input name="steamid" type="hidden" value="'+steamid+'"><input name="link" id="tradelink" type="text"><br><input type="submit" class="btn btn-success" style="margin-top:30px;width: 100px;margin-left:35%;" value="Save!"></form></div>'
            });
            $('#faircheck').avgrund({
                height: 1000,
                width: 700,
                showClose: true,
                showCloseText: 'X',
                enableStackAnimation: true,
                holderClass: 'custom',
                template: '<div class="style-4"><form action="checkgame();" method="get">'+
						'	<input id="roundhash" type="text" placeholder="ROUND_HASH">'+
						'	<input id="winningnum" type="text" placeholder="WINNING_NUM">'+
						'	<input id="totaltickets" type="text" placeholder="TOTAL_TICKETS">'+
						'	<input id="winningticket" type="text" placeholder="WINNING_TICKET">'+
						'</form></div>'+
						'<br><a href="javascript:void(0)" onclick="checkgame();" style="text-decoration: none; color: inherit;"><button type="button" class="btn btn-success" style="width: 100px;">Check!</button></a>'+
						'<br><b><span id="result"></span></b>'+
						'<br><b>Please note, that'+
						' results of fair play check does not depends on your connection to our db, so to prove'+
						'we are not rigging any results, you can unplug you ethernet cable or just turn off you'+
						'wi-fi connection, enter data and press check. You will get positive or negative result'+
						'depends on if entered WINNING_NUM equals obtained one.</b>'
            });
            $(".game-deposits-block").mCustomScrollbar();
            $(".item-block").mCustomScrollbar();
            $(".messages-block").mCustomScrollbar();
            $('#deposit-on-site-button').html('<div class=\'deposit-on-site-button\' onclick=\'loadInvItems('+steamidnew+');\'>ADD MORE</div>');
            setInterval(function(){
            	if(window.innerWidth <= 1200){
            		//console.log(window.innerWidth);
            		$(".content").mCustomScrollbar({theme:"rounded-dark", autoHideScrollbar: true});
                    $('.max-win').html('<p>Your chance</p><span class="max-win-s">'+$('.yourchance').html()+'</span>');
            	}else{
            		if(window.innerWidth > 1200){	
            		$(".content").mCustomScrollbar("destroy");
            	}
                if(window.innerWidth > 1870){
                    $('.max-win').html('<p>Biggest pot</p><span class="max-win-s">'+maxwin+'$</span>');
                } else{
                    $('.max-win').html('<p>Your chance</p><span class="max-win-s">'+$('.yourchance').html()+'</span>');
                }
            }},500);
        });
    })(jQuery);
</script>
<script src="js/snap.svg.js"></script>
<script type="text/javascript" src="js/main47.js"></script>
<script type="text/javascript" src="js/wheel3.js"></script>
<script src="js/flipclock.js"></script>	

</body>
</html>