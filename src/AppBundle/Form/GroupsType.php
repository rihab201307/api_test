<?php
/**
 * Created by PhpStorm.
 * User: redouane
 * Date: 28/02/2018
 * Time: 20:15
 */

namespace AppBundle\Form;

use AppBundle\Entity\Groups;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


class GroupsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('nom');
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Groups::class,
            'csrf_protection' => false
        ]);

    }

}