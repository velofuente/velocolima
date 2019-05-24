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
        $schedule->day = "2019-05-28";
        $schedule->hour = "10:00:00";
        $schedule->instructor_id = "1";
        $schedule->class_id = "1";
        $schedule->room_id = "1";
        $schedule->reservation_limit = "15";
        $schedule->save();
    }
}