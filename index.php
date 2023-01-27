<?php

$channel_data = "";
$channel_url = "";
$chatters = [];
$known_bots = [];
$total_chatters = 0;
$total_chatters_last = 0;

$refresh_time = (!empty($_GET['refresh_time'])) 
	? intval(substr($_GET['refresh_time'], 0, 11))
	: 10;

$bg_color = (!empty($_GET['bg_color'])) 
	? substr($_GET['bg_color'], 0, 6) 
	: "2c2e38";

$text_color = (!empty($_GET['text_color'])) 
	? substr($_GET['text_color'], 0, 6) 
	: "ffffff";

$disable_beep = (!empty($_GET['disable_beep']))
	? true
	: false;

$known_bots = (is_file("bots.txt")) 
	? explode("\n", file_get_contents("bots.txt"))
	: [];
	
session_start();

if (empty($_GET['channel']))
	die("Missing 'channel' attribute");

$channel_url = "https://tmi.twitch.tv/group/user/{$_GET['channel']}/chatters";

$channel_data = file_get_contents($channel_url);

if (empty($channel_data))
	die('Cannot connect to Twitch!');

$channel_data = json_decode($channel_data);

if (empty($channel_data -> chatters))
	die('Cannot obtain chatters data from Twitch!');

foreach (["broadcaster", "vips", "moderators", "staff", "admins", "global_mods", "viewers"] as $group)
	if (!empty($channel_data -> chatters -> $group))
		foreach ($channel_data -> chatters -> $group as $chatter)
			if (!in_array($chatter, $chatters))
				if (!in_array($chatter, $known_bots))
					$chatters[] = "<a href=\"https://twitch.tv/{$chatter}\" target=\"_blank\" style=\"color: #815fc0\">{$chatter}</a>";

sort($chatters);

$total_chatters = intval(count($chatters));

$total_chatters_last = (!empty($_SESSION['twitch-chatters']))
	? intval(count($_SESSION['twitch-chatters']))
	: 0;

$_SESSION['twitch-chatters'] = $chatters;

?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta http-equiv="refresh" content="<?=$refresh_time?>">
		<title><?=$_GET['channel']?> - Twitch Chatters</title>
		<style>
			body 
			{
				background-color: #<?=$bg_color?>; 
				padding: 5px; 
				font-family: Verdana; 
				font-size: 12px; 
				line-height: 14px;
				color: #<?=$text_color?>; 
			}
			a 
			{
				color: #ccc; 
				text-decoration: none;
			}
				a:hover 
				{
					text-decoration: underline;
				}
			.no-select 
			{
				-webkit-user-select: none; 
				-ms-user-select: none; 
				user-select: none;
			}
		</style>
	</head>
	<body>
		<?php if (!$disable_beep and $total_chatters > $total_chatters_last): ?>
			<audio autoplay>
				<source src="pop-in.mp3" type="audio/mpeg">
			</audio>
		<?php elseif (!$disable_beep and $total_chatters > $total_chatters_last): ?>
			<audio autoplay>
				<source src="pop-out.mp3" type="audio/mpeg">
			</audio>
		<?php endif ?>
		<p style="margin: 0 0 10px 0">
			<strong class="no-select">
				<svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24">
					<path fill="#815fc0" d="M2.149 0l-1.612 4.119v16.836h5.731v3.045h3.224l3.045-3.045h4.657l6.269-6.269v-14.686h-21.314zm19.164 13.612l-3.582 3.582h-5.731l-3.045 3.045v-3.045h-4.836v-15.045h17.194v11.463zm-3.582-7.343v6.262h-2.149v-6.262h2.149zm-5.731 0v6.262h-2.149v-6.262h2.149z" fill-rule="evenodd" clip-rule="evenodd"/>
				</svg> 
				<?=$total_chatters?> 
				<?php if ($total_chatters_last > 0 and $total_chatters_last != $total_chatters): ?>
					(<?=($total_chatters_last > $total_chatters) ? "<span style=\"color: red\">-" . abs($total_chatters - $total_chatters_last) . "</span>" : "<span style=\"color: green\">+" . abs($total_chatters - $total_chatters_last) . "</span>"?>)
				<?php endif ?> 
				chatters watching <a href="https://twitch.tv/<?=$_GET['channel']?>" target="_blank"><?=$_GET['channel']?></a>
			</strong>
		</p>
		<?=(!empty($chatters)) ? implode("<br>", $chatters) : "<span style=\"color: orange\">Nobody found!</span>"?>
	</body>
</html>
