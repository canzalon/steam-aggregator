<?php require_once("header.php"); ?>
<body>
	<div class="container-fluid">
		<!-- Spacer -->
		<div class="row-fluid">
			<div class="span12"></div>
			<div class="span12"></div>
		</div> 
		<!-- Steam ID input -->
		<div class="row-fluid form_container">
			<div class="span4"></div>
			<div class="span4">
				<span id="good_form_id">Searching.... this <span id='s'>may</span> <strong>will</strong> take a while! </span>
				<span id="error_form_id">You Idiot, put in the correct id!!!</span>
				<div id="title">
					<a href="/"><h1>Steam Aggregator<h1></a>
				</div>
				<form id='agg-form' action="aggregator.php" method="POST">
					<fieldset>
						<br />
						<input type="text" placeholder="Enter Steam ID..." id='steamid' name="steamid">
						<div style="clear:both">
							<button type="submit" id='agg-form-btn' class="btn">Submit</button>
						</fieldset>
					</form>
				</div>
				<div class="span4"></div>
			</div>
		</div>
		
		<script>
		(function(){
			
			$('#agg-form-btn').click(function(){
				var id =  $('#steamid').val();
				
				$.ajax({
			type: "POST",
			url: "checksteamid.php",
			data: { checksteamid: true, steamid: id }
			}).success(function(data){
				console.log(data)
				if(data.user){
					$('#error_form_id').hide();
					$('#good_form_id').fadeIn(2000);
					$('#agg-form').submit();
				}else{
					$('#error_form_id').fadeIn(2000);
					console.log("false")
				}
			}).done(function( msg ) {
			//console.log("done")
			}).fail(function(data){
				console.log(data);
			});
			
			return false;
			
			})
			
		})()
		</script>
	</body>
	
</html>