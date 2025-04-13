<x-app-layout>
    <x-slot name="header">
        <div class="container">
            <h2 class="mb-4">Création de l'Emploi du Soutenance</h2>
            <p>Choisir les informations ici</p>
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
                    <a href="{{ route('soutenance.create', ['jour' => $jour]) }}" class="btn btn-outline-primary">Ajouter</a>
                </div>

                <table class="table table-bordered text-center">
                    <thead>
                        <tr>
                            <th>Étudiant</th>
                            <th >Encadrant</th>
                            <th >Sous-encadrant</th>
                            <th>Thème</th>
                            <th>Spécialité</th>
                            <th>Groupe</th>
                            <th>Salle</th>
                            <th>Heure Début</th>
                            <th>Heure Fin</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $filteredEmplois = $emplois->where('Jour', $jour);
                        @endphp

                        @forelse($filteredEmplois as $emploi)
                            <tr>
                                <td>{{ $emploi->etudiant?->Nom ?? '—' }}</td>
                                <td class="px-4 py-2">{{ $soutenance->encadrant->Nom ?? '—' }}</td>
                            <td class="px-4 py-2">{{ $soutenance->sousEncadrant->Nom ?? '—' }}</td>
                                <td>{{ $emploi->theme?->Nom ?? '—' }}</td>
                                <td>{{ $emploi->specialite?->Nom ?? '—' }}</td>
                                <td>{{ $emploi->group?->Nom ?? '—' }}</td>
                                <td>{{ $emploi->local?->Nom ?? '—' }}</td>
                                <td>{{ $emploi->HeureDebut }}</td>
                                <td>{{ $emploi->HeureFin }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8">Aucune soutenance prévue ce jour-là.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        @endforeach
    </div>
</x-app-layout>
