<?php

use App\Models\Builder\Addon;
use App\Models\Builder\Folder;
use App\Models\File;
use App\Models\Resource\Resource;
use App\Models\Resource\Version;
use App\Models\User;
use App\Models\UserLog;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('inventory_addons', function (Blueprint $table) {
            $table->id();
            $table->foreignId('resource_id')->constrained('resource_resources')->onDelete('cascade');
            $table->string('name');
            $table->longText('description');
            $table->boolean('is_official')->default(false);
            $table->timestamps();
        });

        // You must create a resource manually before continuing the migration.

        $user = User::create(['name' => 'Maxlego08', 'email' => 'simon.maxence@hotmail.com', 'password' => Hash::make('123456'), 'user_role_id' => 6,]);

        UserLog::make($user, 'Création du compte', UserLog::COLOR_REGISTER, UserLog::ICON_ADD, UserLog::TYPE_CONNEXION);

        Folder::create(['user_id' => $user->id, 'name' => 'home']);

        $file = File::create(['user_id' => $user->id, 'file_extension' => 'fake', 'file_size' => 0, 'file_name' => 'fake', 'is_deletable' => false]);
        $fileVersion = File::create(['user_id' => $user->id, 'file_extension' => 'fake', 'file_size' => 0, 'file_name' => 'fake', 'is_deletable' => false]);

        $resource = Resource::create(['category_id' => 1, 'user_id' => $user->id, 'image_id' => $file->id, 'name' => 'zMenu', 'price' => 0, 'description' => 'hey', 'tag' => 'Best plugin ever', 'is_display' => true, 'is_pending' => true]);

        $version = Version::create(['version' => '1.0.0', 'resource_id' => $resource->id, 'title' => 'First version of the plugin', 'description' => 'No description.', 'download' => 0, 'file_id' => $fileVersion->id, 'file_name' => 'fake',]);
        $resource->update(['version_id' => $version->id]);

        Addon::create(['resource_id' => $resource->id, 'name' => 'zMenu', 'description' => 'zMenu plugin', 'is_official' => true,]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventory_addons');
    }
};
