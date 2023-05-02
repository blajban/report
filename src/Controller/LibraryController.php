<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Book;
use Doctrine\Persistence\ManagerRegistry;
use App\Repository\BookRepository;


use App\Services\UtilityService;

class LibraryController extends AbstractController
{
    private UtilityService $utilityService;

    public function __construct(UtilityService $utilityService)
    {
        $this->utilityService = $utilityService;
    }

    #[Route("/library", name: "library", methods: ['GET'])]
    public function libraryLanding(BookRepository $bookRepository): Response
    {
        $books = $bookRepository->findAll();
        return $this->render('library/library_start.html.twig', [
            'title' => "Bibliotek",
            'heading' => "Bibliotek",
            'content' => $this->utilityService->parseMarkdown('library.md'),
            'books' => $books
        ]);
    }

    // MAKE INTO POST
    #[Route('/library/add', name: 'library_add')]
    public function addBook(BookRepository $bookRepository): Response 
    {
        $book = new Book();
        $book->setTitle('Här är en bok');
        $book->setIsbn('978-91-7000-150-5');
        $book->setAuthor('Erik Sjöberg');

        // tell Doctrine you want to (eventually) save the Product
        // (no queries yet)
        $bookRepository->save($book, true);

        return new Response('Saved new book with id '.$book->getId());
    }

    #[Route('/library/show', name: 'library_show_all')]
    public function showAllBooks(BookRepository $bookRepository): Response 
    {
        $books = $bookRepository->findAll();

        return $this->json($books);
    }

    #[Route('/library/show/{id}', name: 'library_show_by_id')]
    public function showBookById(BookRepository $bookRepository, int $id): Response
    {
        $book = $bookRepository->find($id);

        return $this->json($book);
    }

    #[Route('/library/delete/{id}', name: 'library_delete_by_id')]
    public function deleteBookById(BookRepository $bookRepository, int $id): Response
    {
        $book = $bookRepository->find($id);

        if (!$book) {
            throw $this->createNotFoundException(
                'No book found for id '.$id
            );
        }

        $bookRepository->remove($book, true);

        return $this->redirectToRoute('library_show_all');
    }

    #[Route('/library/update/{id}/{title}', name: 'library_update')]
    public function updateBook(BookRepository $bookRepository, int $id, string $title): Response
    {
        $book = $bookRepository->find($id);

        if (!$book) {
            throw $this->createNotFoundException(
                'No book found for id '.$id
            );
        }

        $book->setTitle($title);
        $bookRepository->save($book, true);

        return $this->redirectToRoute('library_show_all');
    }
}
