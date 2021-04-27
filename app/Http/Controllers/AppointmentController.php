<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Customer;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AppointmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index (Request $request)
    {
        try {
            $sal_id = $request->get('sal_id');
            $appointment = Appointment::where('sal_id', $sal_id)->get();
            $customer = Customer::where('sal_id', $sal_id)->get();
            return response()->json([
                'status' => 200,
                'message' => "Exitoso",
                'appointments' => $appointment,
                 'customers' => $customer
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => 500,
                'message' => "Error",
                'error' => $e->getMessage(),
            ]);
        }

    }
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function indexAppointmentByCustomer(Request $request, $cus_id)
    {
        try {
            $sal_id = $request->get('sal_id');
            $appointment = Appointment::where('cus_id',$cus_id)->where('sal_id', $sal_id)->get();
            return response()->json([
                'status' => 200,
                'message' => "Exitoso",
                 'appointments' => $appointment,
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => 500,
                'message' => "Error",
                'data' => [
                    'error' => $e->getMessage(),
                ]
            ]);
        }

    }

    /**
     * Display the specified resource.
     *
     * @param $app_id
     * @return JsonResponse
     */
    public function show(Request $request, $app_id)
    {
        try {
            $sal_id = $request->get('sal_id');
            $appointment = Appointment::where('sal_id', $sal_id)->where('app_id',$app_id)->first();
            return response()->json([
                'status' => 200,
                'message' => "Exitoso",
                'appointment' => $appointment,

            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => 500,
                'message' => "Error",
                'data' => [
                    'error' => $e->getMessage(),
                ]
            ]);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function create(Request $request)
    {
        try {
            DB::beginTransaction();
            $sal_id = $request->get('sal_id');
            $appointment = new Appointment();
            $appointment->sal_id = $sal_id;
            $appointment = $appointment->create(array_merge($request->all(), ['sal_id' => $sal_id]));

            DB::commit();
            return response()->json([
                'status' => 200,
                'message' => "Exitoso",
                 'appointment' => $appointment,

            ]);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => 500,
                'message' => "Error while creating an appointment",
                'data' => [
                    'error' => $e->getMessage(),
                ]
            ]);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param $sal_id
     * @return JsonResponse
     */
    public function update(Request $request, $app_id)
    {
        try {
            DB::beginTransaction();
            $sal_id = $request->get('sal_id');
            $appointment = Appointment::where('sal_id', $sal_id)->where('app_id',$app_id)->first();
            $appointment->sal_id = $sal_id;
            $appointment->update(array_merge($request->all(), ['sal_id' => $sal_id]));
            DB::commit();
            return response()->json([
                'status' => 200,
                'message' => "Exitoso",
                'appointment' => $appointment,
            ]);
        }catch (Exception $e){
            DB::rollBack();
            return response()->json([
                'status' => 500,
                'message' => "Error",
                'error' => $e->getMessage(),
            ]);
        }
    }
    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param $sal_id
     * @return JsonResponse
     */
    public function delete(Request $request, $app_id)
    {
        try {
            DB::beginTransaction();
            $sal_id = $request->get('sal_id');
            $appointment = Appointment::where('sal_id', $sal_id)->where('app_id',$app_id)->first();
            $appointment->delete();
            DB::commit();
            return response()->json([
                'status' => 200,
                'message' => "Exitoso",
                'appointment' => $appointment,
            ]);
        }catch (Exception $e){
            DB::rollBack();
            return response()->json([
                'status' => 500,
                'message' => "Error",
                'error' => $e->getMessage(),
            ]);
        }
    }
}
