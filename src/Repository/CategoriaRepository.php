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
        $this->_em->persist($categoria);
        $this->_em->flush();
    }

    public function remove(Categoria $categoria): void
    {
        $this->_em->remove($categoria);
        $this->_em->flush();
    }
}
