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
    @foreach ($groupedGestThemes as $themeID => $gestions)
        @php
            $first = $gestions->first(); // pour accéder aux champs communs comme la spécialité, le thème, etc.
            $etudiants = $gestions->map(fn($g) => $g->etudiant)->filter();
            $groupes = $etudiants->map(fn($e) => $e->group->Nom ?? 'Inconnu')->unique();
        @endphp
        <tr>
            <td>{{ $first->specialite->Nom ?? '' }}</td>
            <td>{{ $groupes->implode(', ') }}</td>
            <td>{{ $etudiants->pluck('Nom')->implode(', ') }}</td>
            <td>
                @foreach($first->professeurs->where('pivot.role', 'encadrant') as $prof)
                    {{ $prof->Nom }}@if (!$loop->last), @endif
                @endforeach
            </td>
            <td>
                @foreach($first->professeurs->where('pivot.role', 'sous_encadrant') as $prof)
                    {{ $prof->Nom }}@if (!$loop->last), @endif
                @endforeach
            </td>
            <td>{{ $first->theme->Nom ?? 'N/A' }}</td>
            <td>
                {{-- Attention ici : on ne peut supprimer qu’une affectation complète, donc on prend le premier ID --}}
                <form action="{{ route('gestiondesthemes.destroy', $first->GestionThemeID) }}" method="POST">
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
