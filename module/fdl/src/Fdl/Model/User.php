<?php

/**
 * File : User.php
 * Created at 11-07-2014 5:52:52 PM
 * 
 * @author Corneliu Iancu - Opti Systems
 * @contact corneliu.iancu@opti.ro
 */

namespace Fdl\Model;

use Zend\Crypt\Password\Bcrypt;
use Zend\Session\Container;
use Exception;

class User extends Model {

	public function __construct(\Doctrine\ORM\EntityManager $em) {
		parent::__construct($em);
	}

	/**
	 * Adds a new user.
	 * @param type $data
	 * @return type
	 */
	public function addUser($data) {

		// Must check if there is already a user with that username or that password

		$data['real_password'] = $data['password'];

		$bcrypt = new Bcrypt();

		$data['password'] = $bcrypt->create($data['password']);

		$user = new \Fdl\Entity\User();

		$user->postHydrate($data);

		$this->__em->persist($user);

		$this->__em->flush();

		return array('code' => 1, 'message' => 'Successfull registration.');
	}

	public function editUser($userData) {

		try {
			$user = $this->getUserById($userData->id);
			$user->setFirstname($userData->firstname);
			$user->setLastname($userData->lastname);
			$user->setUsername($userData->username);
			$this->__em->persist($user);
			$this->__em->flush($user);
			return array('code' => 1, 'message' => 'User updated');
		} catch (\Exception $e) {
			return array('code' => 404, 'message' => 'User not found');
		}


//		if ($user) {
//			$user->setFirstname($userData->firstname);
//			$user->setLastname($userData->lastname);
//
//
//			return array('code' => 1, 'message' => 'User will be updated');
//		} else {
//			return array('code' => 404, 'message' => 'User not found');
//		}
	}

	public function removeUser() {
		
	}

	/**
	 * Logges in the user.
	 * @param type $post
	 * @return type	 /
	 */
	public function loginUser($post) {
		$user = $this->__em->getRepository('Fdl\Entity\User')->findBy(array('username' => $post->username));

		if ($user) {

			/* check password match */

			$bcrypt = new Bcrypt();

			$passMatch = $bcrypt->verify($post->password, $user[0]->getPassword());

			if ($passMatch) {
				/* save the user to session , update last login.. */

				$user[0]->setLast_login(new \DateTime('now'));

				$this->__em->persist($user[0]);

				$this->__em->flush();

				$sessionUser = $user[0]->getId();

				unset($sessionUser['password']);
				unset($sessionUser['real_password']);

				$session = new Container('base');

				$session->offsetSet('user', $sessionUser);


				return array('code' => 3, 'message' => 'User logged succesfully', 'data' => $user[0]->getIterationArray());
			} else {

				return array('code' => 1, 'message' => 'Password didn\'t matched');
			}
		} else {

			return array('code' => 0, 'message' => 'User not found.');
		}
	}
	
	
	public function authUser($user_id) {
		
		return $this->getUserById($user_id)->getIterationArray();
		
	}

	/**
	 * 
	 * @param type $id
	 * @return \Fdl\Entity\User
	 * @throws Exception
	 */
	private function getUserById($id) {

		$usr = $this->__em->getRepository("Fdl\Entity\User")->find($id);

		if ($usr) {
			return $usr;
		} else {
			return false;
		}
	}

	//CODE TO BE CONTINUED...
}
