<?php

namespace App\Form;

use App\Entity\Autoservice;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AutoserviceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('address')
            ->add('dateAdd')
            ->add('description')
            ->add('email')
            ->add('name')
            ->add('photo')
            ->add('tel')
            ->add('services')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Autoservice::class,
        ]);
    }

}
