<?php

namespace Modules\Payment\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Modules\Payment\Rules\SpendingAboveIncome;

class SpendingRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules($bill_id = null, $note_id = null, $isUpdate = false): array
    {
        return [
            'note_id' => ['required', 'string'],
            'bill_id' => ['required'],
            'nominal' => ['required', new SpendingAboveIncome($bill_id, $note_id, $isUpdate)],
            'spending_date' => ['required'],
            'description' => ['nullable', 'min:5']
        ];
    }

    /**
     * Get validate attributes
     *
     * @return array
     */
    public function attributes(): array
    {
        return [
            'note_id' => 'Note_id',
            'nominal' => 'Nominal',
            'bill_id' => 'Tagihan',
            'spending_date' => 'Tanggal Pengeluaran',
            'description' => 'Keterangan'
        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }
}
