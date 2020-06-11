<?php

class Connect {
    protected $user = "root";
    protected $pass = "";
    public $mbd;

    public function __construct() {
      $this->mbd = new PDO('mysql:host=localhost;dbname=blarlo', $this->user, $this->pass);
    }

  	public function close(){
     		$this->mbd = null;
   	}

}
