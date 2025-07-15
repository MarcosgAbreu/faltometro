<x-app-layout>
    {{-- CABEÇALHO DA PÁGINA --}}
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Minhas Matérias
            </h2>
            <a href="{{ route('materias.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-500 active:bg-blue-700">
                + Adicionar Matéria
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- MENSAGEM DE SUCESSO --}}
            @if (session('success'))
                <div class="p-4 mb-6 text-sm text-green-800 rounded-lg bg-green-100 dark:bg-gray-800 dark:text-green-400" role="alert">
                    {{ session('success') }}
                </div>
            @endif

            {{-- CONTEÚDO PRINCIPAL --}}
            @if($subjects->isEmpty())
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg text-center p-8">
                    <p class="text-gray-600 dark:text-gray-400">Você ainda não cadastrou nenhuma matéria.</p>
                    <a href="{{ route('materias.create') }}" class="mt-4 inline-block text-blue-500 underline hover:text-blue-700">
                        Que tal adicionar uma agora?
                    </a>
                </div>
            @else
                {{-- AVISO INFORMATIVO --}}
                <div class="p-4 mb-6 text-sm text-blue-800 rounded-lg bg-blue-100 dark:bg-gray-800 dark:text-blue-400" role="alert">
                    <svg class="inline flex-shrink-0 mr-3 w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
                    </svg>
                    <span class="sr-only">Info</span>
                    <span>Para mais detalhes, adicionar faltas ou notas, clique no nome da matéria.</span>
                </div>

                {{-- GRID DE CARDS DAS MATÉRIAS --}}
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach ($subjects as $subject)
                        @php
                            // Lógica de cálculo para o resumo
                            $totalAbsences = $subject->absences->sum('quantity');
                            $limit = $subject->absences_limit;
                            $absencesPercentage = ($limit > 0) ? ($totalAbsences / $limit) * 100 : 0;

                            $totalWeightWithGrades = $subject->grades->whereNotNull('value')->sum('weight');
                            $partialSum = $subject->grades->reduce(fn($carry, $g) => $carry + ($g->value * $g->weight), 0);
                            $partialAverage = $totalWeightWithGrades > 0 ? $partialSum / $totalWeightWithGrades : 0;
                        @endphp

                        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg flex flex-col">
                            {{-- Cabeçalho do Card --}}
                            <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                                <a href="{{ route('materias.show', $subject) }}" class="hover:underline">
                                    <h3 class="font-semibold text-lg text-gray-900 dark:text-gray-100">{{ $subject->name }}</h3>
                                </a>
                                <p class="text-sm text-gray-500 dark:text-gray-400">Carga Horária: {{ $subject->workload }} (períodos)</p>
                            </div>

                            {{-- Corpo do Card com Resumos --}}
                            <div class="p-6 flex-grow space-y-4">
                                {{-- Resumo do Faltômetro --}}
                                <div>
                                    <p class="text-sm font-medium text-gray-700 dark:text-gray-300">Faltas: {{ $totalAbsences }} / {{ $limit }}</p>
                                    <div class="w-full bg-gray-200 rounded-full h-2.5 mt-1 dark:bg-gray-700">
                                        <div class="h-2.5 rounded-full @if($absencesPercentage > 85) bg-red-600 @elseif($absencesPercentage > 60) bg-yellow-400 @else bg-green-500 @endif" style="width: {{ min($absencesPercentage, 100) }}%"></div>
                                    </div>
                                </div>
                                {{-- Resumo da Média --}}
                                <div>
                                    <p class="text-sm font-medium text-gray-700 dark:text-gray-300">Média Parcial: {{ number_format($partialAverage, 2) }}</p>
                                </div>
                            </div>

                            {{-- Rodapé do Card com Ações --}}
                            <div class="p-4 bg-gray-50 dark:bg-gray-800/50 border-t border-gray-200 dark:border-gray-700 flex justify-end items-center gap-4">
                                <a href="{{ route('materias.edit', $subject) }}" class="text-sm text-indigo-600 dark:text-indigo-400 hover:underline">
                                    Editar
                                </a>
                                <form method="POST" action="{{ route('materias.destroy', $subject) }}" onsubmit="return confirm('Tem certeza que deseja excluir esta matéria?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-sm text-red-600 dark:text-red-400 hover:underline">
                                        Excluir
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif

        </div>
    </div>
</x-app-layout>