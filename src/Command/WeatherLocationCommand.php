<?php

namespace App\Command;

use App\Repository\LocationRepository;
use App\Service\WeatherUtil;
use Symfony\Component\Console\Attribute\Argument;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'weather:location',
    description: 'Prognoza pogody dla lokalizacji (po ID)',
)]
class WeatherLocationCommand
{
    public function __construct(
        private readonly LocationRepository $locationRepository,
        private readonly WeatherUtil $weatherUtil,
    ) {
    }

    public function __invoke(
        SymfonyStyle $io,
        #[Argument('Location ID')] int $id,
    ): int {
        $location = $this->locationRepository->find($id);
        if (!$location) {
            $io->error('Nie znaleziono lokalizacji o ID ' . $id);
            return Command::FAILURE;
        }

        $measurements = $this->weatherUtil->getWeatherForLocation($location);

        $io->writeln(sprintf('Location: %s', $location->getName()));
        $io->table(['Date', 'Temperature', 'Humidity', 'Wind speed', 'Precipitation'], array_map(fn($m) => [
            $m->getDate()->format('Y-m-d'),
            $m->getTempCelc() . ' °C',
            $m->getHumidity() . ' %',
            $m->getWindSpeed() . ' km/h',
            $m->getPrecipitation() . ' mm',
        ], $measurements));

        return Command::SUCCESS;
    }
}

/* Wygenerowano z pomoca claude opus 5.5 */
