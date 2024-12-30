<?php

namespace Wsmallnews\Delivery\Models;

use Wsmallnews\Support\Models\SupportModel;

class UserAddress extends SupportModel
{
    protected $table = 'sn_user_addresses';

    protected $guarded = [];

    protected $casts = [
        'is_default' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(config('sn-delivery.user_model'), 'user_id');
    }
}
