<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Builder\ActionType;
use App\Models\Builder\ActionTypeContent;
use App\Models\UserLog;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ActionTypeController extends Controller
{

    /**
     * Affiche la liste des types d'action
     *
     * @return View|\Illuminate\Foundation\Application|Factory|Application
     */
    public function index(): View|\Illuminate\Foundation\Application|Factory|Application
    {
        $actions = ActionType::paginate(30);
        return view('admins.actions.index', [
            'actions' => $actions,
        ]);
    }

    /**
     * Afficher la page de création
     *
     * @return Application|Factory|View|\Illuminate\Foundation\Application
     */
    public function create(): \Illuminate\Foundation\Application|View|Factory|Application
    {
        return view('admins.actions.create');
    }

    /**
     * Créer un nouveau type d'action
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'description' => 'required',
            'example' => 'nullable',
            'documentation_url' => 'nullable|url',
            'is_zmenu_plus' => 'nullable|boolean',
        ]);

        $validatedData['is_zmenu_plus'] = $request->has('is_zmenu_plus');
        $validatedData['addon_id'] = 1;

        $action = ActionType::create($validatedData);

        userLog("Création du type d'action $action->name.$action->id", UserLog::COLOR_SUCCESS, UserLog::ICON_ADD);

        return redirect()->route('admin.actions.edit', $action)->with('toast', createToast('success', 'Création effectuée', "Vous venez de créer le type d'action $action->name.$action->id"));
    }

    /**
     * Afficher la page d'édition
     *
     * @param ActionType $action
     * @return View|\Illuminate\Foundation\Application|Factory|Application
     */
    public function edit(ActionType $action): View|\Illuminate\Foundation\Application|Factory|Application
    {
        return view('admins.actions.edit', [
            'action' => $action
        ]);
    }

    /**
     * Permet de mettre à jour le type d'action
     *
     * @param ActionType $action
     * @param Request $request
     * @return RedirectResponse
     */
    public function update(ActionType $action, Request $request): RedirectResponse
    {
        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'description' => 'nullable',
            'example' => 'nullable',
            'documentation_url' => 'nullable|url',
            'is_zmenu_plus' => 'nullable|boolean',
        ]);

        $validatedData['is_zmenu_plus'] = $request->has('is_zmenu_plus');

        $action->update($validatedData);

        userLog("Modification du type d'action $action->name.$action->id", UserLog::COLOR_WARNING, UserLog::ICON_EDIT);

        return redirect()->route('admin.actions.edit', $action)->with('toast', createToast('success', 'Modification effectuée', "Vous venez de modifier le type d'action $action->name.$action->id"));
    }

    /**
     * Afficher la page de création de contenu
     *
     * @param ActionType $action
     * @return Application|Factory|View|\Illuminate\Foundation\Application
     */
    public function createContent(ActionType $action): \Illuminate\Foundation\Application|View|Factory|Application
    {
        return view('admins.actions.create_content', [
            'action' => $action,
        ]);
    }

    /**
     * Afficher la page d'édition de contenu
     *
     * @param ActionTypeContent $content
     * @return View|\Illuminate\Foundation\Application|Factory|Application
     */
    public function editContent(ActionTypeContent $content): View|\Illuminate\Foundation\Application|Factory|Application
    {
        return view('admins.actions.edit_content', [
            'content' => $content
        ]);
    }

    /**
     * Permet de créer un contenu
     *
     * @param ActionType $action
     * @param Request $request
     * @return RedirectResponse
     */
    public function storeContent(ActionType $action, Request $request): RedirectResponse
    {
        $validatedData = $request->validate([
            'data_type' => 'required|string|in:string,textarea,bool,integer,float',
            'key' => 'required|string|max:255',
            'description' => 'nullable|string',
            'value' => 'nullable|string',
        ]);

        $validatedData['type_id'] = $action->id;
        $content = ActionTypeContent::create($validatedData);

        userLog("Création du contenu d'action $content->key.$content->id", UserLog::COLOR_SUCCESS, UserLog::ICON_ADD);

        return redirect()->route('admin.actions.edit', $action)->with('toast', createToast('success', 'Création effectuée', "Vous venez de créer le contenu d'action $content->key.$content->id"));
    }

    /**
     * Permet de modifier le contenu d'un type d'action
     *
     * @param ActionTypeContent $content
     * @param Request $request
     * @return RedirectResponse
     */
    public function updateContent(ActionTypeContent $content, Request $request): RedirectResponse
    {
        $validatedData = $request->validate([
            'data_type' => 'required|string|max:255',
            'key' => 'required|string|max:255',
            'description' => 'nullable|string',
            'value' => 'nullable|string',
        ]);

        $content->update($validatedData);

        userLog("Modification du contenu d'action $content->key.$content->id", UserLog::COLOR_WARNING, UserLog::ICON_EDIT);

        return redirect()->route('admin.actions.content.edit', $content)->with('toast', createToast('success', 'Modification effectuée', "Vous venez de modifier le contenu d'action $content->key.$content->id"));
    }

    /**
     * Supprimer un contenu
     *
     * @param ActionTypeContent $content
     * @return RedirectResponse
     */
    public function destroyContent(ActionTypeContent $content): RedirectResponse
    {
        $typeId = $content->type_id;
        $content->delete();
        userLog("Suppression du contenu d'action $content->key.$content->id", UserLog::COLOR_DANGER, UserLog::ICON_TRASH);

        return redirect()->route('admin.actions.edit', $typeId)->with('toast', createToast('success', 'Suppression effectuée', "Vous venez de supprimer le contenu d'action $content->key.$content->id"));
    }
}
