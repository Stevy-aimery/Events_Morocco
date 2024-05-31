<?php

namespace App\Form;

use App\Entity\Event;
use App\Form\DataTransformer\CategoryToNumberTransformer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Validator\Constraints\Choice;
use Symfony\Component\Validator\Constraints\NotBlank;



class EventFormType extends AbstractType
{

    private $categoryTransformer;

    public function __construct(CategoryToNumberTransformer $categoryTransformer)
    {
        $this->categoryTransformer = $categoryTransformer;
    }
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titre')
            ->add('description')
            ->add('dateDebut', null, [
                'widget' => 'single_text',
            ])
            ->add('dateFin', null, [
                'widget' => 'single_text',
            ])
            ->add('capacite')
            ->add('prixBillet')
            ->add('image')
            ->add('lieu')
            ->add('category', IntegerType::class, [
                'label' => 'Category',
                'constraints' => [
                    new NotBlank(),
                   
                ],
            ])
        ;
        $builder->get('category')
            ->addModelTransformer($this->categoryTransformer);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Event::class,
        ]);
    }
}
