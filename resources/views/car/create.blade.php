@extends('layouts.app')

@section('content')
    <form method="post" action="{{ route('cars.store') }}">
        @csrf
        <div class="form-group row">
            <label for="manufacturer" class="col-md-4 col-form-label text-md-right">Manufacturer</label>

            <div class="col-md-6">
                <input id="manufacturer" type="text" class="form-control" name="manufacturer" required autocomplete="manufacturer">
            </div>
        </div>

        <div class="form-group row">
            <label for="model" class="col-md-4 col-form-label text-md-right">Model</label>

            <div class="col-md-6">
                <input id="model" type="text" class="form-control" name="model" required autocomplete="model">
            </div>
        </div>

        <div class="form-group row">
            <label for="year" class="col-md-4 col-form-label text-md-right">Creation year</label>

            <div class="col-md-6">
                <input id="year" type="number" min="1900" class="form-control" name="year" required autocomplete="year">
            </div>
        </div>

        <div class="form-group row">
            <label for="condition" class="col-md-4 col-form-label text-md-right">Condition</label>

            <div class="col-md-6">
                <input id="condition" type="text" class="form-control" name="condition" required autocomplete="condition">
            </div>
        </div>

        <div class="form-group row">
            <label for="register_date" class="col-md-4 col-form-label text-md-right">Registration date</label>

            <div class="col-md-6">
                <input id="register_date" type="date" class="form-control" name="register_date" required autocomplete="register_date">
            </div>
        </div>

        <div class="form-group row">
            <label for="price" class="col-md-4 col-form-label text-md-right">Price per minute</label>

            <div class="col-md-6">
                <input id="price" type="number" step="0.01" class="form-control" name="price" required autocomplete="price">
            </div>
        </div>

        <div class="form-group row">
            <label for="number_plate" class="col-md-4 col-form-label text-md-right">Number plate</label>

            <div class="col-md-6">
                <input id="number_plate" type="text" class="form-control" name="number_plate" required autocomplete="number_plate">
            </div>
        </div>

        <div class="form-group row">
            <label for="location" class="col-md-4 col-form-label text-md-right">Location</label>

            <div class="col-md-6">
                <input id="location" type="text" class="form-control" name="location" required autocomplete="location">
            </div>
        </div>

        <div class="form-group row mb-0">
            <div class="col-md-6 offset-md-4">
                <button type="submit" class="btn btn-primary">
                    Create car
                </button>
            </div>
        </div>
    </form>
@endsection
