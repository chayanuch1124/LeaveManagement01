<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>แก้ไขข้อมูลการลา</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100">
    <div class="container mx-auto p-6 bg-white shadow-md rounded-lg mt-10 max-w-lg">
        <h2 class="text-2xl font-bold mb-4">แก้ไขข้อมูลการลา</h2>
        <form action="{{ route('leave.update', $leave->id) }}" method="POST">
            @csrf
            @method('PUT') <!-- Laravel ใช้เป็น PUT -->
            <input type="hidden" name="leave_id" value="1"> <!-- ใส่ค่า ID จริงของการลา -->
            <div class="mb-4">
                <label class="block">ประเภท:</label>
                <select name="type" id="type"
                    class="w-full p-2 border rounded-lg focus:ring focus:ring-blue-300">
                    <option value="{{ $leave->type }}">ลาป่วย</option>
                    <option value="vacation">ลาพักร้อน</option>
                    <option value="personal">ลากิจ</option>
                </select>
            </div>
            {{-- <input type="text" name="type" value="{{ $leave->type }}" class="w-full border p-2 rounded-md"> --}}

            <label class="block mt-2">วันที่เริ่ม:</label>
            <input type="date" name="start_date" value="{{ $leave->start_date }}"
                class="w-full border p-2 rounded-md">

            <label class="block mt-2">วันที่สิ้นสุด:</label>
            <input type="date" name="end_date" value="{{ $leave->end_date }}" class="w-full border p-2 rounded-md">
            <div class="mb-4">
                <label for="reason" class="block text-gray-700 font-semibold mb-1">เหตุผลในการลา</label>
                <textarea name="reason" id="reason" rows="3"
                    class="w-full p-2 border rounded-lg focus:ring focus:ring-blue-300 resize-none"
                    placeholder="กรุณากรอกเหตุผลในการลา...">{{ $leave->reason }}</textarea>
            </div>

            <!-- แสดงสถานะแต่ไม่ให้แก้ไข -->
            <p class="mt-2"><strong>สถานะ:</strong>
                <span class="px-2 py-1 rounded-md text-white bg-yellow-500">{{ $leave->status }}</span>
            </p>

            <button type="submit" class="mt-4 bg-green-500 text-white px-4 py-2 rounded-md">
                ✅ บันทึกการเปลี่ยนแปลง
            </button>
        </form>
    </div>
</body>

</html>
