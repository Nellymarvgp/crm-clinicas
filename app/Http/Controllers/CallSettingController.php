<?php

namespace App\Http\Controllers;

use App\CallSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;

class CallSettingController extends Controller
{
    /**
     * Display a listing of the call settings.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $callSettings = CallSetting::where('is_deleted', 0)->get();
        $user = Sentinel::getUser();
        $role = $user->roles[0]->slug;
        return view('call-setting.index', compact('callSettings', 'user', 'role'));
    }

    /**
     * Show the form for creating a new call setting.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = Sentinel::getUser();
        $role = $user->roles[0]->slug;
        return view('call-setting.create', compact('user', 'role'));
    }

    /**
     * Store a newly created call setting in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'agent_name' => 'required|string|max:255',
            'agent_id' => 'required|string|max:255',
            'call_url' => 'required|url|max:255',
            'parameters' => 'nullable|array',
            'parameters.*.key' => 'required|string|max:255',
            'parameters.*.value' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            $callSetting = new CallSetting();
            $callSetting->agent_name = $request->agent_name;
            $callSetting->agent_id = $request->agent_id;
            $callSetting->call_url = $request->call_url;
            
            // Procesar parámetros de tipo clave-valor
            $parameters = [];
            if ($request->has('parameters')) {
                foreach ($request->parameters as $param) {
                    if (!empty($param['key']) && !empty($param['value'])) {
                        $parameters[$param['key']] = $param['value'];
                    }
                }
            }
            $callSetting->parameters = $parameters;
            $callSetting->is_active = $request->has('is_active');
            $callSetting->save();

            return redirect()->route('setting-call.index')
                ->with('success', 'Configuración de llamada creada exitosamente.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Error al crear la configuración: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Show the form for editing the specified call setting.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $callSetting = CallSetting::findOrFail($id);
        $user = Sentinel::getUser();
        $role = $user->roles[0]->slug;
        return view('call-setting.edit', compact('callSetting', 'user', 'role'));
    }

    /**
     * Update the specified call setting in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'agent_name' => 'required|string|max:255',
            'agent_id' => 'required|string|max:255',
            'call_url' => 'required|url|max:255',
            'parameters' => 'nullable|array',
            'parameters.*.key' => 'required|string|max:255',
            'parameters.*.value' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            $callSetting = CallSetting::findOrFail($id);
            $callSetting->agent_name = $request->agent_name;
            $callSetting->agent_id = $request->agent_id;
            $callSetting->call_url = $request->call_url;
            
            // Procesar parámetros de tipo clave-valor
            $parameters = [];
            if ($request->has('parameters')) {
                foreach ($request->parameters as $param) {
                    if (!empty($param['key']) && !empty($param['value'])) {
                        $parameters[$param['key']] = $param['value'];
                    }
                }
            }
            $callSetting->parameters = $parameters;
            $callSetting->is_active = $request->has('is_active');
            $callSetting->save();

            return redirect()->route('setting-call.index')
                ->with('success', 'Configuración de llamada actualizada exitosamente.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Error al actualizar la configuración: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Remove the specified call setting from storage (soft delete).
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $callSetting = CallSetting::findOrFail($id);
            $callSetting->is_deleted = true;
            $callSetting->save();

            return redirect()->route('setting-call.index')
                ->with('success', 'Configuración de llamada eliminada exitosamente.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Error al eliminar la configuración: ' . $e->getMessage());
        }
    }

    /**
     * Display the public form for initiating calls.
     *
     * @return \Illuminate\Http\Response
     */
    public function showCallForm()
    {
        $agents = CallSetting::where('is_active', 1)
            ->where('is_deleted', 0)
            ->get();
        
        // Para la vista pública no necesitamos $user ni $role
        return view('public.call.form', compact('agents'));
    }

    /**
     * Process the call request from the public form.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function processCallRequest(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:15',
            'agent_id' => 'required|exists:call_settings,id',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            $callSetting = CallSetting::findOrFail($request->agent_id);
            
            // Preparar los datos para la solicitud a la API de llamadas
            $callData = [];
            
            // Añadir los parámetros configurados
            if (!empty($callSetting->parameters)) {
                foreach ($callSetting->parameters as $key => $value) {
                    $callData[$key] = $value;
                }
            }
            
            // Añadir información del usuario
            $callData['user_name'] = $request->name;
            $callData['user_phone'] = $request->phone;
            $callData['agent_id'] = $callSetting->agent_id;
            
            // Aquí se implementaría la lógica para enviar la solicitud a la API
            // utilizando Guzzle o curl
            
            return redirect()->back()
                ->with('success', 'Solicitud de llamada enviada correctamente. Un agente se pondrá en contacto contigo pronto.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Error al procesar la solicitud de llamada: ' . $e->getMessage())
                ->withInput();
        }
    }
}
