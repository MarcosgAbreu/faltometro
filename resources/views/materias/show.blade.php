<x-app-layout>
    {{-- CABEÇALHO DA PÁGINA --}}
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Detalhes de: {{ $subject->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- FEEDBACK DE SUCESSO --}}
            @if (session('success'))
                <div class="p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-100 dark:bg-gray-800 dark:text-green-400" role="alert">
                    {{ session('success') }}
                </div>
            @endif

            {{-- CARD DO FALTÔMETRO --}}
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <section>
                    <header>
                        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                            Faltômetro
                        </h2>
                        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                            Acompanhe suas faltas e o limite para não reprovar.
                        </p>
                    </header>

                    {{-- Lógica e Barra de Progresso --}}
                    @php
                        $totalAbsences = $subject->absences->sum('quantity');
                        $limit = $subject->absences_limit;
                        $percentage = ($limit > 0) ? ($totalAbsences / $limit) * 100 : 0;
                    @endphp
                    <div class="mt-4">
                        <p class="text-sm text-gray-600 dark:text-gray-400">
                            Você tem <strong>{{ $totalAbsences }}</strong> falta(s) de um limite de <strong>{{ $limit }}</strong>.
                        </p>
                        <div class="w-full bg-gray-200 rounded-full h-4 mt-2 dark:bg-gray-700">
                            <div class="h-4 rounded-full 
                                @if($percentage > 85) bg-red-600 @elseif($percentage > 60) bg-yellow-400 @else bg-green-500 @endif"
                                style="width: {{ min($percentage, 100) }}%">
                            </div>
                        </div>
                    </div>

                    {{-- Formulário para Adicionar Faltas --}}
                    <form method="POST" action="{{ route('absences.store', $subject) }}" class="mt-6 space-y-4">
                        @csrf
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                            <div>
                                <label for="absence_date" class="block font-medium text-sm text-gray-700 dark:text-gray-300">Data</label>
                                <input type="date" name="absence_date" id="absence_date" value="{{ date('Y-m-d') }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm bg-white border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">
                            </div>
                            <div>
                                <label for="quantity" class="block font-medium text-sm text-gray-700 dark:text-gray-300">Quantidade</label>
                                <input type="number" name="quantity" id="quantity" value="1" min="1" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm bg-white border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">
                            </div>
                            <div class="sm:self-end">
                                <button type="submit" class="w-full justify-center inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-500 active:bg-blue-700">
                                    Registrar Falta
                                </button>
                            </div>
                        </div>
                    </form>
                    
                    {{-- Lista de Faltas Registradas --}}
                    <div class="mt-6">
                        @if(!$subject->absences->isEmpty())
                        <h3 class="text-md font-medium text-gray-900 dark:text-gray-100">Histórico de Faltas</h3>
                        <ul class="mt-2 divide-y divide-gray-200 dark:divide-gray-700">
                            @foreach ($subject->absences->sortByDesc('absence_date') as $absence)
                            <li class="py-2 flex justify-between items-center">
                                <span class="text-sm text-gray-800 dark:text-gray-200">{{ \Carbon\Carbon::parse($absence->absence_date)->format('d/m/Y') }} ({{$absence->quantity}} falta(s))</span>
                                <form method="POST" action="{{ route('absences.destroy', $absence) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:text-red-700 text-xs" onclick="return confirm('Tem certeza?');">Remover</button>
                                </form>
                            </li>
                            @endforeach
                        </ul>
                        @endif
                    </div>
                </section>
            </div>

            {{-- CARD DA CALCULADORA DE NOTAS --}}
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <section>
                    <header>
                        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                            Acompanhamento de Notas
                        </h2>
                        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                            Cadastre as avaliações, pesos e notas para calcular sua média.
                        </p>
                    </header>

                    {{-- Formulário para Adicionar Avaliação (Nome e Peso) --}}
                    <form method="POST" action="{{ route('grades.store', $subject) }}" class="mt-6 border-b dark:border-gray-700 pb-6">
                        @csrf
                        <h3 class="font-medium text-gray-900 dark:text-gray-100">Adicionar Nova Avaliação</h3>
                        <div class="mt-2 grid grid-cols-1 sm:grid-cols-3 gap-4">
                            <div>
                                <label for="grade_name" class="block font-medium text-sm text-gray-700 dark:text-gray-300">Nome</label>
                                <input type="text" name="name" id="grade_name" placeholder="Ex: P1" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm bg-white border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">
                            </div>
                            <div>
                                <label for="grade_weight" class="block font-medium text-sm text-gray-700 dark:text-gray-300">Peso</label>
                                <input type="number" step="0.01" name="weight" id="grade_weight" placeholder="Ex: 0.4" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm bg-white border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">
                            </div>
                            <div class="sm:self-end">
                                <button type="submit" class="w-full justify-center inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-500 active:bg-blue-700">
                                    Adicionar
                                </button>
                            </div>
                        </div>
                    </form>

                    {{-- Lista de Avaliações Existentes --}}
                    <div class="mt-6">
                        @if($subject->grades->isEmpty())
                            <p class="text-center text-sm text-gray-500 dark:text-gray-400 py-4">Nenhuma avaliação cadastrada.</p>
                        @else
                            <div class="grid grid-cols-6 gap-4 mb-2 text-sm font-bold text-gray-600 dark:text-gray-400">
                                <div class="col-span-3">Avaliação</div>
                                <div class="col-span-2">Nota</div>
                                <div class="text-right">Ação</div>
                            </div>
                            <ul class="space-y-2">
                                @foreach ($subject->grades as $grade)
                                <li class="grid grid-cols-6 gap-4 items-center">
                                    <div class="col-span-3">
                                        <p class="font-semibold text-gray-900 dark:text-gray-100">{{ $grade->name }}</p>
                                        <p class="text-xs text-gray-500">Peso: {{ number_format($grade->weight, 2) }}</p>
                                    </div>
                                    <div class="col-span-2">
                                        <form method="POST" action="{{ route('grades.update', $grade) }}" class="flex items-center gap-2">
                                            @csrf
                                            @method('PATCH')
                                            <input type="number" step="0.01" name="value" value="{{ old('value', $grade->value) }}" placeholder="-" class="w-full text-center rounded-md border-gray-300 shadow-sm bg-white border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">
                                            <button type="submit" class="px-2 py-1 text-xs bg-green-600 text-white rounded hover:bg-green-700" title="Salvar Nota">OK</button>
                                        </form>
                                    </div>
                                    <div class="text-right">
                                        <form method="POST" action="{{ route('grades.destroy', $grade) }}" onsubmit="return confirm('Tem certeza que deseja remover a avaliação \'{{ $grade->name }}\'?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-500 hover:text-red-700 text-sm">Excluir</button>
                                        </form>
                                    </div>
                                </li>
                                @endforeach
                            </ul>
                        @endif
                    </div>
                    
                    {{-- Seção de Resultados (Média) --}}
                    <div class="mt-6 pt-4 border-t dark:border-gray-700">
                        @php
                            $totalWeightWithGrades = $subject->grades->whereNotNull('value')->sum('weight');
                            $partialSum = $subject->grades->reduce(fn($carry, $g) => $carry + ($g->value * $g->weight), 0);
                            $partialAverage = $totalWeightWithGrades > 0 ? $partialSum / $totalWeightWithGrades : 0;
                        @endphp
                        <div class="flex justify-between font-bold text-lg text-gray-900 dark:text-gray-100">
                            <span>Média Parcial:</span>
                            <span>{{ number_format($partialAverage, 2) }}</span>
                        </div>
                        <p class="text-right text-sm text-gray-500">
                            (Calculada com base nos pesos das notas já lançadas: {{ number_format($totalWeightWithGrades, 2) }})
                        </p>
                    </div>

                </section>
            </div>

        </div>
    </div>
</x-app-layout>