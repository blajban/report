<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Book;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
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

    #[Route("/library/add", name: "library_add", methods: ['GET'])]
    public function addBook(): Response
    {
        return $this->render('library/library_add.html.twig', [
            'title' => "Lägg till bok",
            'heading' => "Lägg till bok",
            'content' => $this->utilityService->parseMarkdown('library.md')
        ]);
    }

    #[Route('/library/add', name: 'library_add_callback', methods: ['POST'])]
    public function addBookCallback(BookRepository $bookRepository, Request $request): Response 
    {
        // ADD SUPPORT FOR PICTURE
        // ADD FORM INPUT VALIDATION
        // ADD EXCEPTION HANDLING

        $title = $request->request->get('title');
        $author = $request->request->get('author');
        $isbn = $request->request->get('isbn');

        $book = new Book();
        $book->setTitle($title);
        $book->setAuthor($author);
        $book->setIsbn($isbn);

        $bookRepository->save($book, true);

        return $this->redirectToRoute('library');
    }

    #[Route("/library/edit/handle_checkboxes", name: "library_edit_handle_checkboxes", methods: ['POST'])]
    public function editBooksHandleCheckboxes(BookRepository $bookRepository, Request $request): Response
    {
        $submittedData = $request->request->all();
        $bookIds = isset($submittedData['book_ids']) ? $submittedData['book_ids'] : [];

        return $this->redirectToRoute('library_edit', ['book_ids' => $bookIds]);
    }

    #[Route("/library/edit", name: "library_edit", methods: ['GET'])]
    public function editBooks(BookRepository $bookRepository, Request $request): Response
    {
        $submittedData = $request->request->all();
        $bookIds = isset($submittedData['book_ids']) ? $submittedData['book_ids'] : [];

        $books = [];

        // Handle the checked checkboxes here
        foreach ($bookIds as $bookId) {
            $books[] = $bookRepository->find($bookId);
        }

        return $this->render('library/library_edit.html.twig', [
            'title' => "Böcker",
            'heading' => "Böcker",
            'content' => $this->utilityService->parseMarkdown('library.md'),
            'books' => $books
        ]);
    }

    #[Route('/library/edit', name: 'library_edit_callback', methods: ['POST'])]
    public function editBooksCallback(BookRepository $bookRepository, Request $request): Response 
    {
        return $this->redirectToRoute('library');
    }

    #[Route("/library/remove", name: "library_remove", methods: ['GET'])]
    public function removeBook(): Response
    {
        return $this->render('library/library_remove.html.twig', [
            'title' => "Vill du verkligen ta bort boken?",
            'heading' => "Vill du verkligen ta bort boken?",
            'content' => $this->utilityService->parseMarkdown('library.md')
        ]);
    }

    #[Route('/library/confirm', name: 'library_confirm_callback', methods: ['POST'])]
    public function confirmRemoveBookCallback(BookRepository $bookRepository, Request $request): Response 
    {
        return $this->redirectToRoute('library_remove');
    }

    #[Route('/library/edit', name: 'library_remove_callback', methods: ['POST'])]
    public function removeBookCallback(BookRepository $bookRepository, Request $request): Response 
    {
        return $this->redirectToRoute('library');
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
