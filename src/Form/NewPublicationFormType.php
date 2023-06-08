<?php

namespace App\Form;

use App\Entity\Article;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class NewPublicationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class,[
                'label' => 'Titre',
                'constrains' => [
                    new NotBlank([
                        'message' => 'Merci de renseigner un titre',
                    ]),
            new length([
                'min' => 2,
                'max' => 150,
                'minMessage' => 'le titre doit contenir au minimum {{ limit }} caractères ',
                'maxMessage' => 'le titre doit contenir au maximum {{ limit }} caractères ',


            ]),

        ],
    ])





            ->add('content', TextareaType::class, [
                'label' => 'Titre',
                'constrains' => [
                    new NotBlank([
                        'message' => 'Merci de renseigner un titre',
                    ]),
                    new length([
                        'min' => 2,
                        'max' => 150,
                        'minMessage' => 'le titre doit contenir au minimum {{ limit }} caractères ',
                        'maxMessage' => 'le titre doit contenir au maximum {{ limit }} caractères ',

                    ]),

        ],
    ])


            ->add('save', SubmitType::class, [
                'label' => 'Publier',
                'attr' => [
                    'class' => 'bt btn-outline-primary w-100',
                ],
            ])

        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Article::class,

            'attr' => [
                'novalidate' => 'novalidate'
            ]
        ]);
    }
}
