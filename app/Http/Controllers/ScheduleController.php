<?php

namespace App\Http\Controllers;

use DB;
use App\Branch;
use App\Product;
use App\Schedule;
use App\Instructor;
use App\Models\Brand;
use App\Models\Place;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    /**
     * Función para obtener la lista de estudios (brand) disponibles
     * por plaza
     *
     * @param Illuminate\Http\Request request()
     * @return \Illuminate\Http\Response
     */
    public function getBrandList()
    {
        $placeId = request('place_id');

        if ($placeId == 'allPlaces') {
            return response()->json([
                "message" => "Invalid request"
            ], 400);
        }

        $place = Place::find($placeId);
        $franchises = $place->franchises()
            ->with('brands')
            ->where('franchises.active', true)
            ->get();

        $franchises->filter(function ($franchise) {
            return $franchise->pivot->active;
        })->values();

        $brands = $franchises->pluck('brands')
            ->values();

        $brand = collect($brands->first());

        $brands->each(function ($tempBrand, $key) use (&$brand) {
            if ($key !== 0) {
                $brand = $brand->merge($tempBrand);
            }
        });

        return response()->json([
            "message" => "Success",
            "data" => [
                "brands" => $brand
            ]
        ]);
    }

    /**
     * Función para obtener el listado de sucursales disponoibles
     *
     * @param Request request()
     * @return Reponse
     */
    public function getBranchList()
    {
        $brandId = request()->brand_id;

        if ($brandId === 'allBranches') {
            return response()->json([
                "message" => "Invalid request."
            ], 400);
        }

        $brand = Brand::find($brandId);
        $branches = $brand->branches()
            ->where('active', true)
            ->get();

        $branches->filter(function ($branch) {
            return $branch->pivot->active;
        });

        return response()->json([
            "message" => "Success",
            "data" => [
                "branches" => $branches
            ]
        ]);
    }

    /**
     * Función para obtener las clases disponibles por sucursales
     *
     * @param Integer $branchId
     * 
     * @return Illuminate\Http\Reponse;
     */
    public function getScheduleList(Branch $branch)
    {
        $now = now();
        $date = now();
        $user = request()->user();
        $numCards = $user ? $user->cards->count() : 0;
        $products = Product::where('products.status', 1)
            ->where('products.id', '<>', 1)
            ->whereNotIn('products.type', ['Survenir', 'Free'])
            ->get();

        $schedules = $branch->schedules()
            ->join('instructors', 'schedules.instructor_id', '=', 'instructors.id')
            ->join('branches', 'schedules.branch_id', '=', 'branches.id')
            ->select('schedules.id', 'schedules.day', 'schedules.hour', 'schedules.reservation_limit',
            'schedules.instructor_id', 'schedules.class_id', 'schedules.room_id', 'schedules.branch_id', 'schedules.deleted_at',
            'schedules.created_at', 'schedules.updated_at', 'schedules.description', 'instructors.id AS insId',
            'instructors.name AS instructor_name', 'branches.id AS braId', 'branches.name AS branch_name', DB::raw("CURDATE() as date"))
            ->whereNull('instructors.deleted_at')
            ->whereRaw("schedules.day >= '{$now->format('Y-m-d')}'")
            ->whereRaw("schedules.day <= '{$now->addDays(7)->format('Y-m-d')}'")
            ->orderBy('schedules.hour')
            ->get();

        $now->subDays(7);
        $calendar = collect();
        do {
            $day = strftime('%d', strtotime($date));
            $weekDay = strftime("%a", strtotime($date));
            $calendar->push((object)[
                'title' => "{$weekDay}. {$day}",
                'formatted' => $date->format('Y-m-d')
            ]);
            $date->addDays(1);
        } while ($date->diffInDays($now) < 7);

        $schedules->map(function ($schedule) use ($now) {
            $schedule->disable = false;
            $schedule->show_description = !$schedule->description ? false : true;
            if ($schedule->day == $now->format('Y-m-d')
                && $schedule->hour < $now->format('H:i:s')
            ) {
                $schedule->disable = true;
            }

            $schedule->hour = date("g:i A", strtotime($schedule->hour));
            return $schedule;
        });

        $products->map(function ($product) {
            $product->promotional = 0;
            if ($product->type == 'Deals') {
                $product->promotional = 1;
            }
            return $product;
        });

        return response()->json([
            "data" => [
                "guest" => $user ? false : true,
                "num_cards" => $numCards,
                "calendar" => $calendar,
                "current_date" => $now->format('Y-m-d'),
                "schedules" => $schedules,
                "products" => $products->sortByDesc('promotional')->values(),
                "brand" => $branch->brands->first(),
            ]
        ]);
    }
}
