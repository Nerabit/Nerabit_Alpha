<div id="postAdBox" class="box">
	<div class="cross">
					
	</div>

	<div id="title">
		<h1>Post an Ad here !</h1>
	</div>

	<form id="ad" action="/src/php/action.php?function=postAd" method="post" enctype="multipart/form-data">
		<ul id="top">
			<li>
				<h3>Title</h3>
				<input id="ad_title" name="ad_title" class="input" type="text" size="20" value="">
			</li>
		
			<li>
				<h3>Description</h3>
		 		<textarea id="description" name="description"></textarea>
		 	</li>
		</ul>

		<ul id="left">
			<li>
				<h3>Categorie</h3>
				<div class="select">
		 			<input id="categorie" name="categorie" value=""/>
		 			<div class="icon">
		 				
		 			</div>
		 			<div class="value">
		 				<p></p>
		 			</div>
		  			<div class="ul">
		  				<?php
		  					$Categories = $newBdd->select("*", "categories", "ORDER BY name");

							while($getCategories = $newBdd->fetch_array($Categories)) 
							{
		  				?>
			  					<div class="li" value="<?php echo $getCategories['id'];?>"><?php echo $getCategories['name'];?></div>
			  			<?php
			  				}
			  			?>
		  			</div>
		 		</div>
			</li>
		</ul>

		<ul id="right">
			<li>
				<h3>Price</h3>
				<input id="price" name="price" class="input" type="text" placeholder="BTC"/>
			</li>
		</ul>

		<ul id="bottom">
			<li>
				<h3>Pictures</h3>
				<div class="submit upload-input"/>
					<p>Browse ad cover</p>
				</div>
				<input id="cover-upload" name="cover-upload" type="file" accept="image/*">

				<ul id="left">
					<li>
						<div class="submit upload-input"/>
							<p>Browse second pictures</p>
						</div>
						<input id="pic1-upload" name="pic1-upload" type="file" accept="image/*">
					</li>
				</ul>

				<ul id="right">
					<li>
						<div class="submit upload-input"/>
							<p>Browse third pictures</p>
						</div>
						<input id="pic2-upload" name="pic2-upload" type="file" accept="image/*">
					</li>
				</ul>
			</li>
		</ul>
				
		<ul id="submit">
			<input type="submit" value="Post" disabled/>
		</ul>
	</form>
</div>