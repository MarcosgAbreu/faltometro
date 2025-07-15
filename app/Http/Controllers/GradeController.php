<?php

namespace App\Http\Controllers;

use App\Models\Grade;
use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class GradeController extends Controller
{
    /**
     * Adiciona uma nova avaliação (nome e peso) a uma matéria.
     */
    public function store(Request $request, Subject $subject)
    {
        if (Auth::user()->id !== $subject->user_id) {
            abort(403);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'weight' => 'required|numeric|min:0.01|max:1',
        ]);

        $subject->grades()->create($validated);

        return back()->with('success', 'Avaliação adicionada com sucesso!');
    }

    /**
     * Atualiza a nota (value) de uma avaliação existente.
     */
    public function update(Request $request, Grade $grade)
    {
        if (Auth::user()->id !== $grade->subject->user_id) {
            abort(403);
        }

        $validated = $request->validate([
            // Permite que o campo seja nulo (para apagar a nota) ou numérico
            'value' => 'nullable|numeric|min:0|max:10',
        ]);

        $grade->update($validated);

        // Simplesmente redireciona de volta para a página anterior com uma mensagem.
        return back()->with('success', 'Nota atualizada com sucesso!');
    }

    /**
     * Remove uma avaliação de uma matéria.
     */
    public function destroy(Grade $grade)
    {
        if (Auth::user()->id !== $grade->subject->user_id) {
            abort(403);
        }

        $grade->delete();

        return back()->with('success', 'Avaliação removida com sucesso!');
    }
}