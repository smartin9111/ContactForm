<?php

namespace App\Form;

use App\Entity\UserData;
use Doctrine\DBAL\Types\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserDataType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('name', null, [
            'attr' => ['placeholder' => 'Név']
        ])
        ->add('email', null, [
            'attr' => ['placeholder' => 'E-mail']
        ])
        ->add('message', null, [
            'attr' => ['placeholder' => 'Üzenet']
        ]);
            
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => UserData::class,
            'success_message' => 'Köszönjük szépen a kérdésedet. Válaszunkkal hamarosan keresünk a megadott e-mail címen.'

        ]);
    }
}
