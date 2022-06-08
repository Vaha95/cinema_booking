<?php

namespace App\Domain\Booking\Form;

use App\Domain\Booking\Entity\Session;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class BookingType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'required' => true,
            ])
            ->add('phone', TextType::class, [
                'required' => true,
            ])
            ->add('places', NumberType::class, [
                'required' => true,
            ])
            ->add('session', EntityType::class, [
                'required' => true,
                'class' => Session::class,
            ]);
    }
}