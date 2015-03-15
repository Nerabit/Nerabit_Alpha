<div id="signInBox" class="box">
	<div class="cross">
					
	</div>

	<div id="title">
		<h1>Sign In</h1>
	</div>

	<form action="/src/php/action.php?function=logUser" method="post">
		<ul>
		   	<h3>Username or E-mail</h3>
		   	<input id="username" name="username" type="text"/>

			<div class="error-message"><p>Username is incorrect !</p></div>
		</ul>

		<ul>
		   	<h3>Password</h3>
		    <input id="password" name="password" type="password"/>

		    <div class="error-message"><p>Password is incorrect !</p></div>
		</ul>

		<ul>
		    <li id="submit">
		      	<input type="submit" value="Sign In" disabled/>
		    </li>
		</ul>

		<ul>
		    <li id="forgot">
		    	<a href="#"><p>Forgot password ?</p></a>
		   	</li>
		</ul>
	</form>
</div>