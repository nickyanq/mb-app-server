<?php

namespace Fdl\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="fdls")
 */
class Note extends AbstractEntity {

	/**
	 * @ORM\Id
	 * @ORM\GeneratedValue(strategy="AUTO")
	 * @ORM\Column(type="integer")
	 */
	protected $id;

	/** @ORM\Column(type="string") */
	protected $title;

	/** @ORM\Column(type="text") */
	protected $content;

	/**
	 * @ORM\Column(type="integer")
	 */
	protected $user_id;
	
	/**
	 * @ORM\Column(type="integer")
	 */
	protected $category_id;

	/**
	 * @ORM\Column(type="datetime")
	 */
	protected $create_date;
	
	/**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="fdls")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
	private $user;
	
	/**
     * @ORM\ManyToOne(targetEntity="Category", inversedBy="fdls")
     * @ORM\JoinColumn(name="category_id", referencedColumnName="id")
     */
	private $category;

	/**
	 * @ORM\OneToMany(targetEntity="Vote", mappedBy="fdl")
	 */
	private $votes;
	
	
	public function __construct() {
		$this->create_date = new \DateTime('now');
	}

		public function getId() {
		return $this->id;
	}

	public function getTitle() {
		return $this->title;
	}

	public function getContent() {
		return $this->content;
	}

	public function getUser_id() {
		return $this->user_id;
	}

	public function getCreate_date() {
		return $this->create_date;
	}

	public function getUser() {
		return $this->user;
	}

	public function setId($id) {
		$this->id = $id;
	}

	public function setTitle($title) {
		$this->title = $title;
	}

	public function setContent($content) {
		$this->content = $content;
	}

	public function setUser_id($user_id) {
		$this->user_id = $user_id;
	}

	public function setCreate_date($create_date) {
		$this->create_date = $create_date;
	}

	public function setUser($user) {
		$this->user = $user;
	}
	
	public function getCategory_id() {
		return $this->category_id;
	}

	public function getCategory() {
		return $this->category;
	}

	public function setCategory_id($category_id) {
		$this->category_id = $category_id;
	}

	public function setCategory($category) {
		$this->category = $category;
	}

	public function getVotes() {
		return $this->votes;
	}

	public function setVotes($votes) {
		$this->votes = $votes;
	}




}
