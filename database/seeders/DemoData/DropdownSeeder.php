<?php

namespace Database\Seeders\DemoData;

use App\Library\Enum;
use App\Models\Config;
use Illuminate\Database\Seeder;

class DropdownSeeder extends Seeder
{
    public function run()
    {
        $records = self::getRecords();

        foreach ($records as $record) {
            $values = getDropdown($record['dropdown']);
            $values[] = $record['name'];
            self::updateConfig($record['dropdown'], json_encode($values, true));
        }
    }

    private static function getRecords()
    {
        return [
            /*CONFIG_DROPDOWN_EMP_DESIGNATION*/
            // [
            //     'name'     => 'HR',
            //     'dropdown' => Enum::CONFIG_DROPDOWN_EMP_DESIGNATION,
            // ],
            // [
            //     'name'     => 'Accounts',
            //     'dropdown' => Enum::CONFIG_DROPDOWN_EMP_DESIGNATION,
            // ],
            // [
            //     'name'     => 'Manager',
            //     'dropdown' => Enum::CONFIG_DROPDOWN_EMP_DESIGNATION,
            // ],

            /*CONFIG_DROPDOWN_TICKET_DEPARTMENT*/
            [
                'name'     => 'Customer Service',
                'dropdown' => Enum::CONFIG_DROPDOWN_TICKET_DEPARTMENT,
            ],
            [
                'name'     => 'On Field Service',
                'dropdown' => Enum::CONFIG_DROPDOWN_TICKET_DEPARTMENT,
            ],
            [
                'name'     => 'Accounts Service',
                'dropdown' => Enum::CONFIG_DROPDOWN_TICKET_DEPARTMENT,
            ],

            /*CONFIG_DROPDOWN_NOTIFICATION_TYPE*/
            // [
            //     'name'     => 'Weekly Announcement',
            //     'dropdown' => Enum::CONFIG_DROPDOWN_NOTIFICATION_TYPE,
            // ],
            // [
            //     'name'     => 'Monthly Announcement',
            //     'dropdown' => Enum::CONFIG_DROPDOWN_NOTIFICATION_TYPE,
            // ],
            // [
            //     'name'     => 'Daily Announcement',
            //     'dropdown' => Enum::CONFIG_DROPDOWN_NOTIFICATION_TYPE,
            // ],

            /*CONFIG_DROPDOWN_GENDER*/
            [
                'name'     => 'Male',
                'dropdown' => Enum::CONFIG_DROPDOWN_GENDER,
            ],
            [
                'name'     => 'Female',
                'dropdown' => Enum::CONFIG_DROPDOWN_GENDER,
            ],
            [
                'name'     => 'Others',
                'dropdown' => Enum::CONFIG_DROPDOWN_GENDER,
            ],


            /*CONFIG_DROPDOWN_EMPLOYMENT_STATUS*/
            [
                'name'     => 'Part-Time',
                'dropdown' => Enum::CONFIG_DROPDOWN_EMPLOYMENT_STATUS,
            ],
            [
                'name'     => 'Full Time',
                'dropdown' => Enum::CONFIG_DROPDOWN_EMPLOYMENT_STATUS,
            ],

            /*CONFIG_DROPDOWN_JOB_TITLE*/
            [
                'name'     => 'HR',
                'dropdown' => Enum::CONFIG_DROPDOWN_JOB_TITLE,
            ],
            [
                'name'     => 'Frontend Developer',
                'dropdown' => Enum::CONFIG_DROPDOWN_JOB_TITLE,
            ],
            [
                'name'     => 'Banckend Developer',
                'dropdown' => Enum::CONFIG_DROPDOWN_JOB_TITLE,
            ],
            [
                'name'     => 'FullStack Developer',
                'dropdown' => Enum::CONFIG_DROPDOWN_JOB_TITLE,
            ],

            /*Brand TYPE*/
            // [
            //     'name'     => 'Brand-1',
            //     'dropdown' => Enum::CONFIG_DROPDOWN_AMS_BRAND,
            // ],
            // [
            //     'name'     => 'Brand-2i',
            //     'dropdown' => Enum::CONFIG_DROPDOWN_AMS_BRAND,
            // ],
            // [
            //     'name'     => 'Brand-3',
            //     'dropdown' => Enum::CONFIG_DROPDOWN_AMS_BRAND,
            // ],
            // [
            //     'name'     => 'Brand-4',
            //     'dropdown' => Enum::CONFIG_DROPDOWN_AMS_BRAND,
            // ],

            /* CONFIG_DROPDOWN_BRAND */
            // [
            //     'name'     => 'Samsung',
            //     'dropdown' => Enum::CONFIG_DROPDOWN_AMS_BRAND,
            // ],
            // [
            //     'name'     => 'Apple',
            //     'dropdown' => Enum::CONFIG_DROPDOWN_AMS_BRAND,
            // ],
            // [
            //     'name'     => 'Dell',
            //     'dropdown' => Enum::CONFIG_DROPDOWN_AMS_BRAND,
            // ],


            /* CONFIG_DROPDOWN_UNIT */
            // [
            //     'name'     => 'KG',
            //     'dropdown' => Enum::CONFIG_DROPDOWN_UNIT,
            // ],
            // [
            //     'name'     => 'Litter',
            //     'dropdown' => Enum::CONFIG_DROPDOWN_UNIT,
            // ],
            // [
            //     'name'     => 'Piece',
            //     'dropdown' => Enum::CONFIG_DROPDOWN_UNIT,
            // ],


            /* CONFIG_DROPDOWN_PAYMENT_METHOD */
            // [
            //     'name'     => 'Cash',
            //     'dropdown' => Enum::CONFIG_DROPDOWN_PAYMENT_METHOD,
            // ],
            // [
            //     'name'     => 'Bank',
            //     'dropdown' => Enum::CONFIG_DROPDOWN_PAYMENT_METHOD,
            // ],
            // [
            //     'name'     => 'Bkash',
            //     'dropdown' => Enum::CONFIG_DROPDOWN_PAYMENT_METHOD,
            // ],
            // [
            //     'name'     => 'Rocket',
            //     'dropdown' => Enum::CONFIG_DROPDOWN_PAYMENT_METHOD,
            // ],
            // [
            //     'name'     => 'Nagad',
            //     'dropdown' => Enum::CONFIG_DROPDOWN_PAYMENT_METHOD,
            // ],


            /* CONFIG_DROPDOWN_EXPENSE_CATEGORY */
            // [
            //     'name'     => 'Snacks',
            //     'dropdown' => Enum::CONFIG_DROPDOWN_EXPENSE_CATEGORY,
            // ],
            // [
            //     'name'     => 'Electricity Bill',
            //     'dropdown' => Enum::CONFIG_DROPDOWN_EXPENSE_CATEGORY,
            // ],
            // [
            //     'name'     => 'Internet Bill',
            //     'dropdown' => Enum::CONFIG_DROPDOWN_EXPENSE_CATEGORY,
            // ],
        ];
    }

    private static function updateConfig(string $key, string $value)
    {
        $config = Config::firstOrNew(['key' => $key]);
        $config->value = $value;
        $config->save();
    }
}
