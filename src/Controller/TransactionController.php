<?php

namespace App\Controller;

use App\Entity\Transaction;
use App\Form\TransactionType;
use App\Repository\BirthDeathMarriageCertificatesRepository;
use App\Repository\ClientAvailabilityRepository;
use App\Repository\CmsRepository;
use App\Repository\CriminalRecordCheckRepository;
use App\Repository\CurrenciesRepository;
use App\Repository\DocumentationErrorsRepository;
use App\Repository\DrivingLicenseRepository;
use App\Repository\EmailsRepository;
use App\Repository\EmailTemplatesRepository;
use App\Repository\EmploymentContractsRepository;
use App\Repository\FinancialStatementsRepository;
use App\Repository\HealthInsuranceRepository;
use App\Repository\ImmigrationAppointmentsRepository;
use App\Repository\MedicalRepository;
use App\Repository\OfficeAppointmentsRepository;
use App\Repository\PassportsRepository;
use App\Repository\PaymentsRepository;
use App\Repository\SchoolAttendanceCertificatesRepository;
use App\Repository\ServicesOfferedRepository;
use App\Repository\TenancyAgreementsRepository;
use App\Repository\TransactionRepository;
use App\Repository\UserRepository;
use App\Repository\UtilityBillsRepository;
use App\Repository\YellowPinkSlipsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

/**
 * @Route("/transaction")
 */
class TransactionController extends AbstractController
{
    /**
     * @Route("/transaction/index/{subset}/{clientName}", name="transaction_index", methods={"GET"})
     */
    public function index(string                                   $subset, string $clientName, ServicesOfferedRepository $servicesOfferedRepository,
                          EmailsRepository                         $emailsRepository,
                          EmailTemplatesRepository                 $emailTemplatesRepository,
                          TransactionRepository                    $transactionRepository,
                          ClientAvailabilityRepository             $clientAvailabilityRepository,
                          BirthDeathMarriageCertificatesRepository $birthDeathMarriageCertificatesRepository,
                          CriminalRecordCheckRepository            $criminalRecordCheckRepository,
                          DrivingLicenseRepository                 $drivingLicenseRepository,
                          EmploymentContractsRepository            $employmentContractsRepository,
                          FinancialStatementsRepository            $financialStatementsRepository,
                          HealthInsuranceRepository                $healthInsuranceRepository,
                          MedicalRepository                        $medicalRepository,
                          PassportsRepository                      $passportsRepository,
                          SchoolAttendanceCertificatesRepository   $schoolAttendanceCertificatesRepository,
                          TenancyAgreementsRepository              $tenancyAgreementsRepository,
                          UtilityBillsRepository                   $utilityBillsRepository,
                          OfficeAppointmentsRepository             $officeAppointmentsRepository,
                          ImmigrationAppointmentsRepository        $immigrationAppointmentsRepository,
                          UserRepository                           $userRepository,
                          PaymentsRepository                       $paymentsRepository,
                          Security                                 $security): Response
    {
        $payments = $paymentsRepository->findAll();
        $user = $security->getUser();
        $client_availabilities = $clientAvailabilityRepository->findAll();
        $emails = $emailsRepository->findAll();
        $emailTemplates = $emailTemplatesRepository->findByASC();
        $now = new \DateTime('now');
        $services_offered = $servicesOfferedRepository->findAll();
        $future_office_appointments = $officeAppointmentsRepository->findAll();
        $past_office_appointments = $officeAppointmentsRepository->findAll();
        $immigration_office_appointments = $immigrationAppointmentsRepository->findAll();

        if ($subset == 'Complete' and $clientName == 'All' and $this->isGranted('ROLE_STAFF')) {
            $transactions = $transactionRepository->findBy([
                'status' => 'Complete'
            ]);
            return $this->render('transaction/index.html.twig', [
                'transactions' => $transactions,
                'future_office_appointments' => $future_office_appointments,
                'past_office_appointments' => $past_office_appointments,
                'immigration_office_appointments' => $immigration_office_appointments,
                'services_offereds' => $services_offered,
                'subset' => $subset,
                'now' => $now,
                'client_availabilities' => $client_availabilities,
                'emails' => $emails,
                'emailTemplates' => $emailTemplates,
                'payments' => $payments,

                'birth_marriage_death_certificates' => $birthDeathMarriageCertificatesRepository->findAll(),
                'criminal_record_checks' => $criminalRecordCheckRepository->findAll(),
                'driving_licenses' => $drivingLicenseRepository->findAll(),
                'employment_contracts' => $employmentContractsRepository->findAll(),
                'financial_statements' => $financialStatementsRepository->findAll(),
                'health_insurances' => $healthInsuranceRepository->findAll(),
                'medicals' => $medicalRepository->findAll(),
                'passports' => $passportsRepository->findAll(),
                'school_attendance_certificates' => $schoolAttendanceCertificatesRepository->findAll(),
                'tenancy_agreements' => $tenancyAgreementsRepository->findAll(),
                'utility_bills' => $utilityBillsRepository->findAll()
            ]);
        }

        if ($subset == 'Pending' and $clientName == 'All' and $this->isGranted('ROLE_STAFF')) {
            $transactions = $transactionRepository->findBy([
                'status' => 'Pending'
            ]);
            return $this->render('transaction/index.html.twig', [
                'transactions' => $transactions,
                'future_office_appointments' => $future_office_appointments,
                'past_office_appointments' => $past_office_appointments,
                'immigration_office_appointments' => $immigration_office_appointments,
                'services_offereds' => $services_offered,
                'subset' => $subset,
                'now' => $now,
                'client_availabilities' => $client_availabilities,
                'emails' => $emails,
                'emailTemplates' => $emailTemplates,
                'payments' => $payments,

                'birth_marriage_death_certificates' => $birthDeathMarriageCertificatesRepository->findAll(),
                'criminal_record_checks' => $criminalRecordCheckRepository->findAll(),
                'driving_licenses' => $drivingLicenseRepository->findAll(),
                'employment_contracts' => $employmentContractsRepository->findAll(),
                'financial_statements' => $financialStatementsRepository->findAll(),
                'health_insurances' => $healthInsuranceRepository->findAll(),
                'medicals' => $medicalRepository->findAll(),
                'passports' => $passportsRepository->findAll(),
                'school_attendance_certificates' => $schoolAttendanceCertificatesRepository->findAll(),
                'tenancy_agreements' => $tenancyAgreementsRepository->findAll(),
                'utility_bills' => $utilityBillsRepository->findAll()
            ]);
        }


        if ($subset == 'Abandoned' and $clientName == 'All' and $this->isGranted('ROLE_STAFF')) {
            $transactions = $transactionRepository->findBy([
                'status' => 'Abandoned'
            ]);
            return $this->render('transaction/index.html.twig', [
                'transactions' => $transactions,
                'future_office_appointments' => $future_office_appointments,
                'past_office_appointments' => $past_office_appointments,
                'immigration_office_appointments' => $immigration_office_appointments,
                'services_offereds' => $services_offered,
                'subset' => $subset,
                'now' => $now,
                'client_availabilities' => $client_availabilities,
                'emails' => $emails,
                'emailTemplates' => $emailTemplates,
                'payments' => $payments,

                'birth_marriage_death_certificates' => $birthDeathMarriageCertificatesRepository->findAll(),
                'criminal_record_checks' => $criminalRecordCheckRepository->findAll(),
                'driving_licenses' => $drivingLicenseRepository->findAll(),
                'employment_contracts' => $employmentContractsRepository->findAll(),
                'financial_statements' => $financialStatementsRepository->findAll(),
                'health_insurances' => $healthInsuranceRepository->findAll(),
                'medicals' => $medicalRepository->findAll(),
                'passports' => $passportsRepository->findAll(),
                'school_attendance_certificates' => $schoolAttendanceCertificatesRepository->findAll(),
                'tenancy_agreements' => $tenancyAgreementsRepository->findAll(),
                'utility_bills' => $utilityBillsRepository->findAll()
            ]);
        }

        if ($clientName != 'All' and $this->isGranted('ROLE_STAFF')) {
            $name_container = explode(' ', $clientName);
            $client = $userRepository->findOneBy([
                'firstName' => $name_container[0],
                'lastName' => $name_container[1]
            ]);
            $transactions = $transactionRepository->findBy([
                'client' => $client
            ]);
            return $this->render('transaction/index.html.twig', [
                'transactions' => $transactions,
                'future_office_appointments' => $future_office_appointments,
                'past_office_appointments' => $past_office_appointments,
                'immigration_office_appointments' => $immigration_office_appointments,
                'services_offereds' => $services_offered,
                'subset' => $subset,
                'now' => $now,
                'client_availabilities' => $client_availabilities,
                'emails' => $emails,
                'emailTemplates' => $emailTemplates,
                'payments' => $payments,

                'birth_marriage_death_certificates' => $birthDeathMarriageCertificatesRepository->findAll(),
                'criminal_record_checks' => $criminalRecordCheckRepository->findAll(),
                'driving_licenses' => $drivingLicenseRepository->findAll(),
                'employment_contracts' => $employmentContractsRepository->findAll(),
                'financial_statements' => $financialStatementsRepository->findAll(),
                'health_insurances' => $healthInsuranceRepository->findAll(),
                'medicals' => $medicalRepository->findAll(),
                'passports' => $passportsRepository->findAll(),
                'school_attendance_certificates' => $schoolAttendanceCertificatesRepository->findAll(),
                'tenancy_agreements' => $tenancyAgreementsRepository->findAll(),
                'utility_bills' => $utilityBillsRepository->findAll()
            ]);
        }


        if ($this->isGranted('ROLE_CLIENT')) {
            $transactions = $transactionRepository->findBy([
                'client' => $user
            ]);
        };
        return $this->render('transaction/index.html.twig', [
            'transactions' => $transactions,
            'future_office_appointments' => $future_office_appointments,
            'past_office_appointments' => $past_office_appointments,
            'immigration_office_appointments' => $immigration_office_appointments,
            'services_offereds' => $services_offered,
            'subset' => 'My',
            'now' => $now,
            'client_availabilities' => $client_availabilities,
            'emails' => $emails,
            'emailTemplates' => $emailTemplates,
            'payments' => $payments,

            'birth_marriage_death_certificates' => $birthDeathMarriageCertificatesRepository->findAll(),
            'criminal_record_checks' => $criminalRecordCheckRepository->findAll(),
            'driving_licenses' => $drivingLicenseRepository->findAll(),
            'employment_contracts' => $employmentContractsRepository->findAll(),
            'financial_statements' => $financialStatementsRepository->findAll(),
            'health_insurances' => $healthInsuranceRepository->findAll(),
            'medicals' => $medicalRepository->findAll(),
            'passports' => $passportsRepository->findAll(),
            'school_attendance_certificates' => $schoolAttendanceCertificatesRepository->findAll(),
            'tenancy_agreements' => $tenancyAgreementsRepository->findAll(),
            'utility_bills' => $utilityBillsRepository->findAll()
        ]);
    }

    /**
     * @Route("/new/{userId}/{serviceId}", name="transaction_new", methods={"GET", "POST"})
     */
    public function new(int $userId, int $serviceId, Request $request, UserRepository $userRepository, ServicesOfferedRepository $servicesOfferedRepository, TransactionRepository $transactionRepository, Security $security): Response
    {
        $transaction = new Transaction();
        $user = $userRepository->find($userId);
        $service = $servicesOfferedRepository->find($serviceId);
        $transaction->setClient($user);
        $transaction->setService($service);
        $transaction->setStatus('Pending');
        $transaction->getCreatedBy($security->getUser());
        $transactionRepository->add($transaction, true);
        return $this->redirectToRoute('transaction_index', ['subset' => 'Pending', 'clientName' => 'All'], Response::HTTP_SEE_OTHER);
    }

    /**
     * @Route("/{id}/show", name="transaction_show", methods={"GET"})
     */
    public function show(DocumentationErrorsRepository          $documentationErrorsRepository, Transaction $transaction, EmailTemplatesRepository $emailTemplatesRepository, PassportsRepository $passportsRepository, TenancyAgreementsRepository $tenancyAgreementsRepository,
                         UtilityBillsRepository                 $utilityBillsRepository, BirthDeathMarriageCertificatesRepository $birthDeathMarriageCertificatesRepository, EmploymentContractsRepository $employmentContractsRepository, FinancialStatementsRepository $financialStatementsRepository,
                         SchoolAttendanceCertificatesRepository $schoolAttendanceCertificatesRepository, CriminalRecordCheckRepository $criminalRecordCheckRepository,
                         HealthInsuranceRepository              $healthInsuranceRepository, MedicalRepository $medicalRepository, DrivingLicenseRepository $drivingLicenseRepository, YellowPinkSlipsRepository $yellowPinkSlipsRepository, CurrenciesRepository $currenciesRepository,
                         PaymentsRepository                     $paymentsRepository): Response
    {
        $client = $transaction->getClient();
        $emailTemplates = $emailTemplatesRepository->FindAll();
        $servicesOffered = $transaction->getService();
        $docs = [];
        $docsRequiredPassport = $servicesOffered->isDocsPassport();
        if ($docsRequiredPassport) {
            $docs[] = 'Passport';
        }
        $docsRequiredTenancyAgreement = $servicesOffered->isDocsTenancyAgreement();
        if ($docsRequiredTenancyAgreement) {
            $docs[] = 'Tenancy Agreement';
        }

        $docsRequiredUtilityBill = $servicesOffered->isDocsUtilityBill();
        if ($docsRequiredUtilityBill) {
            $docs[] = 'Utility Bill';
        }

        $docsRequiredBirthMarriageDeathCertificates = $servicesOffered->isDocsBirthMarriageDeathCertificate();
        if ($docsRequiredUtilityBill) {
            $docs[] = 'Birth Marriage Death Certificates';
        }

        $docsRequiredEmploymentContract = $servicesOffered->isDocsEmploymentContract();
        if ($docsRequiredEmploymentContract) {
            $docs[] = 'Employment Contract';
        }

        $docsRequiredFinancialStatements = $servicesOffered->isDocsFinancialStatements();
        if ($docsRequiredFinancialStatements) {
            $docs[] = 'Financial Statements';
        }

        $docsRequiredP60 = $servicesOffered->isDocsP60();
        if ($docsRequiredP60) {
            $docs[] = 'P60';
        }

        $docsRequiredSchoolAttendanceCertificate = $servicesOffered->isDocsSchoolAttendanceCertificate();
        if ($docsRequiredSchoolAttendanceCertificate) {
            $docs[] = 'School Attendance Certificate';
        }

        $docsRequiredCriminalCheck = $servicesOffered->isDocsCriminalRecordCheck();
        if ($docsRequiredCriminalCheck) {
            $docs[] = 'Criminal Record Check';
        }

        $docsRequiredHealthInsurance = $servicesOffered->isDocsHealthInsurance();
        if ($docsRequiredHealthInsurance) {
            $docs[] = 'Health Insurance';
        }

        $docsRequiredMedical = $servicesOffered->isDocsMedical();
        if ($docsRequiredMedical) {
            $docs[] = 'Medical';
        }

        $docsRequiredDrivingLicense = $servicesOffered->isDocsDrivingLicense();
        if ($docsRequiredDrivingLicense) {
            $docs[] = 'Driving License';
        }
        $payments = $paymentsRepository->findAll();
        return $this->render('transaction/show.html.twig', [
            'transaction' => $transaction,
            'docs' => $docs,
            'payments' => $payments,
            'emailTemplates' => $emailTemplates,
            'passports' => $passportsRepository->findBy([
                'passportHolder' => $client
            ]),
            'tenancy_agreements' => $tenancyAgreementsRepository->findBy([
                'tenant' => $client
            ]),
            'birth_death_marriage_certificates' => $birthDeathMarriageCertificatesRepository->findBy([
                'applicant' => $client
            ]),

            'utility_bills' => $utilityBillsRepository->findBy([
                'customer' => $client
            ]),
            'employment_contracts' => $employmentContractsRepository->findBy([
                'employee' => $client
            ]),
            'financial_statements' => $financialStatementsRepository->findBy([
                'accountHolder' => $client
            ]),
            'school_attendance_certificates' => $schoolAttendanceCertificatesRepository->findBy([
                'student' => $client
            ]),
            'criminal_record_checks' => $criminalRecordCheckRepository->findBy([
                'applicant' => $client
            ]),
            'health_insurances' => $healthInsuranceRepository->findBy([
                'applicant' => $client
            ]),
            'medicals' => $medicalRepository->findBy([
                'patient' => $client
            ]),
            'driving_licenses' => $drivingLicenseRepository->findBy([
                'drivingLicenseHolder' => $client
            ]),
            'yellow_pink_slips' => $yellowPinkSlipsRepository->findBy([
                'recipient' => $client
            ]),
            'currencies' => $currenciesRepository->findAll(),
            'documentErrors' => $documentationErrorsRepository->findAll()
        ]);
    }

    /**
     * @Route("/edit/{id}", name="transaction_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Transaction $transaction, TransactionRepository $transactionRepository): Response
    {
        $form = $this->createForm(TransactionType::class, $transaction);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $transactionRepository->add($transaction, true);

            return $this->redirectToRoute('transaction_index', ['subset' => 'Pending', 'clientName' => 'All'], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('transaction/edit.html.twig', [
            'transaction' => $transaction,
            'form' => $form,
        ]);
    }


    /**
     * @Route("/update_status/{status}/{documentType}/{error}/{id}", name="transaction_document_update_status", methods={"GET", "POST"},defaults={"error"=0})
     */
    public function updateDocumentStatus(Request                                  $request, int $id, string $status, string $documentType, $error,
                                         TransactionRepository                    $transactionRepository,
                                         BirthDeathMarriageCertificatesRepository $birthDeathMarriageCertificatesRepository,
                                         CriminalRecordCheckRepository            $criminalRecordCheckRepository,
                                         DrivingLicenseRepository                 $drivingLicenseRepository,
                                         EmploymentContractsRepository            $employmentContractsRepository,
                                         FinancialStatementsRepository            $financialStatementsRepository,
                                         HealthInsuranceRepository                $healthInsuranceRepository,
                                         MedicalRepository                        $medicalRepository,
                                         PassportsRepository                      $passportsRepository,
                                         SchoolAttendanceCertificatesRepository   $schoolAttendanceCertificatesRepository,
                                         TenancyAgreementsRepository              $tenancyAgreementsRepository,
                                         UtilityBillsRepository                   $utilityBillsRepository,
                                         DocumentationErrorsRepository            $documentationErrorsRepository,
                                         EntityManagerInterface                   $manager, Security $security
    ): Response
    {
        $user = $security->getUser();
        $now = new \DateTime('now');
        $document = null;

        $error_messages = $documentationErrorsRepository->findBy([
            'document' => '$documentType']);

        if ($documentType == 'Transaction Record') {
            $document = $transactionRepository->find($id);
        }
        if ($documentType == 'Birth Marriage Death Certificate') {
            $document = $birthDeathMarriageCertificatesRepository->find($id);
        }
        if ($documentType == 'Criminal Record Check') {
            $document = $criminalRecordCheckRepository->find($id);
        }
        if ($documentType == 'Driving License') {
            $document = $drivingLicenseRepository->find($id);
        }
        if ($documentType == 'Employment Contract') {
            $document = $employmentContractsRepository->find($id);
        }
        if ($documentType == 'Financial Statement') {
            $document = $financialStatementsRepository->find($id);
        }
        if ($documentType == 'Health Insurance') {
            $document = $healthInsuranceRepository->find($id);
        }
        if ($documentType == 'Medical') {
            $document = $medicalRepository->find($id);
        }
        if ($documentType == 'Passport') {
            $document = $passportsRepository->find($id);
        }
        if ($documentType == 'School Attendance Certificate') {
            $document = $schoolAttendanceCertificatesRepository->find($id);
        }
        if ($documentType == 'Tenancy Agreement') {
            $document = $tenancyAgreementsRepository->find($id);
        }
        if ($documentType == 'Utility Bill') {
            $document = $utilityBillsRepository->find($id);
        }

        if ($documentType == "Transaction Record") {
            $document->setStatus($status);
        } else {
            if ($status == 'Fail') {
                if (!empty($_POST['errors'])) {
                    $errors = $_POST['errors'];
                    foreach ($errors as $error) {
                        $document->addStandardError($documentationErrorsRepository->find($error));
                    }
                }

            }
            if ($status == "Checked") {
                foreach ($document->getStandardError() as $error) {
                    $document->removeStandardError($error);
                }

            }

            $document->setReviewedBy($user);
            $document->setReviewedDate($now);
            $document->setReviewed($status);
        }


        $manager->flush($document);
        $referer = $request->headers->get('Referer');
        return $this->redirect($referer);
    }

    /**
     * @Route("/{id}", name="transaction_delete", methods={"POST"})
     */
    public function delete(Request $request, Transaction $transaction, TransactionRepository $transactionRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $transaction->getId(), $request->request->get('_token'))) {
            $transactionRepository->remove($transaction, true);
        }

        return $this->redirectToRoute('transaction_index', ['subset' => 'Pending', 'clientName' => 'All'], Response::HTTP_SEE_OTHER);
    }


    /**
     * @Route("/mue1_form/{transactionId}", name="/meu1_form", methods={"GET"})
     */
    public function businessAddress(Request                                  $request, int $transactionId,
                                    CmsRepository                            $cmsRepository,
                                    TransactionRepository                    $transactionRepository,
                                    BirthDeathMarriageCertificatesRepository $birthDeathMarriageCertificatesRepository,
                                    CriminalRecordCheckRepository            $criminalRecordCheckRepository,
                                    DrivingLicenseRepository                 $drivingLicenseRepository,
                                    EmploymentContractsRepository            $employmentContractsRepository,
                                    FinancialStatementsRepository            $financialStatementsRepository,
                                    HealthInsuranceRepository                $healthInsuranceRepository,
                                    MedicalRepository                        $medicalRepository,
                                    PassportsRepository                      $passportsRepository,
                                    SchoolAttendanceCertificatesRepository   $schoolAttendanceCertificatesRepository,
                                    TenancyAgreementsRepository              $tenancyAgreementsRepository,
                                    UtilityBillsRepository                   $utilityBillsRepository,
                                    UserRepository                           $userRepository,
                                    security                                 $security

    ): Response
    {
        $transaction = $transactionRepository->find($transactionId);
        $client = $transaction->getClient();
        $user = $security->getUser();
        $display_language = $user->getOfficialFormDisplayLanguage();
        $birthDeathMarriageCertificates = $birthDeathMarriageCertificatesRepository->findBy([
            'applicant' => $client
        ]);
        $criminalRecordCheck = $criminalRecordCheckRepository->findOneBy([
            'applicant' => $client
        ]);
        $drivingLicense = $drivingLicenseRepository->findOneBy([
            'drivingLicenseHolder' => $client
        ]);
        $employmentContract = $employmentContractsRepository->findOneBy([
            'employee' => $client
        ]);
        $financialStatement = $financialStatementsRepository->findOneBy([
            'accountHolder' => $client
        ]);
        $healthInsurance = $healthInsuranceRepository->findOneBy([
            'applicant' => $client
        ]);
        $medical = $medicalRepository->findOneBy([
            'patient' => $client]);
        $passport = $passportsRepository->findOneBy([
            'passportHolder' => $client
        ]);
        $schoolAttendanceCertificate = $schoolAttendanceCertificatesRepository->findBy([
            'student' => $client
        ]);
        $tenancyAgreement = $tenancyAgreementsRepository->findOneBy([
            'tenant' => $client
        ]);
        $utilityBill = $utilityBillsRepository->findOneBy([
            'customer' => $client
        ]);

        if ($display_language == "English" or $display_language == NULL) {
            $english = TRUE;
            $greek = FALSE;
            $incl_slash = FALSE;
        }

        if ($display_language == "Greek") {
            $english = FALSE;
            $greek = TRUE;
            $incl_slash = FALSE;
        }

        if ($display_language == "Greek & English") {
            $english = TRUE;
            $greek = TRUE;
            $incl_slash = TRUE;
        }

        return $this->render('transaction/official_forms/meu1_form.html.twig', [
                'cms' => $cmsRepository->find('1'),
                'client' => $client,
                'birthDeathMarriageCertificates' => $birthDeathMarriageCertificates,
                'criminalRecordCheck' => $criminalRecordCheck,
                'drivingLicense' => $drivingLicense,
                'employmentContract' => $employmentContract,
                'financialStatement' => $financialStatement,
                'healthInsurance' => $healthInsurance,
                'medical' => $medical,
                'passport' => $passport,
                'schoolAttendanceCertificate' => $schoolAttendanceCertificate,
                'tenancyAgreement' => $tenancyAgreement,
                'utilityBill' => $utilityBill,
                'english' => $english,
                'greek' => $greek,
                'incl_slash' => $incl_slash
            ]
        );
    }

    /**
     * @Route("/mue3_form", name="meu3_form", methods={"GET"})
     */
    public function mue3Form(CmsRepository $cmsRepository): Response
    {
        return $this->render('transaction/official_forms/MEU3/meu3_form.html.twig', [
                'cms' => $cmsRepository->find('1')
            ]
        );
    }

    /**
     * @Route("/account_form", name="account_form", methods={"GET"})
     */
    public function accountForm(CmsRepository $cmsRepository): Response
    {
        return $this->render('transaction/official_forms/accounts/account.html.twig', [
                'cms' => $cmsRepository->find('1')
            ]
        );
    }
}
