<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Vendor\Table;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function index()
    {
        $table = new Table('users');
        return view('layouts.index.index', [
            'columns' => $table->columns,
            'tableName' => $table->tableName,
            'title' => $table->title,
            'pageHasTable' => true,
        ]);
    }

    public function edit($id = 0)
    {
        if (Auth::user()->id != 1 && $id == 1) {
            return redirect()
                ->route('users.index');
        }

        $obj = $id > 0 ? User::findOrFail($id) : new User();

        if (request()->isMethod('post')) {
            $post = request()->get('form', []);

            Validator::make($post, [
                'name' => 'required|string|max:255',
                'password' => 'same:confirm_password|string|min:8',
                'confirm_password' => 'same:password|string|min:8',
                'email' => 'required|email|max:255|unique:users,email,' . $obj->getKey() . ',id',
            ])->validate();

            if ($post['password']) {
                $post['password'] = Hash::make($post['password']);
            } else {
                unset($post['password']);
            }
            unset($post['confirm_password']);

            DB::beginTransaction();
            try {
                $obj->fill($post);
                $obj->save();
                DB::commit();
            } catch (Exception $exception) {
                DB::rollBack();
                return redirect()
                    ->route('users.edit', ['id' => $obj->id])
                    ->with('danger', 'Something went wrong');
            }
            return redirect()
                ->route('users.edit', ['id' => $obj->id])
                ->with('success', 'User has been saved successfully');
        }

        return view('admin.users.edit', [
            'title' => 'Users',
            'obj' => $obj,
        ]);
    }

    public function delete($id)
    {
        if ($id == 1) {
            return redirect()
                ->route('users.index');
        }

        DB::beginTransaction();
        try {
            $obj = User::findOrFail($id);
            $obj->delete();
            DB::commit();
        } catch (Exception $exception) {
            DB::rollBack();

            return redirect()
                ->route('users.index')
                ->with('danger', 'Something went wrong');
        }
        return redirect()
            ->route('users.index')
            ->with('success', 'User deleted successfully');
    }
}
