<x-app-layout>
    <x-slot name="header">
<div class="container">
    <h2>Création d’un nouveau thème</h2>

    <form method="POST" action="{{ route('themes.store') }}">
    @csrf

    <div class="mb-3">
        <label for="Nom" class="form-label">Créer titre</label>
        <input type="text" name="Nom" id="Nom" class="form-control" required>
    </div>

    <div class="mb-3">
        <label for="ProfesseurID" class="form-label">Sélectionner un professeur</label>
        <select name="ProfesseurID" class="form-control">
    @foreach($professeurs as $prof)
        <option value="{{ $prof->ProfesseurID }}">{{ $prof->Nom }}</option>
    @endforeach
</select>

    </div>

    <button type="submit" class="btn btn-success">Confirmer</button>
</form>

</div>
</x-app-layout>
