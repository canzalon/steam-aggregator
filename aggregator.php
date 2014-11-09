<?php require_once ("header.php") ?>
<?php require ("config.php") ?>
<?php $gameArray = doSomeCoolStuff($gameArray); ?>
<body>
	<div class="container-fluid">
		<!-- Spacer -->
		<div class="row-fluid">
			<div class="span12">
			</div>
		</div>
		<!-- Users -->
		<div class="row-fluid">
			<div class="span2"></div>
			<div class="span8 text-center">
				<?php
					echo "<a href='" . $userArray['profileurl'] ."' "
						. "class='btn btn-large btn-inverse disabled'";
						echo "<p>";
						echo "<img src=" . $userArray['avatarfull'] . " />";
						echo "<h1> " . $userArray['personaname'] . "</h1></p>";
					echo "</p></a>";
				?>
			</div>
			<div class="span2"></div>
		</div>
		<!-- Filters -->
		<div class="row-fluid">
			<div class="span3">
				<select multiple>
					<option value="volvo">Volvo</option>
					<option value="saab">Saab</option>
					<option value="opel">Opel</option>
					<option value="audi">Audi</option>
				</select>
			</div>
			<div class="span3"></div>
			<div class="span3"></div>
			<div class="span3"></div>
		</div>
		<!-- Results -->
		<div class="container">
			<!-- tablesorter -->
			<table id="myTable" class="tablesorter">
				<thead>
					<tr>
						<th>App ID</th>
						<th></th>
						<th>Name</th>
						<th>Hours Played</th>
						<th>MetaCritic</th>
						<th>Genre</th>
						<th>Avg Playtime</th>
					</tr>
				</thead>
				<tbody>
					<!-- PHP Produce Rows here <tr> </tr> -->
					<?php
						// DISPLAY GAMELIST
						$total_worth = 0;
						$total_playtime = 0;
						$unplayed_games = 0;
						$current_genre = 0;
						$genres_existing = array();
						$genre_switch = true; //assume true until proven otherwise
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
								//Display AppID
								echo "<td>" . $appid . "</td>";
								//Display LOGO
								if($game['img_logo_url']){
									echo "<td>
											<a href=http://store.steampowered.com/app/".$appid.">
												<img class='steam_logo' src='" . "http://media.steampowered.com/steamcommunity/public/images/apps/" . $appid . "/" . $game['img_logo_url'] . ".jpg' />
											</a>
										</td>";
								} else{ echo "<td><a href=http://store.steampowered.com/app/".$appid."><img class='steam_logo' src='img/steam.jpg'/></a></td>"; }
								
								echo " <td>";
									echo $game["name"];
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
										foreach($app_data["genres"] as $item) {
											echo $item["description"] . "<br>";
											//Populate array of Genres for dropdown select
											foreach($genres_existing as $existing){
												if ($item["description"] == $existing)
												{
													// $existing = $item["description"];
													$genre_switch = false;
												}
											}
											if ($genre_switch == true) //if true, no match so add to array
											{
												//add to genres existing
												$genres_existing = $item["description"];
												array_push($genres_existing, $item["description"]); //pushes to genres_existing array
											}
											//set switch back to true for next iteration
											$genre_switch = true;
										}
									echo "</td>";
								} else{ echo "<td style='color: lightgrey;'>N/A</td>";}
						
								//Avg Playtime
								
								echo "<td>";
										echo $game["story_hours"];
								echo "</td>";
								
							echo "</tr>";
						}
					?>
				</tbody>
			</table>
		</div>
	</div>
</body>