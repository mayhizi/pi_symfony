<?php

namespace RandonneeBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;






class RandonneeType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom',TextType::class)
            ->add('destination',ChoiceType::class,array(
                'label' =>'destination ',
               'choices' =>array('----' =>'----','Tunis'=>'tunis','Sousse'=>'sousse','Nabeul'=>'nabeul','Ariana'=>'ariana','Béja'=>'béja','Ben Arous'=>'ben arous','Bizerte'=>'bizerte','Gabes'=>'gabes','Gafsa'=>'gafsa','Jendouba'=>'jendouba','Kairaouen'=>'kairaouen','Ariana'=>'ariana','Kasserine'=>'kasserine','Kébili'=>'kébili','Le Kef'=>'le kef','Mahdia'=>'mahdia','La Manouba'=>'la manouba','Médnine'=>'médnine','Monastir'=>'monastir','Ariana'=>'ariana','Sfax'=>'sfax','Sidi Bouzid'=>'sidi bouzid','Siliana'=>'siliana','Tataouine'=>'tataouine','Tozeur'=>'tozeur','Zaghouen'=>'zaghouen'),
                'required'=>false,
                'multiple' =>false,
            ))
            ->add('prix')
            ->add('description',TextareaType::class)
            ->add('type_rand',ChoiceType::class,array(
                'label' =>'type_rand ',
                'choices' =>array('----' =>'----','Difficile'=>'difficile','Moyenne'=>'moyenne','Facile'=>'facile'),
                 'required'=>false,
                'multiple' =>false,
            ))
            ->add('nb_places')
            ->add('date_debut', TimeType::class, array(
                    'input'  => 'datetime',
                    'widget' => 'choice',

                )
            )
            ->add('date_fin', TimeType::class, array(
                    'input'  => 'datetime',
                    'widget' => 'choice',

                )
            )
            ->add('date_rand', DateType::class, array(

                'years' => range(date('Y'), date('Y')+2),


            ))
            ->add('imageFile', FileType::class);

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

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'randonneebundle_randonnee';
    }


}
