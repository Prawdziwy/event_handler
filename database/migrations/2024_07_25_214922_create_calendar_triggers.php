<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        DB::unprepared('
            CREATE TRIGGER add_owner_as_member AFTER INSERT ON calendars
            FOR EACH ROW
            BEGIN
                INSERT INTO calendar_members (calendar_id, user_id, created_at, updated_at) 
                VALUES (NEW.id, NEW.owner_id, NOW(), NOW());
            END
        ');
    }

    public function down()
    {
        DB::unprepared('DROP TRIGGER IF EXISTS add_owner_as_member');
    }
};
