<?php


namespace App\Command;

use App\Service\ParkingSpotService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class DeleteExpiredSpotsCommand extends Command
{
    // the name of the command (the part after "bin/console")
    protected static $defaultName = 'app:delete-spots';

    private $parkingSpotService;

    public function __construct(ParkingSpotService $parkingSpotService){
        parent::__construct(null);
        $this->parkingSpotService = $parkingSpotService;
    }

    protected function configure()
    {
        $this->setName('app:delete-spots')
            ->setDescription('Delete expired parking spots.');
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int|void|null
     * @throws \Exception
     */
    protected function execute(InputInterface $input, OutputInterface $output){
        try {
            $this->parkingSpotService->deleteExpiredSpots();
        }catch (\Exception $ex){
            $output->write($ex->getMessage().PHP_EOL);
            return 0;
        }
        $output->write('Success'.PHP_EOL);
        return 1;
    }
}