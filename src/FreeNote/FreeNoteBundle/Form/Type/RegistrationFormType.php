<?php

namespace FreeNote\FreeNoteBundle\Form\Type;

use Symfony\Component\Form\FormBuilderInterface;
use FreeNote\FreeNoteBundle\Model\fnUserParameters;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use FOS\UserBundle\Form\Type\RegistrationFormType as BaseType;

class RegistrationFormType extends BaseType
{
    /**
     * User role.
     *
     * @var string
     */
    protected $role = fnUserParameters::FN_ROLE_USER;

    /**
     * @param $role
     */
    public function setRole($role)
    {
        $this->role = $role;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);

        $builder
            ->add('accountType', 'hidden', array(
                'mapped' => false,
                'data' => ''
            ))
        ;
        $builder
            ->add('userProfile', new UserProfileType($this->role), array(
                'label' => 'fn.label.user.profile'
            ))
        ;
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
