<?php
class BDD
{
	private $bdd;

	private $host = "mysql1.alwaysdata.com";
	private $user = "nerabit";
	private $password = "stumaqm9";
	private $bdname = "nerabit_bdd";

	private $connectionState;

	public function __construct()
	{
		$bddCon = $this->bdd = mysqli_connect($this->host, $this->user, $this->password, $this->bdname);
		if(!$bddCon)
		{
			$this->connectionState = 0;
		}
		else
		{
			$this->connectionState = 1;
		}
	}

	public function select($id, $table, $options="")
	{
		return $this->bdd->query("SELECT ".$id." FROM ".$table." ".$options."");
	}

	public function insert($table, $id, $value)
	{
		return $this->bdd->query("INSERT INTO ".$table." (".$id.") VALUES (".$value.")");
	}

	public function update($table, $idValue, $options="")
	{
		return $this->bdd->query("UPDATE ".$table." SET ".$idValue." ".$options."");
	}

	public function delete($table, $idValue, $options="")
	{
		return $this->bdd->query("DELETE FROM ".$table." WHERE ".$idValue." ".$options."");
	}

	public function fetch_array($content)
	{
		return mysqli_fetch_array($content);
	}

	public function num_rows($content)
	{
		return mysqli_num_rows($content);
	}

	public function real_escape_string($content)
	{
		return mysqli_real_escape_string($this->bdd, $content);
	}

	public function is_bdd_connected()
	{
		return $this->connectionState;
	}
}
?>