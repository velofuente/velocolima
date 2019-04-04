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
        $schedule->day = "2019-03-14";
        $schedule->hour = "10:00:00";
        $schedule->instructor_id = "1";
        $schedule->class_id = "1";
        $schedule->room_id = "1";
        $schedule->reservation_limit = "5";
        $schedule->save();

        $schedule = new Schedule();
        $schedule->day = "2019-03-14";
        $schedule->hour = "08:00:00";
        $schedule->instructor_id = "2";
        $schedule->class_id = "1";
        $schedule->room_id = "1";
        $schedule->reservation_limit = "5";
        $schedule->save();

        $schedule = new Schedule();
        $schedule->day = "2019-03-15";
        $schedule->hour = "12:00:00";
        $schedule->instructor_id = "3";
        $schedule->class_id = "1";
        $schedule->room_id = "1";
        $schedule->reservation_limit = "5";
        $schedule->save();

        $schedule = new Schedule();
        $schedule->day = "2019-03-15";
        $schedule->hour = "18:00:00";
        $schedule->instructor_id = "4";
        $schedule->class_id = "1";
        $schedule->room_id = "1";
        $schedule->reservation_limit = "5";
        $schedule->save();

        $schedule = new Schedule();
        $schedule->day = "2019-03-16";
        $schedule->hour = "16:00:00";
        $schedule->instructor_id = "5";
        $schedule->class_id = "1";
        $schedule->room_id = "1";
        $schedule->reservation_limit = "5";
        $schedule->save();

        $schedule = new Schedule();
        $schedule->day = "2019-03-16";
        $schedule->hour = "17:00:00";
        $schedule->instructor_id = "6";
        $schedule->class_id = "1";
        $schedule->room_id = "1";
        $schedule->reservation_limit = "5";
        $schedule->save();

        $schedule = new Schedule();
        $schedule->day = "2019-03-16";
        $schedule->hour = "18:00:00";
        $schedule->instructor_id = "7";
        $schedule->class_id = "1";
        $schedule->room_id = "1";
        $schedule->reservation_limit = "5";
        $schedule->save();

        $schedule = new Schedule();
        $schedule->day = "2019-03-17";
        $schedule->hour = "12:00:00";
        $schedule->instructor_id = "3";
        $schedule->class_id = "1";
        $schedule->room_id = "1";
        $schedule->reservation_limit = "5";
        $schedule->save();

        $schedule = new Schedule();
        $schedule->day = "2019-03-17";
        $schedule->hour = "11:00:00";
        $schedule->instructor_id = "4";
        $schedule->class_id = "1";
        $schedule->room_id = "1";
        $schedule->reservation_limit = "5";
        $schedule->save();

        $schedule = new Schedule();
        $schedule->day = "2019-03-17";
        $schedule->hour = "16:00:00";
        $schedule->instructor_id = "5";
        $schedule->class_id = "1";
        $schedule->room_id = "1";
        $schedule->reservation_limit = "5";
        $schedule->save();

        $schedule = new Schedule();
        $schedule->day = "2019-03-15";
        $schedule->hour = "10:00:00";
        $schedule->instructor_id = "6";
        $schedule->class_id = "1";
        $schedule->room_id = "1";
        $schedule->reservation_limit = "5";
        $schedule->save();

        $schedule = new Schedule();
        $schedule->day = "2019-03-16";
        $schedule->hour = "09:00:00";
        $schedule->instructor_id = "7";
        $schedule->class_id = "1";
        $schedule->room_id = "1";
        $schedule->reservation_limit = "5";
        $schedule->save();

        $schedule = new Schedule();
        $schedule->day = "2019-03-07";
        $schedule->hour = "08:00:00";
        $schedule->instructor_id = "8";
        $schedule->class_id = "1";
        $schedule->room_id = "1";
        $schedule->reservation_limit = "5";
        $schedule->save();

        $schedule = new Schedule();
        $schedule->day = "2019-03-15";
        $schedule->hour = "13:00:00";
        $schedule->instructor_id = "9";
        $schedule->class_id = "1";
        $schedule->room_id = "1";
        $schedule->reservation_limit = "5";
        $schedule->save();

        $schedule = new Schedule();
        $schedule->day = "2019-03-14";
        $schedule->hour = "14:00:00";
        $schedule->instructor_id = "9";
        $schedule->class_id = "1";
        $schedule->room_id = "1";
        $schedule->reservation_limit = "5";
        $schedule->save();
    }
}