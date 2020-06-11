<?php


class User{

	public $username;
	public $tag;
	public $date;
	public $avatar;
	public $id;
	public $email;
	public $bio;
	public $verified;

	function __construct($username, $tag, $date, $avatar,$id, $email, $bio, $verified){

		$this->username = $username;
		$this->avatar = $avatar;
		$this->tag = $tag;
		$date = strtotime($date);
		$date = date('M d Y', $date);
		$this->date = $date;
		$this->id = $id;
		$this->email = $email;
		$this->bio = $bio;
		$this->verified = $verified;
	}

	function get_profile(){

    echo "<div id = profile class = profile>";
    echo "<br/>";
    echo "<img class = pfp src='images/".$this->avatar."' height = 100; width = 100; position:absolute;top>";
	echo "<br/>";
    echo "<br/>";
	echo "<h2 style=color:white;  >$this->username </h2>";
	echo "<small style=color:white;  >@$this->tag</small>";
    echo "<br/>";
    echo "<br/>";
    echo "<button id = edit>Edit</button>";
    echo "<h4 style=color:white;  >$this->bio</h4>";
	echo "<h5 style=color:white;  >Account created: $this->date</h5>";
    echo "</div>";

	}

	//induvidual stuff

	function get_email(){

		return $this->email;
	}

	function get_username(){

		return $this->username;
	}

	function get_tag(){

		return $this->tag;
	}

	function get_date(){


		$date = strtotime($this->$date);
		$date = date('M d Y', $sqr_date);
		return $this->date;

	}

	function get_avatar(){

		return "images/'$this->avatar'";
	}

	function get_id(){

		return $this->id;
	}


	function get_bio(){

		return $this->bio;
	}

	function get_verified(){

		return $this->verified;

	}

}

?>