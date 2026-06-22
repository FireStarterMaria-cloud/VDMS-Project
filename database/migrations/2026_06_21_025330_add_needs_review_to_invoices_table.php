<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNeedsReviewToInvoicesTable extends Migration
{
    public function up()
    {
        Schema::table('invoices', function (Blueprint $table) {
            $table->boolean('needs_review')->default(false)->after('status');
            $table->foreignId('reviewed_by')->nullable()->after('needs_review')->constrained('users')->nullOnDelete();
            $table->timestamp('reviewed_at')->nullable()->after('reviewed_by');
        });
    }

    public function down()
    {
        Schema::table('invoices', function (Blueprint $table) {
            $table->dropForeign(['reviewed_by']);
            $table->dropColumn(['needs_review', 'reviewed_by', 'reviewed_at']);
        });
    }
}