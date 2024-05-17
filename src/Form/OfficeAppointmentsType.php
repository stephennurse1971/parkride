<?php

namespace App\Form;

use App\Entity\OfficeAppointments;
use App\Entity\User;
use App\Repository\TransactionRepository;
use App\Repository\UserRepository;
use App\Services\ClientHasFutureOfficeAppointment;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class OfficeAppointmentsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $users = [];
        if($options['mode'] == 'edit' ){
            $users[] = $this->userRepository->find($options['client_id']);
        }
        else {


            foreach ($this->transactionRepository->findAll() as $transaction) {
                if ($transaction->getStatus() == 'Pending') {
                    if ($this->clientHasFutureOfficeAppointment->getCountOfFutureOfficeAppointments($transaction->getClient()->getId()) == false) {
                        $users[] = $transaction->getClient();
                    }
                }
            }
        }
        $staff = [];
        foreach ($this->userRepository->findAll() as $user) {
            if (in_array('ROLE_STAFF',$user->getRoles())) {
                $staff[] = $user;
            }
        }

        $builder
            ->add('date', DateType::class, [
                'widget' => 'single_text',
            ])
            ->add('time')
            ->add('client', EntityType::class, [
                'class' => User::class,
                'choice_label' => 'fullName',
               'choices' => $users,
                'required' => true,

            ])
            ->add('staff', EntityType::class, [
                'class' => User::class,
                'choice_label' => 'fullName',
                'choices' => $staff,
                'required' => true,
                'empty_data' => null,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => OfficeAppointments::class,
            'mode'=>null,
            'client_id'=>null
        ]);
    }

    public function __construct(TransactionRepository $transactionRepository, ClientHasFutureOfficeAppointment $clientHasFutureOfficeAppointment, UserRepository $userRepository)
    {
        $this->transactionRepository = $transactionRepository;
        $this->userRepository = $userRepository;
        $this->clientHasFutureOfficeAppointment = $clientHasFutureOfficeAppointment;
    }
}
