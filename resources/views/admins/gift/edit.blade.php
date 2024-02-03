@extends('admins.layouts.app')

@section('title', 'Créer un code cadeau')

@section('content')
    <div class="container-fluid">
        <div class="card shadow mb-4">
            <div class="card-body">

                @if(isset($errors))
                    @foreach ($errors->all() as $error)
                        <div class="alert alert-danger">{{ $error }}</div>
                    @endforeach
                @endif

                <form action="{{ route('admin.gift.update', $gift) }}" method="POST">
                    @csrf

                    {{-- Champ pour le code cadeau --}}
                    <div class="form-group">
                        <label for="giftCode">Code Cadeau</label>
                        <div class="input-group mb-2">
                            <input type="text" class="form-control" id="giftCode" name="code" placeholder="Code Cadeau" value="{{ $gift->code }}"
                                   required>
                            <div class="input-group-append">
                                <button onclick="generateRandomCode()" class="btn btn-success" type="button">Aléatoire
                                </button>
                            </div>
                        </div>
                    </div>

                    {{-- Champ pour la réduction --}}
                    <div class="form-group">
                        <label for="reduction">Réduction (%)</label>
                        <input type="number" class="form-control" id="reduction" name="reduction" value="{{ $gift->reduction }}"
                               placeholder="Réduction en %" required>
                    </div>

                    {{-- Liste déroulante pour le type d'objet --}}
                    <div class="form-group">
                        <label for="typeSelect">Type d'Objet</label>
                        <select class="form-control" id="typeSelect" name="giftable_type" onchange="updateItemList()">
                            <option value="">Sélectionnez un type</option>
                            @foreach($types as $key => $type)
                            <option value="{{ $key }}" @if($gift->giftable_type == $key) selected @endif>{{ $type['name'] }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Liste déroulante pour les objets en fonction du type sélectionné --}}
                    <div class="form-group">
                        <label for="itemSelect">Objet</label>
                        <select class="form-control" id="itemSelect" name="giftable_id">
                            {{-- Les options seront ajoutées dynamiquement --}}
                            @foreach($types[$gift->giftable_type]['values'] as $value)
                                <option @if($gift->giftable_id == $value['id']) selected @endif value="{{ $value['id'] }}">{{ $value['name'] }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="max_use">Nombre maximum d'utilisations:</label>
                        <input type="number" id="max_use" name="max_use" class="form-control" value="{{ $gift->max_use ?? 1 }}">
                    </div>

                    <div class="form-group custom-control custom-switch">
                        <input type="checkbox" class="custom-control-input" id="active" name="active" @if($gift->active ?? false) checked="" @endif>
                        <label class="custom-control-label" for="active">Activer le code</label>
                    </div>

                    <button type="submit" class="btn btn-primary">Modifier le Code Cadeau</button>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>

        function generateRandomCode() {
            let result = '';
            let characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
            let charactersLength = characters.length;
            for (let i = 0; i < 15; i++) {
                result += characters.charAt(Math.floor(Math.random() * charactersLength));
            }
            let element = document.getElementById('giftCode');
            element.value = result;
        }

        const types = @json($types);

        function updateItemList() {
            const type = document.getElementById('typeSelect').value;
            const itemList = document.getElementById('itemSelect');
            itemList.innerHTML = '';

            console.log(type)
            console.log(types[type])

            if (types[type]) {
                types[type].values.forEach(item => {
                    const option = document.createElement('option');
                    console.log(item)
                    option.value = item.id;
                    option.text = item.name; // Assurez-vous que le nom ou l'ID est disponible*/
                    itemList.appendChild(option);
                });
            }
        }
    </script>
@endsection
