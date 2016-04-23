<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Models\Discussion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DiscussionController extends Controller
{
	public function store(Request $request)
	{
		$this->validate($request, [
			'classroom_id' => 'required|exists:classrooms,id',
			'user_id' => 'required|exists:users,id',
			'content' => 'required'
		], [
			'exists' => 'Data :attribute belum terdaftar.',
			'required' => 'Kolom :attribute diperlukan!'
		]);

		if($request->user_id === Auth::user()->id) {
			Discussion::create($request->all());

			\Flash::success('Diskusi berhasil ditambahkan.');

			return redirect()->back();
		}

		return;
	}

    public function destroy($id, Request $request)
    {
    	Discussion::findOrFail($id)->delete();

        \Flash::success('Diskusi berhasil dihapus.');

        return redirect()->route('classrooms.show', $request->classroom);
    }
}