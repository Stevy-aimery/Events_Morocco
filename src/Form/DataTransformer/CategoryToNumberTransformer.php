<?php
// src/Form/DataTransformer/CategoryToNumberTransformer.php
namespace App\Form\DataTransformer;

use App\Entity\Category;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;

class CategoryToNumberTransformer implements DataTransformerInterface
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function transform($category): ?int
    {
        if (null === $category) {
            return null;
        }

        if (!$category instanceof Category) {
            throw new TransformationFailedException('Expected a Category object.');
        }

        return $category->getId();
    }

    public function reverseTransform($categoryId): ?Category
    {
        if (!$categoryId) {
            return null;
        }

        $category = $this->entityManager
            ->getRepository(Category::class)
            ->find($categoryId);

        if (null === $category) {
            throw new TransformationFailedException(sprintf(
                'A category with ID "%s" does not exist!',
                $categoryId
            ));
        }

        return $category;
    }
}
