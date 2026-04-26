<?php

use App\Support\AdminMenuRegistry;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        foreach (AdminMenuRegistry::leafMenuSlugs() as $menuSlug) {
            Schema::create(AdminMenuRegistry::tableNameForMenuSlug($menuSlug), function (Blueprint $table) {
                $table->id();
                $table->json('payload');
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        foreach (array_reverse(AdminMenuRegistry::leafMenuSlugs()) as $menuSlug) {
            Schema::dropIfExists(AdminMenuRegistry::tableNameForMenuSlug($menuSlug));
        }
    }
};
