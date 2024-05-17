<?php

namespace App\Form;

use App\Entity\CmsDynamic;
use App\Entity\ServicesOffered;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CmsDynamicType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('category', ChoiceType::class, [
                'choices' => [
                    'Service' => 'Service',
                    'Article' => 'Article',
                    'Static' => 'Static',
                ],


            ])
            ->add('picture', FileType::class, [
                'label' => 'Picture',
                'mapped' => false,
                'required' => false,
                'attr' => [
                    'class' => 'photo'
                ]
            ])
            ->add('articlePage')
            ->add('webpage', EntityType::class, [
                'class' => ServicesOffered::class,
                'choice_label' => 'serviceOffered',
                'label'=> 'Service',
                'required' => false,
            ])
            ->add('title', TextType::class, [
                'label' => 'Title (English)',
                'required' => false
            ])
            ->add('titleFR', TextType::class, [
                'label' => 'Title (French)',
                'required' => false
            ])
            ->add('titleDE', TextType::class, [
                'label' => 'Title (German)',
                'required' => false
            ])
            ->add('titleES', TextType::class, [
                'label' => 'Title (Spanish)',
                'required' => false
            ])
            ->add('para1', TextareaType::class, [
                'label' => 'Para1 (English)',
                'required' => false
            ])
            ->add('para1FR', TextareaType::class, [
                'label' => 'Para1 (French)',
                'required' => false
            ])
            ->add('para1DE', TextareaType::class, [
                'label' => 'Para1 (German)',
                'required' => false
            ])
            ->add('para1ES', TextareaType::class, [
                'label' => 'Para1 (Spanish)',
                'required' => false
            ])
            ->add('para2', TextareaType::class, [
                'label' => 'Para2 (English)',
                'required' => false
            ])
            ->add('para2FR', TextareaType::class, [
                'label' => 'Para2 (French)',
                'required' => false
            ])
            ->add('para2DE', TextareaType::class, [
                'label' => 'Para2 (German)',
                'required' => false
            ])
            ->add('para2ES', TextareaType::class, [
                'label' => 'Para2 (Spanish)',
                'required' => false
            ])
            ->add('para3', TextareaType::class, [
                'label' => 'Para3 (English)',
                'required' => false
            ])
            ->add('para3FR', TextareaType::class, [
                'label' => 'Para3 (French)',
                'required' => false
            ])
            ->add('para3DE', TextareaType::class, [
                'label' => 'Para3 (German)',
                'required' => false
            ])
            ->add('para3ES', TextareaType::class, [
                'label' => 'Para4 (Spanish)',
                'required' => false
            ])
            ->add('para4', TextareaType::class, [
                'label' => 'Para4 (English)',
                'required' => false
            ])
            ->add('para4FR', TextareaType::class, [
                'label' => 'Para4 (French)',
                'required' => false
            ])
            ->add('para4DE', TextareaType::class, [
                'label' => 'Para4 (German)',
                'required' => false
            ])
            ->add('para4ES', TextareaType::class, [
                'label' => 'Para4 (Spanish)',
                'required' => false
            ])
            ->add('para5', TextareaType::class, [
                'label' => 'Para5 (English)',
                'required' => false
            ])
            ->add('para5FR', TextareaType::class, [
                'label' => 'Para5 (French)',
                'required' => false
            ])
            ->add('para5DE', TextareaType::class, [
                'label' => 'Para5 (German)',
                'required' => false
            ])
            ->add('para5ES', TextareaType::class, [
                'label' => 'Para5 (Spanish)',
                'required' => false
            ])
            ->add('para6', TextareaType::class, [
                'label' => 'Para6 (English)',
                'required' => false
            ])
            ->add('para6FR', TextareaType::class, [
                'label' => 'Para6 (French)',
                'required' => false
            ])
            ->add('para6DE', TextareaType::class, [
                'label' => 'Para6 (German)',
                'required' => false
            ])
            ->add('para6ES', TextareaType::class, [
                'label' => 'Para6 (Spanish)',
                'required' => false
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => CmsDynamic::class,
        ]);
    }
}
