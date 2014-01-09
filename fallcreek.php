<?php
/**
 * Application project for Web Development in Fall Creek, OR
 *
 * Requirements:
 * 1. Setup a small PHP application that echos the page
 *    generation time and how much memory it took to generate
 *    (demonstrates PHP skills - bonus points for using
 *     ZF2/Symfony).
 * 2. Create a 'live clock' on the page using javascript
 *    (demonstrates simple javascript usage - bonus points for
 *    using jQuery written yourself, no cheating with using
 *    someone else's plugin!).
 * 3. Put a picture of a cute animal, or bacon, somewhere on
 *    the page (demonstrates simple HTML/CSS - bacon is tasty,
 *    bonus points for making the bacon draggable and have it
 *    disappear when dropped on the animal. An 'om nom nom'
 *    alert would be nice too). 
 *
 * @author Samuel Raynor <samuel@samuelraynor.com>
 */
 
 // Save the current time for figuring page generation time.
 $page_start = microtime(true);
 
 // Use output buffering so we can generate the entire page
 ob_start();
 
 // I hate starting new lines... 
 ?><!DOCTYPE html>
 <html lang="en">
	<head>
		<meta charset="utf-8">
		<title>Fall Creek Application Project</title>
		
		<link rel="stylesheet" href="bootstrap/css/bootstrap.css">
		<link rel="stylesheet" href="bootstrap/css/bootstrap-theme.css">
		
		<link rel="stylesheet" href="//code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css">
		
		<style type="text/css">
			.stats {
				text-align: center;
				font-size: 10pt;
			}
			
			/* Bacon Game */
			.game_container {
				position: relative;
				width: 300px;
				height: 300px;
				border: 1px solid black;
				margin: 0 auto;
				padding: 10px;
			}
			
			.game_container .bacon {
				position: absolute;
				width: 100px;
				height: 100px;
				
				background-image: url("bacon.png");
			}
			
			.game_container .dog {
				position: absolute;
				width: 100px;
				height: 113px;
				
				background-image: url("dog.png");
			}
			
			.game_container .message {
				display: none;
				text-align: center;
				font-size: 20px;
				font-family: Arial, Sans, sans-serif;
			}
			.game_container .instructions {
				font-size: 20px;
				text-align: center;
				font-family: Arial, Sans, sans-serif;
			}
			.live_clock {
				position: relative;
				width: 250px;
				
				margin: 10px auto;
				border: 1px solid black;
			}
			
			.live_clock span {
				display: block;
				text-align: center;
				padding: 4px;
			}
				
		</style>
		
		<script type="text/javascript" src="//code.jquery.com/jquery-1.9.1.js"></script>
		<script type="text/javascript" src="//code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
		
		<script type="text/javascript" src="bootstrap/js/bootstrap.js"></script>
		
		<script type="text/javascript">
			$(function() {
				// Start live clock
				setInterval(function() {
					var d = new Date();
					
					$(".live_clock .live_time").html(d.toLocaleTimeString());
				}, 1000);
				
				// Bacon Game
				//$("#bacon_game").css();
				$("#bacon_game .bacon").css({ top : "75px", left : "10px", "z-index": "10"}).draggable({ containment: "parent", revert: "valid" });
				$("#bacon_game .dog").css({ top: "175px", left: "175px", "z-index": "5"}).droppable({
					drop: function( event, ui ) {
						$(".game_container .bacon").hide();
						$(".game_container .message").show();
					}
				});
			});
		</script>
		
		<script>
			(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
			(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
			m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
			})(window,document,'script','//www.google-analytics.com/analytics.js','ga');

			ga('create', 'UA-45512702-1', 'samuelraynor.com');
			ga('send', 'pageview');
		</script>
	</head>
	<body>
		<div class="container">
			<p class="live_clock"><span class="live_title">Live Clock</span><span class="live_time">Loading...</span></p>
			<div id="bacon_game" class="game_container">
				<p class="instructions">Cute dog says, "I'm hungry! Please, feed me the bacon."<br>Drag the bacon to the dog</p>
				<div class="message">om nom nom!</div>
				<div class="bacon"></div>
				<div class="dog"></div>
			</div>
			<p class="stats"><span class="page_gen">Page generated in {%page_gen} seconds.</span>
			<span class="mem_usage">Memory Usage: {%mem_usage} MiB.</span></p>
		</div>
	</body>
</html>
<?php
	// Capture the page content in a variable.
	$content = ob_get_contents();
	ob_end_clean();
	
	// Stop the clock!
	$page_end = microtime(true);
	
	// Figure time
	$page_time = number_format($page_end - $page_start, 6);
	
	// Get memory usage
	// memory_get_usage returns bytes. 1068576 = 1MiB
	$mem_usage = number_format(memory_get_usage()/1068756, 4);
	
	// Add in the page time and memory usage.
	$content = str_replace(array("{%page_gen}","{%mem_usage}"), 
							array($page_time, $mem_usage),
							$content);
							
	// Out put page to client
	echo $content;
	
	// Done!
