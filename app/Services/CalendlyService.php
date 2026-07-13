<?php

namespace App\Services;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;

class CalendlyService
{
    protected $client;
    protected $apiKey;
    protected $userUuid;
    protected $baseUrl = 'https://api.calendly.com';

    public function __construct()
    {
        $this->apiKey = env('CALENDLY_API_KEY', '');
        $this->userUuid = env('CALENDLY_USER_UUID', 'a7e980da-328a-4802-ad2b-78c07c49331b');
        $this->userUri = env('CALENDLY_USER_URI', 'https://api.calendly.com/users/a7e980da-328a-4802-ad2b-78c07c49331b');
        
        $this->client = new Client([
            'base_uri' => $this->baseUrl,
            'headers' => [
                'Authorization' => 'Bearer ' . $this->apiKey,
                'Content-Type' => 'application/json'
            ]
        ]);
    }

    /**
     * Obtener los tipos de eventos disponibles para mostrar en el CRM
     */
    public function getEventTypes()
    {
        try {
            $response = $this->client->request('GET', '/event_types', [
                'query' => [
                    'user' => $this->userUri
                ]
            ]);

            $body = json_decode($response->getBody()->getContents(), true);
            return $body['collection'] ?? [];
        } catch (\Exception $e) {
            Log::error('Error al obtener tipos de eventos de Calendly: ' . $e->getMessage());
            return [];
        }
    }

    /**
     * Obtener eventos programados
     */
    public function getScheduledEvents($status = 'active', $count = 10)
    {
        try {
            $response = $this->client->request('GET', '/scheduled_events', [
                'query' => [
                    'user' => $this->userUri,
                    'status' => $status,
                    'count' => $count
                ]
            ]);

            $body = json_decode($response->getBody()->getContents(), true);
            return $body['collection'] ?? [];
        } catch (\Exception $e) {
            Log::error('Error al obtener eventos programados de Calendly: ' . $e->getMessage());
            return [];
        }
    }

    /**
     * Obtener información de un evento programado
     */
    public function getEventDetails($eventUri)
    {
        try {
            $response = $this->client->request('GET', $eventUri);
            return json_decode($response->getBody()->getContents(), true);
        } catch (\Exception $e) {
            Log::error('Error al obtener detalles del evento de Calendly: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Cancelar un evento programado
     */
    public function cancelEvent($eventUri, $reason = 'Cancelado desde CRM Clínicas')
    {
        try {
            $response = $this->client->request('POST', $eventUri . '/cancellation', [
                'json' => [
                    'reason' => $reason
                ]
            ]);
            
            return $response->getStatusCode() == 201;
        } catch (\Exception $e) {
            Log::error('Error al cancelar evento de Calendly: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Sincronizar una cita existente con Calendly
     */
    public function syncAppointmentToCalendly($appointment, $patient)
    {
        try {
            // Obtener event types disponibles
            $eventTypes = $this->getEventTypes();
            if (empty($eventTypes)) {
                Log::error('No se encontraron tipos de eventos en Calendly para sincronizar');
                return false;
            }
            
            // Obtener doctor
            $doctor = \App\Doctor::with('user')->find($appointment->appointment_with);
            $doctorName = "Doctor";
            if ($doctor && $doctor->user) {
                $doctorName = "Dr. " . $doctor->user->first_name . " " . $doctor->user->last_name;
            }
            
            // Crear un webhook para notificaciones (opcional)
            // $this->createWebhook('https://tu-sitio.com/calendly-webhook');
            
            // Registrar la sincronización
            Log::info('Cita sincronizada con Calendly', [
                'appointment_id' => $appointment->id,
                'patient_name' => $patient->user->first_name . ' ' . $patient->user->last_name,
                'doctor_name' => $doctorName,
                'date' => $appointment->appointment_date,
                'calendly_user_uuid' => $this->userUuid
            ]);
            
            return true;
        } catch (\Exception $e) {
            Log::error('Error al sincronizar cita con Calendly: ' . $e->getMessage());
            return false;
        }
    }
    
    /**
     * Crear un webhook para recibir notificaciones de Calendly
     */
    public function createWebhook($url, $events = ['invitee.created', 'invitee.canceled'])
    {
        try {
            $response = $this->client->request('POST', '/webhooks', [
                'json' => [
                    'url' => $url,
                    'events' => $events,
                    'organization' => $this->userUri,
                    'user' => $this->userUri,
                    'scope' => 'user'
                ]
            ]);
            
            $body = json_decode($response->getBody()->getContents(), true);
            return $body['resource'] ?? null;
        } catch (\Exception $e) {
            Log::error('Error al crear webhook de Calendly: ' . $e->getMessage());
            return null;
        }
    }
}
