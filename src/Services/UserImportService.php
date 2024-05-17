<?php


namespace App\Services;


use App\Entity\Import;
use App\Entity\User;
use App\Repository\CountriesRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserImportService
{
    public function importUsers(string $fileName)
    {
        $filepath = $this->container->getParameter('users_attachments_directory');
        $fullpath = $filepath . $fileName;
        $alldatatsFromCsv = [];
        $row = 0;
        if (($handle = fopen($fullpath, "r")) !== FALSE) {
            while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                if ($row == 0) {
                    $row++;
                    continue;
                }
                $num = count($data);
                $row++;
                for ($c = 0; $c < $num; $c++) {
                    $alldatatsFromCsv[$row][] = $data[$c];
                }
            }
            fclose($handle);
        }

        foreach ($alldatatsFromCsv as $oneLineFromCsv) {
            $firstName = trim($oneLineFromCsv[0]);
            $lastName = trim($oneLineFromCsv[1]);
            $email = trim($oneLineFromCsv[2]);
            $landline = trim($oneLineFromCsv[3]);
            $mobile1 = trim($oneLineFromCsv[4]);
            $mobile2 = trim($oneLineFromCsv[5]);
            $gender = trim($oneLineFromCsv[6]);
            $dateOfBirth = trim($oneLineFromCsv[7]);
            $homeAddressStreet = trim($oneLineFromCsv[8]);
            $homeAddressCity = trim($oneLineFromCsv[9]);
            $homeAddressPostCode = trim($oneLineFromCsv[10]);
            $homeAddressCountry = trim($oneLineFromCsv[11]);
            $country = null;

            $get_country = $this->countriesRepository->findOneBy(['country'=>$homeAddressCountry]);
            if($get_country){
                $country = $get_country;
            }
            $notes = trim($oneLineFromCsv[12]);

            if ($email == '') {
                continue;
            }
            $find_user = $this->userRepository->findOneBy(['email' => $email]);
            if ($find_user) {
                continue;
            } else {
                $user = new User();
                $user->setPassword(
                    $this->userPasswordHasher->hashPassword(
                        $user,
                        $user->getPassword()
                    )
                );
                $user->setFirstName($firstName)
                    ->setLastName($lastName)
                    ->setEmail($email)
                    ->setLandline($landline)
                    ->setMobile($mobile1)
                    ->setMobile2($mobile2)
                    ->setGender($gender)
                    ->setDateOfBirth(new \DateTime($dateOfBirth))
                    ->setAddressStreet($homeAddressStreet)
                    ->setAddressCity($homeAddressCity)
                    ->setAddressPostCode($homeAddressPostCode)
                    ->setAddressCountry($country)
                    ->setRoles(['ROLE_CLIENT'])
                ;
                $this->manager->persist($user);
                $this->manager->flush();
            }
        }

        return null;
    }

    public function __construct(UserPasswordHasherInterface $userPasswordHasher,ContainerInterface $container, UserRepository $userRepository, EntityManagerInterface $manager,CountriesRepository $countriesRepository)
    {
        $this->container = $container;
        $this->manager = $manager;
        $this->userRepository = $userRepository;
        $this->countriesRepository = $countriesRepository;
        $this->userPasswordHasher = $userPasswordHasher;
    }
}
