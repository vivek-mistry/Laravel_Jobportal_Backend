<?php

use App\Models\Category;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });

        $data = [
            'name' => 'Software Engineer IT'
        ];
        Category::create($data);

        $data = [
            'name' => 'Doctor'
        ];
        Category::create($data);

        $data = [
            'name' => 'Civil Engineer'
        ];
        Category::create($data);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};
