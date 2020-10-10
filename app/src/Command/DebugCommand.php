<?php

namespace App\Command;

use App\Services\CurrencyRateApiService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class DebugCommand extends Command
{
    protected static $defaultName = 'app:debug';
    /**
     * @var CurrencyRateApiService
     */
    private CurrencyRateApiService $apiService;

    public function __construct(CurrencyRateApiService $apiService)
    {

        parent::__construct();
        $this->apiService = $apiService;
    }


    protected function configure()
    {
        $this
            ->setDescription('Add a short description for your command')
            ->addArgument('arg1', InputArgument::OPTIONAL, 'Argument description')
            ->addOption('option1', null, InputOption::VALUE_NONE, 'Option description')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        dd($this->apiService->getCurrentExchangeRates('EUR'));

        return 0;
    }
}
