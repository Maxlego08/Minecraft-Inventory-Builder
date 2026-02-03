<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Jobs\CategorizeHeadsJob;
use App\Jobs\DownloadHeadCategoriesJob;
use App\Jobs\ScrappingJob;
use App\Models\Builder\Head;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class HeadController extends Controller
{
    public function index()
    {
        $totalHeads = Head::count();
        $uncategorizedHeads = Head::whereNull('category')->count();
        $categorizedHeads = $totalHeads - $uncategorizedHeads;

        $jsonFiles = [];
        $lastDownload = null;

        if (Storage::exists('heads/categories')) {
            $files = Storage::files('heads/categories');
            foreach ($files as $file) {
                if (str_ends_with($file, '.json')) {
                    $jsonFiles[] = pathinfo($file, PATHINFO_FILENAME);
                    $timestamp = Storage::lastModified($file);
                    if ($lastDownload === null || $timestamp > $lastDownload) {
                        $lastDownload = $timestamp;
                    }
                }
            }
        }

        return view('admins.heads.index', [
            'totalHeads' => $totalHeads,
            'uncategorizedHeads' => $uncategorizedHeads,
            'categorizedHeads' => $categorizedHeads,
            'jsonFilesCount' => count($jsonFiles),
            'jsonFiles' => $jsonFiles,
            'lastDownload' => $lastDownload ? date('d/m/Y H:i:s', $lastDownload) : null,
        ]);
    }

    public function downloadCategories()
    {
        DownloadHeadCategoriesJob::dispatch();

        return redirect()->route('admin.heads.index')->with('toast', [
            'type' => 'success',
            'title' => 'Téléchargement lancé',
            'description' => 'Le téléchargement des catégories a été ajouté à la file d\'attente.',
            'duration' => 5000,
        ]);
    }

    public function categorizeHeads()
    {
        CategorizeHeadsJob::dispatch();

        return redirect()->route('admin.heads.index')->with('toast', [
            'type' => 'success',
            'title' => 'Catégorisation lancée',
            'description' => 'La catégorisation des têtes a été ajoutée à la file d\'attente.',
            'duration' => 5000,
        ]);
    }

    public function scrapeHeads(Request $request)
    {
        $request->validate([
            'from' => 'required|integer|min:1',
            'to' => 'required|integer|min:1|gte:from',
        ]);

        $from = (int) $request->input('from');
        $to = (int) $request->input('to');

        for ($i = $from; $i <= $to; $i++) {
            ScrappingJob::dispatch($i);
        }

        $count = $to - $from + 1;

        return redirect()->route('admin.heads.index')->with('toast', [
            'type' => 'success',
            'title' => 'Scraping lancé',
            'description' => "{$count} jobs de scraping ont été ajoutés à la file d'attente.",
            'duration' => 5000,
        ]);
    }
}
