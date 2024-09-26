<?php

namespace App\Repository;

use App\Entity\Categoria;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class CategoriaRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Categoria::class);
    }

    public function salvar(Categoria $categoria): void
    {
        $entityManager = $this->getEntityManager();
        $entityManager->persist($categoria);
        $entityManager->flush();
    }

    public function remove(Categoria $categoria): void
    {
        $entityManager = $this->getEntityManager(); 
        $entityManager->remove($categoria);
        $entityManager->flush();
    }
}
