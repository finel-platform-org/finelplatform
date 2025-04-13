<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Emploi du Temps') }}
        </h2>
    </x-slot>

    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <h1>Création de Emploi du Temps</h1>
                <p>Gérer les emplois du temps ici.</p>

                <!-- Table for Emploi du Temps -->
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Journée / Florative</th>
                            <th>8:00 - 9:30</th>
                            <th>9:30 - 11:00</th>
                            <th>11:00 - 12:30</th>
                            <th>12:30 - 14:00</th>
                            <th>14:00 - 15:30</th>
                            <th>15:30 - 17:00</th>
                        </tr>
                    </thead>
                    <tbody>
    @foreach (['Samedi', 'Dimanche', 'Lundi', 'Mardi', 'Mercredi', 'Jeudi'] as $day)
        <tr>
            <td>{{ $day }}</td>
            @for ($i = 0; $i < 6; $i++)
                <td>
                    @php
                        // Récupérer tous les emplois du temps pour ce jour et cette plage horaire
                        $emploisPourCeCreneau = $emplois->where('Jour', $day)->where('TimeSlot', $i);
                    @endphp

                    @if ($emploisPourCeCreneau->isNotEmpty())
    @foreach ($emploisPourCeCreneau as $emploi)
    <div class="border p-2 mb-1">
    <strong>{{ $emploi->niveau->Nom ?? 'Niveau inconnu' }} - {{ $emploi->group->Nom ?? 'Groupe inconnu' }}</strong> <br>
    @if ($emploi->specialite)
        <em>{{ $emploi->specialite->Nom }}</em> <br>
    @endif
    {{ $emploi->activite->Type ?? 'Activité inconnue' }} : 
    {{ $emploi->module->Nom ?? 'Module inconnu' }} : 
    {{ $emploi->locals->Nom ?? 'Local inconnu' }} : 
    {{ $emploi->professeur->Nom ?? 'Professeur inconnu' }}
</div>


    @endforeach
@endif


                    <!-- Bouton pour ajouter un nouvel emploi -->
                    <a href="{{ route('emploi_du_temps.create', ['day' => $day, 'time' => $i]) }}" class="btn btn-success btn-sm">+</a>
                </td>
            @endfor
        </tr>
    @endforeach
</tbody>

                </table>
            </div>
        </div>
    </div>
</x-app-layout>