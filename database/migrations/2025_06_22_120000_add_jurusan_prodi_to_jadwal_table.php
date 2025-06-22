<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('jadwal', function (Blueprint $table) {
            $table->string('jurusan')->nullable()->after('tahun_akademik');
            $table->string('prodi')->nullable()->after('jurusan');
        });
    }

    public function down(): void
    {
        Schema::table('jadwal', function (Blueprint $table) {
            $table->dropColumn(['jurusan', 'prodi']);
        });
    }
};
