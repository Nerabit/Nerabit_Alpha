<?php
	session_start();
	require("class/bdd.php");
	require("class/User.php");

	if(isset($_GET['function']) AND !empty($_GET['function']))
	{
		$action = $_GET['function'];
		
		////////logUser///////
		if($action == "logUser")
		{
			if((isset($_POST['username']) AND !empty($_POST['username'])) AND (isset($_POST['password']) AND !empty($_POST['password'])))
			{
				$username = $_POST['username'];
				$password = $_POST['password'];

				$newUser = new User();

				if($newUser->logUser($username, $password)) 
				{
					header("location: /index.php");
				}
				else
				{
					echo "Action: nop !";
				}
			}
			else
			{
				echo "Error logins not set !";
			}

		}

		////////regUser///////
		if($action == "regUser")
		{
			if((isset($_POST['firstname']) AND !empty($_POST['firstname'])) AND (isset($_POST['lastname']) AND !empty($_POST['lastname'])) AND (isset($_POST['gender']) AND !empty($_POST['gender'])) AND (isset($_POST['state']) AND !empty($_POST['state'])) AND (isset($_POST['zipcode']) AND !empty($_POST['zipcode'])) AND (isset($_POST['city']) AND !empty($_POST['city'])) AND (isset($_POST['username']) AND !empty($_POST['username'])) AND (isset($_POST['password']) AND !empty($_POST['password'])) AND (isset($_POST['password_check']) AND !empty($_POST['password_check'])) AND (isset($_POST['email']) AND !empty($_POST['email'])))
			{
				$firstname = $_POST['firstname'];
				$lastname = $_POST['lastname'];
				$gender = $_POST['gender'];
				$state = $_POST['state'];
				$zipcode = $_POST['zipcode'];
				$city = $_POST['city'];
				$username = $_POST['username'];
				$password = $_POST['password'];
				$password_check = $_POST['password_check'];
				$email = $_POST['email'];

				$newUser = new User();

				if($newUser->regUser($firstname, $lastname, $gender, $state, $zipcode, $city, $username, $password, $password_check, $email))
				{
					header("location: /index.php");
				}
				else
				{
					echo "Action: nop !";
				}
			}
			else
			{
				echo "Error logUsers not set !";
			}

		}

		////////logOut///////
		if($action == "logOut")
		{
			if(User::logOut())
			{
				header("location: /index.php");
			}
		}

		////////checkToken///////
		if($action == "checkToken")
		{
			$dataArray['return'] = User::checkToken();
		}

		////////isTokenSet///////
		if($action == "isTokenSet")
		{
			$dataArray['return'] = User::isTokenSet();
		}

		////////getId///////
		if($action == "getId")
		{
			$dataArray['return'] = User::getId();
		}

		////////getUsername///////
		if($action == "getUsername")
		{
			$dataArray['return'] = User::getUsername();
		}

		////////isLogged///////
		if($action == "isLogged")
		{
			$dataArray['return'] = User::isLogged();
		}
		////////upRate///////
		if($action == "upRate")
		{
			
		}

		////////getTags///////
		if($action == "getTags")
		{
			$newMotor = new Motor();
			$dataArray['return'] = $newMotor->getTags();
		}

		////////getUserTags///////
		if($action == "getUserTags")
		{
			$newMotor = new Motor();
			$dataArray['return'] = $newMotor->getUserTags();
		}

		////////addTag///////
		if($action == "addTag")
		{
			if(isset($_POST['tagId']) AND !empty($_POST['tagId']))
			{
				$tagId = $_POST['tagId'];

				$newMotor = new Motor();
				$dataArray['return'] = $newMotor->addTag($tagId);
			}
		}

		////////delTag///////
		if($action == "delTag")
		{
			if(isset($_POST['tagId']) AND !empty($_POST['tagId']))
			{
				$tagId = $_POST['tagId'];

				$newMotor = new Motor();
				$dataArray['return'] = $newMotor->delTag($tagId);
			}
		}

		////////getUserTagById///////
		if($action == "getUserTagById")
		{
			if(isset($_POST['tagId']) AND !empty($_POST['tagId']))
			{
				$tagId = $_POST['tagId'];

				$newMotor = new Motor();
				$dataArray['result'] = $newMotor->getUserTagById($tagId);
			}
		}

		////////postAd///////
		if($action == "postAd")
		{
			if(isset($_POST['ad_title']) AND !empty($_POST['ad_title']) AND isset($_POST['description']) AND !empty($_POST['description']) AND isset($_POST['categorie']) AND !empty($_POST['categorie']) AND isset($_POST['price']) AND !empty($_POST['price']) AND isset($_FILES['cover-upload']))
			{
				$title = $_POST['ad_title'];
				$description = $_POST['description'];
				$categorie = $_POST['categorie'];
				$price = $_POST['price'];
				$coverUpload = $_FILES['cover-upload'];

				if((isset($_FILES['pic1-upload']) AND !empty($_FILES['pic1-upload'])) AND (isset($_FILES['pic2-upload']) AND !empty($_FILES['pic2-upload'])))
				{
					$pic1Upload = $_FILES['pic1-upload'];
					$pic2Upload = $_FILES['pic2-upload'];
				}

				if(User::postAd($title, $description, $categorie, $price, $coverUpload, $pic1Upload, $pic2Upload))
				{
					header("location: /index.php");
					echo "Okep !";
				}
				else
				{
					echo "Erreur lors de l'envoie du fichier !";
				}
			}
			else
			{
				echo "Arguments non valides !";
			}
		}
	}
?>