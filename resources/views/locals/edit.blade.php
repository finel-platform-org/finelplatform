<x-app-layout>
    <x-slot name="header">
<div class="container">
    <h1>Modifier la Salle</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('locals.update', $local) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label>Nom de la Salle</label>
            <input type="text" name="nom" class="form-control" value="{{ $local->nom }}" required>
        </div>
        <div class="form-group">
            <label>Capacité</label>
            <input type="number" name="capacite" class="form-control" value="{{ $local->capacite }}" required min="1">
        </div>
        <button type="submit" class="btn btn-primary">Modifier</button>
        <a href="{{ route('locals.index') }}" class="btn btn-secondary">Annuler</a>
    </form>
</div>
</x-app-layout>
