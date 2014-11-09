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
					<!-- tablesorter -->
					<table id="myTable" class="tablesorter">
						<thead>
							<tr>
								<th>Name</th>
								<th>Hours Played</th>
								<th>MetaCritic</th>
								<th>Genre</th>
							</tr>
						</thead>
						<tbody>
							<!-- PHP Produce Rows here <tr> </tr> -->
							<?php
								// DISPLAY GAMELIST
								$total_worth = 0;
								$total_playtime = 0;
								$unplayed_games = 0;

								//Produce row for each game
								foreach ($gameArray as $game)
								{


									echo "<tr>";

									$appid = $game['appid'];
									$appinfo = file_get_contents("http://store.steampowered.com/api/appdetails/?appids=" . $appid . "&filters=metacritic,genres,price_overview");
									$app_json = json_decode($appinfo, true);
									if(isset($app_json[$appid]["data"])){
										$app_data = $app_json[$appid]["data"];
									}

									//Display LOGO
									if($game['img_logo_url']){
										echo "<td>
											<a href=http://store.steampowered.com/app/".$appid.">
											<img class='steam_logo' src='" . "http://media.steampowered.com/steamcommunity/public/images/apps/" . $appid . "/" . $game['img_logo_url'] . ".jpg' />
											</a>
											</td>";
									} else{ echo "<td><a href=http://store.steampowered.com/app/".$appid."><img class='steam_logo' src='img/steam.jpg'/></a></td>"; }
									
									echo " <td>";
									echo $game['name'];
									echo " </td>";


									//Display Playtime
									echo "<td>" . round($game['playtime_forever']/60) . " hour(s)</td>";
									$total_playtime = $total_playtime + $game['playtime_forever']/60;
									if($game['playtime_forever'] == '0') { $unplayed_games++; }

									//Display Metascore
									if(isset($app_data["metacritic"]["url"])){
										echo "<td><a href=". $app_data["metacritic"]["url"] . ">" . $app_data["metacritic"]["score"] . "</a></td>";
									} else{ echo "<td style='color: lightgrey;'>0 or N/A</td>";}

									// Display Genre
									if(isset($app_data["genres"])){
										echo "<td>";
										foreach($app_data["genres"] as $game) {
											echo $game["description"] . "<br>";
										}
										echo "</td>";
									} else{ echo "<td style='color: lightgrey;'>N/A</td>";}

									echo "</tr>";
								}

							?>
						</tbody>
					</table>






					<!-- old -->
					<?php

						$gameArrLength = count($gameArray);

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