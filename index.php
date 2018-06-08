<?php
require_once('./LinkShrink.php');
if (!empty($_POST['website_url']) && !empty($_POST['campaign_source']) && !empty($_POST['campaign_medium'])) {
	$ls = new LinkShrink();
	$urls = $ls->shrinkUrls($_POST['website_url'], $_POST['campaign_source'], $_POST['campaign_medium'], $_POST['campaign_name'], $_POST['campaign_term'], $_POST['campaign_content'], $_POST['custom_link']);
//print_r($urls);
}
?>
<!DOCTYPE HTML>
<html>
	<head>
	<style>
	body {
	@import url('https://fonts.googleapis.com/css?family=Overpass+Mono');
	font-family: 'Overpass Mono', monospace;
	font-size: 1.8em;
	background-color: #1A1B1C;
        color: #FFFFFF;
	}
	label {
	width: 500px; 
	display:block;
        margin-left: auto;
        margin-right: auto;
	}
	.center {
    	display: block;
    	margin-left: auto;
    	margin-right: auto;
	}
	input {
	width: 500px;
	height: 50px;
	border: 5px solid #939699;
	display: block;
        margin-left: auto;
        margin-right: auto;
	font-size: 0.9em;
	}
	textarea {
        width: 500px;
        height: 100px;
        border: 5px solid #939699;
        display: block;
        margin-left: auto;
        margin-right: auto;
        font-size: 0.9em;
	resize: none;
        }
	textarea#short_link {
        height: 500px;
	}
	textarea#custom_link {
        height: 50px;
        }
	.button {	
	 -webkit-transition-duration: 0.2s;
  	 transition-duration: 0.2s;
	 background-color: #FFFFFF;
	 color: #000000;
	 border: 10px solid #65B32E;
         font-family: 'Overpass Mono', monospace;
	 font-size: 1.1em;
	 height: 100px;
	}

	.button:hover {
    	background-color: #65B32E;
    	color: #FFFFFF;
	} 
	</style>
	</head>
	<body>
		<img src="images/scissor-logo.gif" class="center" alt="7val-URL-Shortener" width="1000" />
		<br>
		<form name="" method="POST" >
		<label for="website_url">Website URL</label> <textarea  name="website_url" id="website_url"></textarea><br />
		<label for="campaign_source">Campaign Source</label> <input type="text" name="campaign_source" id="campaign_source" /><br />
		<label for="campaign_medium">Campaign Medium</label> <input type="text" name="campaign_medium" id="campaign_medium" /><br />
		<label for="campaign_name">Campaign Name</label> <input type="text" name="campaign_name" id="campaign_name" /><br />
		<label for="campaign_term">Campaign Term</label> <input type="text" name="campaign_term" id="campaign_term" /><br />
		<label for="campaign_content">Campaign Content</label> <input type="text" name="campaign_content" id="campaign_content" /><br />
		
		<label for="custom_link">Custom-Link</label> <textarea  name="custom_link" id="custom_link" ></textarea><br />
		<br>
		<label for="button"></label> <input type="submit" class="button"  value="Short-Links erstellen" id="submit" />
		<br>
		<label for="short_link">Short-Links</label> <textarea  name="short_link" id="short_link" ><?php if (!empty($urls)) { foreach ($urls as $urlArray) { echo $urlArray['shorturl']."\n\n"; }} ?></textarea><br />
		<br>
		</form>
	</body>
	<footer>
		<img src="images/Woodhack-Logo-transparent.png" width="200px" class="center"  alt="Woodhack"/>
		<br>
		<center>A Woodhack Project
		by Maik &  Alex</center>
	</footer>
</html>
