<?php
	session_start();
	require("src/php/class/bdd.php");
	require("src/php/class/Engine.php");
	require("src/php/class/User.php");

	$newBdd = new BDD();

	$sort = "id DESC";
	if(isset($_GET['sort']) AND !empty($_GET['sort']))
	{
		if($_GET['sort'] == "hightolow")
		{
			$sort = "price DESC";
		}

		if($_GET['sort'] == "lowtohigh")
		{
			$sort = "price";
		}
	}
?>
<!DOCTYPE html>
<html>
	<?php
		include("includes/head.php");
	?>

	<body>
		<?php
			include("includes/header.php");
		?>

		<div id="banner">
			
		</div>

		<?php
			include("includes/optionBar.php");
		?>

		<section>
			<div id="container">
			<?php

				$Publication = $newBdd->select("*", "ads", "ORDER BY ".$sort."");

				while($getPublication = $newBdd->fetch_array($Publication)) 
				{
					$UserInfos = $newBdd->select("*", "users", "WHERE id LIKE '".$getPublication['user_id']."'");
					$getUserInfos = $newBdd->fetch_array($UserInfos);

			?>
					<div class="ad-container" id="<?php echo $getPublication['id'];?>">
						<div class="ad">
							<div class="categorie">
								<p><?php echo Engine::getCategorie($getPublication['categorie']);?></p>
							</div>

							<div class="img-container" style="background: url('/ads/<?php echo $getPublication['id'];?>/coverBlured_<?php echo $getPublication['token'];?>.png'); background-position: center; background-size: cover;">
								<img src="/ads/<?php echo $getPublication['id'];?>/cover_<?php echo $getPublication['token'];?>.png">
								<span class="align-middle"></span>
							</div>

							<div class="hover-img">
									<div class="profil">
										<div class="avatar">
											<img src="/users/<?php echo $getUserInfos['id'];?>/avatar/default.png">
										</div>

										<div class="name">
											<h2><?php echo $getUserInfos['firstname'];?> <?php echo $getUserInfos['lastname'];?></h2>
										</div>
									</div>

									<div class="state">
										<div class="location">
											<p><?php echo $getUserInfos['town'];?>, <?php echo Engine::getState($getUserInfos['state_id']);?></p>
										</div>

										<div class="state-icon">
											<img src="/img/states/<?php echo $getUserInfos['state_id'];?>.png">
										</div>
									</div>

									<div class="prices">
										<div class="dollar"><p><?php Engine::getCharts("USD", $getPublication['price']);?>$</p></div>
										<div class="euro"><p><?php Engine::getCharts("EUR", $getPublication['price']);?>€</p></div>
									</div>

									<div class="rating">
										<div class="rateup">
											<p><?php echo User::getStatsById($getUserInfos['id'])['uprate'];?></p>
										</div>

										<div class="ratedown">
											<p><?php echo User::getStatsById($getUserInfos['id'])['downrate'];?></p>
										</div>
									</div>
								</div>

							<div class="infos">
								<div class="title">
									<p><?php echo $getPublication['title'];?></p>
								</div>

								<div class="price">
									<p><?php echo $getPublication['price'];?></p>
								</div>
							</div>
						</div>	
					</div>
			<?php
				}
			?>
			</div>
		</section>

		<?php
			include("includes/footer.php");
		?>

		<?php
			include("includes/signInBox.php");
		?>

		<?php
			include("includes/signUpBox.php");
		?>

		<?php
			include("includes/postAdBox.php");
		?>

   		<div id="backgroundBlur">
   	
   		</div>

		<?php
			include("includes/libJQuery.php");
		?>
	</body>

</html>