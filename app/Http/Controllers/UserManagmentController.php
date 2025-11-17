<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class UserManagmentController extends Controller
{
    public static function users() {
        if(auth()->user()->adminAccess->user_management == 2){
            return redirect(route('admin.dashboard'))->with('error', 'Access Denied! You do not have permission to access this page.');
        }
        return view('admin.users.manage',[
           'users' => User::where('role', 1)->get(), 
        ]);
    }

    public function getData(Request $request)
    {
        if ($request->ajax()) {

            $users = User::where('role', 1)->withCount('bookings')->get();

            return DataTables::of($users)
                ->addIndexColumn()

                // 🧍 Name
                ->addColumn('name', function ($row) {
                    return e($row->name);
                })

                // 📧 Email
                ->addColumn('email', function ($row) {
                    return e($row->email);
                })

                // 📞 Phone
                ->addColumn('phone', function ($row) {
                    return e($row->phone ?? 'N/A');
                })

                // 📊 Total Bookings
                ->addColumn('total_bookings', function ($row) {
                    return $row->bookings_count;
                })

                // ✅ Status Column
                ->addColumn('status_display', function ($row) {
                    return $row->status == 1
                        ? '<span class="badge bg-success">Active</span>'
                        : '<span class="badge bg-danger">Blocked</span>';
                })

                // ⚙️ Action Buttons
                ->addColumn('action', function ($row) {
                    $deleteRoute = route('admin.users.deleted', $row->id);
                    $updateRoute = route('admin.users.update', [
                        'id' => $row->id,
                        'status' => $row->status == 1 ? 2 : 1,
                    ]);
                    $csrf = csrf_field();

                    $toggleButton = $row->status == 1
                        ? '<form action="' . $updateRoute . '" method="POST" class="d-inline update-status-form delete-confirm">
                            ' . $csrf . '
                            <button type="submit" class="btn btn-sm btn-warning">
                                Block
                            </button>
                        </form>'
                        : '<form action="' . $updateRoute . '" method="POST" class="d-inline update-status-form delete-confirm">
                            ' . $csrf . '
                            <button type="submit" class="btn btn-sm btn-success">
                                Activate
                            </button>
                        </form>';

                    $deleteButton = '<form action="' . $deleteRoute . '" method="POST" class="d-inline delete-confirm-form">
                            ' . $csrf . '
                            <button type="submit" class="btn btn-sm btn-danger">
                                <i class="fa fa-trash"></i>
                            </button>
                        </form>';
                    if (auth()->user()->adminAccess->user_management === 3)
                    return $toggleButton . ' ' . $deleteButton;
                    else
                        return 'N/A';
                })

                ->rawColumns(['status_display', 'action'])
                ->make(true);
        }
    }

    public function updateStatus($id, $status)
    {
        if(auth()->user()->adminAccess->user_management != 3){
            return redirect(route('admin.dashboard'))->with('error', 'Access Denied!');
        }
        $user = User::findOrFail($id);
        $user->status = $status;
        $user->save();

        $notification = new Notification();
        $notification->user_id = auth()->id();
        $notification->message = ' User status has been updated to ' . ($status == 1 ? 'Active' : 'Blocked') . '.';
        $notification->notification_for = 'User';
        $notification->item_id = $user->id;
        $notification->save();

        return response()->json(['message' => 'User status updated successfully!']);
    }


    public function delete($id)
        {
            if(auth()->user()->adminAccess->user_management != 3){
            return redirect(route('admin.dashboard'))->with('error', 'Access Denied!');
        }
            $User = User::findOrFail($id);
            $notification = new Notification();
            $notification->user_id = auth()->id();
            $notification->message = ' User has been deleted .';
            $notification->notification_for = 'User';
            $notification->item_id = $User->id;
            $notification->save();
            $User->delete();

            return response()->json(['message' => 'A User has been deleted']);
        }
}
