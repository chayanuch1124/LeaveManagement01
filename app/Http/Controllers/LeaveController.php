<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Leave;
use Illuminate\Support\Facades\Auth;

class LeaveController extends Controller
{
    /**
     * แสดงฟอร์มขออนุมัติลา
     */
    public function create()
    {
        return view('leave.apply'); // เปิดหน้า leave.apply
    }

    /**
     * บันทึกข้อมูลการลา
     */
    public function store(Request $request)
    {
        $request->validate([
            'type' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        Leave::create([
            'employee_id' => Auth::id(),
            'type' => $request->type,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'reason' => $request->reason,
            'status' => 'pending',
        ]);

        return redirect()->route('dashboard')->with('success', 'ส่งคำขออนุมัติลาเรียบร้อยแล้ว');
    }

    /**
     * แสดงรายการการลาของพนักงาน
     */
    public function dashboard()
    {
        $leaves = Leave::where('employee_id', Auth::id())->get();
        return view('dashboard', compact('leaves'));
    }
    
    public function index()
    {
        $leaves = Leave::with('employee')->get();
        return view('leave.index', compact('leaves'));
    }

    /**
     * แสดงรายละเอียดใบลา (ดู)
     */
    public function show($id)
    {
        $leave = Leave::where('employee_id', Auth::id())->findOrFail($id);
        return view('leave.show', compact('leave'));
    }

    /**
     * แสดงฟอร์มแก้ไขใบลา
     */
    public function edit($id)
    {
        $leave = Leave::where('employee_id', Auth::id())->findOrFail($id);
        return view('leave.edit', compact('leave'));
    }

    /**
     * อัปเดตข้อมูลใบลา
     */
    public function update(Request $request, $id)
    {
        $leave = Leave::where('employee_id', Auth::id())->findOrFail($id);

        $request->validate([
            'type' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        $leave->update([
            'type' => $request->type,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'reason' => $request->reason,
        ]);

        return redirect()->route('dashboard')->with('success', 'อัปเดตใบลาเรียบร้อยแล้ว');
    }

    /**
     * ลบใบลา
     */
    public function destroy($id)
    {
        $leave = Leave::where('employee_id', Auth::id())->findOrFail($id);

        // ตรวจสอบว่าใบลานี้ได้รับการอนุมัติหรือไม่
        if ($leave->status === 'approved') {
            return redirect()->route('dashboard')->with('error', 'ไม่สามารถลบใบลาที่ได้รับการอนุมัติแล้ว');
        }

        $leave->delete();

        return redirect()->route('dashboard')->with('success', 'ลบใบลาเรียบร้อยแล้ว');
    }
}
