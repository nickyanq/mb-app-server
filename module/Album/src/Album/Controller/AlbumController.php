<?php

namespace Album\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Album\Model\Album;		  // <-- Add this import
use Album\Form\AlbumForm;	   // <-- Add this import

class AlbumController extends AbstractActionController {

	protected $albumTable;

	
	/**
	 *
	 * @var \Doctrine\ORM\EntityManager 
	 */
	protected $em ;
	
	protected function setEM(){
		$this->em = $this
				->getServiceLocator()
				->get('Doctrine\ORM\EntityManager');
		
	}




	public function indexAction() {

		$this->setEM();
		
		
		$user = new \Album\Entity\User();
		$user->setFullName('Marco Pivetta');

		$this->em->persist($user);
		$this->em->flush();

		die(var_dump($user->getId())); // yes, I'm lazy




		return new ViewModel(array(
			'albums' => $this->getAlbumTable()->fetchAll(),
		));
	}

	public function addAction() {
		$form = new AlbumForm();
		$form->get('submit')->setValue('Add');

		$request = $this->getRequest();
		if ($request->isPost()) {
			$album = new Album();
			$form->setInputFilter($album->getInputFilter());
			$form->setData($request->getPost());

			if ($form->isValid()) {
				$album->exchangeArray($form->getData());
				$this->getAlbumTable()->saveAlbum($album);

				// Redirect to list of albums
				return $this->redirect()->toRoute('album');
			}
		}
		return array('form' => $form);
	}

	public function editAction() {
		
	}

	public function deleteAction() {
		
	}

	public function getAlbumTable() {
		if (!$this->albumTable) {
			$sm = $this->getServiceLocator();
			$this->albumTable = $sm->get('Album\Model\AlbumTable');
		}
		return $this->albumTable;
	}

}
