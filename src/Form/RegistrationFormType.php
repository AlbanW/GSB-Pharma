<?php

namespace App\Form;

use App\Entity\Client;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Validator\Constraints\NotBlank;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('nom', TextType::class, [
            'attr' => [
                'class' => 'form-control'
            ],
            'label_attr' => [
                'label_class' => 'form-label'
            ]
            ])
        ->add('mail', EmailType::class, [
            'attr' => [
                'class' => 'form-control'
            ],
            'label_attr' => [
                'label_class' => 'form-label'
            ]
            ])

        ->add('prenom', TextType::class, [
            'attr' => [
                'class' => 'form-control'
            ],
            'label_attr' => [
                'label_class' => 'form-label'
            ]
            ])
        ->add('adresse', TextType::class, [
            'attr' => [
                'class' => 'form-control'
            ],
            'label_attr' => [
                'label_class' => 'form-label'
            ]
            ])
        ->add('ville', TextType::class, [
            'attr' => [
                'class' => 'form-control'
            ],
            'label_attr' => [
                'label_class' => 'form-label'
            ]
            ])
        ->add('codePostal', TextType::class, [
            'attr' => [
                'class' => 'form-control'
            ],
            'label_attr' => [
                'label_class' => 'form-label'
            ]
            ])
        ->add('telephone', TextType::class, [
            'attr' => [
                'class' => 'form-control'
            ],
            'label_attr' => [
                'label_class' => 'form-label'
            ]
            ])
        ->add('password', RepeatedType::class, [
            'type' => PasswordType::class,
            'first_options'=> [
                'label'=>'Mot de passe',
                'attr'=> ['class'=>'form-control'],
                'label_attr' => ['label_class' => 'form-label']
            ],
            'second_options'=> [
                'label' => 'Confirmation du mot de passe',
                'attr' => ['class'=>'form-control'],
                'label_attr' => ['label_class' => 'form-label']
            ],
            'invalid_message' => 'Les mots de passe ne correspondent pas'
        ])
        ->add('acceptCgu', CheckboxType::class, [
            'label'    => 'Show this entry publicly?',
            'attr' => 
            [
                'class' => 'form-check-input'
            ],
            'label_attr'=> [
                'label_class' => 'form-check-label'
            ],
            'required' => true,
        ])
        ->add('submit', SubmitType::class, [
            'label' => 'Inscris-moi',
            'attr' => [
                'class'=>'btn btn-light',
            ]
        ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Client::class,
        ]);
    }
}
