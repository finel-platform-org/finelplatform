<x-app-layout>
    <x-slot name="header">
<div class="container-fluid">
    <!-- Custom Header -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Gestion des Professeurs</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active">Professeurs</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <div class="row">
        <div class="col-12">
            <h1>Liste des Professeurs</h1>
            <p>Gérer les professeurs ici.</p>

            <!-- Button to Create a New Professor -->
            <a href="{{ route('professeurs.create') }}" class="btn btn-success mb-3">
                <i class="fas fa-plus"></i> Créer un nouveau professeur
            </a>

            <!-- Table for Professeurs -->
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nom</th>
                        <th>Prénom</th>
                        <th>Email</th>
                        <th>Grade</th>
                        <th>Bureau</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Rows for each professor -->
                    @foreach ($professeurs as $professeur)
                        <tr>
                            <td>{{ $professeur->ProfesseurID }}</td>
                            <td>{{ $professeur->Nom }}</td>
                           
                            <td>{{ $professeur->email }}</td>
                            <td>{{ $professeur->grade }}</td>
                            <td>{{ $professeur->bureau }}</td>
                            <td>
                                <!-- Edit Button -->
                                <a href="{{ route('professeurs.edit', $professeur->ProfesseurID) }}" class="btn btn-primary btn-sm">
                                    <i class="fas fa-edit"></i> Modifier
                                </a>

                                <!-- Delete Button -->
                                <form action="{{ route('professeurs.destroy', $professeur->ProfesseurID) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce professeur ?')">
                                        <i class="fas fa-trash"></i> Supprimer
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
</x-app-layout>