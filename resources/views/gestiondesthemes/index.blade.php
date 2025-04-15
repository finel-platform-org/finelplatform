<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('gestion des themes ') }}
        </h2>
    </x-slot>
<div class="container">
    <h2>Gestion des Thèmes</h2>
    <a href="{{ route('gestiondesthemes.create') }}" class="btn btn-success">+ Ajouter une gestion de thème</a>
    <table class="table mt-3">
    <thead>
        <tr>
            <th>Spécialité</th>
            <th>Groupe(s)</th>
            <th>Étudiant(s)</th>
            <th>Encadrant</th>
            <th>Sous-encadrant</th>
            <th>Thème</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($gestiondesthemes as $gestion)
        <tr>
            <td>{{ $gestion->specialite->Nom }}</td>
            <td>
                @foreach($gestion->etudiants->groupBy('group.Nom') as $groupName => $students)
                    {{ $groupName }}@if (!$loop->last), @endif
                @endforeach
            </td>
            <td>
                @foreach($gestion->etudiants as $etudiant)
                    {{ $etudiant->Nom }}@if (!$loop->last), @endif
                @endforeach
            </td>
            <td>
                @foreach($gestion->professeurs->where('pivot.role', 'encadrant') as $professeur)
                    {{ $professeur->Nom }}@if (!$loop->last), @endif
                @endforeach
            </td>
            <td>
                @foreach($gestion->professeurs->where('pivot.role', 'sous_encadrant') as $professeur)
                    {{ $professeur->Nom }}@if (!$loop->last), @endif
                @endforeach
            </td>
            <td>{{ $gestion->theme->Nom ?? 'N/A' }}</td>
            <td>
                <form action="{{ route('gestiondesthemes.destroy', $gestion->GestionThemeID) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Supprimer</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
</div>
</x-app-layout>
