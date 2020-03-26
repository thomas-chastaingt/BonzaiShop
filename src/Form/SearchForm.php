<?php

namespace App\Form;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Entity\Category;
use App\Data\SearchData;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
class SearchForm extends AbstractType 
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('categories', EntityType::class, [
            'label' => false,
            'required' => false,
            'class' => Category::class,
            'expanded' => true,
            'multiple' => true,
        ]);
    }

    public function configureOptions(OptionsResolver $resolver) 
    {
        $resolver->setDefaults([
            'data_class' => SearchData::class,
            'method' => "GET",
            'csrf_protection' => false

        ]);
    }

    public function getBlockPrefix()
    {
        return '';
    }


}



?>