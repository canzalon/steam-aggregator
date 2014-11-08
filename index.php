<?php require_once("header.php"); ?>

	<body>
		<div class="container-fluid">

			<!-- Spacer --> 
			<div class="row-fluid">
				<div class="span12"></div>
				<div class="span12"></div>
			</div>

			<!-- Steam ID input -->
			<div class="row-fluid">
				<div class="span4"></div>
					<div class="span4">
						<form action="config.php" method="POST">
						  <fieldset>
						    <legend>Steam Aggregator</legend>
						    <label>Enter Steam ID:</label>
						    <input type="text" placeholder="Type something…" name="steamid">
						    <div style="clear:both">
						    <button type="submit" class="btn">Submit</button>
						  </fieldset>
						</form>
					</div>
				<div class="span4"></div>
			</div>
		</div>
	</body>

</html>