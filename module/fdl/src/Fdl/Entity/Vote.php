<?php

namespace Fdl\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="fdl_votes")
 */
class Vote extends AbstractEntity {

	/**
	 * @ORM\Id
	 * @ORM\GeneratedValue(strategy="AUTO")
	 * @ORM\Column(type="integer")
	 */
	protected $id;

	/**
	 * @ORM\Column(type="integer" , nullable = false)
	 */
	protected $fdl_id;

	/**
	 * @ORM\Column(type="integer", nullable = false) 
	 */
	protected $user_id;

	/**
	 * @ORM\Column(type="integer")
	 */
	protected $type;

	/**
	 * @ORM\Column(type="boolean")
	 */
	protected $status = 1;

	/**
	 * @ORM\Column(type="datetime")
	 */
	protected $create_date;

	/**
	 * @ORM\ManyToOne(targetEntity="User", inversedBy="votes")
	 * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
	 */
	private $user;

	/**
	 * @ORM\ManyToOne(targetEntity="Note", inversedBy="fdls")
	 * @ORM\JoinColumn(name="fdl_id", referencedColumnName="id")
	 */
	private $fdl;

	public function __construct() {
		$this->status = 1;
		$this->create_date = new \DateTime('now');
	}

	public function getId() {
		return $this->id;
	}

	public function getFdl_id() {
		return $this->fdl_id;
	}

	public function getUser_id() {
		return $this->user_id;
	}

	public function getType() {
		return $this->type;
	}

	public function getStatus() {
		return $this->status;
	}

	public function getCreate_date() {
		return $this->create_date;
	}

	public function getUser() {
		return $this->user;
	}

	public function getFdl() {
		return $this->fdl;
	}

	public function setId($id) {
		$this->id = $id;
	}

	public function setFdl_id($fdl_id) {
		$this->fdl_id = $fdl_id;
	}

	public function setUser_id($user_id) {
		$this->user_id = $user_id;
	}

	public function setType($type) {
		$this->type = $type;
	}

	public function setStatus($status) {
		$this->status = $status;
	}

	public function setCreate_date($create_date) {
		$this->create_date = $create_date;
	}

	public function setUser($user) {
		$this->user = $user;
	}

	public function setFdl($fdl) {
		$this->fdl = $fdl;
	}

}
