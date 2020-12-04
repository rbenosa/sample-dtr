<?php

namespace App\Imports;

use App\User;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\SkipsFailures;

class UsersImport implements ToModel, WithHeadingRow, SkipsOnFailure, WithChunkReading
{
    use Importable, SkipsFailures;

    private $rows = 0, $users_detail = [];

    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {

        // dd($row);
        /* 
        * Count the number of imported rows
        * Only succesfully imported skipped rows are excluded
        */
        ++$this->rows;

        $parser         = new \TheIconic\NameParser\Parser();
        $parsed_name    = $parser->parse($row['employee_name']);
        $first_name     = $parsed_name->getFirstname();
        $last_name      = $parsed_name->getLastname();
        $_date          = intval($row['date']);
        $date           = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($_date)->format('Y-m-d');
        $time           = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['time'])->format('H:i:s');

        // $user = new User;
        $user = User::updateOrCreate(['first_name' => $first_name, 'last_name' => $last_name, 'date' => $date, 'time' => $time]);
        
        $user->first_name   = $first_name;
        $user->last_name    = $last_name;
        $user->date         = $date;
        $user->time         = $time;
        $user->save();


        array_push($this->users_detail, [
            'id'            => $user->id,
            'name'          => $last_name.', '. $first_name,
            'date'          => date('M d, Y', strtotime($date)),
            'time'          => date('h:i A', strtotime($time)),
            'updated_at'    => $user->updated_at,
        ]);



        return $user;
   
    }


    /* 
        * This will read the spreadsheet in chunks and keep the memory usage under control.
    */
    public function chunkSize(): int
    {
        return 2000;
    }

    /* 
    *   Returns the total number of imported rows
    */
    public function getRowCount(): int
    {
        return $this->rows;
    }

    /* 
    * Returns the details of the imported users
    */
    public function getUsers()
    {
        return $this->users_detail;
    }
}
