<x-app-layout>
    <x-slot name="header">
<div class="container">
    <h1>Créer un nouveau professeur</h1>
    <form action="{{ route('professeurs.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="Nom">Nom</label>
            <input type="text" name="Nom" class="form-control" required>
        </div>
        
        <div class="form-group">
            <label for="grade">Grade</label>
            <input type="text" name="grade" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" name="email" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="bureau">Bureau</label>
            <input type="text" name="bureau" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-success">Créer</button>
    </form>
</div>
</x-app-layout>