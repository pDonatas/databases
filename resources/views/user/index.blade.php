@extends('layouts.app')

@section('content')
    <a href="{{ route('users.create') }}"><button class="btn btn-primary">Create new</button></a>
    <table class="table">
        <thead>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Email</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        @foreach($users as $user)
            <tr>
                <td>{{ $user->id }}</td>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td>
                    <a href="{{ route('users.show', $user->id) }}"><button class="btn btn-primary">Show</button></a>
                    <a href="{{ route('users.edit', $user->id) }}"><button class="btn btn-primary">Edit</button></a>
                    <form method="POST" action="{{ route('users.destroy', $user->id) }}">
                        @method("DELETE")
                        @csrf
                        <button class="btn btn-primary">Delete</button>
                    </form>
                    @if($user->id != Auth::id()) <a href="{{ route('impersonate', $user->id) }}"><button class="btn btn-primary">Impersonate as user</button></a> @endif</td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection
