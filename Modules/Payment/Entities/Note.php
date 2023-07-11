<?php

namespace Modules\Payment\Entities;

use Modules\Utils\Uuid;
use Modules\Master\Entities\Bill;
use Modules\Master\Entities\Spending;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Note extends Model
{

    use Uuid,
        SoftDeletes;

    /**
     * Primary Key Incrementing
     *
     * @var boolean
     */
    public $incrementing = false;

    /**
     * Mass Assignment
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * Primary Key Type
     *
     * @var string
     */
    protected $keyType = "string";

    /**
     * Table name
     *
     * @var string
     */
    protected $table = 'notes';

    /**
     * Get bill
     *
     * @return BelongsTo
     */
    public function bill(): BelongsTo
    {
        return $this->belongsTo(Bill::class);
    }

        /**
     * Get spendings
     *
     * @return HasMany
     */
    public function spendings(): HasMany
    {
        return $this->hasMany(Spending::class);
    }

}
