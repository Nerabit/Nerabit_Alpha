<?php
	class User
	{
		public $newbdd;

		private $id;
		private $username;
		private $password;
		private $token;

		public function __construct()
		{
			$this->newbdd = new BDD();
		}

		public function logUser($username, $password)
		{
			if(!$this->isLogged())
			{
				$UserInfo = $this->newbdd->select("id, password, salt", "users", "WHERE username LIKE '".$username."' OR email LIKE '".$username."'");
				$isReg = $this->newbdd->num_rows($UserInfo);

				if($isReg == 1)
				{
					$getUserInfo = $this->newbdd->fetch_array($UserInfo);

					$salt = $getUserInfo['salt'];

					$password = $this->newbdd->real_escape_string(stripslashes($password));
					$passwordHash = hash('sha256', $password).$salt;

					if($passwordHash == $getUserInfo["password"])
					{
						$this->id = $getUserInfo['id'];

            			$_SESSION['SID_ID'] = session_id();
						self::setToken($this->id);

						echo "Connected !";
						return true;
					}
					else
					{
						echo "Password faux !";
						return false;
					}
				}
				else
				{
					echo "Utilisateur inexistant !";
					return false;
				}
			}
			else
			{
				echo "Already logged !";
				$this->checkToken();
			}
		}

		public function regUser($firstname, $lastname, $gender, $state, $zipcode, $city, $username, $password, $password_check, $email)
		{
			$username = $this->newbdd->real_escape_string(stripslashes($username));
			$username = preg_replace('#[^A-Za-z0-9]+#', '_', $username);
			$username = trim($username, '_');
			$username = strtolower($username);

			$Email = $this->newbdd->select("id", "users", "WHERE email LIKE '".$email."'");
			$getEmail = $this->newbdd->num_rows($Email);

			if($getEmail != 1)
			{	
				$User = $this->newbdd->select("id", "users", "WHERE username LIKE '".$username."'");
				$getUser = $this->newbdd->num_rows($User);

				if($getUser != 1)
				{	
					if($password == $password_check)
					{
						$salt = self::randomSalt(10);

						$password = $this->newbdd->real_escape_string(stripslashes($password));
						$passwordHash = hash('sha256', $password).$salt;

						$regUser = $this->newbdd->insert("users", "firstname, lastname, gender, state, zipcode, town, username, password, salt, email", "'".$firstname."', '".$lastname."', '".$gender."', '".$state."', '".$zipcode."', '".$city."', '".$username."', '".$passwordHash."', '".$salt."', '".$email."'");

						$UserId = $this->newbdd->select("id", "users", "WHERE password LIKE '".$passwordHash."'");
						$getUserId = $this->newbdd->fetch_array($UserId);

						mkdir("../../users/".$getUserId['id']."/avatar", 0700, true);

						self::logUser($username, $password);

						echo "Ya ! T'es enregistré :D";
						return true;
					}
					else
					{
						echo "Les mots de passes c'est pas les mêmes en fait ! Bravo !";
						return false;
					}
				}
				else
				{
					echo "Hum il existe déjà ! Sorry pour toi !";
					return false;
				}
			}
		}

		public static function logOut()
		{
			setcookie("token", null, 0, '/');

			$_COOKIE = array();
			session_destroy();

			return true;
		}

		public static function randomSalt($nbChar) 
		{
			$randString = "";
			$chars = "abcdefghijklmnpqrstuvwxy0123456789";
			srand((double)microtime()*1000000);
			for($i=0; $i < $nbChar; $i++) 
			{
				$randString .= $chars[rand()%strlen($chars)];
			}

			return $randString;
		}

		public static function setToken($userId)
		{
			$token = md5(uniqid(mt_rand(), true));

			setcookie("token", null, 0, '/');

			setcookie("token", $token, time()+3600, '/');

			$newStaticBdd = new BDD();
			$newStaticBdd->update("users", "token = '".$token."'", "WHERE id = '".$userId."'");

			return true;
		}

		public static function checkToken()
		{
			$return = array();

			if(isset($_COOKIE['token']) AND !empty($_COOKIE['token']))
			{
				$newStaticBdd = new BDD();
				$UserInfo = $newStaticBdd->select("token", "users", "WHERE id LIKE '".self::getId()."'");
				$getUserInfo = $newStaticBdd->fetch_array($UserInfo);

				if(self::getToken() == $getUserInfo['token'])
				{
					return true;
				}
				else
				{
					self::LogOut();
					return false;
				}
			}
			else
			{
				self::LogOut();
				return false;
			}
		}

		public static function getToken()
		{
			if(isset($_COOKIE['token']) AND !empty($_COOKIE['token']))
			{
				return $_COOKIE["token"];
			}
			else
			{
				return "null";
			}
		}

		public static function getId()
		{
			$newStaticBdd = new BDD();
			$IdToken = $newStaticBdd->select("id", "users", "WHERE token LIKE '".self::getToken()."'");
			$getIdToken = $newStaticBdd->fetch_array($IdToken);

			return $getIdToken['id'];
		}

		public static function getAvatar()
		{
			$newStaticBdd = new BDD();
			$IdToken = $newStaticBdd->select("avatar", "users", "WHERE token LIKE '".self::getToken()."'");
			$getIdToken = $newStaticBdd->fetch_array($IdToken);

			return $getIdToken['avatar'];
		}

		public static function getUsername()
		{
			if(self::isLogged())
			{
				$newStaticBdd = new BDD();
				$UsernameToken = $newStaticBdd->select("username", "users", "WHERE token LIKE '".self::getToken()."'");
				$getUsernameToken = $newStaticBdd->fetch_array($UsernameToken);

				return $getUsernameToken['username'];
			}
		}

		public static function getFirstName()
		{
			if(self::isLogged())
			{
				$newStaticBdd = new BDD();
				$FirstName = $newStaticBdd->select("firstname", "users", "WHERE token LIKE '".self::getToken()."'");
				$getFirstName = $newStaticBdd->fetch_array($FirstName);

				return $getFirstName['firstname'];
			}
		}

		public static function getLastName()
		{
			if(self::isLogged())
			{
				$newStaticBdd = new BDD();
				$LastName = $newStaticBdd->select("lastname", "users", "WHERE token LIKE '".self::getToken()."'");
				$getLastName = $newStaticBdd->fetch_array($LastName);

				return $getLastName['lastname'];
			}
		}

		public static function getStats()
		{
			if(self::isLogged())
			{
				$newStaticBdd = new BDD();
				$Stats = $newStaticBdd->select("*", "stats", "WHERE id LIKE '".User::getId()."'");
				$getStats = $newStaticBdd->fetch_array($Stats);

				$arrayStats = array('uprate' => $getStats['uprate'], 'downrate' => $getStats['downrate']);
				return $arrayStats;
			}
		}

		public static function getStatsById($user_id)
		{
			$newStaticBdd = new BDD();
			$Stats = $newStaticBdd->select("*", "stats", "WHERE id LIKE '".$user_id."'");
			$getStats = $newStaticBdd->fetch_array($Stats);

			$arrayStats = array('uprate' => $getStats['uprate'], 'downrate' => $getStats['downrate']);
			return $arrayStats;
		}

		public static function isLogged()
		{
			if(isset($_SESSION["SID_ID"]) AND !empty($_SESSION["SID_ID"]))
			{		
				if(self::checkToken())
				{
					return true;
				}	
				else
				{
					return false;
				}
			}
			else
			{
				return false;
			}
		}

		public function upRate($user_rate_id)
		{
			if(User::isLogged())
			{
				$Rates = $newStaticBdd->select("*", "ratings", "WHERE user_id LIKE '".User::getId()." AND user_rate_id LIKE '".$user_rate_id."'");
				$getRates = $newStaticBdd->num_rows($Rates);

				if($getRates != 1) 
				{
					$setRatings = $this->newbdd->insert("ratings", "user_rate_id", "user_id", "'".$user_rate_id."', '".User::getId()."'");

					$UserStats = $newStaticBdd->select("*", "stats", "WHERE user_id LIKE '".$user_rate_id."'");
					$getUserStats = $newStaticBdd->fetch_array($UserStats);

					$rateUp = $getUserStats['uprate'] + 1;

					$upRate = $this->newbdd->update("stats", "uprate = '".$rateUp."'","WHERE user_id LIKE '".$user_rate_id."'");
					$this->newbdd->update("users", "token = '".$token."'", "WHERE id = '".$this->id."'");
				}
			}
		}

		public static function postAd($title, $description, $categorie, $price, $coverUpload, $pic1Upload, $pic2Upload)
		{
			if(self::isLogged())
			{
				$newStaticBdd = new BDD();

				$title = $newStaticBdd->real_escape_string(stripslashes($title));
				$description = $newStaticBdd->real_escape_string(stripslashes($description));

				$coverToken = self::randomSalt(10);

				$postAd = $newStaticBdd->insert("ads", "user_id, title, description, categorie, price, token", "'".self::getId()."', '".$title."', '".$description."', '".$categorie."', '".$price."', '".$coverToken."'");

				////////////////////////////////////////////////////

				$CoverId = $newStaticBdd->select("id", "ads", "WHERE token LIKE '".$coverToken."'");
				$getCoverId = $newStaticBdd->fetch_array($CoverId);

				mkdir("../../ads/".$getCoverId['id'], 0700, true);

				if(isset($coverUpload) AND !empty($coverUpload)) 
				{
					$infoFile = pathinfo($coverUpload['name']);
					$extension_upload = $infoFile['extension'];

					$coverFileSource = $coverUpload['tmp_name'];
				}

				if($extension_upload == "JPG" OR $extension_upload == "JPEG" OR $extension_upload == "jpg" OR $extension_upload == "jpeg")
				{
					$cover = imagecreatefromjpeg($coverFileSource);
				}
				else if($extension_upload == "GIF" OR $extension_upload == "gif")
				{
					$cover = imagecreatefromgif($coverFileSource);
				}
				else if($extension_upload == "PNG" OR $extension_upload == "png")
				{
					$cover = imagecreatefrompng($coverFileSource);
				}

				list($coverWidth, $coverHeight) = getimagesize($coverFileSource);

				$ratioBlured = 300 / $coverWidth;
				$heightBlured = $coverHeight * $ratioBlured;

				$coverBlured = imagecreatetruecolor(300, $heightBlured);
				imagecopyresampled($coverBlured, $cover, 0, 0, 0, 0, 300, $heightBlured, $coverWidth, $coverHeight);

				imagefilter($coverBlured, IMG_FILTER_GAUSSIAN_BLUR);
				imagefilter($coverBlured, IMG_FILTER_GAUSSIAN_BLUR);
				imagefilter($coverBlured, IMG_FILTER_GAUSSIAN_BLUR);
				imagefilter($coverBlured, IMG_FILTER_GAUSSIAN_BLUR);
				imagefilter($coverBlured, IMG_FILTER_GAUSSIAN_BLUR);
				imagefilter($coverBlured, IMG_FILTER_GAUSSIAN_BLUR);
				imagefilter($coverBlured, IMG_FILTER_GAUSSIAN_BLUR);
				imagefilter($coverBlured, IMG_FILTER_GAUSSIAN_BLUR);
				imagefilter($coverBlured, IMG_FILTER_GAUSSIAN_BLUR);
				imagefilter($coverBlured, IMG_FILTER_GAUSSIAN_BLUR);
				imagefilter($coverBlured, IMG_FILTER_GAUSSIAN_BLUR);
				imagefilter($coverBlured, IMG_FILTER_GAUSSIAN_BLUR);
				imagefilter($coverBlured, IMG_FILTER_GAUSSIAN_BLUR);
				imagefilter($coverBlured, IMG_FILTER_GAUSSIAN_BLUR);
				imagefilter($coverBlured, IMG_FILTER_GAUSSIAN_BLUR);
				imagefilter($coverBlured, IMG_FILTER_GAUSSIAN_BLUR);
				imagefilter($coverBlured, IMG_FILTER_GAUSSIAN_BLUR);
				imagefilter($coverBlured, IMG_FILTER_GAUSSIAN_BLUR);
				imagefilter($coverBlured, IMG_FILTER_GAUSSIAN_BLUR);
				imagefilter($coverBlured, IMG_FILTER_GAUSSIAN_BLUR);
				
				imagepng($coverBlured, "../../ads/".$getCoverId['id']."/coverBlured_".$coverToken.".png");

				//////////////////////////////////////////////////

				move_uploaded_file($coverUpload['tmp_name'], "../../ads/".$getCoverId['id']."/cover_".$coverToken.".png");

				if(isset($pic1Upload) AND !empty($pic1Upload))
				{
					move_uploaded_file($pic1Upload['tmp_name'], "../../ads/".$getCoverId['id']."/pic1_".$coverToken.".png");
				}
				
				if(isset($pic2Upload) AND !empty($pic2Upload))
				{
					move_uploaded_file($pic2Upload['tmp_name'], "../../ads/".$getCoverId['id']."/pic2_".$coverToken.".png");
				}

				return $coverUpload;
			}
			else
			{
				echo "You are not logged !";
				return false;
			}
		}
	}
?>