<x-app-layout>
    <x-slot name="header">
        <div class="container">
            <h2 class="mb-4">Emploi du Temps de Soutenance</h2>
            <a href="{{ route('soutenance.create') }}" ></a>
        </div>
    </x-slot>

    <div class="container">
        @php
            $jours = ['Samedi', 'Dimanche', 'Lundi', 'Mardi', 'Mercredi', 'Jeudi'];
        @endphp

        @foreach($jours as $jour)
            <div class="mb-5">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <h4>{{ $jour }}</h4>
                    <a href="{{ route('soutenance.create', ['jour' => $jour]) }}" 
                       class="btn btn-outline-primary">
                       Ajouter pour {{ $jour }}
                    </a>
                </div>

                @if($emplois->has($jour))
                    <table class="table table-bordered text-center">
                        <thead>
                            <tr>
                                <th>Étudiants</th>
                                <th>Encadrant</th>
                                <th>Sous-encadrant</th>
                                <th>Thème</th>
                                <th>Spécialité</th>
                                <th>Groupes</th>
                                <th>Salle</th>
                                <th>Heure Début</th>
                                <th>Heure Fin</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($emplois[$jour] as $themeGroup)
                                @foreach($themeGroup as $creneau => $emploisSameTheme)
                                    @php
                                        $firstEmploi = $emploisSameTheme->first();
                                        $etudiants = $emploisSameTheme->pluck('etudiant.Nom')->filter()->implode(', ');
                                        $groupes = $emploisSameTheme->pluck('group.Nom')->filter()->unique()->implode(', ');
                                    @endphp
                                    <tr>
                                        <td>{{ $etudiants ?: 'N/A' }}</td>
                                        <td>{{ $firstEmploi->professeur->Nom ?? 'N/A' }}</td>
                                        <td>{{ $firstEmploi->sousEncadrant->Nom ?? '—' }}</td>
                                        <td>{{ $firstEmploi->theme->Nom ?? 'N/A' }}</td>
                                        <td>{{ $firstEmploi->specialite->Nom ?? '—' }}</td>
                                        <td>{{ $groupes ?: '—' }}</td>
                                        <td>{{ $firstEmploi->local->Nom ?? 'N/A' }}</td>
                                        <td>{{ $firstEmploi->HeureDebut }}</td>
                                        <td>{{ $firstEmploi->HeureFin }}</td>
                                        <td>
                    
                                        <form action="{{ route('soutenance.destroy', $firstEmploi->EmploiSoutenanceID) }}" 
      method="POST" 
      style="display: inline-block;">
    @csrf
    @method('DELETE')
    <button type="submit" class="btn btn-sm btn-danger" 
            onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette soutenance?')">
        <i class="fas fa-trash"></i> Supprimer
    </button>
</form>
                                        </td>
                                    </tr>
                                @endforeach
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <div class="alert alert-info">Aucune soutenance prévue ce jour.</div>
                @endif
            </div>
        @endforeach
    </div>
</x-app-layout>