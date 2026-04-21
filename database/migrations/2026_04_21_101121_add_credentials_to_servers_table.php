<?php

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
        Schema::table('servers', function (Blueprint $table) {
            // SSH Access Fields
            $table->string('ssh_username')->nullable()->after('api_token');
            $table->text('ssh_password')->nullable()->after('ssh_username'); // encrypted
            $table->integer('ssh_port')->default(22)->after('ssh_password');
            $table->text('ssh_private_key')->nullable()->after('ssh_port'); // encrypted
            
            // Panel Access Fields
            $table->enum('panel_type', ['aaPanel', 'cPanel', 'DirectAdmin', 'Plesk', 'Custom', 'None'])->default('None')->after('ssh_private_key');
            $table->string('panel_url')->nullable()->after('panel_type');
            $table->string('panel_username')->nullable()->after('panel_url');
            $table->text('panel_password')->nullable()->after('panel_username'); // encrypted
            $table->integer('panel_port')->nullable()->after('panel_password');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('servers', function (Blueprint $table) {
            $table->dropColumn([
                'ssh_username',
                'ssh_password',
                'ssh_port',
                'ssh_private_key',
                'panel_type',
                'panel_url',
                'panel_username',
                'panel_password',
                'panel_port',
            ]);
        });
    }
};
