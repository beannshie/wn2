<?php

namespace FreeNote\FreeNoteBundle\Form\Type;

use Symfony\Component\Form\FormBuilderInterface;
use FreeNote\FreeNoteBundle\Model\fnUserInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use FOS\UserBundle\Form\Type\RegistrationFormType as BaseType;

class RegistrationFormType extends BaseType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);

        $builder
            ->add('accountType', 'hidden', array(
            'mapped' => false,
            'data' => ''));
        $builder->add('userProfile', new UserProfileType(fnUserInterface::FN_ROLE_BUYER), array(
            'label' => 'fn.user.register.profile',
            'translation_domain' => 'fnForms'));
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        parent::setDefaultOptions($resolver);

        $resolver->setDefaults(array(
            'cascade_validation' => true,
        ));
    }

    public function getName()
    {
        return 'free_note_user_registration';
    }
}
