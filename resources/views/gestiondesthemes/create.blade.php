<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Créer une gestion de thème') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <form method="POST" action="{{ route('gestiondesthemes.store') }}">
                    @csrf

                    <!-- Spécialité -->
                    <div class="mb-4">
                        <label for="specialite" class="block font-medium text-sm text-gray-700">Spécialité</label>
                        <select name="SpecialiteID" id="specialite" class="form-control">
                            <option disabled selected>Choisir une spécialité</option>
                            @foreach($specialites as $specialite)
                                <option value="{{ $specialite->SpecialiteID }}">{{ $specialite->Nom }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Section -->
                    <div class="mb-4">
                        <label for="section" class="block font-medium text-sm text-gray-700">Section</label>
                        <select name="SectionID" id="section" class="form-control">
                            <option disabled selected>Choisir une section</option>
                        </select>
                    </div>

                    <!-- Groupe -->
                    <div class="mb-4">
                        <label for="group" class="block font-medium text-sm text-gray-700">Groupe</label>
                        <select name="GroupID" id="group" class="form-control">
                            <option disabled selected>Choisir un groupe</option>
                        </select>
                    </div>

                    <!-- Étudiants -->
                    <div class="mb-4">
                        <label>Étudiants</label>
                        <div class="dropdown-field">
                            <input type="text" readonly placeholder="Sélectionner les étudiants" class="form-control dropdown-toggle" data-target="#etudiants-list">
                            <div id="etudiants-list" class="dropdown-checkboxes hidden border p-2 mt-1 bg-white shadow">
                                <input type="text" class="form-control mb-2 search-input" placeholder="Rechercher...">
                                <div class="checkbox-wrapper">
                                    @foreach($etudiants as $e)
                                        <div>
                                            <input type="checkbox" name="EtudiantID[]" value="{{ $e->EtudiantID }}"> {{ $e->Nom }}
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Encadrants -->
                    <div class="mb-4">
                        <label>Encadrants</label>
                        <div class="dropdown-field">
                            <input type="text" readonly placeholder="Sélectionner les encadrants" class="form-control dropdown-toggle" data-target="#encadrants-list">
                            <div id="encadrants-list" class="dropdown-checkboxes hidden border p-2 mt-1 bg-white shadow">
                                <input type="text" class="form-control mb-2 search-input" placeholder="Rechercher...">
                                <div class="checkbox-wrapper">
                                    @foreach($professeurs as $p)
                                        <div>
                                            <input type="checkbox" name="ProfesseurID[encadrant][]" value="{{ $p->ProfesseurID }}"> {{ $p->Nom }}
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Sous-encadrants -->
                    <div class="mb-4">
                        <label>Sous-encadrants</label>
                        <div class="dropdown-field">
                            <input type="text" readonly placeholder="Sélectionner les sous-encadrants" class="form-control dropdown-toggle" data-target="#sous-encadrants-list">
                            <div id="sous-encadrants-list" class="dropdown-checkboxes hidden border p-2 mt-1 bg-white shadow">
                                <input type="text" class="form-control mb-2 search-input" placeholder="Rechercher...">
                                <div class="checkbox-wrapper">
                                    @foreach($professeurs as $p)
                                        <div>
                                            <input type="checkbox" name="ProfesseurID[sous_encadrant][]" value="{{ $p->ProfesseurID }}"> {{ $p->Nom }}
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Thème -->
                    <div class="mb-4">
                        <label for="theme" class="block font-medium text-sm text-gray-700">Thème</label>
                        <select name="ThemeID" id="theme" class="form-control">
                            <option disabled selected>Choisir un thème</option>
                            @foreach($themes as $theme)
                                <option value="{{ $theme->ThemeID }}">{{ $theme->Nom }}</option>
                            @endforeach
                        </select>
                    </div>

                    <button type="submit" class="btn btn-primary">Créer la gestion de thème</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function () {




            
            // AJAX pour récupérer les sections par spécialité
            $('#specialite').on('change', function () {
                let specialiteID = $(this).val();
                if (specialiteID) {
                    $.ajax({
                        url: '/get-sections-by-specialite/' + specialiteID,
                        type: 'GET',
                        success: function (data) {
                            $('#section').empty().append('<option disabled selected>Choisir une section</option>');
                            data.forEach(section => {
                                $('#section').append(`<option value="${section.SectionID}">${section.Nom}</option>`);
                            });
                        }
                    });
                } else {
                    $('#section').empty().append('<option disabled selected>Choisir une section</option>');
                }
            });

            // AJAX pour récupérer les groupes par section
            $('#section').on('change', function () {
                let sectionID = $(this).val();
                if (sectionID) {
                    $.ajax({
                        url: '/get-groupes-by-section/' + sectionID,
                        type: 'GET',
                        success: function (data) {
                            $('#group').empty().append('<option disabled selected>Choisir un groupe</option>');
                            data.forEach(group => {
                                $('#group').append(`<option value="${group.GroupID}">${group.Nom}</option>`);
                            });
                        }
                    });
                } else {
                    $('#group').empty().append('<option disabled selected>Choisir un groupe</option>');
                }
            });

           // AJAX pour récupérer les étudiants par groupe
           $('#group').on('change', function () {
    let groupID = $(this).val();
    if (groupID) {
        $.ajax({
            url: '{{ url("/get-etudiants-by-group") }}/' + groupID,
            type: 'GET',
            success: function (data) {
                console.log(data);  // Affichez les données pour voir la réponse
                $('#etudiants-list .checkbox-wrapper').empty();  // Vider la liste des étudiants avant de les remplir
                if (data.length > 0) {
                    // Si des étudiants sont trouvés, les afficher
                    data.forEach(etudiant => {
                        $('#etudiants-list .checkbox-wrapper').append(`
                            <div>
                                <input type="checkbox" name="EtudiantID[]" value="${etudiant.EtudiantID}"> ${etudiant.Nom}
                            </div>
                        `);
                    });
                } else {
                    // Si aucun étudiant n'est trouvé, afficher un message
                    $('#etudiants-list .checkbox-wrapper').append(`
                        <div>Aucun étudiant trouvé pour ce groupe.</div>
                    `);
                }
            },
            error: function (xhr, status, error) {
                console.error("Erreur AJAX:", status, error); // Ajoute des détails sur l'erreur
                alert("Une erreur est survenue lors de la récupération des étudiants.");
            }
        });
    } else {
        // Si aucun groupe n'est sélectionné, vider la liste des étudiants
        $('#etudiants-list .checkbox-wrapper').empty();
    }
});



            // Code pour afficher/cacher les menus déroulants
            $('.dropdown-toggle').click(function () {
                let target = $(this).data('target');
                $('.dropdown-checkboxes').not(target).addClass('hidden');
                $(target).toggleClass('hidden');
            });

            $(document).click(function (e) {
                if (!$(e.target).closest('.dropdown-field').length) {
                    $('.dropdown-checkboxes').addClass('hidden');
                }
            });

            $('.search-input').on('keyup', function () {
                let value = $(this).val().toLowerCase();
                $(this).siblings('.checkbox-wrapper').children('div').each(function () {
                    let label = $(this).text().toLowerCase();
                    $(this).toggle(label.includes(value));
                });
            });
        });
    </script>

    <style>
       

        .form-control {
            display: block;
            width: 100%;
            padding: 0.5rem;
            border-radius: 0.375rem;
            border: 1px solid #d1d5db;
        }

        .dropdown-checkboxes {
            max-height: 250px;
            overflow-y: auto;
        }

        .checkbox-wrapper {
            max-height: 180px;
            overflow-y: auto;
        }

        .hidden {
            display: none;
        }
    </style>
</x-app-layout>
