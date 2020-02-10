<?php

namespace App\Http\Controllers;

use App\{UserSchedule, UserWaitList, User, Purchase, Tool, Schedule, Branch};
use Illuminate\Support\Facades\{Log, Hash};
use Illuminate\Http\Request;
use Carbon\Carbon;
use DB;

class BookClassController extends Controller
{

    private $invalidity_reason = "";

    /**
     * Validar mensaje para cancelación de una reservación
     *
     * @param Request $request
     * @return void
     */
    public function validatePackageReservation(Request $request)
    {
        $now = Carbon::now();
        $user = $request->user();
        // $user = User::find(784); // wolfernand@gmail.com
        return $this->runValidatePackageReservation($request->schedule_id, $user, $now, $request->require_response);
    }

    /**
     * Ejecutar validaciones para la reservación
     *
     * @param Integer $schedule_id
     * @param User $requestUser
     * @param Carbon $now
     * @param Boolean $require_response
     * @return \Illuminate\Http\Response
     */
    function runValidatePackageReservation($schedule_id, $requestUser, $now, $require_response)
    {
        //Obtener el horario en le que se quiere reservar
        $schedule = Schedule::where('id', $schedule_id)->first();
        if (!$schedule) {
            return $this->returnResponse("ERROR", "No se puede reservar, (horario no válido).", $require_response);
        }
        //Validar cuantos minutos han pasado de la clase
        $remainingMinutes = $this->validateTimeReservation($now, $schedule);
        if (is_string($remainingMinutes)) {
            return $this->returnResponse("ERROR", $remainingMinutes, $require_response);
        }
        //Obtener la clase próxima a vencer (Sin importar si tiene o no restricción)
        $availablePurchase = $this->getAvailablePurchases($requestUser->id, $schedule, true);
        //TODO: validar el motivo por el cual no deja reservar
        if ($availablePurchase === false || empty($availablePurchase)) {
            $tempMessage = "No tienes clases compradas. Compra clases para poder hacer tu reservación.";
            if ($this->invalidity_reason != "") {
                $tempMessage = $this->invalidity_reason;
            }
            return $this->returnResponse("ERROR", $tempMessage, $require_response, ["invalidation_message" => "true"]);
        }
        //Obtener el producto de la compra
        $product = $availablePurchase->product;
        if (!$product) {
            return $this->returnResponse("ERROR", "No se puede reservar, (producto no válido).", $require_response);
        }

        // Obtener reservaciones del día
        $reservations = UserSchedule::whereHas('schedule', function($query) use ($schedule) {
            $query->where('day', $schedule->day);
        })->where('user_id', $$requestUser->id)->first();

        $reservationsCount = $reservations->filter(function($reservation) use ($product) {
            if (isset($reservation->purchase->productWithTrashed)) {
                return $reservation->purchase->productWithTrashed->id == $product->id;
            }
            return false;
        })->count();

        if ($reservationsCount > 0 && $product->count_limit && $reservationsCount > $product->count_limit && config('constants.reservationDayCountLimit')) {
            return $this->returnResponse("ERROR", config('constants.reservationDayMessage'));
        }

        //Validar si el producto de la compra a validar es reembolsable
        if (!$product->is_refundable) {
            return $this->returnResponse("OK", "Esta reservación no es reembolsable. Al cancelar esta reservación no se te reembolsará.", $require_response, ["purchaseId" => $availablePurchase->id]);
        }
        return $this->returnResponse("OK", $this->getPurchaseToValidateMessage($product, $remainingMinutes), $require_response, ["purchaseId" => $availablePurchase->id]);
    }

    /**
     * Obtener mensaje a retornar de una compra
     *
     * @param Product $product
     * @param Integer $remainingMinutes
     * @return void
     */
    function getPurchaseToValidateMessage($product, $remainingMinutes)
    {
        //Simular que faltan o que ya pasaron x minutos de una clase
        // $remainingMinutes = 121;
        //Obtener tiempo de cancelación de la clase
        $cancelationMinutes = ($product->cancelation_range) ? $product->cancelation_range : config("constants.defaultCancelationMinutes");
        //Calcular si se puede obtener horas cerradas o minutos
        $timeType = "minutos";
        $cancelationMinutesTime = $cancelationMinutes;
        if (($cancelationMinutes % 60) === 0) {
            $cancelationMinutesTime = $cancelationMinutes / 60;
            $timeType = "horas";
        }
        $timeRemainingType = "minutos";
        $remainingMinutesTime = $remainingMinutes;
        if (($remainingMinutes % 60) === 0) {
            $remainingMinutesTime = $remainingMinutes / 60;
            $timeRemainingType = "horas";
        }
        $beforeOrAfter = "se está reservando {$remainingMinutesTime} {$timeRemainingType} antes del inicio de la clase (Solo es reembolsable al reservar antes de {$cancelationMinutesTime} {$timeType}).";
        //Validar si está en tiempo de cancelación
        if ($remainingMinutes < $cancelationMinutes) {
            if ($remainingMinutes <= 0) {
                $beforeOrAfter = "ya inició la clase";
            }
            $message = "Esta reservación no será reembolsable debido a que {$beforeOrAfter}";
        } else {
            $message = "Esta reservación sólo puede modificarse o cancelarse antes de {$cancelationMinutesTime} {$timeType} del inicio de la clase.";
        }
        return $message;
    }

    /**
     * Obtener las compras o la compra disponibles de un usuario
     * Si se retorna closest aplicará validaciones de horario y vigencia y
     * retornará un solo paquete
     *
     * @param Integer $user_id
     * @param Schedule $schedule
     * @param boolean $closest
     * @return boolean|Collection|array
     */
    function getAvailablePurchases($user_id, $schedule, $closest = false)
    {
        //Obtener la compra de la clase reservada
        $userSchedule = UserSchedule::with([
            "purchase",
            "purchase.product" => function($query){
                return $query->withTrashed();
            }
            ])->where("schedule_id", $schedule->id)->where("user_id", $user_id)->first();
        if (!empty($userSchedule)) {
            if ($userSchedule->status == "active") {
                $purchase = $userSchedule->purchase;
                if ($closest) {
                    return $purchase;
                }
                //TODO:Validar si es reservable o no
                return [
                    "scheduledPurchases" => collect([$purchase]),
                    "noScheduledPurchases" => collect([])
                ];
            }
        }

        $invalidationMessage = "";
        //Obtener las compras con clases disponibles y restringidas por horario
        $scheduledPurchases = Purchase::with([
            "product" => function($query){
                return $query->withTrashed();
            },
            "product.schedules"
            ])
            ->selectRaw("*, DATE_ADD(created_at, INTERVAL expiration_days DAY) expirationDate")
            // ->where('product_id', 22)
            ->where('user_id', $user_id)
            ->where('n_classes', "<>", 0)
            ->whereRaw("NOW() < DATE_ADD(created_at, INTERVAL expiration_days DAY)")
            ->orderByRaw('DATE_ADD(created_at, INTERVAL expiration_days DAY)')
            ->whereHas('product.schedules')
            ->get();
        //Obtener compras con clases disponibles sin restricciones de horario
        $noScheduledPurchases = Purchase::with([
            "product" => function($query){
                return $query->withTrashed();
            },
            "product.schedules"
            ])
            ->selectRaw("*, DATE_ADD(created_at, INTERVAL expiration_days DAY) expirationDate")
            // ->where('product_id', 22)
            ->where('user_id', $user_id)
            ->where('n_classes', "<>", 0)
            ->whereRaw("NOW() < DATE_ADD(created_at, INTERVAL expiration_days DAY)")
            ->orderByRaw('DATE_ADD(created_at, INTERVAL expiration_days DAY)')
            ->doesntHave('product.schedules')
            ->get();
        //Obtener la hora de la reservación
        $reservationHour = $schedule->getHourInstance()->format("H");
        //Obtener el número de día de la reservación
        $reservationDate = Carbon::parse($schedule->day);
        $reservationDay = $reservationDate->dayOfWeek;
        //Filtrar las compras restringidas basadas en horario y día de reservación y vigencia de compra
        $allScheduledPurchasesCount = Purchase::where('user_id', $user_id)->count();
        $scheduledPurchasesAmount = count($scheduledPurchases);
        $scheduledPurchases = $scheduledPurchases->filter(function($scheduledPurchase) use ($reservationHour, $reservationDay){
            return $this->filterReservableSchedulePurchases($scheduledPurchase, $reservationHour, $reservationDay);
        });
        $scheduledPurchasesAmountAfterScheduleValidation = count($scheduledPurchases);
        if ($scheduledPurchasesAmountAfterScheduleValidation == 0 && $scheduledPurchasesAmount > 0 && $allScheduledPurchasesCount > 0) {
            $invalidationMessage = "No tienes clases compradas disponibles para reservar en este horario.";
        }
        $scheduledPurchases = $scheduledPurchases->filter(function ($scheduledPurchase) use ($reservationDate){
            return $this->filterValidSchedulePurchases($scheduledPurchase, $reservationDate);
        });
        if (count($scheduledPurchases) == 0 && ($scheduledPurchasesAmountAfterScheduleValidation > 0 || $allScheduledPurchasesCount > 0) && $invalidationMessage == "") {
            $invalidationMessage = "No tienes clases compradas vigentes para reservar en esta fecha.";
        }
        $noScheduledPurchasesAmount = count($noScheduledPurchases);
        //Filtrar las compras sin restricciones que estén vigentes para ese día
        $noScheduledPurchases = $noScheduledPurchases->filter(function ($noScheduledPurchase) use ($reservationDate){
            return $this->filterValidSchedulePurchases($noScheduledPurchase, $reservationDate);
        });
        if (count($noScheduledPurchases) == 0 && $noScheduledPurchasesAmount > 0 && $invalidationMessage == "") {
            $invalidationMessage = "No tienes clases compradas vigentes para reservar en esta fecha.";
        }
        $this->invalidity_reason = $invalidationMessage;
        //Validar si tiene alguna compra con clases disponibles.
        if ((count($scheduledPurchases) + count($noScheduledPurchases)) < 1) {
            return false;
        }
        //Validar si se debe de retornar solo la próxima a vencer
        if ($closest) {
            $collection = collect();
            if (count($noScheduledPurchases) > 0) {
                $collection->push($noScheduledPurchases->first());
            }
            if (count($scheduledPurchases) > 0) {
                $collection->push($scheduledPurchases->first());
            }
            return $collection->sortBy("expirationDate")->first();
        }
        //Retornar clases con y sin restricción
        return [
            "scheduledPurchases" => $scheduledPurchases,
            "noScheduledPurchases" => $noScheduledPurchases
        ];
    }

    /**
     * Validar el tiempo restante para una reservación
     * Se toma en cuenta un periode de hasta 15 minutos una vez que ya empezó la clase
     *
     * @param Carbon $now
     * @param Schedule $schedule
     * @param boolean $returnTime
     * @return String|Integer
     */
    function validateTimeReservation($now, $schedule, $returnTime = false)
    {
        //Obtener inicio de clase
        $scheduleBeginTime = Carbon::parse($schedule->day)->setTimeFrom($schedule->getHourInstance());
        //Obtener los minutos faltantes para la clase
        $remainingMinutes = $now->diffInMinutes($scheduleBeginTime, false);
        //Validar cuantos minutos han pasado de la clase
        if ($remainingMinutes < config("constants.minutesAfterClassStart") && $returnTime == false) {
            return "No se puede reservar, (La clase ya empezó).";
        }
        return $remainingMinutes;
    }

    /**
     * Retornar respuesta
     *
     * @param String $status
     * @param String $message
     * @param boolean $response
     * @param null|object|array $data
     * @return \Illuminate\Http\Response|array
     */
    public function returnResponse($status, $message, $response = false, $data = null)
    {
        //Armar array de respuesta
        $responseArray = [
            "status" => $status,
            "message" => $message
        ];
        //Validar si es necesario adjuntar datos adicionales
        if ($data) {
            $responseArray["data"] = $data;
        }
        //Validar si es necesario retornar en formato de respuesta
        if ($response) {
            return response()->json($responseArray);
        }
        return $responseArray;
    }

    /**
     * Validar si una clase está vigente para una fecha
     *
     * @param Schedule $scheduledPurchase
     * @param Integer $hour
     * @param Integer $reservationDate
     * @return void
     */
    public function filterValidSchedulePurchases($scheduledPurchase, $reservationDate)
    {
        $endAvailable = Carbon::parse($scheduledPurchase->expirationDate)->format('Y-m-d');
        // Log::info("{$scheduledPurchase->id} - {$scheduledPurchase->expirationDate}");
        // Log::info($reservationDate->format('Y-m-d') <= $endAvailable);
        return $reservationDate->format('Y-m-d') <= $endAvailable;
    }

    /**
     * Validar si una clase es reservable en un día y una hora
     *
     * @param Schedule $scheduledPurchase
     * @param Integer $hour
     * @param Integer $reservationDay
     * @return void
     */
    public function filterReservableSchedulePurchases($scheduledPurchase, $hour, $reservationDay)
    {
        //Validar si el producto cuenta con horario
        $productSchedules = $scheduledPurchase->product->schedules;
        if (!$productSchedules) {
            return false;
        }
        foreach ($productSchedules as $productSchedule) {
            //Obtener días de reservación
            $availableDays = explode(",", $productSchedule->available_days);
            //Validar si se puede reservar en ese día
            if (!in_array($reservationDay, $availableDays)) {
                return false;
            }
            //Validar estructura de horario
            if (count($availableDays) < 1) {
                Log::info("MALFORMED SCHEDULE | DAYS | product: {$productSchedule->id}");
                return false;
            }
            //Obtener horas de reservación
            $availableSchedules = explode(";", $productSchedule->schedules);
            foreach ($availableSchedules as $availableSchedule) {
                $scheduleTime = explode("-", $availableSchedule);
                if (count($scheduleTime) < 2) {
                    Log::info("MALFORMED SCHEDULE | HOURS | product: {$productSchedule->id} - productSchedule: {$availableSchedule->id}");
                    return false;
                }
                $beginTime = $scheduleTime[0];
                $endTime = $scheduleTime[1];
                //Validar si cumple con el tiempo de reservación
                if ($hour >= $beginTime && $hour <= $endTime) {
                    return true;
                }
            }
        }
        return false;
    }

    /**
     * Reservar una clase
     *
     * @param Request $request
     * @return json
     */
    public function book(Request $request)
    {
        //Obtener el usuario que hizo el request
        $requestUser = $request->user();
        $now = Carbon::now();
        //Obtener el horario en le que se quiere reservar
        $schedule = Schedule::where('id', $request->schedule_id)->first();
        if (!$schedule) {
            return $this->returnResponse("ERROR", "No se puede reservar, (horario no válido).", true);
        }
        //Validar cuantos minutos han pasado de la clase
        $remainingMinutes = $this->validateTimeReservation($now, $schedule);
        if (is_string($remainingMinutes)) {
            return $this->returnResponse("ERROR", $remainingMinutes, true);
        }
        //Obtener la clase próxima a vencer (Sin importar si tiene o no restricción)
        $purchase = $this->getAvailablePurchases($requestUser->id, $schedule, true);
        if ($purchase === false) {
            $tempMessage = "No tienes clases compradas. Compra clases para poder hacer tu reservación.";
            if ($this->invalidity_reason != "") {
                $tempMessage = $this->invalidity_reason;
            }
            return $this->returnResponse("ERROR", $tempMessage, true);
        }
        //Validar si la compra obtenida es la misma que se obtuvo al momento de realizar la validación
        if ($purchase->id != $request->originalPurchaseId) {
            return $this->returnResponse("ERROR", "No se puede reservar, (Se ha actualizado la compra seleccionada). {$purchase->id} -  {$request->originalPurchaseId}", true);
        }

        //obtiene el numero de reservaciones que se han hecho a esa clase
        $instances = UserSchedule::where('schedule_id', $request->schedule_id)->where('status', "active")->count();
        //Obtiene y revisa si el usuario ya tiene esta clase reservada
        $bookedClass = UserSchedule::where('schedule_id', $request->schedule_id)->where('user_id', $requestUser->id)->first();
        //Validaa si el lugar está disponible
        $alreadyReserved = UserSchedule::where("bike", $request->bike)->where("schedule_id", $request->schedule_id)->first();
        //Instructores de esa clase
        $instructorBikes = Tool::where("branch_id", $request->branch_id)->where("type", "instructor")->get();
        //bicicletas no disponibles de esa clase
        $disabledBikes = Tool::where("branch_id", $request->branch_id)->where("type", "disabled")->get();
        //Obtiene el numero total de clases del cliente
        $numClases = DB::table('purchases')->select(DB::raw('SUM(n_classes) as clases'))->where('user_id', '=', "{$requestUser->id}")->first();
        $classes = $numClases->clases;
        DB::beginTransaction();
        if (!$bookedClass){
            //Valida si hay lugar disponible
            if ($instances <= $schedule->reservation_limit){
                if (in_array($request->bike, (array)$disabledBikes)){
                    DB::commit();
                    return response()->json([
                        'status' => 'ERROR',
                        'message' => "Este lugar no se encuentra disponible.",
                        'updateClass' => 1
                    ]);
                }
                if (in_array($request->bike, (array)$instructorBikes)){
                    DB::commit();
                    return response()->json([
                        'status' => 'ERROR',
                        'message' => "Este lugar no se encuentra disponible.",
                        'updateClass' => 1
                    ]);
                }
                if ($alreadyReserved && $alreadyReserved->status!='cancelled'){
                    DB::commit();
                    return response()->json([
                        'status' => 'ERROR',
                        'message' => "Ese lugar ya ha sido reservado.",
                        'updateClass' => 1
                    ]);
                }
                //obtiene el id de la bici,id del horario, id de la compra
                UserSchedule::create([
                    'user_id' => $requestUser->id,
                    'schedule_id' => $request->schedule_id,
                    'purchase_id' => $purchase->id,
                    //'tool_schedule_id' => $request->tool_schedule_id,
                    'bike' => $request->bike,
                    'status' => 'active',
                    'changedSit' => 0,
                ]);
                //Resta una clase a la compra del usuario y actualiza ese campo en la base de datos
                $purchase->n_classes -= 1;
                $purchase->save();
                //obtiene el numero total de clases
                $numClases = Purchase::select(DB::raw('SUM(n_classes) as clases'))->whereRaw("NOW() <= DATE_ADD(created_at, INTERVAL expiration_days DAY)")->where('user_id', '=', "{$requestUser->id}")->groupBy("id")->get();
                $classes = $numClases->sum("clases");
                // log::info("B234");
                /* if($classes == 1){
                    // log::info("B234");
                    $lastClassPurchase = Purchase::where('user_id', $requestUser->id)
                    ->where('n_classes', "<>", 0)
                    //->whereRaw("created_at < DATE_ADD(created_at, INTERVAL expiration_days DAY)")
                    //->whereRaw("NOW() < DATE_ADD(created_at, INTERVAL expiration_days DAY)")
                    //->orderByRaw('DATE_ADD(created_at, INTERVAL expiration_days DAY)')->first();
                    ->whereRaw("NOW() < DATE_ADD(created_at, INTERVAL expiration_days DAY)")
                    ->orderByRaw('DATE_ADD(created_at, INTERVAL expiration_days DAY)')->first();
                    //verificar si el producto es diferente a clase
                    if ($lastClassPurchase) {
                        if($lastClassPurchase->product->id != 1){
                            // log::info("ENVIANDO UN MENSAJE");
                            //$promocion = Product::where('description', 'Clase adicional')->first();
                            // Purchase::create([
                            //     'product_id' => $promocion->id,
                            //     'user_id' => $requestUser->id,
                            //     'n_classes' => $promocion->n_classes,
                            //     'expiration_days' => $promocion->expiration_days,
                            //     'status' => 'pending',
                            // ]);
                            app('App\Http\Controllers\MailSendingController')->additionalFreeClass($requestUser->email,$requestUser->name);
                        }
                    }
                } */
                DB::commit();
                return response()->json([
                    'status' => 'OK',
                    'message' => "Lugar reservado con éxito.",
                ]);
            } else {
                return response()->json([
                    'status' => 'ERROR',
                    'message' => "No hay cupo disponible.",
                ]);
            }
        } else {
            if ($bookedClass->changedSit == 0) {
                if ($alreadyReserved && $alreadyReserved->status!='cancelled') {
                    DB::commit();
                    return response()->json([
                        'status' => 'ERROR',
                        'message' => "Ese lugar ya ha sido reservado.",
                    ]);
                }
                $changedSiteMessage = "Lugar cambiado con éxito.";
                if ($bookedClass->status == 'cancelled') {
                    $bookedClass->status = 'active';
                    $bookedClass->bike = $request->bike;
                    $bookedClass->changedSit = 0;
                    $bookedClass->purchase_id = $purchase->id;
                    $bookedClass->save();
                    //Resta una clase a la compra del usuario y actualiza ese campo en la base de datos
                    $purchase->n_classes -= 1;
                    $purchase->save();
                    $changedSiteMessage = "Lugar reservado con éxito.";
                } else {
                    $bookedClass->bike = $request->bike;
                    $bookedClass->purchase_id = $purchase->id;
                    $bookedClass->changedSit = 1;
                    $bookedClass->save();
                }
                DB::commit();
                return response()->json([
                    'status' => 'OK',
                    'message' => $changedSiteMessage,
                ]);
            } else {
                return response()->json([
                    'status' => 'ERROR',
                    'message' => "Solo puedes cambiar de lugar una vez.",
                ]);
            }
        }
    }

    public function absentUserClass(Request $request){
        // TODO: Revisar la condición if($requestedClass=='active' || $requestedClass!='active') en esta función, cancelClass y attendClass
        $requestedClass = UserSchedule::find($request->schedule_id);
        if ($requestedClass == 'active' || $requestedClass != 'active') {
            $requestedClass->status = 'absent';
            $requestedClass->changedSit = 0;
            $requestedClass->save();
            return response()->json([
                'status' => 'OK',
                'message' => 'El usuario no asistió a la clase.',
            ]);
        } else {
            // log::info($requestedClass);
            return response()->json([
                'status' => 'ERROR',
                'message' => 'Ocurrió un error al procesar la solicitud. Intenta refrescando la página.',
            ]);
        }
        // log::info($requestedClass);
    }

    public function cancelClass(Request $request)
    {
        $requestedClass = UserSchedule::find($request->id);
        // Obtiene el periodo de cancelacion de la ubicación
        $schedule = Schedule::find($requestedClass->schedule_id);
        // Verificar el horario que agrego el admin para las clases  cancelables
        $purchase = Purchase::with(["product" => function($query){$query->withTrashed();}])->find($requestedClass->purchase_id);
        $product = $purchase->product;

        if($requestedClass->status == 'cancelled'){
            return response()->json([
                'status' => 'OK',
                'message' => 'Clase cancelada con éxito.',
            ]);
        }

        // Actualizar el estado a cancelado
        $requestedClass->status = 'cancelled';
        $requestedClass->changedSit = 0;
        $requestedClass->save();
        $scheduleDate = Carbon::parse("{$schedule->day} {$schedule->hour}");
        $remainingTimeToClass = now()->diffInMinutes($scheduleDate);
        $cancelationRange = ($product->cancelation_range && $product->cancelation_range != 0)
            ? $product->cancelation_range
            : $schedule->branch->cancelation_period * 60;

        if ($product->is_refundable && $remainingTimeToClass >= $cancelationRange) {
            // Reembolsar compra
            $purchase->n_classes ++;
            $purchase->save();
            $message = "Clase cancelada con éxito, se te reembolsará esta clase.";
        } else {
            $message = "Clase cancelada con éxito.";
        }

        return response()->json([
            'status' => 'OK',
            'message' => $message,
        ]);
    }

    public function waitList(Request $request)
    {
        //obtiene el usuario que hizo el request
        $requestUser = $request->user();
        $waitList = DB::table('wait_lists')->select('id')->where('schedule_id', "{$request->schedule_id}")->first();
        UserWaitList::create([
            'user_id' => $requestUser->id,
            'wait_list_id' => $waitList,
            'status' => 'active',
        ]);
        return response()->json([
            'status' => 'OK',
            'message' => "Has sido agregado a la lista de espera de esta clase.",
        ]);
    }

    public function attendClass(Request $request){
        $requestedClass = UserSchedule::find($request->reservation_id);
        if ($requestedClass->status == 'active' || $requestedClass->status != 'active'){
            $requestedClass->status = 'taken';
            $requestedClass->save();
            return response()->json([
                'status' => 'OK',
                'message' => "Asistencia registrada con éxito.",
            ]);
        } else {
            return response()->json([
                'status' => 'ERROR',
                'message' => "Ocurrió un error al procesar la solicitud. Intenta refrescando la página.",
            ]);
        }
    }

    public function claimClass(Request $request) {
        //Validaa si el lugar está disponible
        $alreadyReserved = UserSchedule::where("bike", $request->bike)->where("schedule_id", $request->schedule_id)->first();
        //obtiene el numero total de clases
        $numClases = Purchase::select(DB::raw('SUM(n_classes) as clases'))->whereRaw("NOW() <= DATE_ADD(created_at, INTERVAL expiration_days DAY)")->where('user_id', '=', "{$request->user_id}")->groupBy("id")->get();
        $classes = $numClases->sum("clases");
        //obtiene la compra con la fecha de caducidad mas proxima del usuario con clases disponibles
        //valida si el usuario tiene clases disponibles
        if ($classes > 0) {
            $compra = Purchase::where('user_id', $request->user_id)
            ->where('n_classes', "<>", 0)
            ->whereRaw("NOW() < DATE_ADD(created_at, INTERVAL expiration_days DAY)")
            ->orderByRaw('DATE_ADD(created_at, INTERVAL expiration_days DAY)')->first();
            if ($alreadyReserved && $alreadyReserved->status != 'cancelled') {
                DB::commit();
                return response()->json([
                    'status' => 'ERROR',
                    'message' => "Ese lugar ya ha sido reservado.",
                    'updateClass' => 1
                ]);
            }
            //obtiene el id de la bici,id del horario, id de la compra
            UserSchedule::create([
                'user_id' => $request->user_id,
                'schedule_id' => $request->schedule_id,
                'purchase_id' => $compra->id,
                //'tool_schedule_id' => $request->tool_schedule_id,
                'bike' => $request->bike,
                'status' => 'active',
                'changedSit' => 0,
            ]);
            //Resta una clase a la compra del usuario y actualiza ese campo en la base de datos
            $compra->n_classes -= 1;
            $compra->save();
            DB::commit();
            return response()->json([
                'status' => 'OK',
                'message' => "Lugar reservado con éxito.",
            ]);
        } else {
            return response()->json([
                'status' => 'ERROR',
                'message' => "El usuario no tiene clases compradas.",
            ]);
        }
    }

    public function preRegister(Request $request) {
        DB::beginTransaction();
        $password = substr($request->phone, -4);

        // Available alpha caracters
        $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        // generate a pin based on 2 * 7 digits + a random character
        $pin = $characters[rand(0, strlen($characters) - 1)]
        . $characters[rand(0, strlen($characters) - 1)]
        . $characters[rand(0, strlen($characters) - 1)]
        . $characters[rand(0, strlen($characters) - 1)];
        // shuffle the result
        $share_code = str_shuffle($pin);

        $user = User::create([
            'name' => $request->name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'password' => Hash::make('temporal' . $password),
            'birth_date' => $request->birth_date,
            'phone' => $request->phone,
            'shoe_size' => $request->shoe_size,
            'gender' => $request->gender,
            'share_code' => $share_code,
            'role_id' => 3,
        ]);
        $purchase = Purchase::create([
            'product_id' => 2,
            'user_id' => $user->id,
            'n_classes' => 0,
            'expiration_days' => 1,
            // 'status' => 0,
        ]);
        UserSchedule::create([
            'user_id' => $user->id,
            'schedule_id' => $request->schedule_id,
            'purchase_id' => $purchase->id,
            'bike' => $request->bike,
            'status' => 'active',
            'changedSit' => 0,
        ]);
        DB::commit();
        app('App\Http\Controllers\MailSendingController')->walkInRegister($user->email, $user->name, $password);
        return response()->json([
            'status' => 'OK',
            'message' => "Usuario agregado con éxito.",
        ]);
    }

    public function checkCancelLimit(Request $request){
        try {
            $requestedClass = UserSchedule::find($request->id);
            //obtiene el periodo de cancelacion de la ubicación
            $schedule = Schedule::find($requestedClass->schedule_id);
            $purchase = Purchase::with(["product" => function($query){$query->withTrashed();}])->find($requestedClass->purchase_id);
            $product = $purchase->product;

            $scheduleDate = Carbon::parse("{$schedule->day} {$schedule->hour}");
            $remainingTimeToClass = now()->diffInMinutes($scheduleDate);
            $cancelationRange = ($product->cancelation_range && $product->cancelation_range != 0)
                ? $product->cancelation_range
                : $schedule->branch->cancelation_period * 60;

            if ($product->is_refundable && $remainingTimeToClass >= $cancelationRange) {
                $isRefundable = true;
                $message = "Clase cancelada con exitó.";
            } else {
                $isRefundable = false;
                $message = "Esta clase no es reembolsable debido a que está fuera del periodo de cancelación.";
            }
            return response()->json([
                'status' => 'OK',
                'is_refundable' => $isRefundable,
                'message' => $message,
            ]);
        } catch (Exception $e) {
            Log::error("BookClassController@checkCancelLimit ".'line-'.$e->getLine().'  message'.$e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'Ocurrió un error al procesar la solicitud, por favor intentalo nuevamente.',
            ]);
        }
    }
}