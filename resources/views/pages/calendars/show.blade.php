@extends('layouts.app')

@section('content')
<section id="page">
    <div class="container">
        <x-calendar-show-info :calendar="$calendar" />
        <x-calendar-show-members-list :calendar="$calendar" :members="$members" />
        <x-calendar-show :calendar="$calendar" :events="$events" />
        <x-calendar-show-add-event-form :calendar="$calendar" />
    </div>
</section>
@endsection
