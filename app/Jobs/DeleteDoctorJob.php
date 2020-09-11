<?php


namespace App\Jobs;


use App\Models\Doctor;

class DeleteDoctorJob extends Job
{
    protected $idClinic;

    public function __construct($idClinic)
    {
        $this->idClinic = $idClinic;
    }

    public function handle()
    {
        Doctor::where('clinic_id', $this->idClinic)->delete();
    }
}
