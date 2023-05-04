<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Book;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\BookRepository;

use App\Services\UtilityService;
use Exception;

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
            throw new Exception('No book picture found for id ' . $id);
        }

        return $this->utilityService->imageResponse($book->getPicture());
    }

    #[Route("/library", name: "library", methods: ['GET'])]
    public function libraryLanding(BookRepository $bookRepository): Response
    {
        $books = $bookRepository->findAll();

        return $this->render('library/library_start.html.twig', [
            'title' => "Bibliotek",
            'heading' => "Bibliotek",
            'books' => $books
        ]);
    }

    #[Route("/library/show/{id}", name: "library_show", methods: ['GET'])]
    public function libraryShowBook(BookRepository $bookRepository, int $id): Response
    {
        $book = $bookRepository->find($id);

        if (!$book) {
            throw new Exception('No book found for id ' . $id);
        }

        return $this->render('library/library_show.html.twig', [
            'title' => $book->getTitle(),
            'heading' => $book->getTitle(),
            'book' => $book
        ]);
    }

    #[Route("/library/add", name: "library_add", methods: ['GET'])]
    public function addBook(): Response
    {
        return $this->render('library/library_add.html.twig', [
            'title' => "Lägg till bok",
            'heading' => "Lägg till bok"
        ]);
    }

    #[Route('/library/add', name: 'library_add_callback', methods: ['POST'])]
    public function addBookCallback(BookRepository $bookRepository, Request $request): Response 
    {
        /** @var UploadedFile $pictureFile */
        $pictureFile = $request->files->get('picture');

        $book = new Book();
        $bookRepository->add($book, [
            'title' => $request->request->get('title'),
            'author' => $request->request->get('author'),
            'isbn' => $request->request->get('isbn'),
            'picture' => $this->utilityService->generatePictureDataFromUploaded($pictureFile)
        ]);

        return $this->redirectToRoute('library');
    }

    #[Route("/library/edit", name: "library_edit", methods: ['GET'])]
    public function editBooks(BookRepository $bookRepository, Request $request): Response
    {
        $submittedData = $request->query->all();
        $bookIds = isset($submittedData['book_ids']) ? $submittedData['book_ids'] : [];

        $books = $bookRepository->findManybyId($bookIds);

        return $this->render('library/library_edit.html.twig', [
            'title' => "Böcker",
            'heading' => "Böcker",
            'books' => $books
        ]);
    }

    #[Route('/library/edit', name: 'library_edit_callback', methods: ['POST'])]
    public function editBooksCallback(BookRepository $bookRepository, Request $request): Response 
    {
        $bookId = $request->request->get('book_to_update');

        /** @var UploadedFile $pictureFile */
        $pictureFile = $request->files->get('picture');

        $bookRepository->update($bookId, [
            'title' => $request->request->get('title'),
            'author' => $request->request->get('author'),
            'isbn' => $request->request->get('isbn'),
            'picture' => $this->utilityService->generatePictureDataFromUploaded($pictureFile)
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

    #[Route('/library/reset', name: 'library_reset', methods: ['GET', 'POST'])]
    public function resetDatabase(BookRepository $bookRepository): Response 
    {
        $baseDir = $this->getParameter('kernel.project_dir') . '/public/img/';

        $imaginaryBooks = [
            "book1" => [
                "title" => "Frogs in the Garden",
                "author" => "Lily Greenpond",
                "isbn" => "978-1-2345-6789-1",
                "picture" => $this->utilityService->generatePictureDataFromFile($baseDir . 'frog.jpg')
            ],
            "book2" => [
                "title" => "The Galloping Adventures",
                "author" => "William Whinny",
                "isbn" => "978-1-2345-6789-2",
                "picture" => $this->utilityService->generatePictureDataFromFile($baseDir . 'horse.jpg')
            ],
            "book3" => [
                "title" => "The Curious Cat Chronicles",
                "author" => "Felicity Feline",
                "isbn" => "978-1-2345-6789-3",
                "picture" => $this->utilityService->generatePictureDataFromFile($baseDir . 'cat.jpg')
            ],
            "book4" => [
                "title" => "Dogs of the Golden Park",
                "author" => "Charles Canine",
                "isbn" => "978-1-2345-6789-4",
                "picture" => $this->utilityService->generatePictureDataFromFile($baseDir . 'dog.jpg')
            ],
        ];

        $currentBooks = $bookRepository->findAll();
        $currentBookIds = [];
        foreach ($currentBooks as $currentBook) {
            $currentBookIds[] = $currentBook->getId();
        }

        $bookRepository->delete($currentBookIds);

        foreach ($imaginaryBooks as $imaginaryBook) {
            $book = new Book();
            $bookRepository->add($book, $imaginaryBook);
        }

        return $this->redirectToRoute('library');
    }

    #[Route("/api/library/books", methods: ['GET'])]
    public function allBooksJson(): Response
    {
        return $this->utilityService->jsonResponse("/api/library/books");
    }

    #[Route("/api/library/book/{isbn}", methods: ['GET'])]
    public function bookByIsbnJson(): Response
    {
        return $this->utilityService->jsonResponse("/api/library/book/{isbn}");
    }


}
