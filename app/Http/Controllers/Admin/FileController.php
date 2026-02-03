<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\File;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class FileController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        // Global stats from DB
        $totalFiles = File::count();
        $totalSizeBytes = File::sum('file_size');

        // Breakdown by extension
        $extensionStats = File::select('file_extension', DB::raw('COUNT(*) as count'), DB::raw('SUM(file_size) as total_size'))
            ->groupBy('file_extension')
            ->orderByDesc('total_size')
            ->get();

        $imageCount = File::whereIn('file_extension', File::IMAGE)->count();
        $imageSizeBytes = File::whereIn('file_extension', File::IMAGE)->sum('file_size');
        $pluginCount = File::whereIn('file_extension', array_merge(File::JAR, File::ZIP))->count();
        $pluginSizeBytes = File::whereIn('file_extension', array_merge(File::JAR, File::ZIP))->sum('file_size');

        // Disk usage (real filesystem)
        $diskUsage = $this->getDiskUsage();

        // Top 10 users by storage
        $topUsers = File::select('user_id', DB::raw('COUNT(*) as file_count'), DB::raw('SUM(file_size) as total_size'))
            ->groupBy('user_id')
            ->orderByDesc('total_size')
            ->limit(10)
            ->with('user:id,name')
            ->get();

        // Recent files with search
        $filesQuery = File::with('user:id,name')->orderByDesc('created_at');
        if ($search) {
            $filesQuery->where(function ($q) use ($search) {
                $q->where('file_upload_name', 'like', "%{$search}%")
                    ->orWhere('file_name', 'like', "%{$search}%")
                    ->orWhere('file_extension', $search)
                    ->orWhereHas('user', function ($q) use ($search) {
                        $q->where('name', 'like', "%{$search}%");
                    });
            });
        }
        $files = $filesQuery->paginate(50);

        return view('admins.files.index', [
            'totalFiles' => $totalFiles,
            'totalSizeBytes' => $totalSizeBytes,
            'imageCount' => $imageCount,
            'imageSizeBytes' => $imageSizeBytes,
            'pluginCount' => $pluginCount,
            'pluginSizeBytes' => $pluginSizeBytes,
            'extensionStats' => $extensionStats,
            'diskUsage' => $diskUsage,
            'topUsers' => $topUsers,
            'files' => $files,
            'search' => $search,
        ]);
    }

    public function destroy(File $file)
    {
        // Delete physical file
        $imagePath = "public/images/{$file->file_name}.{$file->file_extension}";
        if (Storage::exists($imagePath)) {
            Storage::delete($imagePath);
        }

        $pluginExtensions = array_merge(File::JAR, File::ZIP);
        if (in_array($file->file_extension, $pluginExtensions)) {
            $pluginFiles = Storage::disk('plugins')->allFiles('');
            foreach ($pluginFiles as $pFile) {
                if (str_contains($pFile, $file->file_name)) {
                    Storage::disk('plugins')->delete($pFile);
                }
            }
        }

        // Delete cache
        $file->deleteCache();

        // Delete DB record
        $file->delete();

        return redirect()->route('admin.files.index')->with('toast', [
            'type' => 'success',
            'title' => 'Fichier supprimé',
            'description' => "Le fichier {$file->file_upload_name} a été supprimé.",
            'duration' => 5000,
        ]);
    }

    public function clearCache()
    {
        $cacheFiles = Storage::files('public/images/cache');
        $count = count($cacheFiles);
        $size = 0;

        foreach ($cacheFiles as $file) {
            $size += Storage::size($file);
        }

        Storage::delete($cacheFiles);

        $formattedSize = $this->formatBytes($size);

        return redirect()->route('admin.files.index')->with('toast', [
            'type' => 'success',
            'title' => 'Cache vidé',
            'description' => "{$count} fichiers supprimés ({$formattedSize} libérés).",
            'duration' => 5000,
        ]);
    }

    private function getDiskUsage(): array
    {
        $usage = [];

        // Public disk (images)
        $publicPath = storage_path('app/public');
        if (is_dir($publicPath)) {
            $usage['images'] = [
                'label' => 'Images (public)',
                'path' => $publicPath,
                'size' => $this->directorySize($publicPath),
            ];
        }

        // Images cache
        $cachePath = storage_path('app/public/images/cache');
        if (is_dir($cachePath)) {
            $usage['cache'] = [
                'label' => 'Cache thumbnails',
                'path' => $cachePath,
                'size' => $this->directorySize($cachePath),
                'count' => count(Storage::files('public/images/cache')),
            ];
        }

        // Plugins disk
        $pluginsPath = storage_path('app/plugins');
        if (is_dir($pluginsPath)) {
            $usage['plugins'] = [
                'label' => 'Plugins (JAR/ZIP)',
                'path' => $pluginsPath,
                'size' => $this->directorySize($pluginsPath),
            ];
        }

        // Heads
        $headsPath = storage_path('app/public/images/head');
        if (is_dir($headsPath)) {
            $usage['heads'] = [
                'label' => 'Têtes (WebP)',
                'path' => $headsPath,
                'size' => $this->directorySize($headsPath),
            ];
        }

        // Server disk info
        $totalDisk = disk_total_space(storage_path());
        $freeDisk = disk_free_space(storage_path());
        $usage['server'] = [
            'label' => 'Serveur',
            'total' => $totalDisk,
            'free' => $freeDisk,
            'used' => $totalDisk - $freeDisk,
            'percent' => $totalDisk > 0 ? round((($totalDisk - $freeDisk) / $totalDisk) * 100, 1) : 0,
        ];

        return $usage;
    }

    private function directorySize(string $path): int
    {
        $size = 0;
        $iterator = new \RecursiveIteratorIterator(
            new \RecursiveDirectoryIterator($path, \RecursiveDirectoryIterator::SKIP_DOTS)
        );
        foreach ($iterator as $file) {
            if ($file->isFile()) {
                $size += $file->getSize();
            }
        }
        return $size;
    }

    private function formatBytes(int $bytes, int $precision = 2): string
    {
        $units = ['o', 'Ko', 'Mo', 'Go', 'To'];
        $factor = floor((strlen((string) $bytes) - 1) / 3);
        $factor = min($factor, count($units) - 1);
        return round($bytes / pow(1024, $factor), $precision) . ' ' . $units[$factor];
    }
}
