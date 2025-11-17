<?php

namespace App\Http\Controllers;

use App\Models\AgentPage;
use Illuminate\Http\Request;

class AgentPageController extends Controller
{
    public static function index(){
        if(auth()->user()->adminAccess->pages_management == 2){
            return redirect(route('admin.dashboard'))->with('error', 'Access Denied! You do not have permission to access this page.');
        }
        return view('admin.pages.agent-page',[
            'agentpage' => AgentPage::first(),
        ]);
    }

    public function update(Request $request)
    {
        if(auth()->user()->adminAccess->pages_management != 3){
            return redirect(route('admin.dashboard'))->with('error', 'Access Denied!');
        }
        $agent = AgentPage::firstOrNew(['id' => 1]);

        $validated = $request->validate([
            'description' => 'required',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        // ✅ Save image if uploaded
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = uniqid('agent_') . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('admin-assets/img/agent'), $filename);
            $validated['image'] = 'admin-assets/img/agent/' . $filename;
        }

        // ✅ Start with validated data
        $data = $validated;

        // ✅ Save all fields
        $agent->fill($data)->save();

        return response()->json([
            'success' => true,
            'message' => 'Agent page updated successfully!',
        ]);
    }
}
