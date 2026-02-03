<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Builder\Addon;
use App\Models\UserLog;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class AddonController extends Controller
{

    /**
     * Affiche la liste des addons
     *
     * @return View|\Illuminate\Foundation\Application|Factory|Application
     */
    public function index(): View|\Illuminate\Foundation\Application|Factory|Application
    {
        $addons = Addon::paginate(30);
        return view('admins.addons.index', [
            'addons' => $addons,
        ]);
    }

    /**
     * Afficher la page de création
     *
     * @return Application|Factory|View|\Illuminate\Foundation\Application
     */
    public function create(): \Illuminate\Foundation\Application|View|Factory|Application
    {
        return view('admins.addons.create');
    }

    /**
     * Créer un nouvel addon
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'description' => 'required',
            'resource_id' => 'required|integer|exists:resource_resources,id',
            'is_official' => 'nullable|boolean',
        ]);

        $validatedData['is_official'] = $request->has('is_official');

        $addon = Addon::create($validatedData);

        userLog("Création de l'addon $addon->name.$addon->id", UserLog::COLOR_SUCCESS, UserLog::ICON_ADD);

        return redirect()->route('admin.addons.edit', $addon)->with('toast', createToast('success', 'Création effectuée', "Vous venez de créer l'addon $addon->name.$addon->id"));
    }

    /**
     * Afficher la page d'édition
     *
     * @param Addon $addon
     * @return View|\Illuminate\Foundation\Application|Factory|Application
     */
    public function edit(Addon $addon): View|\Illuminate\Foundation\Application|Factory|Application
    {
        return view('admins.addons.edit', [
            'addon' => $addon
        ]);
    }

    /**
     * Permet de mettre à jour l'addon
     *
     * @param Addon $addon
     * @param Request $request
     * @return RedirectResponse
     */
    public function update(Addon $addon, Request $request): RedirectResponse
    {
        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'description' => 'nullable',
            'resource_id' => 'required|integer|exists:resource_resources,id',
            'is_official' => 'nullable|boolean',
        ]);

        $validatedData['is_official'] = $request->has('is_official');

        $addon->update($validatedData);

        userLog("Modification de l'addon $addon->name.$addon->id", UserLog::COLOR_WARNING, UserLog::ICON_EDIT);

        return redirect()->route('admin.addons.edit', $addon)->with('toast', createToast('success', 'Modification effectuée', "Vous venez de modifier l'addon $addon->name.$addon->id"));
    }
}
