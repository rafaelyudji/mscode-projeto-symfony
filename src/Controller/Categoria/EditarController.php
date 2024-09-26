<?php

namespace App\Controller\Categoria;

use App\Entity\Categoria;
use App\Repository\CategoriaRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EditarController extends AbstractController
{
    public function __construct(private CategoriaRepository $categoriaRepository)
    {
    }

    #[Route('/categorias/editar/{id}', name: 'editar_categoria_show', methods: ['GET'])]
    public function show(int $id): Response
    {
        $categoria = $this->categoriaRepository->find($id);

        if (!$categoria) {
            $this->addFlash('danger', 'Categoria não encontrada.');
            return $this->redirectToRoute('listar_categorias');
        }

        return $this->render('categoria/editar.html.twig', [
            'categoria' => $categoria
        ]); 
    }

    #[Route('/categorias/editar/{id}', name: 'editar_categoria_salvar', methods: ['POST'])]
    public function salvar(Request $request, int $id): Response
    {
        $categoria = $this->categoriaRepository->find($id);
        if (!$categoria) {
            $this->addFlash('danger', 'Categoria não encontrada.');
            return $this->redirectToRoute('listar_categorias');
        }

        $nomeCategoria = $request->request->get('nome');
        if (strlen($nomeCategoria) > 50) {
            $this->addFlash('danger', 'Nome deve ter no máximo 50 caracteres!');
            return $this->redirectToRoute('editar_categoria_show', ['id' => $id]);
        }

        $categoria->setNome($nomeCategoria);
        $this->categoriaRepository->salvar($categoria);

        return $this->redirectToRoute('listar_categorias');
    }
}
