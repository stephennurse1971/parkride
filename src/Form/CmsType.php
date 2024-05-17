<?php

namespace App\Form;

use App\Entity\Cms;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CmsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('companyName')
            ->add('companyEmail')
            ->add('companyTel')
            ->add('companyMobile')
            ->add('companyAddress')
            ->add('companyAddressCity')
            ->add('companyAddressPostalCode')
            ->add('companyAddressCountry')
            ->add('addressGpsLocation')
            ->add('addressInstructions')
            ->add('cms1EN', TextareaType::class, [
                'label' => 'CMS 1',
                'required' => false
            ])
            ->add('cms2EN', TextareaType::class, [
                'label' => 'CMS 2',
                'required' => false
            ])
            ->add('cms3EN', TextareaType::class, [
                'label' => 'CMS 3',
                'required' => false
            ])
            ->add('cms4EN', TextareaType::class, [
                'label' => 'CMS 4',
                'required' => false
            ])
            ->add('footerText', TextareaType::class, [
                'label' => 'Footer text',
                'required' => false
            ])
            ->add('facebook')
            ->add('twitter')
            ->add('instagram')
            ->add('linkedIn')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Cms::class,
        ]);
    }
}
