<?php require_once ("header.php") ?>
<?php require ("config.php") ?>

	<body>

		<div class="container-fluid">

				<!-- Users -->
				<div class="row-fluid">
					<div class="span12">
						<?php

							echo "<p>";
							echo "<img src=" . $userArray['avatarfull'] . " />";
							echo "ID: " . $userArray['personaname'] . "</p>";
							echo "</p>";

						?>
					</div>
				</div>

				<!-- Filters -->
				<div class="row-fluid">
					<div class="span12">


					</div>
				</div>

				<!-- Results -->
				<div class="container">
					<?php

						$gameArrLength = count($gameArray);

						// for ($x = 0; $x < $gameArrLength; $x++)
						// {
						// 	echo "<div class='row-fluid'>";
						// 	echo "<div class='span2'>";
						// 	echo gameArray[$x]['name'];
						// 	echo "</div>";
						// 	echo "</div>";
						// }

						foreach ($gameArray as $game)
						{
							echo "<div class='row-fluid'>";
							echo "<div class='span2'>";
							echo $game['name'];
							echo "</div>";
							echo "</div>";
						}





					?>

					<!-- Header (let this be model for javascript produced html) -->
					<div class="row-fluid">

						<div class="span2">
							Game
						</div>

						<div class="span2">

						</div>

						<div class="span2">
							
						</div>

						<div class="span2">
							
						</div>

						<div class="span2">
							
						</div>

						<div class="span2">
							
						</div>

					</div>


				</div>

		</div>

	</body>