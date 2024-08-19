<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Builder\ButtonType;
use App\Models\Builder\ButtonTypeContent;
use App\Models\UserLog;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
class ButtonController extends Controller

{

    /**
     * Affiche la liste des boutons
     *
     * @return View|\Illuminate\Foundation\Application|Factory|Application
     */
    public function index(): View|\Illuminate\Foundation\Application|Factory|Application
    {
        $buttons = ButtonType::paginate(30);
        return view('admins.buttons.index', [
            'buttons' => $buttons,
        ]);
    }

    /**
     * Afficher la page de création
     *
     * @return Application|Factory|View|\Illuminate\Foundation\Application
     */
    public function create(): \Illuminate\Foundation\Application|View|Factory|Application
    {
        return view('admins.buttons.create');
    }

    /**
     * Afficher la page de création
     *
     * @param ButtonType $button
     * @return Application|Factory|View|\Illuminate\Foundation\Application
     */
    public function createContent(ButtonType $button): \Illuminate\Foundation\Application|View|Factory|Application
    {
        return view('admins.buttons.create_content', [
            'button' => $button,
        ]);
    }


    /**
     * Afficher la page d'édition
     *
     * @param ButtonType $button
     * @return View|\Illuminate\Foundation\Application|Factory|Application
     */
    public function edit(ButtonType $button): View|\Illuminate\Foundation\Application|Factory|Application
    {
        return view('admins.buttons.edit', [
            'button' => $button
        ]);
    }


    /**
     * Afficher la page d'édition
     *
     * @param ButtonTypeContent $content
     * @return View|\Illuminate\Foundation\Application|Factory|Application
     */
    public function editContent(ButtonTypeContent $content): View|\Illuminate\Foundation\Application|Factory|Application
    {
        return view('admins.buttons.edit_content', [
            'content' => $content
        ]);
    }

    /**
     * Permet de mettre à jour le bouton
     *
     * @param ButtonType $button
     * @param Request $request
     * @return RedirectResponse
     */
    public function update(ButtonType $button, Request $request): RedirectResponse
    {
        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'description' => 'nullable',
            'example' => 'nullable'
        ]);


        $button->update($validatedData);

        userLog("Modification du bouton $button->name.$button->id", UserLog::COLOR_WARNING, UserLog::ICON_EDIT);

        return redirect()->route('admin.buttons.edit', $button)->with('toast', createToast('success', 'Modification effectué', "Vous venez de modifier le bouton $button->name.$button->id"));
    }

    /**
     * Permet de modifier le contenu d'un bouton
     *
     * @param ButtonTypeContent $content
     * @param Request $request
     * @return RedirectResponse
     */
    public function updateContent(ButtonTypeContent $content, Request $request): RedirectResponse
    {
        $validatedData = $request->validate([
            'data_type' => 'required|string|max:255',
            'key' => 'required|string|max:255',
            'description' => 'nullable|string',
            'documentation_url' => 'nullable|url'
        ]);

        $content->update($validatedData);

        userLog("Modification du contenu de bouton $content->key.$content->id", UserLog::COLOR_WARNING, UserLog::ICON_EDIT);

        return redirect()->route('admin.buttons.content.edit', $content)->with('toast', createToast('success', 'Modification effectué', "Vous venez de modifier le contenu de bouton $content->key.$content->id"));
    }

    /**
     * Permet de créer un contenu
     *
     * @param ButtonType $button
     * @param Request $request
     * @return RedirectResponse
     */
    public function storeContent(ButtonType $button, Request $request): RedirectResponse
    {

        $validatedData = $request->validate([
            'data_type' => 'required|string|in:text,textarea,number',
            'key' => 'required|string|max:255',
            'description' => 'nullable|string',
            'documentation_url' => 'nullable|url'
        ]);

        $validatedData['type_id'] = $button->id;
        $content = ButtonTypeContent::create($validatedData);

        userLog("Création du contenu de bouton $content->key.$content->id", UserLog::COLOR_SUCCESS, UserLog::ICON_ADD);

        return redirect()->route('admin.buttons.edit', $button)->with('toast', createToast('success', 'Création effectué', "Vous venez de créer le contenu de bouton $content->key.$content->id"));
    }

    public function destroyContent(ButtonTypeContent $content): RedirectResponse
    {
        $content->delete();
        userLog("Suppression du contenu de bouton $content->key.$content->id", UserLog::COLOR_DANGER, UserLog::ICON_TRASH);

        return redirect()->route('admin.buttons.edit', $content->type_id)->with('toast', createToast('success', 'Suppression effectué', "Vous venez de supprimer le contenu de bouton $content->key.$content->id"));
    }

}
