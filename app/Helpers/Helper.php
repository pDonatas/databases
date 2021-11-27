<?php declare(strict_types=1);

namespace App\Helpers;

use App\Http\Repository\Neo4j\CarRepository;
use App\Http\Repository\Neo4j\CarSessionRepository;

class Helper
{
    public static function countActiveSessions(int $userId): int
    {
        $carSessionRepository = app(CarSessionRepository::class);

        return $carSessionRepository->countActiveSessions($userId);
    }

    public static function carRentBy(int $userId, int $carId): bool
    {
        $carSessionRepository = app(CarSessionRepository::class);

        return $carSessionRepository->isUserHasRentForCar($userId, $carId);
    }

    public static function getCarName(int $carId): string
    {
        $carRepository = app(CarRepository::class);

        $car = $carRepository->find($carId);

        return $car->year . ' ' .  $car->manufacturer . ' ' . $car->model;
    }
}
