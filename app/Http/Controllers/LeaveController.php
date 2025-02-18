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
        // ดึงข้อมูลการลางานโดยตรวจสอบบทบาทของผู้ใช้
        $leave = Leave::findOrFail($id);

        // ตรวจสอบสิทธิ์: admin หรือเจ้าของข้อมูล
        if (Auth::user()->role !== 'admin' && $leave->employee_id !== Auth::id()) {
            abort(403, 'คุณไม่มีสิทธิ์เข้าถึงหน้านี้');
        }

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

    public function updateStatus(Request $request, $id)
    {
        // Find the leave record by ID
        $leave = Leave::findOrFail($id);

        // Ensure the user has the right to update the status
        if (Auth::user()->role !== 'admin' && $leave->employee_id !== Auth::id()) {
            abort(403, 'คุณไม่มีสิทธิ์ในการเปลี่ยนแปลงสถานะการลา');
        }

        // Validate status input (approved or rejected)
        $request->validate([
            'status' => 'required|in:approved,rejected',
        ]);

        // Update the status first
        $leave->update([
            'status' => $request->status,
        ]);

        // If status is approved, deduct the leave days
        if ($request->status == 'approved') {
            // ตรวจสอบว่าใครเป็นเจ้าของใบลา
            $employee = \App\Models\Employee::findOrFail($leave->employee_id); // หาพนักงานจาก employee_id ของใบลา

            $startDate = \Carbon\Carbon::parse($leave->start_date);  // Convert start_date to Carbon instance
            $endDate = \Carbon\Carbon::parse($leave->end_date);  // Convert end_date to Carbon instance

            // Calculate the number of days the employee is taking off
            $daysOff = $startDate->diffInDays($endDate) +1 ; // +1 to include the start date

            // Deduct the leave days from the employee
            $employee->leave_balance -= $daysOff;  // Deduct the leave days from the employee's balance

            // Save the updated employee leave balance
            $employee->save();  // Save the changes to the employee's leave balance
        }

        // Return the user back to the dashboard with a success message
        return redirect()->route('leave.index')->with('success', 'อัปเดตสถานะการลาเรียบร้อยแล้ว');
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
