<?php

namespace FreeNote\FreeNoteBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class UserProfileType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('surname')
            ->add('phone_number')
            ->add('newsletter', 'checkbox', array(
                'label' => 'fn.user.register.newsletter',
                'translation_domain' => 'FreeNoteBundle',
                'data' => true))
            ->add('free_notes')
            ->add('vg', 'hidden', array(
                'mapped' => false,
                'data' => ''));

    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'FreeNote\FreeNoteBundle\Entity\UserProfile',
            'validation_groups' => function(FormInterface $form)
            {
                return array($form->get('vg')->getData());
            },
        ));
    }

    public function getName()
    {
        return 'free_note_user_profile';
    }
}