@extends('layouts.app')

@section('content')
<section id="page">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Profile') }}</div>
                    <div class="card-body">
                        <x-profile-edit-form />
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
