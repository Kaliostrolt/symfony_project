<?php

namespace App\Command;

use App\Service\UserService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;

class CreateAdminUserCommand extends Command
{
    protected static $defaultName = 'app:create-admin-user';

    /**
     * @var UserService
     */
    private $userService;

    public function __construct(
        UserService $userService,
        string $name = null
    ) {
        parent::__construct($name);
        $this->userService = $userService;
    }

    protected function configure()
    {
        $this
            ->setDescription('create user-Admin')
            ->addArgument('email', InputArgument::OPTIONAL, sprintf('Write email'))
            ->addArgument('password', InputArgument::OPTIONAL,'Write password')
        ;
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $helper = $this->getHelper('question');
        $questionEmail = new Question('enter please email: ', '');
        $email = $helper->ask($input, $output, $questionEmail);
        $questionPassword = new Question('enter please password: ', '');
        $password = $helper->ask($input, $output, $questionPassword);
        $output->writeln('Admin create');
        $userRole ='admin';

        $this->userService->createAdmin( $email, $password);

        return 0;
    }
}
