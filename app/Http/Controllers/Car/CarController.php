<?php

declare(strict_types=1);

namespace App\Http\Controllers\Car;

use App\Http\Controllers\Controller;
use App\Models\Car;
use App\Http\Requests\StoreCarRequest;
use App\Http\Requests\UpdateCarRequest;
use App\Models\Session;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class CarController extends Controller
{
    public function index(): View
    {
        $cars = Car::all();

        return view('car.index', compact('cars'));
    }

    public function create()
    {
        return view('car.create');
    }

    public function store(StoreCarRequest $request): RedirectResponse
    {
        Car::create($request->toArray());

        return response()->redirectToRoute('cars.index');
    }

    public function show(Car $car): View
    {
        return view('car.show', compact('car'));
    }

    public function edit(Car $car)
    {
        return view('car.edit', compact('car'));
    }

    public function update(UpdateCarRequest $request, Car $car): RedirectResponse
    {
        $car->update($request->toArray());

        return response()->redirectToRoute('cars.index');
    }

    public function destroy(Car $car): RedirectResponse
    {
        $car->delete();

        return response()->redirectToRoute('cars.index');
    }

    public function rent(Car $car): RedirectResponse
    {
        $user = \Auth::user();

        $carSession = new Session();
        $carSession->user()->associate($user);
        $carSession->car()->associate($car);
        $carSession->start_time = Carbon::now();
        $carSession->start_address = $car->location;
        $carSession->car_price = $car->price;

        $carSession->save();

        return redirect()->route('cars.index');
    }
}
