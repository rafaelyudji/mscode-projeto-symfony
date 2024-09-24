<?php

namespace App\Controller\Categoria;

use App\Repository\CategoriaRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ExcluirController extends AbstractController
{
    public function __construct(
        private CategoriaRepository $categoriaRepository,
    ) {
    }

    #[Route('categorias/excluir/{id}', name: 'excluir_categoria', methods: ['POST'])]
    public function excluir(int $id): Response
    {
        $categoria = $this->categoriaRepository->find($id);
        if (!$categoria) {
            $this->addFlash('danger', 'Categoria não encontrada.');
            return $this->redirectToRoute('listar_categorias');
        }

        $this->categoriaRepository->remove($categoria);
        $this->addFlash('success', 'Categoria excluída com sucesso!');

        return $this->redirectToRoute('listar_categorias');
    }
}
        