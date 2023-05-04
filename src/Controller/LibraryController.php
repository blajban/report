<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Book;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\BookRepository;

//use App\Library\Library;


use App\Services\UtilityService;

class LibraryController extends AbstractController
{
    private UtilityService $utilityService;

    public function __construct(UtilityService $utilityService)
    {
        $this->utilityService = $utilityService;
    }

    #[Route('/book_picture/{id}', name: 'book_picture')]
    public function bookPicture(int $id, BookRepository $bookRepository): Response
    {
        $book = $bookRepository->find($id);

        if (!$book || !$book->getPicture()) {
            throw $this->createNotFoundException('No book picture found for id ' . $id);
        }

        $pictureData = stream_get_contents($book->getPicture());

        $response = new Response($pictureData);
        $response->headers->set('Content-Type', 'image');

        return $response;
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
        // ADD FORM INPUT VALIDATION FOR ISBN

        /** @var UploadedFile $pictureFile */
        $pictureFile = $request->files->get('picture');

        $pictureData = null;
        if ($pictureFile) {
            $pictureData = file_get_contents($pictureFile->getPathname());
        }

        $book = new Book();
        $bookRepository->add($book, [
            'title' => $request->request->get('title'),
            'author' => $request->request->get('author'),
            'isbn' => $request->request->get('isbn'),
            'picture' => $pictureData
        ]);

        return $this->redirectToRoute('library');
    }

    #[Route("/library/edit", name: "library_edit", methods: ['GET'])]
    public function editBooks(BookRepository $bookRepository, Request $request): Response
    {
        // ADD FORM INPUT VALIDATION
        // ADD EXCEPTION HANDLING

        $submittedData = $request->query->all();
        $bookIds = isset($submittedData['book_ids']) ? $submittedData['book_ids'] : [];

        $books = $bookRepository->findManybyId($bookIds);

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
        $bookId = $request->request->get('book_to_update');

        /** @var UploadedFile $pictureFile */
        $pictureFile = $request->files->get('picture');

        $pictureData = null;
        if ($pictureFile) {
            $pictureData = file_get_contents($pictureFile->getPathname());
        }
        
        $bookRepository->update($bookId, [
            'title' => $request->request->get('title'),
            'author' => $request->request->get('author'),
            'isbn' => $request->request->get('isbn'),
            'picture' => $pictureData
        ]);

        $submittedData = $request->request->all();
        $selectedBooks = isset($submittedData['selected_books']) ? $submittedData['selected_books'] : [];


        return $this->redirectToRoute('library_edit', ['book_ids' => $selectedBooks]);
    }

    #[Route("/library/remove", name: "library_remove", methods: ['GET'])]
    public function removeBook(BookRepository $bookRepository, Request $request): Response
    {
        $submittedData = $request->query->all();
        $bookIds = isset($submittedData['book_ids']) ? $submittedData['book_ids'] : [];

        $books = $bookRepository->findManybyId($bookIds);

        return $this->render('library/library_remove.html.twig', [
            'title' => "Vill du verkligen ta bort?",
            'heading' => "Vill du verkligen ta bort?",
            'content' => $this->utilityService->parseMarkdown('library.md'),
            'books' => $books
        ]);
    }

    #[Route('/library/remove', name: 'library_remove_callback', methods: ['POST'])]
    public function removeBookCallback(BookRepository $bookRepository, Request $request): Response 
    {
        $submittedData = $request->request->all();
        $bookIds = isset($submittedData['book_ids']) ? $submittedData['book_ids'] : [];

        $bookRepository->delete($bookIds);
        

        return $this->redirectToRoute('library');
    }

}
