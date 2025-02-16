<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\Leave;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class EmployeeController extends Controller
{
    /**
     * แสดงหน้า Dashboard ของพนักงาน
     */
    public function dashboard(Request $request)
    {
        $user = Auth::user();
        // dd(Auth::user()->name);
        $user = auth()->guard()->user();
        
        // $user = $auth->name;
        // dd(auth()->guard()->user()); // ดึงข้อมูลพzนักงานที่ล็อกอินอยู่
        // dd($user);
        // $employees = Employee::all(); // ✅ ถูกต้อง
        $employees = Employee::where('user_id', $user->id)->first();
        $leaves = Leave::where('employee_id', $user->id)->get();
        return view('employee_dashboard', compact('user', 'leaves','employees'));
    }

    /**
     * แสดงฟอร์มแก้ไขข้อมูลพนักงาน
     */
    public function editProfile()
    {
        $employee = Auth::user();
        return view('employee.edit_profile', compact('employee'));
    }

    /**
     * อัปเดตข้อมูลพนักงาน
     */
    public function updateProfile(Request $request)
    {
        $employee = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'position' => 'nullable|string|max:255',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'password' => 'nullable|string|min:6|confirmed',
        ]);

        // อัปเดตรูปภาพ
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('photos', 'public');
            $employee->photo = $photoPath;
        }

        // อัปเดตรายละเอียดอื่นๆ
        $employee->name = $request->name;
        $employee->phone = $request->phone;
        $employee->position = $request->position;

        // อัปเดตรหัสผ่านหากกรอกมาใหม่
        if ($request->password) {
            $employee->password = Hash::make($request->password);
        }

        /*$employee->save();*/

        return redirect()->route('employee.dashboard')->with('success', 'อัปเดตข้อมูลเรียบร้อยแล้ว');
    }

    /**
     * แสดงรายการพนักงานทั้งหมด (สำหรับ Admin หรือ Manager)
     */
    public function index()
    {
        $employee = Employee::all();
        return view('employee.index', compact('employee'));
    }

    /**
     * แสดงรายละเอียดของพนักงานแต่ละคน
     */
    public function show($id)
    {
        $employee = Employee::findOrFail($id);
        return view('employee.show', compact('employee'));
    }

    /**
     * ลบพนักงาน (เฉพาะ Admin เท่านั้น)
     */
    public function destroy($id)
    {
        $employee = Employee::findOrFail($id);
        $employee->delete();
        return redirect()->route('employee.index')->with('success', 'ลบพนักงานเรียบร้อยแล้ว');
    }
}
