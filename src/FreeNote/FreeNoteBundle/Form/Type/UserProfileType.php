<?php

namespace FreeNote\FreeNoteBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use FreeNote\FreeNoteBundle\Model\fnUserInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class UserProfileType extends AbstractType
{
    /**
     * User role.
     *
     * @var string
     */
    protected $role;

    /**
     * Constructor.
     *
     * @param $role
     */
    public function __construct($role)
    {
        $this->role = $role;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', null, array(
                'label' => 'fn.user.register.name',
                'translation_domain' => 'fnForms'))
            ->add('surname', null, array(
                'label' => 'fn.user.register.surname',
                'translation_domain' => 'fnForms'))
            ->add('phone_number', null, array(
                'label' => 'fn.user.register.phone_number',
                'translation_domain' => 'fnForms'))
            ->add('recommended_by', null, array(
                'label' => 'fn.user.register.recommended_by',
                'translation_domain' => 'fnForms'))
            ->add('avatar', null, array(
                'label' => 'fn.user.register.avatar',
                'translation_domain' => 'fnForms'))
            ->add('newsletter', 'checkbox', array(
                'label' => 'fn.user.register.newsletter',
                'translation_domain' => 'fnForms',
                'data' => true))
            ->add('postal_address', null, array(
                'label' => 'fn.user.register.postal_address',
                'translation_domain' => 'fnForms'));

        if($this->role == fnUserInterface::FN_ROLE_BUYER_CO)
        {
            $builder
                ->add('companyName', null, array(
                'label' => 'fn.user.register.company_name',
                'translation_domain' => 'fnForms'))
                ->add('nip', null, array(
                'label' => 'fn.user.register.nip',
                'translation_domain' => 'fnForms'))
                ->add('regon', null, array(
                'label' => 'fn.user.register.regon',
                'translation_domain' => 'fnForms'))
                ->add('business_address', null, array(
                'label' => 'fn.user.register.business_address',
                'translation_domain' => 'fnForms'));
        }
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'FreeNote\FreeNoteBundle\Entity\UserProfile',
            'cascade_validation' => true,
            'validation_groups' => function(FormInterface $form)
            {
                if($this->role == fnUserInterface::FN_ROLE_USER)
                {
                    return array();
                }
                else if($this->role == fnUserInterface::FN_ROLE_BUYER)
                {
                    return array('buyerPP');
                }
                else if($this->role == fnUserInterface::FN_ROLE_BUYER_CO)
                {
                    return array('buyerCO');
                }
                else if($this->role == fnUserInterface::FN_ROLE_SELLER)
                {
                    return array();
                }
            },
        ));
    }

    public function getName()
    {
        return 'free_note_user_profile';
    }
}