<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReportRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        return [
            'report_type' => ['required', 'string', 'in:presence,evaluation,department,direction,employee'],
            'period' => ['required', 'string', 'in:daily,weekly,monthly,quarterly,semester,yearly,custom'],
            'start_date' => ['nullable', 'date'],
            'end_date' => ['nullable', 'date', 'after_or_equal:start_date'],
            'department_id' => ['nullable', 'integer', 'exists:departements,id'],
            'direction_id' => ['nullable', 'integer', 'exists:directions,id'],
            'employe_id' => ['nullable', 'integer', 'exists:employes,id'],
            'status' => ['nullable', 'string'],
        ];
    }
}
