<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        #sidebar {
            width: 64px;
            overflow: hidden;
            transition: width 0.3s;
        }

        #sidebar.open {
            width: 200px;
        }

        .menu-item {
            display: flex;
            align-items: center;
            padding: 0.75rem;
            transition: background-color 0.3s;
        }

        .menu-item:hover {
            background-color: #f3f4f6;
        }

        .menu-text {
            margin-left: 0.75rem;
            white-space: nowrap;
            opacity: 0;
            transition: opacity 0.3s;
        }

        #sidebar.open .menu-text {
            opacity: 1;
        }
    </style>
</head>

<body class="bg-gray-100 flex">
    <!-- Sidebar -->
    <div id="sidebar" class="fixed top-0 left-0 bg-white shadow-md h-full flex flex-col transition-all duration-300">
        <div class="flex items-center justify-center py-4 border-b">
            <h2 class="text-lg font-semibold">S</h2>
        </div>
        <nav class="flex-1 px-2 py-6">
            <ul class="space-y-6">
                <a href="{{ route('dashboard') }}" <li class="menu-item">
                    <span class="text-gray-600 hover:text-gray-900">📊</span>
                    <span class="menu-text text-sm font-medium text-gray-600">Dashboard</span>

                    </li>
                </a>
                <li class="menu-item">
                    <span class="text-gray-600 hover:text-gray-900">📅</span>
                    <span class="menu-text text-sm font-medium text-gray-600">Calendar</span>
                </li>
                <a href="{{ route('leave.apply') }}" <li class="menu-item">
                    <span class="text-gray-600 hover:text-gray-900">📝</span>
                    <span class="menu-text text-sm font-medium text-gray-600">Leave Form</span>
                    </li>
                </a>
                <li class="menu-item">
                    <span class="text-gray-600 hover:text-gray-900">📜</span>
                    <span class="menu-text text-sm font-medium text-gray-600">Leave History</span>
                </li>
                <div class="p-4 border-t">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="w-full text-left text-red-600 hover:text-red-800">
                            <span class="menu-text text-sm font-medium text-gray-600">🚪log out</span>
                        </button>
                    </form>
                </div>

            </ul>
        </nav>
        <div class="p-4 border-t">
            <button id="toggleSidebar" class="w-full text-left text-gray-600">☰ Toggle</button>
        </div>
    </div>

    <!-- Content -->
    <div id="content" class="flex-1 p-6 ml-16 transition-all duration-300">
        <div class="mb-6 flex items-center justify-between">
            <h1 class="text-2xl font-bold">Employee Dashboard</h1>
        </div>

        <div class="employee-container bg-white rounded-lg shadow-md p-6">
            <!-- Employee Profile Section -->

            <div class="flex justify-between items-center mb-6">

                <div class="flex items-center space-x-4">
                    <img src="{{ $employees->photo }}" alt="Employee Photo" class="w-24 h-24 rounded-full">
                    <div>
                        <h2 class="text-xl font-semibold">{{ $employees->name }}</h2>
                        <p class="text-gray-600">ตำแหน่ง: {{ $employees->position }}</p>
                    </div>
                </div>
                <div class="text-right">
                    <p class="text-gray-600">โทร: {{ $employees->phone }}</p>
                    <p class="text-gray-600">อีเมล: {{ $employees->email }}</p>
                </div>


            </div>

            <!-- Leave Balance -->
            <div class="bg-gray-50 p-4 rounded-md mb-6">
                <h3 class="text-lg font-semibold">วันลาคงเหลือ {{ $employees->leave_balance }} วัน</h3>

                <a href="{{ route('leave.apply') }}"
                    class="mt-2 inline-block bg-blue-600 text-white px-4 py-2 rounded-md">
                    📝 ยื่นขอลางาน
                </a>
            </div>

            <!-- Leave History -->
            <h3 class="text-lg font-semibold mb-4">ประวัติการลา</h3>
            <table class="w-full border-collapse border border-gray-200">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="border border-gray-200 px-4 py-2 text-left">ประเภท</th>
                        <th class="border border-gray-200 px-4 py-2 text-left">วันที่เริ่ม</th>
                        <th class="border border-gray-200 px-4 py-2 text-left">วันที่สิ้นสุด</th>
                        <th class="border border-gray-200 px-4 py-2 text-left">สถานะ</th>
                        <th class="border border-gray-200 px-4 py-2 text-center">จัดการ</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($leaves as $leave)
                        <tr>
                            <td class="border border-gray-200 px-4 py-2">{{ $leave->type }}</td>
                            <td class="border border-gray-200 px-4 py-2">{{ $leave->start_date }}</td>
                            <td class="border border-gray-200 px-4 py-2">{{ $leave->end_date }}</td>
                            <td class="border border-gray-200 px-4 py-2">
                                <span
                                    class="px-2 py-1 rounded-md text-white 
                                    {{ $leave->status == 'approved' ? 'bg-green-500' : ($leave->status == 'pending' ? 'bg-yellow-500' : 'bg-red-500') }}">
                                    {{ ucfirst($leave->status) }}
                                </span>
                            </td>
                            
                            <td class="border border-gray-200 px-4 py-2 text-center">
                                @if ($leave->status !== 'approved')
                                    <a href="{{ route('leave.edit', $leave->id) }}" class="bg-yellow-500 text-white px-2 py-1 rounded-md">
                                        ✏️ แก้ไข
                                    </a>
                            
                                    <form action="{{ route('leave.destroy', $leave->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="bg-red-500 text-white px-2 py-1 rounded-md" 
                                            onclick="return confirm('คุณแน่ใจหรือไม่ว่าต้องการลบใบลานี้?');">
                                            🗑️ ลบ
                                        </button>
                                    </form>
                                @else
                                    <span class="text-gray-400">🔒 ไม่สามารถแก้ไขหรือลบได้</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

        </div>
    </div>

    <script>
        document.getElementById('toggleSidebar').addEventListener('click', function() {
            document.getElementById('sidebar').classList.toggle('open');
        });
    </script>
</body>

</html>
