<?php

namespace App\Services;

class PatientAddressService
{
    /**
     * Apply address sync logic based on the is_delivery_same_as_residential flag.
     *
     * If true: overwrite delivery fields with residential values.
     * If false: leave delivery fields exactly as the user submitted them.
     */
    public function syncDeliveryAddress(array $data): array
    {
        $sameAsResidential = $data['is_delivery_same_as_residential'] ?? true;

        if ($sameAsResidential) {
            $data['d_address']  = $data['address']  ?? null;
            $data['d_suite']    = $data['suite_no']  ?? null;
            $data['d_city']     = $data['city']      ?? null;
            $data['d_state']    = $data['state']     ?? null;
            $data['d_zip_code'] = $data['zip_code']  ?? null;
        }

        return $data;
    }
}