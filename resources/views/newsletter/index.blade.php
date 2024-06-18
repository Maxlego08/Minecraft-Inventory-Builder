

@extends('layouts.app')

@section('content')
    <div class="card(body">
        <h1>Votre abonnement à la Newsletter</h1>

        @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif

        @if (user()->newsletter_active)
            <form action="{{ route('newsletter.inactive') }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-danger">Se désabonner à la newsletter</button>
            </form>
        @else
            <form action="{{ route('newsletter.active') }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-success">S'abonner à la newsletter</button>
            </form>
        @endif
    </div>
@endsection

