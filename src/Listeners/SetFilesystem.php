<?php

namespace BinaryCats\LaravelTenant\Listeners;

use BinaryCats\LaravelTenant\TenantManager;
use Illuminate\Auth\Events\Authenticated;

class SetFilesystem
{
    /**
     * @var BinaryCats\LaravelTenant\TenantManager
     */
    protected $tenantManager;

    /**
     * Create new Middleware.
     *
     * @param BinaryCats\LaravelTenant\TenantManager $tenantManager
     */
    public function __construct(TenantManager $tenantManager)
    {
        $this->tenantManager = $tenantManager;
    }

    /**
     * Handle the event.
     *
     * @param  Illuminate\Auth\Events\Authenticated $event
     * @return void
     */
    public function handle(Authenticated $event)
    {
        $this->addFilesystem();
    }

    /**
     * Dynamically add a file system.
     *
     * @param App\User $user
     */
    protected function addFilesystem()
    {
        // Add the key dinamically based on the tenant
        // Set the disk to be default?
        config(
            [
                $this->filesystemConfigKey() => $this->filesystemConfig(),
                'medialibrary.disk_name' => $this->key(),
            ]
        );
    }

    /**
     * Key to use for the disks and resets.
     *
     * @return string
     */
    protected function key()
    {
        return $this->tenantManager->uuid();
    }

    /**
     * Make the filesustem key to use.
     *
     * @return string
     */
    protected function filesystemConfigKey()
    {
        return "filesystems.disks.{$this->key()}";
    }

    /**
     * Protected filesystem.
     *
     * @return array
     */
    protected function filesystemConfig()
    {
        return array_merge(
            $this->defaultFilesystemConfig(), [
                'root' => $this->key(),
            ]
        );
    }

    /**
     * Collect default configuration.
     *
     * @return array
     */
    protected function defaultFilesystemConfig()
    {
        // replace as configurable
        $key = 's3';
        // resolve
        return config("filesystems.disks.{$key}", []);
    }
}
