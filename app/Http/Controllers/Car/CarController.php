<?php

declare(strict_types=1);

namespace App\Http\Controllers\Car;

use App\Http\Controllers\Controller;
use App\Http\Repository\Neo4j\CarRepository;
use App\Http\Repository\Neo4j\CarSessionRepository;
use App\Models\Car;
use App\Http\Requests\StoreCarRequest;
use App\Http\Requests\UpdateCarRequest;
use App\Models\Session;
use Carbon\Carbon;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class CarController extends Controller
{
    public function __construct(
        public CarRepository $carRepository,
        public CarSessionRepository $carSessionRepository
    ) {}

    public function index(): View
    {
        $cars = $this->carRepository->findAll();

        return view('car.index', compact('cars'));
    }

    public function create(): View
    {
        return view('car.create');
    }

    public function store(StoreCarRequest $request): RedirectResponse
    {
        $this->carRepository->create($request->toArray());

        return response()->redirectToRoute('cars.index');
    }

    public function show(int $car): View
    {
        $car = $this->carRepository->find($car);

        return view('car.show', compact('car'));
    }

    public function edit(int $car): View
    {
        $car = $this->carRepository->find($car);

        return view('car.edit', compact('car'));
    }

    public function update(UpdateCarRequest $request, int $id): RedirectResponse
    {
        $this->carRepository->update($request->toArray(), $id);

        return response()->redirectToRoute('cars.index');
    }

    public function destroy(int $car): RedirectResponse
    {
        $this->carSessionRepository->deleteSessions($car);
        $this->carRepository->delete($car);

        return response()->redirectToRoute('cars.index');
    }

    public function rent(int $car): RedirectResponse
    {
        $car = $this->carRepository->find($car);

        $this->carSessionRepository->create([
            'user_id' => Auth::id(),
            'car_id' => $car->id,
            'start_time' => Carbon::now(),
            'start_address' => $car->location,
            'car_price' => $car->price
        ]);

        return redirect()->route('cars.index');
    }

    public function stopRent(): RedirectResponse
    {
        $this->carSessionRepository->stopRents(Auth::id());

        return redirect()->route('cars.index');
    }

    public function stopRentForCar(int $carId): RedirectResponse
    {
        $this->carSessionRepository->stopRents(Auth::id(), $carId);

        return redirect()->route('cars.index');
    }
}
