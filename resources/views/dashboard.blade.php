@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        @foreach ($wallets as $wallet)
            <div class="col-md-4">
                <a href="{{ route('wallet.show', $wallet->id) }}" class="wallet-item">
                    <div class="card">
                        <div class="card-header">{{ $wallet->name }}</div>
                        <div class="card-body">
                            <p>{{ str_limit($wallet->comment, $limit = 150, $end = '...') }}</p>
                            <i>Updated 3 minutes ago</i>
                        </div>
                    </div>
                </a>
            </div>
        @endforeach
    </div>
</div>
@endsection
