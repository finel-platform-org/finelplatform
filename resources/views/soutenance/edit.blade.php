<x-app-layout>
    <x-slot name="header">
        <div class="container">
            <h2 class="mb-4">Modifier l'Emploi du Soutenance</h2>
        </div>
    </x-slot>

    <div class="container">
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('soutenance.update', $emploi->EmploiSoutenanceID) }}" method="POST">
            @csrf
            @method('PUT')

            <!-- Theme selection -->
            <div class="mb-3">
                <label for="theme" class="form-label">Thème</label>
                <select id="theme" name="ThemeID" class="form-control" required>
                    <option value="">Sélectionner un thème</option>
                    @foreach($themes as $theme)
                        <option value="{{ $theme->ThemeID }}" 
                            {{ $emploi->ThemeID == $theme->ThemeID ? 'selected' : '' }}>
                            {{ $theme->Nom }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Professor selection -->
            <div class="mb-3">
                <label for="professeur" class="form-label">Encadrant</label>
                <select id="professeur" name="ProfesseurID" class="form-control" required>
                    <option value="">Sélectionner un encadrant</option>
                    @foreach($professeurs as $professeur)
                        <option value="{{ $professeur->ProfesseurID }}" 
                            {{ $emploi->ProfesseurID == $professeur->ProfesseurID ? 'selected' : '' }}>
                            {{ $professeur->Nom }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Sous-encadrant selection -->
            <div class="mb-3">
                <label for="sous_encadrant" class="form-label">Sous-encadrant</label>
                <select id="sous_encadrant" name="SousEncadrantID" class="form-control">
                    <option value="">Sélectionner un sous-encadrant</option>
                    @foreach($professeurs as $professeur)
                        <option value="{{ $professeur->ProfesseurID }}" 
                            {{ $emploi->SousEncadrantID == $professeur->ProfesseurID ? 'selected' : '' }}>
                            {{ $professeur->Nom }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Time selection -->
            <div class="mb-3">
                <label for="HeureDebut" class="form-label">Heure Début</label>
                <select id="HeureDebut" name="HeureDebut" class="form-control" required>
                    <option value="">Sélectionner une heure</option>
                    @for ($i = 8; $i <= 18; $i++)
                        <option value="{{ $i }}:00" {{ $emploi->HeureDebut == "$i:00" ? 'selected' : '' }}>{{ $i }}:00</option>
                        <option value="{{ $i }}:30" {{ $emploi->HeureDebut == "$i:30" ? 'selected' : '' }}>{{ $i }}:30</option>
                    @endfor
                </select>
            </div>

            <div class="mb-3">
                <label for="HeureFin" class="form-label">Heure Fin</label>
                <select id="HeureFin" name="HeureFin" class="form-control" required>
                    <option value="">Sélectionner une heure</option>
                    @for ($i = 8; $i <= 18; $i++)
                        <option value="{{ $i }}:00" {{ $emploi->HeureFin == "$i:00" ? 'selected' : '' }}>{{ $i }}:00</option>
                        <option value="{{ $i }}:30" {{ $emploi->HeureFin == "$i:30" ? 'selected' : '' }}>{{ $i }}:30</option>
                    @endfor
                </select>
            </div>

            <!-- Local selection -->
            <div class="mb-3">
                <label for="local" class="form-label">Local</label>
                <select id="local" name="LocalID" class="form-control" required>
                    <option value="">Sélectionner un local</option>
                    @foreach($locals as $local)
                        <option value="{{ $local->LocalID }}" 
                            {{ $emploi->LocalID == $local->LocalID ? 'selected' : '' }}>
                            {{ $local->Nom }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Day selection -->
            <div class="mb-3">
                <label for="jour" class="form-label">Jour</label>
                <select id="jour" name="Jour" class="form-control" required>
                    <option value="">Sélectionner un jour</option>
                    @foreach(['Samedi', 'Dimanche', 'Lundi', 'Mardi', 'Mercredi', 'Jeudi'] as $jour)
                        <option value="{{ $jour }}" {{ $emploi->Jour == $jour ? 'selected' : '' }}>{{ $jour }}</option>
                    @endforeach
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Enregistrer</button>
            <a href="{{ route('soutenance.index') }}" class="btn btn-secondary">Annuler</a>
        </form>
    </div>
</x-app-layout>