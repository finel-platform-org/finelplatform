<x-app-layout>
    <x-slot name="header">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Créer une affectation de thème') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <form method="POST" action="{{ route('gestiondesthemes.store') }}">
                    @csrf

                    <!-- Thème -->
                    <div class="mb-4">
                        <label for="theme" class="block font-medium text-sm text-gray-700">Thème *</label>
                        <select name="ThemeID" id="theme" class="form-control" required>
                            <option value="" disabled selected>Choisir un thème</option>
                            @foreach($themes as $theme)
                                <option value="{{ $theme->ThemeID }}" data-professor="{{ $theme->professeur_id ?? '' }}">
                                    {{ $theme->Nom }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-4">
    <label class="block font-medium text-sm text-gray-700">Encadrant principal *</label>
    <div class="flex items-center mt-1">
        <input type="text" id="encadrant-name" class="form-control flex-1" readonly>
        <input type="hidden" name="ProfesseurID_encadrant" id="encadrant-id">
        <span id="encadrant-loading" class="ml-2 hidden">
            <i class="fas fa-spinner fa-spin"></i>
        </span>
    </div>
</div>

                    <!-- Sous-encadrant -->
                    <div class="mb-4">
                        <label for="sous_encadrant" class="block font-medium text-sm text-gray-700">Sous-encadrant</label>
                        <select name="ProfesseurID_sous_encadrant" id="sous_encadrant" class="form-control">
                            <option value="" selected>Aucun sous-encadrant</option>
                        </select>
                    </div>

                    <!-- Étudiants -->
                    <!-- Étudiants -->
<div class="mb-4">
    <label class="block font-medium text-sm text-gray-700">Étudiants *</label>
    <div class="dropdown-field">
        <input type="text" id="etudiants-input" readonly placeholder="Sélectionner les étudiants" 
               class="form-control dropdown-toggle" data-target="#etudiants-list">
        <div id="etudiants-list" class="dropdown-checkboxes hidden border p-2 mt-1 bg-white shadow">
            <input type="text" class="form-control mb-2 search-input" placeholder="Rechercher...">
            <div class="checkbox-wrapper">
                @foreach($etudiants as $e)
                    <div>
                        <input type="checkbox" name="EtudiantID[]" value="{{ $e->EtudiantID }}" 
                               class="student-checkbox"> {{ $e->Nom }}
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
                   
                    <div class="grid grid-cols-2 gap-4 mb-4">
    <div>
        <label class="block font-medium text-sm text-gray-700">Groupe</label>
        <input type="text" id="group-display" class="form-control" readonly>
    </div>
    <div>
        <label class="block font-medium text-sm text-gray-700">Spécialité</label>
        <input type="text" id="specialite-display" class="form-control" readonly>
    </div>
</div>
</div>

                    

                    <button type="submit" class="btn btn-primary">Enregistrer</button>
                </form>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
       $(document).ready(function() {
    // Lorsqu'un thème est sélectionné
    $('#theme').change(function() {
        const themeId = $(this).val();
        $('#encadrant-loading').removeClass('hidden');
        
        if (themeId) {
            $.get(`/get-professor-by-theme/${themeId}`, function(data) {
                $('#encadrant-loading').addClass('hidden');
                
                if (data.error) {
                    alert(data.error);
                    $('#encadrant-name').val('');
                    $('#encadrant-id').val('');
                } else {
                    $('#encadrant-name').val(data.Nom);
                    $('#encadrant-id').val(data.ProfesseurID);
                    
                    // Mettre à jour les sous-encadrants
                    $.get('/get-all-professors', function(professeurs) {
                        let options = '<option value="" selected>Aucun sous-encadrant</option>';
                        professeurs.forEach(prof => {
                            if (prof.ProfesseurID != data.ProfesseurID) {
                                options += `<option value="${prof.ProfesseurID}">${prof.Nom}</option>`;
                            }
                        });
                        $('#sous_encadrant').html(options);
                    });
                }
            }).fail(function() {
                $('#encadrant-loading').addClass('hidden');
                alert('Erreur lors de la récupération du professeur');
                $('#encadrant-name').val('');
                $('#encadrant-id').val('');
            });
        } else {
            $('#encadrant-name').val('');
            $('#encadrant-id').val('');
            $('#sous_encadrant').html('<option value="" selected>Aucun sous-encadrant</option>');
        }
    });

    // Gestion des étudiants sélectionnés
   // Gestion des étudiants sélectionnés
$(document).on('change', '.student-checkbox', function() {
    const selectedStudents = $('.student-checkbox:checked').map(function() {
        return $(this).val();
    }).get();

    if (selectedStudents.length > 0) {
        $.get('/get-students-info', { ids: selectedStudents }, function(data) {
            let studentNames = [];
            let groups = new Set();
            let specialites = new Set();
            
            data.students.forEach(student => {
                studentNames.push(student.name);
                groups.add(student.group);
                specialites.add(student.specialite);
            });
            
            // Mettre à jour le champ d'entrée avec les noms des étudiants
            $('#etudiants-input').val(studentNames.join(', '));
            
            // Mettre à jour les champs Groupe et Spécialité
            $('#group-display').val(Array.from(groups).join(', '));
            $('#specialite-display').val(Array.from(specialites).join(', '));
        });
    } else {
        $('#etudiants-input').val('');
        $('#group-display').val('');
        $('#specialite-display').val('');
    }
});

    // Gestion des menus déroulants
    $('.dropdown-toggle').click(function() {
        const target = $(this).data('target');
        $('.dropdown-checkboxes').not(target).addClass('hidden');
        $(target).toggleClass('hidden');
    });

    $(document).click(function(e) {
        if (!$(e.target).closest('.dropdown-field').length) {
            $('.dropdown-checkboxes').addClass('hidden');
        }
    });

    $('.search-input').on('keyup', function() {
        const value = $(this).val().toLowerCase();
        $(this).siblings('.checkbox-wrapper').children('div').each(function() {
            const label = $(this).text().toLowerCase();
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
        .form-control[readonly] {
        background-color: #f3f4f6;
        cursor: not-allowed;
    }
    .fa-spinner {
        color: #3b82f6;
    }
    #etudiants-input {
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

#etudiants-input::placeholder {
    color: #6b7280;
    opacity: 1;
}
    </style>
</x-app-layout>