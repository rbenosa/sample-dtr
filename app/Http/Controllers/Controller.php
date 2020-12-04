<?php

namespace App\Http\Controllers;

use App\Imports\UsersImport;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\DB;
use App\User;
use Carbon\Carbon;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;


    public function index()
    {
        /* Get the current DateTime */
        $date = Carbon::now();


        $data = [
            'date'      => $date->toFormattedDateString(),
            'raw_date'  => $date->toDateString(),
            'time'      => $date->format('h:i'),
            'users'     => $this->get_users(),
        ];


        return view('welcome', $data);
    }



    public function get_users()
    {

        return User::where('deleted_at', null)->orderBy('id', 'desc')->paginate(10);

    }



    public function store_dtr(Request $request)
    {
        $this->validate($request, [
            'first_name' => [
                                'required',
                                'string',

                            ],
            'last_name' => [
                                'required',
                                'string',
                            ],
            'date'      => [
                                'required',
                                'date',
                                'date_format:Y-m-d',
                            ],
            'time'      => [
                                'required',
                                'date_format:H:i',
                            ],

        ]);

        
        // Set to variables
        $first_name     = $request->first_name;
        $last_name      = $request->last_name;
        $date           = $request->date;
        $time           = $request->time;
        


        // Insert ot datebase
        $user = new User;

        $user->first_name   = $first_name;
        $user->last_name    = $last_name;
        $user->date         = $date;
        $user->time         = $time;
        $user->save();

        $data = [
            'id'            => $user->id,
            'first_name'    => $first_name,
            'last_name'     => $last_name,
            'date'          => date('M d, Y', strtotime($date)),
            'time'          => date('h:i A', strtotime($time)),
        ];

        return $data;
        
    }



    public function update_dtr(Request $request)
    {

        $this->validate($request, [
            'first_name' => [
                                'required',
                                'string',

                            ],
            'last_name' => [
                                'required',
                                'string',
                            ],
            'date'      => [
                                'required',
                                'date',
                                'date_format:Y-m-d',
                            ],
            'time'      => [
                                'required',
                                'date_format:H:i',
                            ],
        ]);

        // Set to variables
        $first_name     = $request->first_name;
        $last_name      = $request->last_name;
        $date           = $request->date;
        $time           = $request->time;
        $id             = $request->id;

        User::where('id', $id)->update([
            'first_name'    => $first_name,
            'last_name'     => $last_name,
            'date'          => $date,
            'time'          => $time,
        ]);

        $data = [
            'first_name'    => $first_name,
            'last_name'     => $last_name,
            'date'          => date('M d, Y', strtotime($date)),
            'time'          => date('H:i A', strtotime($time)),
        ];

        return $data;


    }



    /* This function will download the template file in excel */
    public function template_dtr()
    {
        $path = storage_path('files\dtr-import-template.xls');

        return response()->download($path);
    }



    public function import_dtr(Request $request)
    {
        // dd($request->all());
        // * validate the excel file
        $this->validate(
            $request,
            [
                'dtr' => 'required|mimes:xls,xlsx,csv',
            ],
            [
                'dtr.required'   => 'You haven\'t uploaded an excel file.',
                'dtr.mimes'      => 'We only accept :values.',
            ]
        );

        
        
        $file           = $request->file('dtr');
    
        $import = new UsersImport;
    
        
        Excel::import($import, $file);


        $users = $import->getUsers();


        return [
            'users'  => $users
        ];

    }



    public function delete_dtr(Request $request)
    {
        $id = $request->id;
    
        $model = User::find($id);
        $model->delete();

        return $id;
    }



    public function restore_dtr(Request $request)
    {
        User::withTrashed()->find($request->id)->restore();

        $user = User::find($request->id)->toArray();

        $data = [
            'id'    => $user['id'],
            'name'  => $user['last_name'].', '. $user['first_name'],
            'date'  => date('M d, Y', strtotime($user['date'])),
            'time'  => date('g:i A', strtotime($user['time'])), 
        ];

        return $data;

    }
}
