<?php

namespace App\Http\Controllers;

use App\Models\Absence;
use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AbsenceController extends Controller
{
    /**
     * Salva uma nova falta para uma matéria.
     */
    public function store(Request $request, Subject $subject)
    {
        // Autorização: Garante que o usuário só pode adicionar faltas às suas próprias matérias.
        if (Auth::user()->id !== $subject->user_id) {
            abort(403);
        }

        // Validação dos dados do formulário
        $validated = $request->validate([
            'absence_date' => 'required|date',
            'quantity'     => 'required|integer|min:1',
            'description'  => 'nullable|string|max:255',
        ]);

        // Cria a falta usando o relacionamento
        $subject->absences()->create($validated);

        return back()->with('success', 'Falta registrada com sucesso!');
    }

    /**
     * Remove uma falta específica.
     */
    public function destroy(Absence $absence)
    {
        // Autorização: Garante que o usuário só pode excluir faltas de suas próprias matérias.
        if (Auth::user()->id !== $absence->subject->user_id) {
            abort(403);
        }

        $absence->delete();

        return back()->with('success', 'Falta removida com sucesso!');
    }
}