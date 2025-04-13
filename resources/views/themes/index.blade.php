<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Création des thèmes') }}
        </h2>
    </x-slot>

    <div class="container">
    <a href="/themes/create" class="btn btn-success mb-3">+ créer un nv thème</a>



        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Titre</th>
                    <th>Professeur</th>
                </tr>
            </thead>
            <tbody>
                @foreach($themes as $theme)
                    <tr>
                        <td>{{ $theme->Nom }}</td>
                        <td>{{ $theme->professeur->Nom ?? 'Non assigné' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</x-app-layout>
