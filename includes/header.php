<header>
	<nav>
		<ul id="left">
			<li>
				<a href="/index.php" class="logo">
					<img src="/img/nerabit.png">
				</a>
			</li>
		</ul>

		<ul id="right">
		<?php
			if(!isset($_SESSION['SID_ID'])) 
			{
		?>
				<li>
					<a id="signUp">
						<input type="submit" value="Post an ad"/>
					</a>
				</li>
				<li>
					<a id="signIn">
						<h2>Sign In</h2>
					</a>
				</li>
				<li>
					<a id="signUp">
						<h2>Sign Up</h2>
					</a>
				</li>
		<?php
			}
			else
			{
		?>
				<li id="submit">
					<input type="submit" value="Post an ad"/>
				</li>

				<div id="profil">
					<div id="username">
						<a href="/src/php/action.php?function=logOut"><h2><?php echo User::getFirstName(), ' ', User::getLastName()?></h2></a>
					</div>

					<div id="avatar">
						<img src="/users/<?php echo User::getId();?>/avatar/default.png">
					</div>
				</div>
		<?php
			}
		?>
		</ul>
	</nav>
</header>