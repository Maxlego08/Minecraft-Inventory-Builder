<?php

namespace App\Http\Controllers\Resource;

use App\Http\Controllers\Controller;
use App\Models\Resource\Access;
use App\Models\Resource\Resource;
use App\Models\User;
use App\Models\UserLog;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Validation\ValidationException;

class ResourceBuyerController extends Controller
{
    /**
     * Show a resource
     *
     * @param string $slug
     * @param Resource $resource
     * @return \Illuminate\Contracts\Foundation\Application|Factory|View|Application|RedirectResponse
     */
    public function index(string $slug, Resource $resource): \Illuminate\Contracts\Foundation\Application|Factory|View|Application|RedirectResponse
    {

        if (!$resource->isModerator()) {
            return Redirect::route('resources.index')->with('toast', createToast('error', __('resources.view.errors.owner.title'), __('resources.view.errors.owner.content'), 5000));
        }

        if ($resource->is_pending && !$resource->isModerator()) {
            return Redirect::route('resources.index')->with('toast', createToast('error', __('resources.view.errors.pending.title'), __('resources.view.errors.pending.content'), 5000));
        }

        if ($resource->is_deleted && !user()->role->isModerator()) {
            return Redirect::route('resources.index')->with('toast', createToast('error', __('resources.view.errors.deleted.title'), __('resources.view.errors.deleted.content'), 5000));
        }

        if ($resource->price == 0) {
            return Redirect::route('resources.view', ['resource' => $resource, 'slug' => $resource->slug()]);
        }

        if ($slug != $resource->slug()) return Redirect::route('resources.buyers', ['resource' => $resource->id, 'slug' => $resource->slug()]);

        $search = request()->input('search');
        $buyers = Access::select('resource_accesses.*')
            ->with('user')
            ->leftJoin('users', 'users.id', '=', 'resource_accesses.user_id')
            ->where('resource_id', $resource->id)
            ->when($search, function ($query) use ($search) {
                $query->where('users.name', 'like', '%' . $search . '%');
            })->paginate(50);

        return view('resources.pages.buyers', ['resource' => $resource, 'buyers' => $buyers]);
    }

    /**
     * @param Resource $resource
     * @return RedirectResponse
     */
    public function indexById(Resource $resource): RedirectResponse
    {
        return Redirect::route('resources.buyers', ['resource' => $resource->id, 'slug' => $resource->slug()]);
    }

    /**
     * Delete a user who access to the plugin
     *
     * @param Resource $resource
     * @param Access $buyer
     * @return RedirectResponse
     */
    public function remove(Resource $resource, Access $buyer): RedirectResponse
    {

        if (!$resource->isModerator()) {
            return Redirect::route('resources.index')->with('toast', createToast('error', __('resources.view.errors.owner.title'), __('resources.view.errors.owner.content'), 5000));
        }

        if ($resource->id !== $buyer->resource_id) {
            return Redirect::route('resources.index')->with('toast', createToast('error', __('resources.view.errors.owner.title'), __('resources.view.errors.owner.content'), 5000));
        }

        if ($resource->is_pending && !$resource->isModerator()) {
            return Redirect::route('resources.index')->with('toast', createToast('error', __('resources.view.errors.pending.title'), __('resources.view.errors.pending.content'), 5000));
        }

        if ($resource->is_deleted && !user()->role->isModerator()) {
            return Redirect::route('resources.index')->with('toast', createToast('error', __('resources.view.errors.deleted.title'), __('resources.view.errors.deleted.content'), 5000));
        }

        $buyer->user->clear('user.access');
        $buyer->delete();

        userLog("Suppression de l'utilisateur $buyer->user_id à la resource $resource->id", UserLog::COLOR_DANGER, UserLog::ICON_FILE);

        return Redirect::route('resources.buyers', ['resource' => $resource, 'slug' => $resource->slug()])->with('toast', createToast('success', __('resources.buyers.remove.title'), __('resources.buyers.remove.content'), 5000));
    }

    /**
     * @param Request $request
     * @param Resource $resource
     * @return RedirectResponse
     * @throws ValidationException
     */
    public function create(Request $request, Resource $resource): RedirectResponse
    {

        if (!$resource->isModerator()) {
            return Redirect::route('resources.index')->with('toast', createToast('error', __('resources.view.errors.owner.title'), __('resources.view.errors.owner.content'), 5000));
        }

        $this->validate($request, [
            'username' => 'required',
        ]);

        if ($resource->is_pending && !$resource->isModerator()) {
            return Redirect::route('resources.index')->with('toast', createToast('error', __('resources.view.errors.pending.title'), __('resources.view.errors.pending.content'), 5000));
        }

        if ($resource->is_deleted && !user()->role->isModerator()) {
            return Redirect::route('resources.index')->with('toast', createToast('error', __('resources.view.errors.deleted.title'), __('resources.view.errors.deleted.content'), 5000));
        }

        $user = User::where('name', $request['username'])->first();
        if (!isset($user)) {
            return Redirect::route('resources.buyers', ['resource' => $resource, 'slug' => $resource->slug()])->with('toast', createToast('error', __('resources.buyers.error.title'), __('resources.buyers.create.content'), 5000));
        }

        $access = Access::where('user_id', $user->id)->where('resource_id', $resource->id)->first();
        if (isset($access)) {
            return Redirect::route('resources.buyers', ['resource' => $resource, 'slug' => $resource->slug()])->with('toast', createToast('error', __('resources.buyers.already.title'), __('resources.buyers.already.content'), 5000));
        }

        Access::create([
            'user_id' => $user->id,
            'resource_id' => $resource->id,
        ]);
        $user->clear('user.access');

        userLog("Ajout de l'utilisateur $user->id à la resource $resource->id", UserLog::COLOR_SUCCESS, UserLog::ICON_FILE);

        return Redirect::route('resources.buyers', ['resource' => $resource, 'slug' => $resource->slug()])->with('toast', createToast('success', __('resources.buyers.create.title'), __('resources.buyers.create.content'), 5000));
    }

}
