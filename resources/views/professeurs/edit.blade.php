<x-app-layout>
    <x-slot name="header">
<div class="container">
    <h1>Modifier le professeur</h1>
    <form action="{{ route('professeurs.update', $professeur->ProfesseurID) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="Nom">Nom</label>
            <input type="text" name="Nom" class="form-control" value="{{ $professeur->Nom }}" required>
        </div>
        <div class="form-group">
            <label for="DepartementID">Département ID</label>
            <input type="text" name="DepartementID" class="form-control" value="{{ $professeur->DepartementID }}" required>
        </div>
        <div class="form-group">
            <label for="grade">Grade</label>
            <input type="text" name="grade" class="form-control" value="{{ $professeur->grade }}" required>
        </div>
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" name="email" class="form-control" value="{{ $professeur->email }}" required>
        </div>
        <div class="form-group">
            <label for="bureau">Bureau</label>
            <input type="text" name="bureau" class="form-control" value="{{ $professeur->bureau }}" required>
        </div>
        <button type="submit" class="btn btn-primary">Mettre à jour</button>
    </form>
</div>
</x-app-layout>