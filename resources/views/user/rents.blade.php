@extends('layouts.app')

@section('content')
    <a href="{{ route('cars.index') }}"><button class="btn btn-primary">Car list</button></a>
    <table class="table">
        <thead>
        <tr>
            <th>#</th>
            <th>Name</th>
            <th>Date</th>
            <th>Status</th>
        </tr>
        </thead>
        <tbody>
        @foreach($sessions as $session)
            <tr>
                <td>{{ $session->id }}</td>
                <td>{{ App\Helpers\Helper::getCarName($session->car_id) }}</td>
                <td>{{ $session->start_time }}</td>
                <td>{{ $session->active == 1 ? 'Active' : 'Inactive' }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection
