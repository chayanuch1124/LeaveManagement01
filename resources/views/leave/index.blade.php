<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>รายการคำขอลางาน</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-6">

    <div class="max-w-5xl mx-auto bg-white shadow-md rounded-lg p-6">
        <h2 class="text-2xl font-bold text-gray-700 mb-4">📋 รายการคำขอลางาน</h2>

        @if(session('success'))
            <div class="p-3 bg-green-500 text-white rounded-md mb-4">
                {{ session('success') }}
            </div>
        @endif

        @if($leaves->isEmpty())
            <p class="text-center text-gray-500">ไม่มีคำขอลาที่รอพิจารณา</p>
        @else
        <table class="w-full bg-white border border-gray-300 rounded-lg">
            <thead class="bg-gray-200">
                <tr>
                    <th class="p-3 border">👤 พนักงาน</th>
                    <th class="p-3 border">📅 วันที่</th>
                    <th class="p-3 border">📌 ประเภท</th>
                    <th class="p-3 border">⚡ สถานะ</th>
                    <th class="p-3 border">🔍 ดูรายละเอียด</th>
                </tr>
            </thead>
            <tbody>
                @foreach($leaves as $leave)
                <tr class="text-center">
                    <td class="p-3 border">{{ $leave->employee->name }}</td>
                    <td class="p-3 border">{{ $leave->start_date }} - {{ $leave->end_date }}</td>
                    <td class="p-3 border">{{ ucfirst($leave->type) }}</td>
                    <td class="p-3 border">
                        <span class="px-2 py-1 rounded text-white 
                            {{ $leave->status == 'pending' ? 'bg-yellow-500' : ($leave->status == 'approved' ? 'bg-green-500' : 'bg-red-500') }}">
                            {{ ucfirst($leave->status) }}
                        </span>
                    </td>
                    <td class="p-3 border">
                        <a href="{{ route('leave.show', $leave->id) }}" 
                           class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600">
                            🔍 ดูรายละเอียด
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @endif
    </div>

</body>
</html>
