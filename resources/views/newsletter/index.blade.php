

@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Votre abonnement à la Newsletter</h1>

        @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif

        @if ($newsletter && $newsletter->newsletter_active)
            <form action="{{ route('newsletter.inactive') }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-danger">Vous vous êtes désabonné de la newsletter</button>
            </form>
        @else
            <form action="{{ route('newsletter.active') }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-success">Vous vous êtes abonné à la newsletter</button>
            </form>
        @endif
    </div>
@endsection
