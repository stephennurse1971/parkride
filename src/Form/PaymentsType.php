<?php

namespace App\Form;

use App\Entity\Payments;
use App\Entity\Transaction;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PaymentsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('date', DateType::class, [
                'widget' => 'single_text',
                'data'=>new \DateTime()
            ])
            ->add('amount',TextType::class,[
                'data'=>$options['balancedOwed']
            ])
            ->add('transaction', EntityType::class, [
                'class' => Transaction::class,
                'choice_label' => 'id',
                'required' => true,
                'empty_data' => null,
                'data'=>$options['transaction']
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Payments::class,
            'transaction'=>null,
            'balancedOwed'=>null
        ]);
    }
}
