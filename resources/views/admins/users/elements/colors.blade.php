<div class="container-fluid">
    <h1 class="h3 mb-2 text-gray-800">Couleur achetés</h1>
    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th>Couleur</th>
                        <th>Date d'obtention</th>
                        <th>Paiement relié</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($nameColorAccesses as $access)
                        <tr>
                            <td class="{{ $access->color->code }}">{!! $access->color->translation() !!}</td>
                            <td>{{ format_date($access->created_at, true) }}</td>
                            <td>
                                @if($access->payment)
                                    <a href="{{ route('admin.payments.show', $access->payment) }}">{{ $access->payment->payment_id }}</a>
                                @else
                                    Obtenu gratuitement
                                @endif
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
