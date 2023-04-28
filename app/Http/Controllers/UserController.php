<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Vendor\Table;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function index()
    {
        $table  = new Table('users');
        return view('layouts.index', [
            'columns' => $table->columns,
            'tableName' => $table->tableName,
            'title' => $table->title,
            'pageHasTable' => true,
        ]);
    }

    public function edit($id = 0)
    {
        $obj = $id > 0 ? User::find($id) : new User();

        if (request()->isMethod('post')) {
            request()->validate([
                'name' => 'required',
            ]);
            DB::beginTransaction();
            try {
                $obj->fill(request()->all());
                $obj->save();
                DB::commit();
            } catch (\Exception $exception) {
                DB::rollBack();
                throw $exception;
            }

            return redirect()->route('users.edit', ['id' => $obj->id]);
        }
        return view('admin.user.edit');
    }
}
