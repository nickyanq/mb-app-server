<?php

namespace Fdl\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="categories")
 */
class Category extends AbstractEntity {

	/**
	 * @ORM\Id
	 * @ORM\GeneratedValue(strategy="AUTO")
	 * @ORM\Column(type="integer")
	 */
	protected $id;

	/** @ORM\Column(type="string") */
	protected $title;

	/**
	 * @ORM\Column(type="datetime")
	 */
	protected $create_date;

	/**
	 * @ORM\OneToMany(targetEntity="Note", mappedBy="user")
	 */
	private $fdls;

	public function __construct() {
		$this->create_date = new \DateTime('now');
	}

	public function getId() {
		return $this->id;
	}

	public function getTitle() {
		return $this->title;
	}

	public function getCreate_date() {
		return $this->create_date;
	}

	public function getFdls() {
		return $this->fdls;
	}

	public function setId($id) {
		$this->id = $id;
	}

	public function setTitle($title) {
		$this->title = $title;
	}

	public function setCreate_date($create_date) {
		$this->create_date = $create_date;
	}

	public function setFdls($fdls) {
		$this->fdls = $fdls;
	}

}
