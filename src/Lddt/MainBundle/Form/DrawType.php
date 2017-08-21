<?php

namespace Lddt\MainBundle\Form;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DrawType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('title',TextType::class,
            array('label'=>'Nom du dessin'));

            if(! $builder->getData()->getId ()){
                /*$builder ->add('drawPath',TextType::class,
                array('label'=>'chemin du dessin',
                    'attr'=>array('class'=>'form-control')));*/
                //Formulaire imbriqué pour charger la clas PicType > 1 form pour créer un dessin et 1 form imbriqué pour créer un image
                $builder->add('pic',PicType::class);
            }


//           $builder ->add('avatarPath',TextType::class,
//                array('label'=>'chemin de votre avatar'))
//
//            ->add('authorName',TextType::class,
//                array('label'=>'Pseudo', 'attr'=>array ('class'=>form-control')));


            //->add('drawPath')
             //->add('isOnline')
           //->add('avatarPath')
            //->add('authorName')
            //->add('createdAt')
            //->add('updatedAt')
            $builder->add('category', EntityType::class,
                array('class'=>"Lddt\MainBundle\Entity\Category",
                    'choice_label'=>'name','label'=>'Catégorie'))

            ->add('color',EntityType::class,
                array('class'=>"Lddt\MainBundle\Entity\Color",'label'=>'Associez vos couleurs',
        'choice_label'=>'name','multiple'=>true, 'expanded'=>true))

               /*->add('tag',EntityType::class,
                   array('class'=>"Lddt\MainBundle\Entity\Tag",'label'=>'Taguez vos dessins',
                       'choice_label'=>'name','multiple'=>true, 'expanded'=>true))*/

               ->add('tag',CollectionType::class,
                   array('entry_type'=>TagType::class,
                       'allow_add'=>true,
                   'allow_delete'=>true))

            ->add('valider',SubmitType::class,
                array('attr'=> array('class'=>'btn btn-primary pull-right')));
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Lddt\MainBundle\Entity\Draw'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'lddt_mainbundle_draw';
    }


}
