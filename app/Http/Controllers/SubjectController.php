<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Subject;

class SubjectController extends Controller
{
    public function index()
    {
        // Pega apenas as matérias do usuário que está logado
        $subjects = Auth::user()->subjects()->get();

        // Retorna a view e passa a variável $subjects para ela
        return view('materias.index', ['subjects' => $subjects]);
    }

    public function create()
    {
        // A única função dele é retornar a view com o formulário de criação
        return view('materias.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'workload' => 'required|integer|min:1',
            'absences_limit_percent' => 'required|integer|min:10|max:30',
        ]);

        $absences_limit = intval($validatedData['workload'] * ($validatedData['absences_limit_percent'] / 100));

        Auth::user()->subjects()->create([
            'name' => $validatedData['name'],
            'workload' => $validatedData['workload'],
            'absences_limit' => $absences_limit,
        ]);

        return redirect()->route('materias.index')
            ->with('success', 'Matéria adicionada com sucesso!');
    }

    public function destroy(Subject $materia)
    {
        // Garante que o usuário logado só pode excluir suas próprias matérias.
        if (Auth::user()->id !== $materia->user_id) {
            abort(403); // Acesso negado
        }

        $materia->delete();

        return redirect()->route('materias.index')
            ->with('success', 'Matéria excluída com sucesso!');
    }

    public function show(Subject $materia)
    {
        // Autorização: garante que o usuário só veja suas próprias matérias
        if (Auth::user()->id !== $materia->user_id) {
            abort(403);
        }

        $materia->load('absences', 'grades');

        return view('materias.show', ['subject' => $materia]);

    }

    public function edit(Subject $materia)
    {
        // Verificação de autorização: garante que o usuário só pode editar suas próprias matérias.
        if (Auth::id() !== $materia->user_id) {
            abort(403, 'Acesso não autorizado.');
        }

        // Retorna a view de edição, passando a matéria que queremos editar.
        return view('materias.edit', ['subject' => $materia]);
    }


    public function update(Request $request, Subject $materia)
    {
        // Verificação de autorização
        if (Auth::id() !== $materia->user_id) {
            abort(403, 'Acesso não autorizado.');
        }

        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'workload' => 'required|integer|min:1',
            'absences_limit_percent' => 'required|integer|min:10|max:30',
        ]);

        $absences_limit = intval($validatedData['workload'] * ($validatedData['absences_limit_percent'] / 100));

        $materia->update([
            'name' => $validatedData['name'],
            'workload' => $validatedData['workload'],
            'absences_limit' => $absences_limit,
        ]);

        return redirect()->route('materias.index')
            ->with('success', 'Matéria atualizada com sucesso!');
    }

}

