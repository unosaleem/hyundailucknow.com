<?php

namespace App\Services;

use App\Models\Lead;
use Illuminate\Support\Facades\Log;

class InfomanCrmService
{
    /**
     * Send lead details to Infoman eCRM API.
     *
     * @param Lead|array $lead
     * @return array
     */
    public function sendLead($lead): array
    {
        $url = config('services.infoman_ecrm.url', 'http://ecrminwappapi.infoman-ecrm.com/Lead/LeadCreation');
        $token = config('services.infoman_ecrm.token', 'cP2yC9iiPNndRJhJjMW0KASBeeaar');
        $vendor = config('services.infoman_ecrm.vendor', 'WEbsite');
        $make = config('services.infoman_ecrm.make', 'HYUNDAI');
        $timeout = (int) config('services.infoman_ecrm.timeout', 10);

        $name = is_array($lead) ? ($lead['name'] ?? '') : ($lead->name ?? '');
        $city = is_array($lead) ? ($lead['city'] ?? '') : ($lead->city ?? '');
        $mobile = is_array($lead) ? ($lead['mobile'] ?? '') : ($lead->mobile ?? '');
        $email = is_array($lead) ? ($lead['email'] ?? '') : ($lead->email ?? '');
        $model = is_array($lead) ? ($lead['model'] ?? '') : ($lead->model ?? '');

        // Extract digits for clean 10-digit mobile
        $cleanMobile = preg_replace('/\D+/', '', (string) $mobile);

        $payload = [
            [
                'Vendor' => $vendor,
                'ProspectName' => (string) $name,
                'Address' => (string) $city,
                'PinCode' => '',
                'MobileNo' => $cleanMobile ?: (string) $mobile,
                'PhoneNo' => '',
                'EmailId' => (string) ($email ?? ''),
                'EnquiryDate' => now()->format('Y-m-d'),
                'Make' => $make,
                'ModelEnquired' => (string) ($model ?? ''),
                'SubModel' => '',
                'Telecaller' => '',
                'SalesConsultant' => '',
                'Outlet' => '',
            ]
        ];

        try {
            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                'Authorization: ' . $token,
                'Content-Type: application/json',
                'Accept: application/json',
            ]);
            curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);

            $response = curl_exec($ch);
            $statusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            $curlError = curl_error($ch);
            curl_close($ch);

            if ($curlError) {
                Log::error('Infoman eCRM Lead Send Failed (cURL)', [
                    'error' => $curlError,
                    'payload' => $payload,
                ]);

                return [
                    'success' => false,
                    'error' => $curlError,
                ];
            }

            $isSuccess = ($statusCode >= 200 && $statusCode < 300);

            Log::info('Infoman eCRM Lead Send Response', [
                'status_code' => $statusCode,
                'response' => $response,
                'customer' => $name,
                'mobile' => $cleanMobile,
            ]);

            return [
                'success' => $isSuccess,
                'status_code' => $statusCode,
                'response' => $response,
            ];
        } catch (\Throwable $e) {
            Log::error('Infoman eCRM Lead Send Exception: ' . $e->getMessage(), [
                'exception' => $e,
                'payload' => $payload,
            ]);

            return [
                'success' => false,
                'error' => $e->getMessage(),
            ];
        }
    }
}
