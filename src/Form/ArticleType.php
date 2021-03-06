<?php

namespace App\Form;

use App\Entity\Article;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ArticleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('titre')

            ->add('image', FileType::class, 
            [
                'label' => 'image',
               
            ])

            ->add('description', TextareaType::class, 
            [
                'attr' =>
                [
                'row' => 30,
                ]
            ])

            ->add('Enregistrer', SubmitType::class,
            [
                'attr' =>
                [
                'class' => 'btn'
                ],
                
                ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Article::class,
        ]);
    }
}
