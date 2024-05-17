<?php

namespace App\Form;

use App\Entity\Competitors;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CompetitorsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            ->add('webSite')
            ->add('telephone')
            ->add('companyAddressStreet')
            ->add('companyAddressCity')
            ->add('companyAddressPostalCode')
            ->add('companyAddressCountry')
            ->add('facebook')
            ->add('linkedIn')
            ->add('instagram')
            ->add('twitter')
            ->add('type', ChoiceType::class, [
                'multiple' => false,
                'expanded' => false,
                'choices' => [
                    'Law firm' => 'Law firm',
                    'Immigration specialist' => 'Immigration specialist'
                ],])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Competitors::class,
        ]);
    }
}
