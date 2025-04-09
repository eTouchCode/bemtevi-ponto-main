<?php

namespace App\Models;

use App\Http\Controllers\Tenant\EmployeeController;
use App\Models\Admin\CentralEmployeeLogin;
use App\Notifications\InviteNotification;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasOneOrMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Log;
use Notification;
use Sqids\Sqids;
use Str;
use URL;

class Employee extends Model
{
    use SoftDeletes, HasFactory;

    const STATUS_VALUES = [
        0 => "Inactive",
        1 => "Available",
        2 => "Vacation",
        3 => "Injured",
    ];

    protected $fillable = [
        'name',
        'contract_start',
        'position_id',
        'pis',
        'cpf',
        'rg',
        'rg_number',
        'rg_emission',
        'drivers_license',
        'drivers_license_expiry',
        'drivers_license_type',
        'address',
        'number',
        'complement',
        'neighborhood',
        'cep',
        'email',
        'phone',
        'spouse',
        'dateofbirth',
        'status',
    ];

    public function getStatus()
    {
        return self::STATUS_VALUES[$this->status] ?? "N/A";
    }
    public function status()
    {
        return self::STATUS_VALUES;
    }

    public function family(): HasMany
    {
        return $this->hasMany(EmployeeFamily::class);
    }

    public function position(): BelongsTo
    {
        return $this->belongsTo(Position::class, 'position_id')->with('salary', 'workshift');
    }

    public function additionals(): BelongsToMany
    {
        return $this->belongsToMany(AdditionalPayment::class, 'employee_additionals', 'employee_id', 'additional_id');
    }

    public function user(): HasOne
    {
        return $this->hasOne(EmployeeLogin::class);
    }

    public function attendance(): HasMany
    {
        return $this->hasMany(EmployeeAttendance::class);
    }

    public function absence(): HasMany 
    {
        return $this->hasMany(EmployeeAbsence::class);
    }

    public static function createLogin(Employee $employee)
    {
        if (empty($employee->user()->first())) {
            try {
                do {
                    $token = Str::random(20);
                } while (EmployeeLogin::where('invite_token', $token)->first());

                $globalId = getRandomChars($employee->cpf);

                $sqids = new Sqids();

                $globalId = $sqids->encode($globalId);

                $employee->user()->create([
                    'global_id' => $globalId,
                    'employee_id' => $employee->id,
                    'email' => $employee->email,
                    'password' => null,
                    'invite_token' => $token,
                ]);

                $url = URL::action([EmployeeController::class, 'inviteLink'], ['token' => $token]);

                Notification::route('mail', $employee->email)->notify(new InviteNotification($url, tenant('name'), $employee));
            } catch (\Throwable $th) {
                Log::error($th->getMessage());
                CentralEmployeeLogin::where('global_id', $globalId)->delete();
                return false;
            }
            return true;
        }

        return false;
    }

    public function payments(): HasOneOrMany
    {
        return $this->hasMany(EmployeePayment::class);
    }
}
