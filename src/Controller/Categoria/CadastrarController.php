<?php

namespace App\Controller\Categoria; // Certifique-se de que o namespace está correto

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\CategoriaRepository; 
use App\Entity\Categoria;

class CadastrarController extends AbstractController
{
    public function __construct(private CategoriaRepository $categoriaRepository)
    {
    }

    #[Route('/categorias/cadastrar', name: 'cadastrar_categoria_show', methods: ['GET'])] // Adicionei uma barra inicial no path
    public function show(): Response
    {
        return $this->render('categoria/cadastrar.html.twig'); // Corrigi o caminho para o template
    }   

    #[Route('/categorias/cadastrar', name: 'cadastrar_categoria_salvar', methods: ['POST'])] // Adicionei uma barra inicial no path
    public function salvar(Request $request): Response
    {
        $nomeCategoria = $request->request->get('nome');

        if (strlen($nomeCategoria) > 50) {
            $this->addFlash('danger', 'Nome deve ter no máximo 50 caracteres!');
            return $this->redirectToRoute('cadastrar_categoria_show');
        }

        $categoriaExistente = $this->categoriaRepository->findOneBy(['nome' => $nomeCategoria]);

        if ($categoriaExistente) {
            $this->addFlash('danger', "Categoria com nome \"{$nomeCategoria}\" já existe!");
            return $this->redirectToRoute('cadastrar_categoria_show');
        }

        $categoria = new Categoria();
        $categoria->setNome($nomeCategoria);

        $this->categoriaRepository->salvar($categoria);

        $this->addFlash('success', 'Categoria cadastrada com sucesso!'); 
        return $this->redirectToRoute('listar_categorias'); 
    }
}
