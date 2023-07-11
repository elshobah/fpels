<?php

namespace Modules\Payment\Entities;

use Modules\Utils\Uuid;
use Modules\Master\Entities\Bill;
use Modules\Payment\Entities\Note;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Spending extends Model
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
    protected $table = 'spendings';

    /**
     * Get bill
     *
     * @return BelongsTo
     */
    public function bill(): BelongsTo
    {
        return $this->belongsTo(Bill::class);
    }

    public function note(): BelongsTo
    {
        return $this->belongsTo(Note::class);
    }
}
