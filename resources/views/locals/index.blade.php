<x-app-layout>
    <x-slot name="header">
    <div class="container">
        <h1>Liste des Salles</h1>
        <a href="{{ route('locals.create') }}" class="btn btn-primary">Ajouter une Salle</a>

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <table class="table table-bordered mt-3">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nom</th>
                    <th>Capacité</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($locals as $local)
                    <tr>
                        <td>{{ $local->LocalID }}</td>
                        <td>{{ $local->Nom }}</td>
                        <td>{{ $local->Capacite }}</td>
                        <td>
                            <a href="{{ route('locals.edit', $local->LocalID) }}" class="btn btn-warning">Modifier</a>
                            <form action="{{ route('locals.destroy', $local->LocalID) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Supprimer</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</x-app-layout>
