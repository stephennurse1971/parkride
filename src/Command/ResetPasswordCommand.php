<?php

namespace App\Command;

use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class ResetPasswordCommand extends Command
{
    protected static $defaultName = 'app:reset-password';
    protected static $defaultDescription = 'Let you change your password';

    protected function configure(): void
    {
        $this
            ->setDescription(self::$defaultDescription)
            ->addArgument('email', InputArgument::REQUIRED,'enter user mail')
            ->addArgument('password',InputArgument::REQUIRED,'type your new password')
            //->addOption('option1', null, InputOption::VALUE_NONE, 'Option description')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $email = $input->getArgument('email');
        $password = $input->getArgument('password');

        if ($email && $password) {
           // $io->note(sprintf('You passed an argument: %s', $arg1));
            $user = $this->userRepository->findOneBy(['email'=>$email]);
            $user->setPassword(
                $this->passwordEncoder->encodePassword(
                    $user,
                   $password
                )
            );
            $this->manager->flush();
        }



        $io->success('Password Reset Successful');

        return Command::SUCCESS;
    }
    public function __construct(EntityManagerInterface $manager,UserRepository $userRepository,UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->userRepository = $userRepository;
        $this->manager = $manager;
        $this->passwordEncoder = $passwordEncoder;
        parent::__construct();
    }
}
