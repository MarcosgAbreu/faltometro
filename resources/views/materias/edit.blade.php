<!-- resources/views/materias/edit.blade.php -->
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Editando Matéria: <span class="font-normal">{{ $subject->name }}</span>
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 md:p-8 text-gray-900 dark:text-gray-100">

                    {{-- Formulário de Edição --}}
                    <form method="POST" action="{{ route('materias.update', $subject) }}">
                        @csrf  {{-- Token de segurança obrigatório --}}
                        @method('PATCH') {{-- Informa ao Laravel que esta é uma requisição de atualização --}}

                        <!-- Nome da Matéria -->
                        <div>
                            <label for="name" class="block font-medium text-sm text-gray-700 dark:text-gray-300">Nome da Matéria</label>
                            <input id="name" name="name" type="text" value="{{ old('name', $subject->name) }}" required
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm dark:bg-gray-700 dark:border-gray-600 focus:border-indigo-500 focus:ring-indigo-500">
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>

                        <!-- Carga Horária -->
                        <div class="mt-4">
                            <label for="workload" class="block font-medium text-sm text-gray-700 dark:text-gray-300">Carga Horária (Total de períodos)</label>
                            <input id="workload" name="workload" type="number" value="{{ old('workload', $subject->workload) }}" required
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm dark:bg-gray-700 dark:border-gray-600 focus:border-indigo-500 focus:ring-indigo-500">
                             <x-input-error :messages="$errors->get('workload')" class="mt-2" />
                        </div>

                        <!-- Limite de Faltas (Slider de %) -->
                        <div class="mt-4">
                            <label for="absences_limit_percent"
                                class="block font-medium text-sm text-gray-700 dark:text-gray-300">Limite de Faltas (%)</label>
                            <div class="flex items-center gap-4">
                                <input id="absences_limit_percent" name="absences_limit_percent" type="range"
                                    min="10" max="30" step="1"
                                    value="{{ old('absences_limit_percent', 25) }}"
                                    class="block mt-1 w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 bg-white">
                                <span id="percent_val" class="font-semibold text-indigo-600 dark:text-indigo-400">
                                    {{ old('absences_limit_percent', 25) }}
                                </span>%
                            </div>
                            <x-input-error :messages="$errors->get('absences_limit_percent')" class="mt-2" />
                            <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">
                                Normalmente entre 10% e 30% da carga horária. Ex: Para 80 períodos e 25%, o limite é 20 faltas.
                            </p>
                        </div>
                        <script>
                            const slider = document.getElementById('absences_limit_percent');
                            const percentVal = document.getElementById('percent_val');
                            if (slider && percentVal) {
                                slider.addEventListener('input', function () {
                                    percentVal.textContent = this.value;
                                });
                            }
                        </script>

                        <!-- Botões de Ação -->
                        <div class="flex items-center justify-end mt-6">
                            <a href="{{ route('materias.index') }}" class="text-sm text-gray-600 dark:text-gray-400 hover:underline">
                                Cancelar
                            </a>

                            <button type="submit" class="ms-4 inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-500 active:bg-blue-700">
                                Salvar Alterações
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>