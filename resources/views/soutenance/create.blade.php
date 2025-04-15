<x-app-layout>
    <x-slot name="header">
        <div class="container">
            <h2 class="mb-4">Création de l'Emploi du Soutenance</h2>
            <p>Choisir les informations ici</p>
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

        <form action="{{ route('soutenance.store') }}" method="POST">
            @csrf

            <!-- Hidden field for selected day -->
            <input type="hidden" name="Jour" value="{{ request('jour') }}">

            <!-- Sélection du Thème -->
            <div class="mb-3">
                <label for="theme" class="form-label">Thème</label>
                <select id="theme" name="ThemeID" class="form-control" required>
                    <option value="">Sélectionner un thème</option>
                    @foreach($themes as $theme)
                        <option value="{{ $theme->ThemeID }}">{{ $theme->Nom }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Auto-filled fields -->
            <div class="mb-3">
                <label for="encadrant" class="form-label">Encadrant</label>
                <input type="text" id="encadrant" class="form-control" readonly>
                <input type="hidden" id="encadrant_id" name="ProfesseurID">
            </div>

            <div class="mb-3">
                <label for="sous_encadrant" class="form-label">Sous-encadrant</label>
                <input type="text" id="sous_encadrant" class="form-control" readonly>
                <input type="hidden" id="sous_encadrant_id" name="SousEncadrantID">
            </div>

            <div class="mb-3">
    <label class="form-label">Étudiants concernés</label>
    <textarea id="etudiants_liste" class="form-control" rows="3" readonly></textarea>
</div>


            <div class="mb-3">
                <label for="specialite" class="form-label">Spécialité</label>
                <input type="text" id="specialite" class="form-control" disabled>
                <input type="hidden" id="specialite_id" name="SpecialiteID">
            </div>

            <div class="mb-3">
    <label class="form-label">Groupes concernés</label>
    <textarea id="groupes_liste" class="form-control" readonly></textarea>
</div>

            <!-- Time selection -->
            <div class="mb-3">
                <label for="HeureDebut" class="form-label">Heure Début</label>
                <select id="HeureDebut" name="HeureDebut" class="form-control" required>
                    <option value="">Sélectionner une heure</option>
                    @for ($i = 8; $i <= 18; $i++)
                        <option value="{{ $i }}:00">{{ $i }}:00</option>
                        <option value="{{ $i }}:30">{{ $i }}:30</option>
                    @endfor
                </select>
            </div>

            <div class="mb-3">
                <label for="HeureFin" class="form-label">Heure Fin</label>
                <select id="HeureFin" name="HeureFin" class="form-control" required>
                    <option value="">Sélectionner une heure</option>
                    @for ($i = 8; $i <= 18; $i++)
                        <option value="{{ $i }}:00">{{ $i }}:00</option>
                        <option value="{{ $i }}:30">{{ $i }}:30</option>
                    @endfor
                </select>
            </div>

            <!-- Local selection -->
            <div class="mb-3">
                <label for="local" class="form-label">Local</label>
                <select id="local" name="LocalID" class="form-control" required>
                    <option value="">Sélectionner un local</option>
                    @foreach($locals as $local)
                        <option value="{{ $local->LocalID }}">{{ $local->Nom }}</option>
                    @endforeach
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Confirmer</button>
            <a href="{{ route('soutenance.index') }}" class="btn btn-secondary">Annuler</a>
        </form>
    </div>

    <script>
document.getElementById('theme').addEventListener('change', function() {
    let themeID = this.value;

    if (themeID) {
        fetch(`/api/get-gestion-theme-by-theme?theme=${themeID}`)
        .then(response => response.json())
        .then(data => {
            // Remplir les champs professeurs
            document.getElementById('encadrant').value = data.encadrant?.nom || '';
            document.getElementById('encadrant_id').value = data.encadrant?.id || '';
            
            if (data.sous_encadrant) {
                document.getElementById('sous_encadrant').value = data.sous_encadrant.nom;
                document.getElementById('sous_encadrant_id').value = data.sous_encadrant.id;
            }
            
            // Afficher la liste des étudiants
            const etudiantsText = data.etudiants.map(e => e.nom).join('\n');
            document.getElementById('etudiants_liste').value = etudiantsText;
            
            // Afficher la liste des groupes (uniques)
            const groupes = [...new Set(data.etudiants.map(e => e.groupe_nom))].join('\n');
            document.getElementById('groupes_liste').value = groupes;
            
            // Remplir spécialité
            document.getElementById('specialite').value = data.specialite.nom;
            document.getElementById('specialite_id').value = data.specialite.id;
        })
        .catch(error => {
            console.error('Erreur:', error);
            alert('Erreur lors du chargement des données');
        });
    } else {
        // Réinitialiser les champs
        document.getElementById('etudiants_liste').value = '';
        document.getElementById('groupes_liste').value = '';
    }
});
</script>
</x-app-layout>