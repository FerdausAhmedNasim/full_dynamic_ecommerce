<?php

namespace App\Library\Services\Seller\Settings;

use Exception;
use App\Library\Helper;
use App\Models\Address;
use Yajra\DataTables\Facades\DataTables;
use App\Library\Services\Admin\BaseService;

class PickupHubService extends BaseService
{
    private function actionHtml($row)
    {
        $actionHtml = '';
        $route = route('seller.config.general_settings.pickup_hub.delete', $row->id);

        if ($row->id) {
            if (Helper::hasAuthRolePermission('seller_pickup_hub_update')) {
                $actionHtml .= '<a class="dropdown-item text-primary" href="' . route('seller.config.general_settings.pickup_hub.edit', $row->id) . '" ><i class="far fa-edit"></i> Edit</a>';
            }

            if (Helper::hasAuthRolePermission('seller_pickup_hub_delete')) {
                $actionHtml .= '<button class="dropdown-item text-danger" onclick="confirmFormModal(\'' . $route . '\', \'Confirmation\', \'Are you sure to delete?\');"><i class="fa fa-trash-alt"></i> Delete</button>';
            }
        } else {
            $actionHtml = '';
        }

        return '<div class="action dropdown">
                    <button class="btn btn2-secondary btn-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                       <i class="fas fa-tools"></i> Action
                    </button>
                    <div class="dropdown-menu">
                        ' . $actionHtml . '
                    </div>
                </div>';
    }

    public function dataTable()
    {
        $data = Address::where('user_id', authSellerId())->get();

        return DataTables::of($data)
                ->addIndexColumn()
                ->editColumn('street_address', function ($row) {
                    return $row->street_address;
                })
                ->editColumn('area_id', function ($row) {
                    return $row?->area?->en_name;
                })
                ->editColumn('thana_id', function ($row) {
                    return $row?->thana?->en_name;
                })
                ->editColumn('note', function ($row) {
                    return $row->note;
                })
                ->addColumn('action', function ($row) {
                    return $this->actionHtml($row);
                })
                ->rawColumns(['action'])
                ->make(true);
    }

    public function store(array $data): bool
    {
        try {
            $data['user_id'] = authSellerId();
            $data['location'] = Address::determineLocation($data);

            $this->data = Address::create($data);

            return $this->handleSuccess('Successfully Created');
        } catch (Exception $e) {
            Helper::log($e);

            return $this->handleException($e);
        }
    }

    public function update(Address $pickupHub, array $data): bool
    {
        try {
            $data['user_id'] = authSellerId();
            $data['location'] = Address::determineLocation($data);

            $this->data = $pickupHub->update($data);

            return $this->handleSuccess('Successfully updated');
        } catch (Exception $e) {
            Helper::log($e);

            return $this->handleException($e);
        }
    }
}