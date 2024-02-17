<?php

namespace App\Models\Builder;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id
 * @property int $user_id
 * @property string $name
 * @property Folder $parent
 * @property Folder[] $children
 * @property Inventory[] $inventories
 */
class Folder extends Model
{
    // Les attributs de base du modèle
    protected $fillable = ['name', 'user_id', 'parent_id'];

    /**
     * Relation parente (un dossier peut avoir un seul dossier parent).
     */
    public function parent(): BelongsTo
    {
        return $this->belongsTo(Folder::class, 'parent_id');
    }

    /**
     * Relation enfants (un dossier peut avoir plusieurs sous-dossiers).
     */
    public function children(): HasMany
    {
        return $this->hasMany(Folder::class, 'parent_id');
    }


    public function inventories(): HasMany
    {
        return $this->hasMany(Inventory::class);
    }

    /**
     * Relation avec l'utilisateur (chaque dossier appartient à un utilisateur).
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Obtient la hiérarchie des dossiers, excluant le dossier principal.
     *
     * @return array
     */
    public function getBreadcrumbHierarchy(): array
    {
        $hierarchy = [];
        $currentFolder = $this;

        array_unshift($hierarchy, [
            'id' => $this->id,
            'name' => $this->name,
        ]);

        while ($currentFolder->parent) {

            if ($currentFolder->parent->parent == null) return $hierarchy;

            array_unshift($hierarchy, [
                'id' => $currentFolder->parent->id,
                'name' => $currentFolder->parent->name,
            ]);
            $currentFolder = $currentFolder->parent;
        }

        return $hierarchy;
    }

    public function generate(): string
    {
        $currentFolder = $this;
        $breadcrumbs = [];
        while ($currentFolder) {
            array_unshift($breadcrumbs, $currentFolder);
            $currentFolder = $currentFolder->parent;
        }

        // Ajouter 'Home' au début
        $breadcrumbsHtml = '<nav aria-label="breadcrumb"><ol class="breadcrumb">';

        foreach ($breadcrumbs as $folder) {
            if ($folder === end($breadcrumbs)) {
                // Dossier actuel
                $breadcrumbsHtml .= '<li class="breadcrumb-item active" aria-current="page">' . e($folder->name) . '</li>';
            } else {
                // Dossier parent
                $breadcrumbsHtml .= '<li class="breadcrumb-item"><a href="' . route('admin.inventories.folders.user', $folder) . '">' . e($folder->name) . '</a></li>';
            }
        }

        $breadcrumbsHtml .= '</ol></nav>';

        return $breadcrumbsHtml;
    }

}
