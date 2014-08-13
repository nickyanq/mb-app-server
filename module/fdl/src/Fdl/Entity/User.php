<?php

namespace Fdl\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\Annotation As Annotation;

/**
 * @ORM\Entity 
 * @ORM\Table(name="users")
 */
class User extends AbstractEntity {

	/**
	 * @ORM\Id
	 * @ORM\GeneratedValue(strategy="AUTO")
	 * @ORM\Column(type="integer")
	 */
	protected $id;

	/**
	 * @ORM\Column(type="string", length=255) 
	 */
	protected $firstname;

	/**
	 * @ORM\Column(type="string", length=255) 
	 */
	protected $lastname;

	/**
	 * @ORM\Column(type="string", length=255) 
	 */
	protected $email;

	/**
	 * @ORM\Column(type="string", length=255) 
	 */
	protected $username;

	/**
	 * @ORM\Column(type="string", length=255) 
	 */
	protected $password;
	
	/**
	 * @ORM\Column(type="string",length=255)
	 */
	protected $real_password;
	
	/**
	 * @ORM\Column(type="datetime")
	 */
	protected $last_login;

	/**
	 * @ORM\Column(type="datetime")
	 */
	protected $create_date;
	
	/**
	 * @ORM\OneToMany(targetEntity="Note", mappedBy="user")
	 */
	private $fdls;
	
	/**
	 * @ORM\OneToMany(targetEntity="Vote", mappedBy="user")
	 */
	private $votes;



	public function __construct() {
		$this->create_date = new \DateTime("now");
		$this->last_login = new \DateTime("now");
	}
	
	public function getId() {
		return $this->id;
	}

	public function getFirstname() {
		return $this->firstname;
	}

	public function getLastname() {
		return $this->lastname;
	}

	public function getEmail() {
		return $this->email;
	}

	public function getUsername() {
		return $this->username;
	}

	public function getPassword() {
		return $this->password;
	}

	public function getReal_password() {
		return $this->real_password;
	}

	public function getLast_login() {
		return $this->last_login;
	}

	public function getCreate_date() {
		return $this->create_date;
	}

	public function setId($id) {
		$this->id = $id;
	}

	public function setFirstname($firstname) {
		$this->firstname = $firstname;
	}

	public function setLastname($lastname) {
		$this->lastname = $lastname;
	}

	public function setEmail($email) {
		$this->email = $email;
	}

	public function setUsername($username) {
		$this->username = $username;
	}

	public function setPassword($password) {
		$this->password = $password;
	}

	public function setReal_password($real_password) {
		$this->real_password = $real_password;
	}

	public function setLast_login($last_login) {
		$this->last_login = $last_login;
	}

	public function setCreate_date($create_date) {
		$this->create_date = $create_date;
	}


}
