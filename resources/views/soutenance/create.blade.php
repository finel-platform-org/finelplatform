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
        @if($themes->isEmpty())
            <option value="" disabled>Aucun thème disponible dans votre département</option>
        @else
            @foreach($themes as $theme)
                <option value="{{ $theme->ThemeID }}">{{ $theme->Nom }}</option>
            @endforeach
        @endif
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
    const themeID = this.value;
    const baseUrl = window.location.origin;
    
    if (!themeID) {
        clearFields();
        return;
    }

    fetch(`${baseUrl}/get-gestion-theme-by-theme?theme=${themeID}`, {
        headers: {
            'Accept': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
        },
        credentials: 'include'
    })
    .then(response => {
        if (!response.ok) {
            return response.text().then(text => { throw new Error(text); });
        }
        return response.json();
    })
    .then(data => {
        if (data.error) {
            throw new Error(data.error);
        }
        
        // Update fields with multiple students
        updateFields(data);
    })
    .catch(error => {
        console.error('Fetch error:', error);
        alert(`Error loading data: ${error.message}`);
        clearFields();
    });
});

function updateFields(data) {
    // Encadrant
    document.getElementById('encadrant').value = data.encadrant?.nom || 'Non spécifié';
    document.getElementById('encadrant_id').value = data.encadrant?.id || '';
    
    // Sous-encadrant
    document.getElementById('sous_encadrant').value = data.sous_encadrant?.nom || 'Non spécifié';
    document.getElementById('sous_encadrant_id').value = data.sous_encadrant?.id || '';
    
    // Étudiants (multiple)
    const etudiantsText = data.etudiants?.map(e => e.nom).join('\n') || 'Aucun étudiant trouvé';
    document.getElementById('etudiants_liste').value = etudiantsText;
    
    // Groupes (multiple)
    const groupesText = data.groups?.map(g => g.nom).join('\n') || 
                       data.etudiants?.map(e => e.groupe_nom).filter(Boolean).join('\n') || 
                       'Aucun groupe trouvé';
    document.getElementById('groupes_liste').value = groupesText;
    
    // Specialite
    document.getElementById('specialite').value = data.specialite?.nom || 'Non spécifiée';
    document.getElementById('specialite_id').value = data.specialite?.id || '';
}

function clearFields() {
    document.getElementById('encadrant').value = '';
    document.getElementById('encadrant_id').value = '';
    document.getElementById('sous_encadrant').value = '';
    document.getElementById('sous_encadrant_id').value = '';
    document.getElementById('etudiants_liste').value = '';
    document.getElementById('groupes_liste').value = '';
    document.getElementById('specialite').value = '';
    document.getElementById('specialite_id').value = '';
};
</script>
</x-app-layout>