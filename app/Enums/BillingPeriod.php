<?php

namespace App\Enums;

enum BillingPeriod: string
{
    case Monthly = 'monthly';
    case Yearly = 'yearly';

    public function label(): string
    {
        return match ($this) {
            self::Monthly => 'Monthly',
            self::Yearly => 'Yearly',
        };
    }

    /**
     * Localized "/ month" or "/ year" suffix shown next to a price.
     */
    public function publicSuffix(): string
    {
        return match ($this) {
            self::Monthly => __('public.pricing.per_month'),
            self::Yearly => __('public.pricing.per_year'),
        };
    }

    public function publicLabel(): string
    {
        return match ($this) {
            self::Monthly => __('public.pricing.monthly'),
            self::Yearly => __('public.pricing.yearly'),
        };
    }
}
