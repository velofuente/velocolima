<?php

use Illuminate\Database\Seeder;
use App\Schedule;

class ScheduleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $schedule = new Schedule();
        $schedule->day = "2019-03-05";
        $schedule->hour = "16:00:00";
        $schedule->instructor_id = "1";
        $schedule->id_classes = "1";
        $schedule->id_rooms = "1";
        $schedule->reservation_limit = "5";
        $schedule->save();

        $schedule = new Schedule();
        $schedule->day = "2019-03-05";
        $schedule->hour = "20:00:00";
        $schedule->instructor_id = "1";
        $schedule->id_classes = "1";
        $schedule->id_rooms = "1";
        $schedule->reservation_limit = "5";
        $schedule->save();

        $schedule = new Schedule();
        $schedule->day = "2019-03-07";
        $schedule->hour = "08:00:00";
        $schedule->instructor_id = "1";
        $schedule->id_classes = "1";
        $schedule->id_rooms = "1";
        $schedule->reservation_limit = "5";
        $schedule->save();
    }
}