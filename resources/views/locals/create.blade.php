<x-app-layout>
    <x-slot name="header">
<div class="container">
    <h1>Ajouter une Salle</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('locals.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label>Nom de la Salle</label>
            <input type="text" name="nom" class="form-control" required>
        </div>
        <div class="form-group">
            <label>Capacité</label>
            <input type="number" name="capacite" class="form-control" required min="1">
        </div>
        <button type="submit" class="btn btn-success">Ajouter</button>
        <a href="{{ route('locals.index') }}" class="btn btn-secondary">Annuler</a>
    </form>
</div>
</x-app-layout>
