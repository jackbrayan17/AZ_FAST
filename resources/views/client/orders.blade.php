@extends('layout.app')

@section('content')

<div class="container mx-auto">
    <h2 class="text-2xl font-bold mb-4">Mes Commandes</h2>
    
    @if($orders->isEmpty())
        <p>Aucune commande trouvée.</p>
    @else
        <table class="min-w-full">
            <thead>
                <tr>
                    <th>ID de Commande</th>
                    <th>Statut</th>
                    <th>Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($orders as $order)
                    <tr>
                        <td>{{ $order->id }}</td>
                        <td>{{ $order->status }}</td>
                        <td>{{ $order->created_at->format('d-m-Y') }}</td>
                        <td>
                            <a href="{{ route('client.orders.show', $order->id) }}" class="btn-secondary">Détails</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>

@endsection
