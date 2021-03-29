<?php

namespace App\Form;

use App\Entity\Uploads;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FilesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('fileName', 
                FileType::class
            );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Uploads::class,
            // включить/выключить защиту от CSRF для этой формы
            'csrf_protection' => true,
            // имя скрытого HTML поля, хранящего токен
            'csrf_field_name' => '_token',
            // произвольная строка, использовання для генерирования значения токена,
            // использование другой строки для каждой формы усиливает её безопасность
            'csrf_token_id'   => 'upload_csrf',
        ]);
    }
}
