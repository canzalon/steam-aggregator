<?php require_once ("header.php") ?>
<?php require ("config.php") ?>
<?php $gameArray = doSomeCoolStuff($gameArray); 
	$genres_all; 
?>
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css">
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
			<!-- <div class="span12">
				<select multiple id="all_genres">
					
				</select>
			</div> -->
			<!-- 
			<div class="span3">
				<input type="text" readonly="" id="hp-amount">
				<div id="hoursplayed"></div>
			</div>
			<div class="span3">
				<input type="text" readonly="" id="avgp-amount">
				<div id="avgplayed"></div>
			</div>
			<div class="span3">
				<input type="text" readonly="" id="mt-amount">
				<div id="metacritic"></div>
			</div>
			-->
		</div>
		<!-- Results -->
		<div class="container">

			<div class="info_container">
				<table id="info_table1" class="table table-bordered">
					<tr>
						<td>Real Name</td>
						<td><?php if(isset($userArray['realname'])){ echo $userArray['realname'];} 
							else{ echo "<span style='color: lightgrey;'>N/A</span>";}
							?>
						</td>
					</tr>
					<tr>
						<td>SteamID</td>
						<td><?php echo $userArray['steamid']; ?></td>
					</tr>
					<tr>
						<td>Status</td>
						<td><?php 
							switch($userArray['personastate']) {
								case 0: echo "Offline"; break;
								case 1: echo "Online"; break;
								case 2: echo "Busy"; break;
								case 3: echo "Away"; break;
								case 4: echo "Snooze"; break;
								case 5: echo "Looking To Trade"; break; 
								case 6: echo "Looking To Play"; break;
							}
							?>
						</td>
					</tr>
				</table>	

				<table id="info_table2" class="table table-bordered">
					<tr>
						<td>Total Playtime</td>
						<td id="total_playtime"></td>
					</tr>
					<tr>
						<td>Unplayed Games</td>
						<td id="unplayed_games"></td>
					</tr>
					<tr>
						<td>Games Count</td>
						<td><?php echo $gameJSON['response']['game_count']; ?></td>
					</tr>
				</table>
			</div>

			<!-- tablesorter -->
			<input type="text" class="form-control" id="searchInput"  style="width:100%;" placeholder="Filter Results...">
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
				<tbody id="gtable">
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

								foreach ($app_data['genres'] as  $g) {
									$genres_all[$g['description']] = "";
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
											echo $item["description"].'<br />';
											//Populate array of Genres for dropdown select
											/*
											
											/*
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
											
											*/
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

	<?php //var_dump($genres_all); 
		$g_string = "[";
		foreach($genres_all as $k => $v){
			$g_string.= "\"$k\",";
		}
		$g_string.="]";
		//echo $g_string;
	?>

	<script>

		//Info-table Values
		var totalPlaytime = '<?php echo number_format((float)$total_playtime, 2, '.', '') . " hour(s)"; ?>';
		var unplayedGames = "<?php echo $unplayed_games . " (" . round(($unplayed_games/$gameJSON['response']['game_count']) * 100) . "% of library)" ?>";
		$('#total_playtime').append(totalPlaytime);
		$('#unplayed_games').append(unplayedGames);

		$(document).ready(function(){

			var gen_options = <?php echo $g_string; ?>;
			$.each(gen_options, function(index, val){
				$('#all_genres').append("<option value='"+val+"'>"+val+"</option>");
			});
			$('#all_genres')

			$( "#hoursplayed" ).slider({
		      range: true,
		      min: 0,
		      max: 500,
		      values: [ 75, 300 ],
		      slide: function( event, ui ) {
		        $( "#hp-amount" ).val( "$" + ui.values[ 0 ] + " - $" + ui.values[ 1 ] );
		      }
		    });
		    $( "#avgplayed" ).slider({
		      range: true,
		      min: 0,
		      max: 500,
		      values: [ 75, 300 ],
		      slide: function( event, ui ) {
		        $( "#avgp-amount" ).val( "$" + ui.values[ 0 ] + " - $" + ui.values[ 1 ] );
		      }
		    });
		    $( "#metacritic" ).slider({
		      range: true,
		      min: 0,
		      max: 500,
		      values: [ 75, 300 ],
		      slide: function( event, ui ) {
		        $( "#mt-amount" ).val( "$" + ui.values[ 0 ] + " - $" + ui.values[ 1 ] );
		      }
		    });


		    //Filter Function
		    $("#searchInput").keyup(function(){
				console.log("Hi");
				//split value of searchInput
				var data = this.value;
				//create jquery obejct of the rows
				var gametable = $("#gtable").find("tr");
				if(this.value == ""){
					gametable.show();
					return;
				}
				//hide all rows
				gametable.hide();

				//recursively filter the jquery object to get results
				gametable.filter(function(i, v){
					var $t = $(this);
					console.log(data);

					if($t.is(":Contains('"+data+"')")){
						return true;
					}
					return false;
				})
				//show the rows that match
				.show();
			});

		});    
	</script>
	
</body>