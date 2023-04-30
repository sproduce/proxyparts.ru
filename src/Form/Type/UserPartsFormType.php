<?php

namespace App\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;


//use Symfony\Component\Form\Extension\Core\Type\SubmitType;

use App\Entity\UserParts;

class UserPartsFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('id', HiddenType::class,)
            ->add('price', IntegerType::class,['label' => 'Цена'])
            ->add('property', ChoiceType::class,[
                'trim' => true, 
                'label' => 'Состояние',
                'choices' => [
                    'Новая' => 0,
                    'Уценка' => 1,
                    'Б/У' => 10,   
                ]
            ])
            ->add('comment', TextType::class,['trim' => true, 'required' => false, 'label' => 'Комментарий']);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => UserParts::class,
        ]);
    }
}
