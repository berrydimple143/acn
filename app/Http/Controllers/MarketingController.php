<?php

namespace App\Http\Controllers;

use Yajra\Datatables\Datatables;
use Illuminate\Http\Request;
use App\Http\Controllers\AdminController;
use App\EmailList;
use Carbon\Carbon;
use App\Exceptions\GeneralException;

class MarketingController extends Controller
{
    public function email_lists() {
		if(AdminController::isLogin()) {
            try {
				return view('admin.email_lists', ['title' => 'Email List Page', 'runningbg' => session('runningbg')]);
			} catch(\Exception $e) {
				throw new GeneralException("Oops! There was an error somewhere in the process.");
			}
        } else {
                return redirect()->route('login');
        }
	}
	
	public function data() {
		$lists = EmailList::where('customer_id', session('user')->customer_id);
        return Datatables::of($lists)			
            ->addColumn('action', function ($list) {
				$id = $list->id;								
                $buttons = '<center><a title="Edit this list" href="' . route('list.edit', ['id' => $id]) .'" class="btn btn-warning"><i class="fa fa-edit"></i></a>&nbsp;';
                $buttons .= '<a title="Delete this list" href="' . route('list.delete', ['id' => $id]) .'" class="btn btn-danger"><i class="fa fa-trash"></i></a>&nbsp;';
                $buttons .= '<a title="View emails in this list" href="' . route('list.emails', ['id' => $id]) .'" class="btn btn-success"><i class="fa fa-search"></i></a></center>';            
				return $buttons;
			})->addColumn('created_at', function($list) {
				$dt = new Carbon($list->created_at);
                $fmt = $dt->toDayDateTimeString();
                return $fmt;
			})->addColumn('updated_at', function($list) {
				$dt2 = new Carbon($list->updated_at);
                $fmt2 = $dt2->toDayDateTimeString();
                return $fmt2;
			})->rawColumns(['action'])->make(true);
	}
	
	public function list_add() {
		if(AdminController::isLogin()) {
			try {
				return view('admin.email_list_add', ['title' => 'Email List Add Page', 'runningbg' => session('runningbg')]);
			} catch(\Exception $e) {
				throw new GeneralException("Oops! There was an error somewhere in the process.");
			}
        } else {
            return redirect()->route('login');
        }
	}
	
	public function list_store(Request $request) {
		if(AdminController::isLogin()) {
			$v = $request->validate([				
				'name' => 'required|string|max:50',					
			]);
			try {
				$data = [				
					'customer_id' => session('user')->customer_id,
					'name' => $request->input('name', ''),								
				];
				$c = EmailList::create($data);	
				return redirect()->route('email.lists');
			} catch(\Exception $e) {
				throw new GeneralException("Oops! There was an error somewhere in the process.");
			}
		} else {
            return redirect()->route('login');
        }
	}
	
	public function list_edit($id) {
		if(AdminController::isLogin()) {
			try {
				$list = EmailList::where('id', $id)->first();
				return view('admin.email_list_edit', ['title' => 'Email List - Edit Page', 'list' => $list, 'runningbg' => session('runningbg')]);
			} catch(\Exception $e) {
				throw new GeneralException("Oops! There was an error somewhere in the process.");
			}
		} else {
            return redirect()->route('login');
        }
	}
	
	public function list_update(Request $request, $id) {
		if(AdminController::isLogin()) {
			$v = $request->validate([				
				'name' => 'required|string|max:50',					
			]);
			try {
				$data = ['name' => $request->input('name', ''),];
				$l = EmailList::where('id', $id)->update($data);
				return redirect()->route('email.lists');
			} catch(\Exception $e) {
				throw new GeneralException("Oops! There was an error somewhere in the process.");
			}
		} else {
            return redirect()->route('login');
        }
	}
	
	public function list_delete($id) {
		if(AdminController::isLogin()) {
			try {
				$list = EmailList::where('id', $id)->first();
				return view('admin.email_list_delete', ['title' => 'Email List - Delete Page', 'list' => $list, 'runningbg' => session('runningbg')]);
			} catch(\Exception $e) {
				throw new GeneralException("Oops! There was an error somewhere in the process.");
			}
		} else {
            return redirect()->route('login');
        }
	}
	
	public function list_destroy($id) {
		if(AdminController::isLogin()) {
			try {
				$ls = EmailList::where('id', $id)->where('customer_id', session('user')->customer_id)->delete();				
				return redirect()->route('email.lists');
			} catch(\Exception $e) {
				throw new GeneralException("Oops! There was an error somewhere in the process.");
			}
		} else {
            return redirect()->route('login');
        }
    }
}
