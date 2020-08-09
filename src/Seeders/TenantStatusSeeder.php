<?php

namespace BinaryCats\LaravelTenant\Seeders;

use Illuminate\Database\Seeder;
use BinaryCats\LaravelTenant\Contracts\TenantStateful;

class TenantStatusSeeder extends Seeder
{
    /**
     * Bind the implementation
     *
     * @var BinaryCats\LaravelTenant\Contracts\TenantStateful
     */
    protected $tenantStatus;

    /**
     * Creat new Seeder
     *
     * @return void
     */
    public function __construct()
    {
        $this->tenantStatus = app(config('tenant.models.tenant_status'));
    }

    /**
     * Array of values to save
     *
     * @var array
     */
    protected $values = [
        TenantStateful::UNCONFIRMED => [
            'label' => 'Unconfirmed',
            'description' => 'Account has not been confirmed yet',
            'allows_use' => true,
        ],
        TenantStateful::ACTIVE => [
            'label' => 'Active',
            'description' => 'Account is active and in good standing',
            'allows_use' => true,
        ],
        TenantStateful::SUSPENDED => [
            'label' => 'Suspended',
            'description' => 'The account has been suspended.',
            'allows_use' => false,
        ],
        TenantStateful::ABANDONED => [
            'label' => 'Abandoned',
            'description' => 'The account did not have activity over a long period of time.',
            'allows_use' => true,
        ],
        TenantStateful::INACTIVED => [
            'label' => 'Inactivated',
            'description' => 'The account has been inactivated by the owner.',
            'allows_use' => false,
        ],

    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->tenantStatus->unguard();

        $this->values()->each(
            function ($record, $key) {
                $this->tenantStatus->firstOrNew(
                    [
                    $this->tenantStatus->getKeyName() => $key,
                    ]
                )->fill($record)->save();
            }
        );

        $this->tenantStatus->reguard();
    }

    /**
     * Resolve the values
     *
     * @return Illumiante\Support\Collection
     */
    protected function values()
    {
        return collect($this->values);
    }
}
