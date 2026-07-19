<?php

namespace App\Services;

use App\Appointment;
use App\Doctor;
use App\Patient;
use Carbon\Carbon;
use Google\Client;
use Google\Service\Calendar;
use Illuminate\Support\Facades\Log;

class GoogleCalendarService
{
    /**
     * Crea un evento en Google Calendar para una cita.
     *
     * @param Appointment $appointment
     * @param Patient $patient
     * @param Doctor $doctor
     * @param string $time Hora en formato H:i
     * @return array{id:string,htmlLink:string|null}
     */
    public function createAppointmentEvent(Appointment $appointment, Patient $patient, Doctor $doctor, string $time): array
    {
        $calendarId = config('services.google_calendar.calendar_id');
        $credentialsPath = config('services.google_calendar.credentials_json');
        $impersonateUser = config('services.google_calendar.impersonate_user');

        if (empty($calendarId)) {
            throw new \RuntimeException('No se configuro GOOGLE_CALENDAR_ID.');
        }

        if (empty($credentialsPath)) {
            throw new \RuntimeException('No se configuro GOOGLE_CALENDAR_CREDENTIALS_JSON.');
        }

        if (!file_exists($credentialsPath)) {
            throw new \RuntimeException('No existe el archivo de credenciales de Google Calendar: ' . $credentialsPath);
        }

        $client = new Client();
        $client->setApplicationName('CRM Clinicas - Citas');
        $client->setAuthConfig($credentialsPath);
        $client->setScopes([Calendar::CALENDAR]);

        if (!empty($impersonateUser)) {
            $client->setSubject($impersonateUser);
        }

        $calendar = new Calendar($client);

        $timezone = config('app.timezone', 'America/Caracas');
        $slotDurationMinutes = (int) ($doctor->slot_time ?: 30);

        $startAt = Carbon::createFromFormat('Y-m-d H:i', $appointment->appointment_date . ' ' . $time, $timezone);
        $endAt = (clone $startAt)->addMinutes($slotDurationMinutes);

        $doctorName = 'Doctor';
        if ($doctor->relationLoaded('user') && $doctor->user) {
            $doctorName = trim('Dr. ' . $doctor->user->first_name . ' ' . $doctor->user->last_name);
        }

        $patientName = trim(($patient->user->first_name ?? '') . ' ' . ($patient->user->last_name ?? ''));

        $descriptionLines = [
            'Paciente: ' . ($patientName ?: 'N/A'),
            'Telefono: ' . ($patient->user->mobile ?? 'N/A'),
            'Direccion: ' . ($patient->address ?? 'N/A'),
            'Genero: ' . ($patient->gender ?? 'N/A'),
            'Edad: ' . ($patient->age ?? 'N/A'),
            'Doctor: ' . $doctorName,
            'Cita ID: ' . $appointment->id,
        ];

        $attendees = [];
        if (!empty($patient->user->email)) {
            $attendees[] = ['email' => $patient->user->email];
        }

        $event = new Calendar\Event([
            'summary' => 'Cita odontologica - ' . ($patientName ?: 'Paciente'),
            'description' => implode("\n", $descriptionLines),
            'start' => [
                'dateTime' => $startAt->toRfc3339String(),
                'timeZone' => $timezone,
            ],
            'end' => [
                'dateTime' => $endAt->toRfc3339String(),
                'timeZone' => $timezone,
            ],
            'attendees' => $attendees,
        ]);

        $createdEvent = $calendar->events->insert($calendarId, $event, ['sendUpdates' => 'all']);

        Log::info('Evento creado en Google Calendar para cita publica', [
            'appointment_id' => $appointment->id,
            'google_event_id' => $createdEvent->getId(),
            'google_event_link' => $createdEvent->getHtmlLink(),
        ]);

        return [
            'id' => $createdEvent->getId(),
            'htmlLink' => $createdEvent->getHtmlLink(),
        ];
    }
}
