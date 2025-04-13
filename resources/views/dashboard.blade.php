<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Admin Dashboard') }}
        </h2>
    </x-slot>

    <div class="container mx-auto p-6">
        <h1 class="text-xl font-bold mb-4">Bienvenue {{ Auth::user()->name }} !</h1>

        <div class="flex gap-4 justify-center">
            @foreach([
                ['name' => 'Classes', 'count' => 0, 'icon' => '📚'],
                ['name' => 'Salles', 'count' => 0, 'icon' => '🏠'],
                ['name' => 'Geoups', 'count' => 0, 'icon' => '🏢'],
                ['name' => 'Professeurs', 'count' => 0, 'icon' => '👨‍🏫'],
            ] as $stat)
            <div class="bg-white shadow-md rounded-lg p-4 w-40 h-32 flex flex-col items-center justify-center text-center">
                <span class="text-3xl">{{ $stat['icon'] }}</span>
                <h3 class="text-sm font-semibold mt-2">{{ $stat['name'] }}</h3>
                <p class="text-lg font-bold">{{ $stat['count'] }}</p>
            </div>
            @endforeach
        </div>
    </div>
</x-app-layout>
