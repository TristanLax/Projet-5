<?php

namespace App\Form;

use App\Entity\Post;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PostEditType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, array('label' => 'Titre :'))
            ->add('content', TextareaType::class, array(
                'attr' => array('class' => 'ckeditor'),
                'label' => 'Message :'
            ))
            ->add('mainImage', FileType::class, array(
                    'label' => 'Image principale :',
                    'required' => false ))
            ->add('pictureFiles', FileType::class, array(
                    'required' => false, 'multiple' => true,
                    'label' => 'Images supplémentaires :'))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Post::class,
        ]);
    }
}
