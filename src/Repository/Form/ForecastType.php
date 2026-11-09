<?php

namespace App\Repository\Form;

use App\Entity\Forecast;
use App\Entity\Location;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ForecastType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('location', EntityType::class, [
                'class' => Location::class,
                'choice_label' => 'name',
            ])
            ->add('date', DateType::class, [
                'widget' => 'single_text',
            ])
            ->add('temp_celc', NumberType::class, ['label' => 'Temperature (°C)', 'input' => 'string', 'scale' => 0])
            ->add('humidity', NumberType::class, ['label' => 'Humidity (%)', 'input' => 'string', 'scale' => 0])
            ->add('wind_speed', NumberType::class, ['label' => 'Wind speed (km/h)', 'input' => 'string', 'scale' => 0])
            ->add('precipitation', NumberType::class, ['label' => 'Precipitation (mm)', 'input' => 'string', 'scale' => 0])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Forecast::class,
        ]);
    }
}

/* Kod wygenerowany z pomoca z claude opus 5.5 */
