<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Créer un Emploi du Temps') }}
        </h2>
    </x-slot>

    <div class="container-fluid">
        <div class="row">
        <div class="col-12">
    <h1>Créer un Emploi du Temps</h1>
    <!-- Updated line below -->
    <p><strong>Jour :</strong> {{ $day }}, <strong>Heure :</strong> {{ $timeRanges[$timeSlot] }}</p>

    <!-- Formulaire pour créer un emploi du temps -->
    <form action="{{ route('emploi_du_temps.store') }}" method="POST">
        @csrf
        <input type="hidden" name="Jour" value="{{ $day }}">
        <input type="hidden" name="TimeSlot" value="{{ $timeSlot }}">


                    <!-- Affichage des erreurs -->
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <!-- Parcours -->
<!-- Parcours -->
<select id="parcours" name="ParcoursID" class="form-control" required>
    <option disabled selected>Choisir un parcours</option>
    <!-- Rempli dynamiquement via AJAX -->
</select>

<!-- Niveau -->
<select id="niveau" name="NiveauID" class="form-control" required>
    <option disabled selected>Choisir un niveau</option>
    <!-- Rempli dynamiquement via AJAX -->
</select>

<!-- Semestre -->
<select id="semestre" name="SemestreID" class="form-control">
                        <option disabled selected>Choisir un semestre</option>
                        @foreach($niveaux as $niveau)
                            <option disabled>{{ $niveau->Nom }} Semesters:</option>
                            @foreach($niveau->semesters as $semester)
                                <option value="{{ $semester->SemestreID }}">{{ $semester->Nom }}</option>
                            @endforeach
                        @endforeach
                    </select>

<!-- Spécialité -->
<select id="specialite" name="SpecialiteID" class="form-control">
    <option disabled selected>Choisir une spécialité</option>
</select>

<!-- Section -->
<select id="section" name="SectionID" class="form-control">
    <option disabled selected>Choisir une section</option>
</select>

<!-- Activité -->
<select id="activite" name="ActiviteID" class="form-control">
    <option disabled selected>Choisir une activité</option>
    @foreach($activites as $a)
        <option value="{{ $a->ActiviteID }}">{{ $a->Type }}</option>
    @endforeach
</select>

<!-- Groupe (dépend du type d'activité) -->
<div id="groupe-container"></div>

<!-- Module -->
<select id="module" name="ModuleID" class="form-control">
    <option disabled selected>Choisir un module</option>
    @foreach($sections as $section)
                            <option disabled>{{ $section->Nom }} modules:</option>
                            @foreach($section->modules as $module)
                                <option value="{{ $module->ModuleID }}">{{ $module->Nom }}</option>
                            @endforeach
                        @endforeach
</select>

<!-- Professeur -->
<select name="ProfesseurID" class="form-control" required>
    <option disabled selected>Choisir un professeur</option>
    @foreach($professeurs as $p)
        <option value="{{ $p->ProfesseurID }}">{{ $p->Nom }}</option>
    @endforeach
</select>

<!-- Local -->
<select name="LocalID" class="form-control">
    <option disabled selected>Choisir un local</option>
    @foreach($locaux as $l)
        <option value="{{ $l->LocalID }}">{{ $l->Nom }}</option>
    @endforeach
</select>

                    </div>

                    <button type="submit" class="btn btn-primary">Confirmer</button>
                </form>
            </div>
        </div>
    </div>
    <script>
$(document).ready(function () {
    $.get('/get-parcours-by-departement', function(data) {
        $('#parcours').empty().append('<option disabled selected>Choisir un parcours</option>');
        data.forEach(p => $('#parcours').append(`<option value="${p.ParcoursID}">${p.Nom}</option>`));
    });


    $('#parcours').on('change', function() {
        let id = $(this).val();
        $.get('/get-niveaux-by-parcours/' + id, function(data) {
            $('#niveau').empty().append('<option disabled selected>Choisir un niveau</option>');
            data.forEach(n => $('#niveau').append(`<option value="${n.NiveauID}">${n.Nom}</option>`));
        });

        // Charger spécialités
        $.get('/get-specialites-by-niveau/' + id, function (data) {
            $('#specialite').empty().append('<option disabled selected>Choisir une spécialité</option>');
            data.forEach(s => $('#specialite').append(`<option value="${s.SpecialiteID}">${s.Nom}</option>`));
        });
    });

    $('#specialite').on('change', function () {
        let id = $(this).val();
        $.get('/get-sections-by-specialite/' + id, function (data) {
            $('#section').empty().append('<option disabled selected>Choisir une section</option>');
            data.forEach(s => $('#section').append(`<option value="${s.SectionID}">${s.Nom}</option>`));
        });
    });

    $('#section').on('change', function () {
        let id = $(this).val();

        // Charger groupes
        $.get('/get-groupes-by-section/' + id, function (data) {
            if ($('#activite').val() === 'Cours') {
                let html = '<label>Groupes :</label>';
                data.forEach(g => {
                    html += `<div><input type="checkbox" name="GroupIDs[]" value="${g.GroupID}"> ${g.Nom}</div>`;
                });
                $('#groupe-container').html(html);
            } else {
                let html = '<label>Groupe :</label><select name="GroupID" class="form-control">';
                html += '<option disabled selected>Choisir un groupe</option>';
                data.forEach(g => html += `<option value="${g.GroupID}">${g.Nom}</option>`);
                html += '</select>';
                $('#groupe-container').html(html);
            }
        });

        // Charger modules
        $.get('/get-modules-by-semestre/' + id, function (data) {
        $('#module').empty().append('<option disabled selected>Choisir un module</option>');
        data.forEach(m => $('#module').append(`<option value="${m.ModuleID}">${m.Nom}</option>`));
        });
    });

    $('#activite').on('change', function () {
        $('#section').trigger('change'); // Recharger groupes selon activité
    });
});
</script>

</x-app-layout>
