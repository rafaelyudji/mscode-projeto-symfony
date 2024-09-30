<?php

namespace App\Repository;

use App\Entity\Produto;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class ProdutoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Produto::class);
    }

    public function save(Produto $produto): void
    {
        $entityManager = $this->getEntityManager();
        $entityManager->persist($produto);
        $entityManager->flush();
    }
    
    // Outros métodos personalizados, se necessário.
}
