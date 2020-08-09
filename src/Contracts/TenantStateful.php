<?php

namespace BinaryCats\LaravelTenant\Contracts;

interface TenantStateful
{
    /**
     * Account has not been confirmed yet.
     */
    const UNCONFIRMED = 1;

    /**
     * Account is active and in good standing.
     */
    const ACTIVE = 2;

    /**
     * The account has been suspended.
     */
    const SUSPENDED = 3;

    /**
     * The account did not have activity over a long period of time.
     */
    const ABANDONED = 4;

    /**
     * The account has been inactivated by the owner.
     */
    const INACTIVED = 5;

    /**
     * Return the value of the field to which the comparison needs to be made.
     *
     * @return string
     */
    public function getStatus();

    /**
     * Return the field to which the comparison needs to be made.
     *
     * @return string
     */
    public function getStatusName();
}
