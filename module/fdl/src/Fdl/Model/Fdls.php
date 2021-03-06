<?php

namespace Fdl\Model;

use Fdl\Model\Model as Model;

class Fdls extends Model {

    public function __construct(\Doctrine\ORM\EntityManager $em) {
        parent::__construct($em);
    }

    public function addFdl($data) {

        $note = new \Fdl\Entity\Note();

        $note->setTitle($data->title);

        $note->setContent($data->content);

        $user = $this->__em->getRepository('Fdl\Entity\User')->find($data->user_id);

        $category = $this->__em->getRepository('Fdl\Entity\Category')->find($data->category);

        $note->setCategory($category);

        $note->setUser($user);

        $this->__em->persist($note);

        $this->__em->flush();

        return array('code' => 1, 'message' => 'Successfully inserted.');
    }

    public function getAll() {
        $fdls = $this->__em->getRepository('Fdl\Entity\Note')->findBy(array(), array('id' => 'desc'));
        //should wrap them into a method in model.
        foreach ($fdls as &$fdl) {
            $votesRaw = $fdl->getVotes();
            $array = array();
            foreach ($votesRaw as &$vot) {
                $votUser = $vot->getUser()->getIterationArray();
                unset($votUser['real_password']);
                unset($votUser['password']);
                $vot = $vot->getIterationArray();
                $vot['user'] = $votUser;
                array_push($array, $vot);
            }

            $user = $fdl->getUser()->getIterationArray();
            unset($user['real_password']);
            unset($user['password']);
            $category = $fdl->getCategory();
            $fdl = $this->serialize($fdl);
            $fdl['user'] = $user;
            $fdl['category'] = $category->getIterationArray();
            $fdl['votes'] = $array;
        }

        return $fdls;
    }

    public function getAllCategories() {

        $fdlsCats = $this->__em->getRepository('Fdl\Entity\Category')->findAll();

        foreach ($fdlsCats as &$fdl) {
            $fdl = $this->serialize($fdl);
        }

        return $fdlsCats;
    }

    public function pullFdls() {
        //last id is

        $last_id = $new_last_id = $this->getLastNoteId();
        $loops = 0;

        if ($last_id) {
            while ($loops < 25 && $last_id == $new_last_id) {
                $loops++;
                $new_last_id = $this->getLastNoteId();
                if ($new_last_id != $last_id) {
                    $customMessage = 'changed number of fdls';
                    return array('code' => 1, 'fdls' => $this->getNewNotes($last_id));
                }
                sleep(1);
            }
        } else {
            return array('code' => 0, 'data' => array());
        }


        return array('code' => 0, 'data' => array());

        /*
          $lastCount = $newCount = count($this->__em->getRepository('Fdl\Entity\Note')->findAll());
          $loops = 0;
          $customMessage = 'waited 15 loops';
          while ($loops < 25 && $lastCount == $newCount) {
          $loops++;
          $newCount = count($this->__em->getRepository('Fdl\Entity\Note')->findAll());
          if ($newCount != $lastCount) {
          $customMessage = 'changed number of fdls';
          return array('code' => 1, 'fdls' => $this->getAll());
          }
          sleep(1);
          }
          //            sleep(3);
          return array('code' => 0, 'data' => array());
         * 
         */
    }

    private function getNewNotes($id) {
        $result = $this->__em->createQuery("select N from Fdl\Entity\Note N 
            WHERE N.id > :id
            ORDER BY N.id DESC")
                ->setParameter('id', $id)
                ->getResult();
        if (empty($result))
            return false;
        else {
            foreach ($result as &$fdl) {
                $votesRaw = $fdl->getVotes();
                $array = array();
                foreach ($votesRaw as &$vot) {
                    $votUser = $vot->getUser()->getIterationArray();
                    unset($votUser['real_password']);
                    unset($votUser['password']);
                    $vot = $vot->getIterationArray();
                    $vot['user'] = $votUser;
                    array_push($array, $vot);
                }

                $user = $fdl->getUser()->getIterationArray();
                unset($user['real_password']);
                unset($user['password']);
                $category = $fdl->getCategory();
                $fdl = $this->serialize($fdl);
                $fdl['user'] = $user;
                $fdl['category'] = $category->getIterationArray();
                $fdl['votes'] = $array;
            }

            return $result;
        }
    }

    private function getLastNoteId() {
        $result = $this->__em->createQuery("select N.id from Fdl\Entity\Note N ORDER BY N.id DESC")
                ->setMaxResults(1)
                ->getResult();
        if (empty($result))
            return false;
        else
            return $result[0]['id'];
    }

    public function addVote($data) {

        /* must check if the user already vote for that fdl */

        $exists = $this->__em->getRepository('Fdl\Entity\Vote')->findBy(array('user_id' => $data->user_id, 'fdl_id' => $data->fdl_id, 'type' => $data->type));

        if ($exists) {
            $exists = $exists[0];

            if ($exists->getStatus() == 1) {
                $exists->setStatus(0);
            } else {
                $exists->setStatus(1);
            }

            $this->__em->persist($exists);

            $this->__em->flush();

            return array('code' => 101, 'message' => 'This vote already exists', 'testData' => $data);
        }

        $user = $this->__em->getRepository('Fdl\Entity\User')->find($data->user_id);

        $fdl = $this->__em->getRepository('Fdl\Entity\Note')->find($data->fdl_id);

        $vote = new \Fdl\Entity\Vote();

        $vote->setFdl($fdl);

        $vote->setUser($user);

        $vote->setType($data->type);

        $this->__em->persist($vote);

        $this->__em->flush($vote);

        return array('code' => 101, 'message' => 'Submitted', 'testData' => $data);
    }

    //CODE TO BE CONTINUED...
}
