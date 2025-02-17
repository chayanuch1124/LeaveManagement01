<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>รายละเอียดคำขอลางาน</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-6">

    <div class="max-w-3xl mx-auto bg-white shadow-md rounded-lg p-6">
        <h2 class="text-2xl font-bold text-gray-700 mb-4">📌 รายละเอียดคำขอลางาน</h2>

        <p><strong>👤 พนักงาน:</strong> {{ $leave->employee->name }}</p>
        <p><strong>📌 ประเภท:</strong> {{ ucfirst($leave->type) }}</p>
        <p><strong>📅 วันที่:</strong> {{ $leave->start_date }} - {{ $leave->end_date }}</p>
        <p><strong>📝 เหตุผล:</strong> {{ $leave->reason }}</p>
        <p><strong>⚡ สถานะ:</strong> 
            <span class="px-2 py-1 rounded text-white {{ $leave->status == 'pending' ? 'bg-yellow-500' : ($leave->status == 'approved' ? 'bg-green-500' : 'bg-red-500') }}">
                {{ ucfirst($leave->status) }}
            </span>
        </p>

        <!-- ฟอร์มอนุมัติ / ปฏิเสธ -->
        <form action="{{ route('leave.approval.update', $leave->id) }}" method="POST" class="mt-3">
            @csrf
            @method('PUT')

            <label class="block text-gray-700 font-semibold mb-1">หมายเหตุ (ถ้ามี):</label>
            <textarea name="reason" class="w-full border rounded-md p-2 mb-2" placeholder="กรอกหมายเหตุ (ถ้าจำเป็น)"></textarea>

            <input type="hidden" name="status" id="status">
            <button type="submit" onclick="document.getElementById('status').value='approved'"
                class="bg-green-500 text-white px-4 py-2 rounded-md hover:bg-green-600">
                ✅ อนุมัติ
            </button>
            <button type="submit" onclick="document.getElementById('status').value='rejected'"
                class="bg-red-500 text-white px-4 py-2 rounded-md hover:bg-red-600">
                ❌ ปฏิเสธ
            </button>
        </form>

        <a href="{{ route('leave.index') }}" class="mt-4 inline-block text-blue-500 hover:underline">⬅️ กลับไปหน้ารายการ</a>
    </div>

</body>
</html>
