<?php

namespace App\Http\Controllers\Resource;

use App\Exceptions\FileExtensionException;
use App\Exceptions\UserFileFullException;
use App\Http\Controllers\Controller;
use App\Models\Resource\Category;
use App\Models\Resource\Resource;
use App\Models\Resource\Version;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Validation\ValidationException;
use Intervention\Image\Facades\Image;

class ResourceCreateController extends Controller
{
    /**
     * Create a new resource
     *
     * @return \Illuminate\Foundation\Application|Application|Factory|View|RedirectResponse
     */
    public function index(): Application|Factory|View|\Illuminate\Foundation\Application|RedirectResponse
    {
        $role = user()->role;
        $counts = Resource::where('user_id', user()->id)->count();
        if ($counts >= $role->max_resources) {
            return Redirect::back()->with('toast', createToast('error', __('resources.create.errors.limit.title'), __('resources.create.errors.limit.content'), 5000));
        }
        return view('resources.create', ['versions' => $this->versions(), 'categories' => Category::all(), 'role' => $role,]);
    }

    /**
     * Create a resource
     *
     * @param Request $request
     * @return RedirectResponse
     * @throws ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $role = user()->role;

        $this->validate($request, [

            'name_resource' => ['required', 'string', 'min:3', 'max:100'],
            'version' => ['required', 'string', 'min:3', 'max:25'],
            'tags' => ['required', 'string', 'min:3', 'max:150'],

            'description' => 'required',
            'price' => ['nullable', 'integer', 'min:0', 'max:100'],
            'category' => ['required'],
            'version_base_mc' => ['required'],

            'upload_file' => 'required|mimes:jar,zip|max:4096', // jar = application/octet-stream - zip = application/x-zip-compressed;
            'icon' => $role->getImageValidator(),

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

        $category = Category::find($request['category']);

        if (!isset($category) && $category->category_id !== null) {
            return Redirect::back()->withInput($request->input())->with('error', __('Unable to find the category, please try again.'));
        }

        $imageFile = $request->file('icon');
        $image = Image::make($imageFile);
        $user = user();

        try {
            $media = $this->storeImage($user, $imageFile, $image, false, true, 50, 50);
        } catch (FileExtensionException|UserFileFullException $e) {
            return Redirect::back()->withInput($request->input())->with('toast', createToast('error', 'Error !', 'Your resource icon is not right', 5000));
        }

        $file = $request->file('upload_file');

        $price = $request['price'];

        $resource = Resource::create(['category_id' => $category->id, 'user_id' => $user->id, 'image_id' => $media->id, 'name' => $request['name_resource'], 'price' => min(100, max(0, $price)), 'description' => $request['description'], 'tag' => $request['tags'], 'is_display' => true, 'is_pending' => true, 'contributors' => $request['contributors'], 'source_code_link' => $request['link_source'], 'donation_link' => $request['link_donation'], 'discord_server_id' => $request['discord'], 'bstats_id' => $request['bstats_id'], 'required_dependencies' => $request['required_dependencies'],
            'optional_dependencies' => $request['optional_dependencies'], 'link_information' => $request['link_information'], 'link_support' => $request['link_support'], 'lang_support' => $request['lang_support'], 'versions' => implode(",", $request['versions'] ?? []), 'version_id' => null,]);

        $storedFile = $this->storeFile($user, $resource, $file);
        $fileName = str_replace('.' . $this->getFileExtension($file), '', $file->getClientOriginalName());

        $version = Version::create(['version' => $request['version'], 'resource_id' => $resource->id, 'title' => 'First version of the plugin', 'description' => 'No description.', 'download' => 0, 'file_id' => $storedFile->id, 'file_name' => $fileName,]);

        $resource->update(['version_id' => $version->id]);

        return Redirect::route('resources.index')->with('toast', createToast('success', __('resources.create.success.title'), __('resources.create.success.content'), 5000));
    }

}
