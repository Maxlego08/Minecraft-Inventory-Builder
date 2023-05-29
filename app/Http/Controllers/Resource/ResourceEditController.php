<?php

namespace App\Http\Controllers\Resource;

use App\Http\Controllers\Controller;
use App\Models\Resource\Category;
use App\Models\Resource\Resource;
use App\Models\UserLog;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Validation\ValidationException;

class ResourceEditController extends Controller
{
    /**
     * Edit a resource
     *
     * @param Resource $resource
     * @return Factory|\Illuminate\Foundation\Application|View|RedirectResponse|Application
     */
    public function index(Resource $resource): Factory|\Illuminate\Foundation\Application|View|RedirectResponse|Application
    {

        if (!$resource->isModerator()) {
            return Redirect::route('resources.index')->with('toast', createToast('error', __('resources.view.errors.permission.title'), __('resources.view.errors.permission.content'), 5000));
        }

        return view('resources.edit', ['resource' => $resource, 'versions' => $this->versions(), 'categories' => Category::all(), 'role' => user()->role]);
    }

    /**
     * Store a resource update
     *
     * @param Request $request
     * @param Resource $resource
     * @return RedirectResponse
     * @throws ValidationException
     */
    public function store(Request $request, Resource $resource): RedirectResponse
    {

        if (!$resource->isModerator()) {
            return Redirect::route('resources.index')->with('toast', createToast('error', __('resources.view.errors.permission.title'), __('resources.view.errors.permission.content'), 5000));
        }

        $this->validate($request, [
            'name_resource' => ['required', 'string', 'min:3', 'max:100'],
            'tags' => ['required', 'string', 'min:3', 'max:150'],

            'description' => 'required',
            'price' => ['nullable', 'decimal:2', 'min:0.0', 'max:100'],
            'version_base_mc' => ['required'],

            'contributors' => ['nullable', 'string', 'min:0', 'max:300'],
            'link_source' => ['nullable', 'string', 'min:0', 'max:300'],
            'link_donation' => ['nullable', 'string', 'min:0', 'max:300'],
            'link_information' => ['nullable', 'string', 'min:0', 'max:300'],
            'link_support' => ['nullable', 'string', 'min:0', 'max:300'],
            'lang_support' => ['nullable', 'string', 'min:0', 'max:300'],
            'bstats_id' => ['nullable', 'string', 'min:0', 'max:300'],
            'discord' => ['nullable', 'string', 'min:18', 'max:18'],

            'required_dependencies' => ['nullable', 'string', 'min:3', 'max:300'],
            'optional_dependencies' => ['nullable', 'string', 'min:3', 'max:300'],
        ]);

        $resource->update([
            'name' => $request['name_resource'],
            'description' => $request['description'],
            'tag' => $request['tags'],
            'contributors' => $request['contributors'],
            'source_code_link' => $request['link_source'],
            'donation_link' => $request['link_donation'],
            'discord_server_id' => $request['discord'],
            'bstats_id' => $request['bstats_id'],
            'required_dependencies' => $request['required_dependencies'],
            'optional_dependencies' => $request['optional_dependencies'],
            'link_information' => $request['link_information'],
            'link_support' => $request['link_support'],
            'lang_support' => $request['lang_support'],
            'versions' => implode(",", $request['versions'] ?? []),
        ]);

        $resource->clear('supported.version');

        userLog("Modification de la resource $resource->id", UserLog::COLOR_SUCCESS, UserLog::ICON_FILE);

        return Redirect::route('resources.view', ['resource' => $resource, 'slug' => $resource->slug()])->with('toast', createToast('success', __('resources.edit.success.title'), __('resources.edit.success.content'), 5000));
    }
}
