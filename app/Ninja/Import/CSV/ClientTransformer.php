<?php
namespace App\Ninja\Import\CSV;

use App\Ninja\Import\BaseTransformer;
use League\Fractal\Resource\Item;

/**
 * Class ClientTransformer.
 */
class ClientTransformer extends BaseTransformer
{
    /**
     * @param $data
     *
     * @return bool|Item
     */
    public function transform($data)
    {
        if (isset($data->name) && $this->hasClient($data->name)) {
            return false;
        }
        return new Item($data, function ($data) {
            return [
                'name' => $this->getString($data, 'name'),
                'work_phone' => $this->getString($data, 'work_phone'),
                'address1' => $this->getString($data, 'address1'),
                'city' => $this->getString($data, 'city'),
                'state' => $this->getString($data, 'state'),
                'postal_code' => $this->getString($data, 'postal_code'),
                'private_notes' => $this->getString($data, 'notes'),
                'website' => $this->getString($data, 'website'),
                'vat_number' => $this->getString($data, 'vat_number'),
                'id_number' => $this->getString($data, 'id_number'),
                'contacts' => [
                    [
                        'first_name' => $this->getString($data, 'first_name'),
                        'last_name' => $this->getString($data, 'last_name'),
                        'email' => $this->getString($data, 'email'),
                        'phone' => $this->getString($data, 'phone'),
                    ],
                ],
                'country_id' => isset($data->country) ? $this->getCountryId($data->country) : null,
            ];
        });
    }
}
