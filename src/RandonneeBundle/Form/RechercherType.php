<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 23/11/2017
 * Time: 19:00
 */

namespace RandonneeBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

use Symfony\Component\Form\Extension\Core\Type\TextType;


class RechercherType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('nom', TextType::class)
            ->add('destination', TextType::class)
            ->add('Rechercher', SubmitType::class);
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'RandonneeBundle\Entity\Randonnee'
        ));
    }


}