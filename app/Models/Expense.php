<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    protected $guarded = [];

    protected static function booted()
    {
        static::creating(function($model) {
            $model->expenses_id = 'YC'.date('ymdhi');
        });
    }

    public function expenseStatus()
    {
        return $this->belongsTo(ExpenseStatus::class);
    }

    public function term()
    {
        return $this->belongsTo(Term::class);
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function source()
    {
        return $this->belongsTo(Source::class);
    }

    public function contractor()
    {
        return $this->belongsTo(Contractor::class);
    }

    public function contractorCategory()
    {
        return $this->belongsTo(ContractorCategory::class);
    }
}
