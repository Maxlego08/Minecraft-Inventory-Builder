<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment\Gift;
use App\Models\Resource\Resource;
use App\Models\User;
use App\Models\UserLog;
use App\Models\UserRole;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Validation\ValidationException;

class GiftController extends Controller
{
    /**
     * Afficher tous les codes cadeaux
     *
     * @return \Illuminate\Contracts\Foundation\Application|Factory|View|Application
     */
    public function index(): Application|View|Factory|\Illuminate\Contracts\Foundation\Application
    {
        $gifts = Gift::orderBy('created_at', 'DESC')->paginate();
        return view('admins.gift.index', [
            'gifts' => $gifts,
        ]);
    }

    /**
     * Créer un code cadeau
     *
     * @return \Illuminate\Contracts\Foundation\Application|Factory|View|Application
     */
    public function create(): Application|View|Factory|\Illuminate\Contracts\Foundation\Application
    {
        return view('admins.gift.create', [
            'types' => $this->getTypes()
        ]);
    }

    /**
     * Créer un code cadeau
     *
     * @param Gift $gift
     * @return \Illuminate\Contracts\Foundation\Application|Factory|View|Application
     */
    public function edit(Gift $gift): Application|View|Factory|\Illuminate\Contracts\Foundation\Application
    {
        return view('admins.gift.edit', [
            'types' => $this->getTypes(),
            'gift' => $gift,
        ]);
    }

    private function getTypes(): array
    {
        return [
            UserRole::class => [
                'name' => 'Account Upgrade',
                'values' => [
                    [
                        'name' => 'Premium',
                        'id' => UserRole::where('power', UserRole::PREMIUM)->first()->id
                    ],
                    [
                        'name' => 'Pro',
                        'id' => UserRole::where('power', UserRole::PRO)->first()->id
                    ]
                ]
            ],
            Resource::class => [
                'name' => 'Resource',
                'values' => Resource::all()->map(function ($item) {
                    return [
                        'id' => $item->id,
                        'name' => $item->name
                    ];
                })->toArray()
            ],
            User\NameColor::class => [
                'name' => 'Couleur de pseudo',
                'values' => User\NameColor::all()->map(function ($item) {
                    return [
                        'id' => $item->id,
                        'name' => $item->translation(),
                    ];
                })->toArray()
            ],
        ];
    }

    /**
     * Sauvegarder un code cadeau
     *
     * @param Request $request
     * @return RedirectResponse
     * @throws ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        // Valider les données du formulaire
        $this->validate($request, [
            'code' => ['required', 'string', 'max:20', 'min:3', 'regex:/^[a-zA-Z0-9_]+$/u', 'unique:gifts,code'],
            'max_use' => ['required'],
            'reduction' => ['required'],
            'type' => ['required'],
            'item_id' => ['required'],
        ]);

        $gift = new Gift([
            'user_id' => user()->id,
            'code' => $request['code'],
            'max_use' => $request['max_use'],
            'reduction' => $request['reduction'],
            'giftable_type' => $request['type'],
            'giftable_id' => $request['item_id'],
            'active' => $request->input('active') === 'on',
        ]);

        $gift->save();

        userLog("Création du code cadeau $gift->code.$gift->id", UserLog::COLOR_SUCCESS, UserLog::ICON_ADD);

        // Rediriger l'utilisateur ou envoyer une réponse
        return Redirect::route('admin.gift.index')->with('toast',
            createToast('success', 'Succès', "Création du code cadeau $gift->code.$gift->id"));
    }


    public function delete(Gift $gift): RedirectResponse
    {
        $gift->logs()->delete();
        $gift->delete();

        userLog("Suppression du code cadeau $gift->code.$gift->id", UserLog::COLOR_DANGER, UserLog::ICON_REMOVE);
        return Redirect::back()->with('toast', createToast('success', 'Vous venez de supprimer un code cadeau', "Vous venez de supprimer le code cadeau $gift->code.$gift->id"));
    }

    /**
     * Mettre à jour un code cadeau
     *
     * @param Request $request
     * @param Gift $gift
     * @return RedirectResponse
     * @throws ValidationException
     */
    public function update(Request $request, Gift $gift): RedirectResponse
    {
        $this->validate($request, [
            'code' => ['required', 'string', 'max:20', 'min:3', 'regex:/^[a-zA-Z0-9_]+$/u', 'unique:gifts,code,' . $gift->id],
            'max_use' => ['required'],
            'reduction' => ['required'],
            'giftable_type' => ['required'],
            'giftable_id' => ['required'],
        ]);

        $request['active'] = $request->input('active') === 'on';
        $gift->update($request->all());

        userLog("Modification du code cadeau $gift->code.$gift->id", UserLog::COLOR_SUCCESS, UserLog::ICON_EDIT);
        return Redirect::route('admin.gift.index')->with('toast', createToast('success', 'Vous venez de modifier un code cadeau', "Modification du code cadeau $gift->code.$gift->id"));
    }

}

