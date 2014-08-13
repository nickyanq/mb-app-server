<?php

/**
 * File : FdlController.php
 * Created at 10-07-2014 6:26:01 PM
 * 
 * @author Corneliu Iancu - Opti Systems
 * @contact corneliu.iancu@opti.ro
 */

namespace Fdl\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Session\Container;
use Fdl\Model\Fdls;
use Zend\Crypt\Password\Bcrypt;

//use Fdl\Model\AlbumTable;


class FdlController extends AbstractActionController {

    /**
     * vote status = 0 -> inactive
     * vote status = 1 -> active
     * 
     */
    protected $errors = array('status', 'messsage');

    /** @var Fdls */
    protected $fdlModel;

    public function onDispatch(\Zend\Mvc\MvcEvent $e) {

        $sm = $this->getServiceLocator();

        $this->fdlModel = $sm->get('Fdl\Model\Fdls');

        $this->layout('layout/json.phtml');

        $headers = $this->getResponse()->getHeaders();

        $headers->addHeaderLine('Content-Type', 'application/json');

        $this->getResponse()->setStatusCode(200);

        parent::onDispatch($e);
    }

    public function indexAction() {

        $data = array('code' => 1, 'message' => 'Welcome to FDL api');

        $response = $this->getResponse();

        $response->setContent(json_encode($data));

        return $response;
    }

    public function getAllFdlsAction() {

        $data = $this->fdlModel->getAll();

        $response = $this->getResponse();

        $response->setContent(json_encode($data));

        return $response;
    }

    public function pullAllFdlsAction() {
//        sleep(3);
        $data = $this->fdlModel->pullFdls();

        $response = $this->getResponse();

        $response->setContent(json_encode($data));

        return $response;
    }

    public function getAllFdlCategoriesAction() {

        $data = $this->fdlModel->getAllCategories();

        $response = $this->getResponse();

        $response->setContent(json_encode($data));

        return $response;
    }

    public function addFdlAction() {

//		$data = array('title' => 'myTitle', 'content' => 'contentTest');

        $response = $this->getResponse();

        if ($this->params()->fromPost()) {

            $data = $this->params()->fromPost();
        } else {
            $error = array('code' => 301, 'message' => 'Invalid request.');

            $response->setContent(json_encode($error));
            return $response;
        }

        $errors = $this->fdlModel->addFdl((object) $data);

        $response->setContent(json_encode($errors));

        return $response;
    }

    public function registerUserAction() {
        $response = $this->getResponse();
        if ($this->params()->fromPost()) {
            $data = $this->params()->fromPost();
        } else {
            $error = array('code' => 101, 'message' => $_POST);

            $response->setContent(json_encode($error));
            return $response;
        }

        $r = $this->userModel->addUser($data);
//		$r = array('code'=>333, 'Message' => 'Registering is on hold. This is a test...');

        $response->setContent(json_encode($r));
        return $response;
    }

    public function loginAction() {
        $response = $this->getResponse();

        $post = $this->params()->fromPost();

        if ($post) {
            $data = $this->params()->fromPost();
        } else {
            $error = array('code' => 101, 'message' => 'Invalid request.');
            $response->setContent(json_encode($error));
            return $response;
        }

        $r = $this->userModel->loginUser((object) $post);

        $response->setContent(json_encode($r));
        return $response;
    }

    public function logoutAction() {
        $response = $this->getResponse();


        $session = new Container('base');

        if ($user = $session->offsetGet('user')) {
            $session->getManager()->getStorage()->clear();
            $error = array('code' => 101, 'message' => 'User is logged in.');
        } else {
            $error = array('code' => 101, 'message' => 'Invalid request.');
        }

        $response->setContent(json_encode($error));

        return $response;
    }

    public function authenticateAction() {

        $response = $this->getResponse();

        $session = new Container('base');

        $userid = $session->offsetGet('user');

        if ($userid) {
            $r = array('code' => 1, 'message' => "I got the user", 'data' => $this->userModel->authUser($userid));
        } else {
            $r = array('code' => 2, 'message' => "Failed to fetch logged user", 'data' => array());
        }

        $response->setContent(json_encode($r));
        return $response;
    }

    public function updateUserAction() {
        $response = $this->getResponse();

        $post = $this->params()->fromPost();

        if ($post) {
            $data = $this->params()->fromPost();
        } else {
            $error = array('code' => 101, 'message' => 'Invalid request.');
            $response->setContent(json_encode($error));
            return $response;
        }

        $rsp = $this->userModel->editUser((object) $post);

        $response->setContent(json_encode($rsp));
        return $response;
    }

    public function voteAction() {

        $response = $this->getResponse();

        if ($this->params()->fromPost()) {

            $data = $this->params()->fromPost();
        } else {

            $error = array('code' => 101, 'message' => 'Invalid request.');

            $response->setContent(json_encode($error));

            return $response;
        }

        $rsp = $this->fdlModel->addVote((object) $data);

        $response->setContent(json_encode($rsp));

        return $response;
    }

    public function startAppAction() {
        $response = $this->getResponse();
        $this->em = $this
                ->getServiceLocator()
                ->get('Doctrine\ORM\EntityManager');
        $categoies = array(
            array('title' => 'Love'),
            array('title' => 'Money'),
            array('title' => 'Work'),
            array('title' => 'Intimacy'),
            array('title' => 'Animals'),
            array('title' => 'Kids'),
            array('title' => 'Health'),
            array('title' => 'Miscellaneous')
        );
        foreach ($categoies as $category) {
            $cat = new \Fdl\Entity\Category();
            $cat->setTitle($category['title']);
            $this->em->persist($cat);
            $this->em->flush();
        }

        $response->setContent(json_encode(array("code" => 1, "message" => "Application successfully started.")));

        return $response;
    }

}
