<?php

namespace App\Services;

use App\Entity\Countries;
use App\Entity\DocumentHistory;
use App\Entity\User;
use App\Repository\DocumentHistoryRepository;
use Doctrine\ORM\EntityManagerInterface;

class DocumentAuditTracker
{
    public function update($oldEntity,$entity,$document,User $user,User $client){
        $notes = [];
        $getters = array_filter(get_class_methods($entity), function ($method) {
            return 'get' === substr($method, 0, 3);
        });
        foreach ($getters as $getter) {
            if ($entity->{$getter}() != $oldEntity->{$getter}()) {
                $changed = str_replace('get','',$getter);
                $old_value = $oldEntity->{$getter}();
                $new_value = $entity->{$getter}();

                if($entity->{$getter}() instanceof User){
                    $old_value = $oldEntity->{$getter}()->getFullName();
                    $new_value = $entity->{$getter}()->getFullName();
                }

                if($entity->{$getter}() instanceof Countries){
                    $old_value = $oldEntity->{$getter}()->getCountry();
                    $new_value = $entity->{$getter}()->getCountry();
                }

                if($entity->{$getter}() instanceof \DateTime){
                    $old_value = $oldEntity->{$getter}()->format('Y-m-d');
                    $new_value = $entity->{$getter}()->format('Y-m-d');
                }


             $notes[] = $changed. ' changed from '.$old_value. ' to '.$new_value;
            }
        }
        if(!empty($notes)){
            $document_history = new DocumentHistory();
            $document_history->setNotes($notes)
                ->setEditedBy($user)
                ->setDate(new \DateTime('now'))
                ->setDocument($document)
                ->setDocumentId($entity->getId())
                ->setClient($client);
            ;
            $this->manager->persist($document_history);
            $this->manager->flush();
        }
       return count($notes) ;

    }
    public function getDocumentHistory($document,User $user){
        return $this->documentHistoryRepository->findBy(['document'=>$document, 'client'=>$user]);

    }
    public function __construct(EntityManagerInterface $manager,DocumentHistoryRepository $documentHistoryRepository)
    {
        $this->manager = $manager;
        $this->documentHistoryRepository = $documentHistoryRepository;
    }

}