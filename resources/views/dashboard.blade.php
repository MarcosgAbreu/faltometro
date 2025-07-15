<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
        
            {{-- Card de Atenção para Matérias com Faltas no Limite --}}
            @php
                $subjects = Auth::user()->subjects()->with('absences', 'grades')->get();
                $attentionSubjects = $subjects->filter(function($subject) {
                    $totalAbsences = $subject->absences->sum('quantity');
                    return $subject->absences_limit > 0 && $totalAbsences >= ($subject->absences_limit * 0.8);
                });
            @endphp

            @if($attentionSubjects->count() > 0)
            <div class="bg-yellow-100 dark:bg-yellow-900 p-6 rounded-lg shadow">
                <h3 class="text-lg font-semibold text-yellow-800 dark:text-yellow-200 mb-2">Atenção! Matérias próximas do limite de faltas:</h3>
                <ul class="space-y-2">
                    @foreach($attentionSubjects as $subject)
                        @php
                            $totalAbsences = $subject->absences->sum('quantity');
                        @endphp
                        <li class="flex justify-between items-center">
                            <span class="font-medium">{{ $subject->name }}</span>
                            <span class="text-sm text-yellow-700 dark:text-yellow-100">
                                {{ $totalAbsences }} / {{ $subject->absences_limit }} faltas
                            </span>
                        </li>
                    @endforeach
                </ul>
            </div>
            @endif

            {{-- Card de Médias das Matérias --}}
            <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow">
                <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100 mb-4">Médias das Matérias do Semestre</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @foreach($subjects as $subject)
                        @php
                            $media = 0;
                            $pesoTotal = $subject->grades->sum('weight');
                            if ($pesoTotal > 0) {
                                $media = $subject->grades->sum(function($grade) {
                                    return ($grade->value ?? 0) * $grade->weight;
                                });
                            }
                        @endphp
                        <div class="border rounded-md p-4 flex flex-col">
                            <span class="font-medium text-indigo-700 dark:text-indigo-300">{{ $subject->name }}</span>
                            <span class="mt-2 text-sm text-gray-700 dark:text-gray-200">Média: <strong>{{ number_format($media, 2) }}</strong></span>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- Botão para Gerenciar Matérias --}}
            <div class="flex justify-end">
                <a href="{{ route('materias.index') }}"
                   class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-500 active:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    Gerenciar Matérias
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
