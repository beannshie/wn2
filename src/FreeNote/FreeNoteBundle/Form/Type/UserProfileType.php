<?php

namespace FreeNote\FreeNoteBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use FreeNote\FreeNoteBundle\Model\fnUserParameters;
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
                'label' => 'fn.label.user.name'))
            ->add('surname', null, array(
                'label' => 'fn.label.user.surname'))
            ->add('phoneNumber', 'number', array(
                'label' => 'fn.label.user.phone_number'))
            ->add('recommendedBy', null, array(
                'label' => 'fn.label.user.recommended_by',
                'required' => false))
            ->add('avatar', null, array(
                'label' => 'fn.label.user.avatar'))
            ->add('newsletter', 'checkbox', array(
                'label' => 'fn.label.user.newsletter',
                'data' => true))
            ->add('postalAddress', 'sylius_address', array(
                'label' => 'fn.label.user.postal_address'));

        if(in_array($this->role, array(fnUserParameters::FN_ROLE_BUYER_CO, fnUserParameters::FN_ROLE_SELLER)))
        {
            $builder
                ->add('companyName', null, array(
                    'label' => 'fn.label.user.company_name'))
                ->add('nip', null, array(
                    'label' => 'fn.label.user.nip'))
                ->add('regon', null, array(
                    'label' => 'fn.label.user.regon'))
                ->add('businessAddress', 'sylius_address', array(
                    'label' => 'fn.label.user.business_address'));
        }
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'FreeNote\FreeNoteBundle\Entity\UserProfile',
            'cascade_validation' => true,
            'validation_groups' => function(FormInterface $form)
            {
                if($this->role == fnUserParameters::FN_ROLE_USER)
                {
                    return array('Default');
                }
                else if($this->role == fnUserParameters::FN_ROLE_BUYER)
                {
                    return array('buyerPP', 'Default');
                }
                else if($this->role == fnUserParameters::FN_ROLE_BUYER_CO)
                {
                    return array('buyerCO', 'Default');
                }
                else if($this->role == fnUserParameters::FN_ROLE_SELLER)
                {
                    return array('buyerCO', 'Default');
                }
            },
        ));
    }

    public function getName()
    {
        return 'free_note_user_profile';
    }
}