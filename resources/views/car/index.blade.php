@extends('layouts.app')

@section('content')
    <a href="{{ route('cars.create') }}"><button class="btn btn-primary">Create new</button></a>
    <table class="table">
        <thead>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Number plate</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        @foreach($cars as $car)
            <tr>
                <td>{{ $car->id }}</td>
                <td>{{ $car->year }} {{ $car->manufacturer }} {{ $car->model }}</td>
                <td>{{ $car->number_plate }}</td>
                <td>
                    <a href="{{ route('cars.show', $car->id) }}"><button class="btn btn-primary">Show</button></a>
                    <a href="{{ route('cars.edit', $car->id) }}"><button class="btn btn-primary">Edit</button></a>
                    <form method="POST" action="{{ route('cars.destroy', $car->id) }}">
                        @method("DELETE")
                        @csrf
                        <button class="btn btn-primary">Delete</button>
                    </form>
                    @if(auth()->user()->carSessions()->countActive() == 0)
                        <a href="{{ route('cars.rent', $car->id) }}"><button class="btn btn-primary">Rent</button></a>
                    @endif
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection
