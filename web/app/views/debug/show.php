<?php
	use DebugBar\StandardDebugBar;

	$debugbar = new StandardDebugBar();
	$debugbarRenderer = $debugbar->getJavascriptRenderer();
?>
<html>
	<head>
	    <?php echo $debugbarRenderer->renderHead() ?>
	</head>
	<body>
		<h1>
			Debug Mode
		</h1>
		<p> 
			... Use the debug bar below to see what happened during the last request.
		</p>
	    
	    <?php echo $debugbarRenderer->render() ?>
	</body>
</html>