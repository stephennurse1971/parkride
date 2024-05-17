<?php

namespace App\Form;

use App\Entity\DocumentHistory;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DocumentHistoryType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
//            ->add('notes',:class,[
//             //   'mapped'=>false
//            ])
            ->add('notes')
            ->add('document')
            ->add('documentId')
            ->add('date', DateType::class, [
                'widget' => 'single_text',
            ])
            ->add('editedBy', EntityType::class, [
                'class' => User::class,
                'choice_label' => 'fullName',
                'required' => true,
                'empty_data' => null,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => DocumentHistory::class,
        ]);
    }
}
