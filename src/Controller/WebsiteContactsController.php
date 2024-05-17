<?php

namespace App\Controller;

use App\Entity\WebsiteContacts;
use App\Form\WebsiteContactsType;
use App\Repository\ServicesOfferedRepository;
use App\Repository\UserRepository;
use App\Repository\WebsiteContactsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/website/contacts")
 */
class WebsiteContactsController extends AbstractController
{
    /**
     * @Route("/", name="website_contacts_index", methods={"GET"})
     */
    public function index(WebsiteContactsRepository $websiteContactsRepository, UserRepository $userRepository): Response
    {
        return $this->render('website_contacts/index.html.twig', [
            'website_contacts' => $websiteContactsRepository->findAll(),
            'users' => $userRepository->findAll()
        ]);
    }

    /**
     * @Route("/new", name="website_contacts_new", methods={"GET", "POST"})
     */
    public function new(Request $request, WebsiteContactsRepository $websiteContactsRepository, EntityManagerInterface $manager, ServicesOfferedRepository $servicesOfferedRepository): Response
    {

        $now = new \DateTime('now');
        $first_name = $_POST['firstName'];
        $last_name = $_POST['lastName'];
        $email = $_POST['email'];
        $mobile = $_POST['mobile'];
        $notes = $_POST['notes'];
        $service = $_POST['service'];
        $serviceId = $servicesOfferedRepository->findOneBy([
            'serviceOffered' => $service
        ]);
        $website_contact = new WebsiteContacts();
        $website_contact->setService($serviceId)
            ->setDateTime($now)
            ->setFirstName($first_name)
            ->setLastName($last_name)
            ->setEmail($email)
            ->setMobile($mobile)
            ->setStatus('Pending')
            ->setNotes($notes);
        $manager->persist($website_contact);
        $manager->flush();

        return $this->redirect($request->headers->get('Referer'));
    }

    /**
     * @Route("/{id}", name="website_contacts_show", methods={"GET"})
     */
    public function show(WebsiteContacts $websiteContact): Response
    {
        return $this->render('website_contacts/show.html.twig', [
            'website_contact' => $websiteContact,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="website_contacts_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, WebsiteContacts $websiteContact, WebsiteContactsRepository $websiteContactsRepository): Response
    {
        $form = $this->createForm(WebsiteContactsType::class, $websiteContact);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $websiteContactsRepository->add($websiteContact, true);

            return $this->redirectToRoute('website_contacts_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('website_contacts/edit.html.twig', [
            'website_contact' => $websiteContact,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}/setToJunk", name="website_contacts_set_to_junk", methods={"GET", "POST"})
     */
    public function setToJunk(Request $request, WebsiteContacts $websiteContact, WebsiteContactsRepository $websiteContactsRepository, EntityManagerInterface $manager): Response
    {
        $websiteContact->setStatus('Junk');
        $manager->flush($websiteContact);
        $referer = $request->headers->get('Referer');
        return $this->redirect($referer);

    }

    /**
     * @Route("/{id}/revertToPending", name="website_contacts_revert_to_pending", methods={"GET", "POST"})
     */
    public function revertToPending(Request $request, WebsiteContacts $websiteContact, WebsiteContactsRepository $websiteContactsRepository, EntityManagerInterface $manager): Response
    {
        $websiteContact->setStatus('Pending');
        $manager->flush($websiteContact);
        $referer = $request->headers->get('Referer');
        return $this->redirect($referer);

    }

    /**
     * @Route("/{id}", name="website_contacts_delete", methods={"POST"})
     */
    public
    function delete(Request $request, WebsiteContacts $websiteContact, WebsiteContactsRepository $websiteContactsRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $websiteContact->getId(), $request->request->get('_token'))) {
            $websiteContactsRepository->remove($websiteContact, true);
        }

        return $this->redirectToRoute('website_contacts_index', [], Response::HTTP_SEE_OTHER);
    }
}
