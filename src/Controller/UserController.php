<?php

namespace App\Controller;

use App\Entity\Transaction;
use App\Entity\User;
use App\Entity\WebsiteContacts;
use App\Form\ImportType;
use App\Form\UserType;
use App\Repository\ClientAvailabilityRepository;
use App\Repository\ServicesOfferedRepository;
use App\Repository\TransactionRepository;
use App\Repository\UserRepository;
use App\Repository\WebsiteContactsRepository;
use App\Services\UserImportService;
use Doctrine\ORM\EntityManagerInterface;
use JeroenDesloovere\VCard\VCard;
use Jsvrcek\ICS\CalendarExport;
use Jsvrcek\ICS\CalendarStream;
use Jsvrcek\ICS\Model\Calendar;
use Jsvrcek\ICS\Model\CalendarEvent;
use Jsvrcek\ICS\Model\Relationship\Attendee;
use Jsvrcek\ICS\Model\Relationship\Organizer;
use Jsvrcek\ICS\Utility\Formatter;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Csv;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;


/**
 * @Route("/user")
 *
 */
class UserController extends AbstractController
{
    /**
     * @Route("/clients/{status}", name="user_index", methods={"GET"})
     * @Security("is_granted('ROLE_STAFF')")
     */
    public function index(string $status, UserRepository $userRepository, TransactionRepository $transactionRepository, ServicesOfferedRepository $servicesOfferedRepository, ClientAvailabilityRepository $clientAvailabilityRepository): Response
    {
        $now = new \DateTime('now');
        $client_availabilities = $clientAvailabilityRepository->findAll();
        if ($status == 'All') {
            $users = [];
            foreach ($userRepository->findAll() as $user) {
                if (in_array('ROLE_CLIENT', $user->getRoles())) {
                    $users[] = $user;
                }
            }
        }
        if ($status == 'Active') {
            $users = [];
            foreach ($userRepository->findAll() as $user) {
                $client_transactions = $transactionRepository->findBy(['client' => $user]);
                if ($client_transactions) {
                    foreach ($client_transactions as $transaction) {
                        if ($transaction->getStatus() == 'Pending') {
                            $users[] = $user;
                            break;
                        }
                    }
                }
            }
        }
        if ($status == 'Complete') {
            $users = [];
            foreach ($userRepository->findAll() as $user) {
                $client_transactions = $transactionRepository->findBy(['client' => $user]);
                if ($client_transactions) {
                    foreach ($client_transactions as $transaction) {
                        if ($transaction->getStatus() == 'Complete') {
                            $users[] = $user;
                            break;
                        }
                    }
                }
            }
        }
        if ($status == 'Staff') {
            $users = [];
            foreach ($userRepository->findAll() as $user) {
                if (in_array('ROLE_STAFF', $user->getRoles()) || in_array('ROLE_ADMIN', $user->getRoles()) || in_array('ROLE_SUPER_ADMIN', $user->getRoles())) {
                    $users[] = $user;
                }
            }
        }
        return $this->render('user/index.html.twig', [
            'users' => $users,
            'status' => $status,
            'transactions' => $transactionRepository->findAll(),
            'services' => $servicesOfferedRepository->findAll(),
            'client_availabilities' => $client_availabilities,
            'now' => $now
        ]);
    }


    /**
     * @Route("/new", name="user_new", methods={"GET", "POST"})
     */
    public function new(Request $request, UserRepository $userRepository, \Symfony\Component\Security\Core\Security $security, UserPasswordHasherInterface $userPasswordHasher): Response
    {
        $user = new User();
        $now = new \DateTime('now');
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if ($form['roles']->getData()) {
                $roles = $form['roles']->getData();
                $user->setRoles($roles);
            }
            $user->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    $user->getPassword()
                )
            );
            $user->setCreatedBy($security->getUser()->getFullName());
            $userRepository->add($user, true);

            return $this->redirectToRoute('user_index', ['status' => 'All'], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('user/new.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }


    /**
     * @Route("/new_from_website_contacts/{websiteContactId}", name="user_new_from_website_contacts", methods={"GET", "POST"})
     */
    public function new_from_website_contact(Request $request, int $websiteContactId,TransactionRepository $transactionRepository, WebsiteContactsRepository $websiteContactsRepository, UserRepository $userRepository, \Symfony\Component\Security\Core\Security $security, UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $manager): Response
    {
        $websiteContact = $websiteContactsRepository->findOneBy([
            'id' => $websiteContactId
        ]);
        $newService = $websiteContact->getService();
        $user = new User();
        $created_at = new \DateTime($websiteContact->getDateTime()->format('Y-m-d H:i'));
            $user->setFirstName($websiteContact->getFirstName())
                ->setLastName($websiteContact->getLastName())
                ->setEmail($websiteContact->getEmail())
                ->setMobile($websiteContact->getMobile())
                ->setNotes($websiteContact->getNotes())
                ->setCreatedBy('On-Line')
                ->setCreatedAt($websiteContact->getDateTime())
                 ->setRoles(['ROLE_CLIENT'])
                ->setPassword(
                    $userPasswordHasher->hashPassword(
                        $user,
                        'password'
                    )
                );

            $userRepository->add($user, true);

            $newtransaction = new Transaction();
            $newtransaction->setService($newService)
                ->setClient($user)
                ->setCreatedAt($created_at)
                ->setCreatedBy('On-Line')
                ->setStatus('Pending')  ;

        $manager->persist($newtransaction);
        $manager->flush();
            return $this->redirectToRoute('transaction_index', ['subset' => 'Pending', 'clientName' => 'All'], Response::HTTP_SEE_OTHER);

    }

    /**
     * @Route("/{id}", name="user_show", methods={"GET"})
     */
    public function show(User $user): Response
    {
        return $this->render('user/show.html.twig', [
            'user' => $user,
        ]);
    }

    /**
     * @Route("/{fullName}/edit", name="user_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, string $fullName, UserRepository $userRepository, UserPasswordHasherInterface $userPasswordHasher, \Symfony\Component\Security\Core\Security $security): Response
    {
        $user_name = explode(' ', $fullName);
        $user = $userRepository->findOneBy(['firstName' => $user_name[0], 'lastName' => $user_name[1]]);
        if ($user == $security->getUser() || $this->isGranted('ROLE_STAFF') || $this->isGranted('ROLE_ADMIN') || $this->isGranted('ROLE_SUPER_ADMIN')) {
            $form = $this->createForm(UserType::class, $user, ['user' => $user]);
            if ($user->getPhoto()) {
                $form->remove('photo');
            }
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $referer = $request->request->get('referer');
                if ($form->has('photo')) {
                    $photo = $form->get('photo')->getData();
                    if ($photo) {
                        $originalFilename = pathinfo($photo->getClientOriginalName(), PATHINFO_FILENAME);
                        $newFilename = $user->getFullName() . '.' . $photo->guessExtension();
                        $photo->move(
                            $this->getParameter('employee_photos_directory'),
                            $newFilename
                        );
                        $user->setPhoto($newFilename);
                    }
                }
                if ($form->has('roles')) {
                    $roles = $form['roles']->getData();
                    $user->setRoles($roles);
                }
                $user->setPassword(
                    $userPasswordHasher->hashPassword(
                        $user,
                        $user->getPassword()
                    )
                );
                $userRepository->add($user, true);
                return $this->redirect($referer);
            }

            return $this->renderForm('user/edit.html.twig', [
                'user' => $user,
                'form' => $form,
            ]);
        } else {
            return $this->redirectToRoute('dashboard');
        }
    }

    /**
     * @Route("/{id}", name="user_delete", methods={"POST"})
     * @Security("is_granted('ROLE_STAFF')")
     */
    public
    function delete(Request $request, User $user, UserRepository $userRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $user->getId(), $request->request->get('_token'))) {
            $userRepository->remove($user, true);
        }

        return $this->redirectToRoute('user_index', [], Response::HTTP_SEE_OTHER);
    }

    /**
     * @Route("/delete/photo/{id}", name="user_delete_photo")
     */
    public
    function deletePhoto(Request $request, User $user, EntityManagerInterface $manager): Response
    {
        $referer = $request->headers->get('Referer');
        $user->setPhoto(null);
        $manager->flush();
        return $this->redirect($referer);
    }

    /**
     * @Route ("/export/users", name="users_export" )
     * @Security("is_granted('ROLE_STAFF')")
     */
    public
    function usersExport(UserRepository $userRepository)
    {
        $data = [];
        $fileName = 'user_contacts_export.csv';
        $exported_date = new \DateTime('now');
        $exported_date = $exported_date->format('d-M-Y h:m');
        $count = 0;
        $user_list = $userRepository->findAll();
        foreach ($user_list as $user) {
            $concatenatedNotes = "Client list exported from Gwenny's Red Tape Services on: " . $exported_date;
            $country = null;
            if ($user->getAddressCountry()) {
                $country = $user->getAddressCountry()->getCountry();
            }
            $dateOfBirth = null;
            if ($user->getDateOfBirth()) {
                $dateOfBirth = $user->getDateOfBirth()->format('d-m-Y');
            }
            $data[] = [
                $user->getFirstName(),
                $user->getLastName(),
                $user->getEmail(),
                $user->getLandline(),
                $user->getMobile(),
                $user->getMobile2(),
                $user->getGender(),
                $dateOfBirth,
                $user->getAddressStreet(),
                $user->getAddressCity(),
                $user->getAddressPostCode(),
                $country,
                $concatenatedNotes,
                $user->getId(),
            ];
        }
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('User Contacts');
        $sheet->getCell('A1')->setValue('First Name');
        $sheet->getCell('B1')->setValue('Last Name');
        $sheet->getCell('C1')->setValue('Email');
        $sheet->getCell('D1')->setValue('Home phone');
        $sheet->getCell('E1')->setValue('Mobile1');
        $sheet->getCell('F1')->setValue('Mobile2');
        $sheet->getCell('G1')->setValue('Gender');
        $sheet->getCell('H1')->setValue('Date Of Birth');
        $sheet->getCell('I1')->setValue('Home Street');
        $sheet->getCell('J1')->setValue('Home City');
        $sheet->getCell('K1')->setValue('Home PostalCode');
        $sheet->getCell('L1')->setValue('Home Country');
        $sheet->getCell('M1')->setValue('Notes');
        $sheet->getCell('N1')->setValue('id');
        $sheet->fromArray($data, null, 'A2', true);
        $total_rows = $sheet->getHighestRow();
        for ($i = 2; $i <= $total_rows; $i++) {
            $cell = "L" . $i;
            $sheet->getCell($cell)->getHyperlink()->setUrl("https://google.com");
        }
        $writer = new Csv($spreadsheet);
        $response = new StreamedResponse(function () use ($writer) {
            $writer->save('php://output');
        });
        $response->headers->set('Content-Type', 'application/vnd.ms-excel');
        $response->headers->set('Content-Disposition', sprintf('attachment;filename="%s"', $fileName));
        $response->headers->set('Cache-Control', 'max-age=0');
        return $response;
    }


    /**
     * @Route ("/import/users", name="users_import" )
     * @Security("is_granted('ROLE_STAFF')")
     */
    public
    function usersImport(Request $request, SluggerInterface $slugger, UserRepository $userRepository, UserImportService $userImportService): Response
    {
        $form = $this->createForm(ImportType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $importFile = $form->get('File')->getData();
            if ($importFile) {
                $originalFilename = pathinfo($importFile->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename . '.' . 'csv';
                try {
                    $importFile->move(
                        $this->getParameter('users_attachments_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    die('Import failed');
                }
                $userImportService->importUsers($newFilename);
                return $this->redirectToRoute('user_index', ['status' => 'All']);
            }
        }
        return $this->render('business_contacts/import.html.twig', [
            'form' => $form->createView(),
        ]);
    }


    /**
     * @Route("/{id}/viewphoto", name="user_viewphoto")
     */
    public
    function viewUserPhoto(string $fullName, User $user)
    {
        $imagename = $user->getPhoto();
        return $this->render('user/image_view.twig', ['imagename' => $imagename]);
    }


}
