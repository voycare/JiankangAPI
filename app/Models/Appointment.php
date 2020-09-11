<?php


namespace App\Models;


use App\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    const PENDING = 0;
    const CONFIRMED = 1;
    const CANCELLED = 2;
    const COMPLETED = 3;
    const RESCHEDULED = 4;
    const REFUNDED = 5;

    // State
    const PROCESSING = 1;
    const DONE = 2;

    // Specialty
    const COUNSELING = 1;
    const FERTILITY = 2;

    // Type
    const CONSULATION = 1;
    const SITE_VISIT = 2;

    public $timestamps = ['date'];
    protected $fillable = ['client_id', 'doctor_id', 'date', 'status', 'mode', 'type_id'];

    /**
     * @return array
     */
    public static function getSpecialtyOptions()
    {
        return [
            self::COUNSELING => 'Counseling',
            self::FERTILITY => 'Fertility'
        ];
    }

    /**
     * @return array
     */
    public static function getFertilityOptions()
    {
        return [
            1 => 'IVF',
            2 => 'Egg Freezing',
            3 => 'Embryo Freezing',
            4 => 'Surrogacy',
            5 => 'Egg Donations'
        ];
    }

    /**
     * @return array
     */
    public static function getCounselingOptions()
    {
        return [
            6 => 'Depression',
            7 => 'Anxiety',
            8 => 'Postpartum',
            9 => 'Domestic Violence',
            10 => 'Menopause',
            11 => 'Couple’s Counseling'
        ];
    }

    /**
     * @return array
     */
    public static function getTypeOptions()
    {
        return [
            1 => 'Online Consulation',
            2 => 'Site Visit'
        ];
    }

    /**
     * @return array
     */
    public static function getStatusOptions()
    {
        return [
            Appointment::PENDING => 'Pending',
            Appointment::CONFIRMED => 'Confirmed',
            Appointment::CANCELLED => 'Cancelled',
            Appointment::COMPLETED => 'Completed',
            Appointment::RESCHEDULED => 'Rescheduled'
        ];
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function client()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function clinic()
    {
        return $this->belongsTo(Clinic::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function schedule_times()
    {
        return $this->hasMany(AppointmentSchedule::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function cancellations()
    {
        return $this->hasMany(AppointmentCancellation::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function documents()
    {
        return $this->hasMany(AppointmentDocument::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function interpreter()
    {
        return $this->hasOne(Interpreter::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function treatment()
    {
        return $this->belongsTo(ClinicTreatment::class, 'treatment_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function payment()
    {
        return $this->belongsTo(Payment::class);
    }

    /**
     * @param Appointment $appt
     * @param $status
     * @param $message
     * @param $error_message
     * @param $schedule_item_id
     * @return bool
     */
    public static function updateStatusClient(Appointment &$appt, $status, &$message, &$error_message, $schedule_item_id = 0)
    {
        if (
            $status == Appointment::CANCELLED && $appt->status == Appointment::PENDING
        ) {
            $now = Carbon::now();
            $now = $now->addDays(2);
            if ($appt->date && $appt->date >= $now) {
                $error_message = 'Cannot cancel because appointment is within less than 48 hours.';
                return false;
            }

            $appt->status = Appointment::CANCELLED;
            $appt->save();
        }

        if (
            $status == Appointment::RESCHEDULED && $appt->status == Appointment::CONFIRMED
            && !empty($schedule_item_id)
        ) {
            $item = AppointmentSchedule::where('appointment_id', $appt->id)->where('id', intval($schedule_item_id))->first();
            if ($item) {
                $item->accept = true;
                $item->save();
            }
            $appt->date = $item->reschedule_time;
            $appt->status = Appointment::CONFIRMED;
            $appt->save();
            $message = 'Thank you for confirming your appointment!';
        }

        return true;
    }

    /**
     * @param Appointment $appt
     * @param $status
     * @param $message
     * @param $error_message
     * @param $schedule_item_id
     * @return bool
     */
    public static function updateStatusClinic(Appointment &$appt, $status, &$message, &$error_message)
    {
        if (
            $status == Appointment::CANCELLED && $appt->status == Appointment::PENDING
        ) {
            $now = Carbon::now();
            if ($now->diffInHours($appt->created_at) < 48) {
                $error_message = 'Cannot cancel because appointment is within less than 48 hours.';
                return false;
            }

            $appt->status = Appointment::CANCELLED;
            $appt->save();
        }

        if (
            $status == Appointment::CONFIRMED && $appt->status == Appointment::PENDING
        ) {
            $now = Carbon::now();
            if ($now->diffInHours($appt->created_at) >= 48) {
                $error_message = 'Cannot cancel because appointment is within less than 48 hours.';
                return false;
            }

            $message = 'Thank you for comfirming your appointment!';
            $appt->status = Appointment::CONFIRMED;
            $appt->save();
        }
    }
}
