<x-app-layout>
    <x-slot name="header">
<div class="container">
    <h2>Créer un Emploi de Soutenance</h2>
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

        <div class="mb-3">
            <label for="professeur" >Professeur</label>
            <select id="professeur" name="ProfesseurID" class="form-control" required></select>
        </div>

        <!-- Champs remplis automatiquement -->
        <div class="mb-3">
            <label for="etudiant" class="form-label">Étudiant</label>
            <select  id="etudiant" name="EtudiantID" class="form-control" required></select>
        </div>

        <div class="mb-3">
            <label for="specialite" class="form-label">Spécialité</label>
            <input type="text" id="specialite" class="form-control" disabled>
<input type="hidden" id="specialite_id" name="SpecialiteID">

        </div>

        <div class="mb-3">
            <label for="groupe" class="form-label">Groupe</label>
            <input type="text" id="groupe" class="form-control" disabled>

<!-- Champ caché : contient le vrai ID -->
<input type="hidden" id="groupe_id" name="GroupID">
        </div>

        <!-- Sélection de l'Heure de Début -->
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
        <input type="hidden" name="Jour" value="{{ request('jour') }}">


        <!-- Sélection de l'Heure de Fin -->
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

        <!-- Sélection du Local -->
        <div class="mb-3">
            <label for="local" class="form-label">Local</label>
            <select id="local" name="LocalID" class="form-control" required>
                <option value="">Sélectionner un local</option>
                @foreach($locals as $local)
                    <option value="{{ $local->LocalID }}">{{ $local->Nom }}</option>
                @endforeach
            </select>
        </div>

        <!-- Bouton de confirmation -->
        <button type="submit" class="btn btn-primary">Confirmer</button>
    </form>
</div>

<!-- Script pour le remplissage automatique -->
<script>
document.getElementById('theme').addEventListener('change', function() {
    
    let themeID = this.value;

    if (themeID) {
        fetch(`/api/get-gestion-theme-by-theme?theme=${themeID}`)
        .then(response => response.json())
        .then(data => {
            document.getElementById('professeur').innerHTML = data.professeurs.map(prof => 
            `<option value="${prof.id}">${prof.nom}</option>`).join('');
            document.getElementById('etudiant').innerHTML = data.etudiants.map(etudiant => 
            `<option value="${etudiant.id}">${etudiant.nom}</option>`).join('');
            document.getElementById('specialite').value = data.specialite.nom;
document.getElementById('specialite_id').value = data.specialite.id;

document.getElementById('groupe').value = data.groupe.nom;
document.getElementById('groupe_id').value = data.groupe.id;

        })
        .catch(error => console.error('Erreur:', error));
    }
});
</script>

</x-app-layout>
