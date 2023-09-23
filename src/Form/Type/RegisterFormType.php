<?php

namespace App\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Validator\Constraints\Length;


class RegisterFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class,['trim' => true,'label' => 'Почта (Login)'])
            ->add('name', TextType::class,['trim' => true,'label' => 'Имя (название организации)'])
            ->add('passwd', RepeatedType::class,[
                        'trim' => true,
                        'type' => PasswordType::class,
                        'constraints' => [new Length(['min' => 7,
                            'minMessage' => 'Пароль не может быть короче {{ limit }} символов',
                            ])],
                        'invalid_message' => 'Пароли не совпадают.',
                    ])
            ->add('submit',SubmitType::class);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
