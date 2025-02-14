@extends('layouts.app')

@section('title', 'Weather App')

@section('content')
    @if($showAddForm ?? false)
        @include('components.add-favorite-location')
    @else
        @include('components.weather', ['weather' => $weather ?? null])
    @endif

@endsection
