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
            width: 220px;
        }

        .menu-item {
            display: flex;
            align-items: center;
            padding: 0.75rem;
            transition: background-color 0.3s;
            cursor: pointer;
        }

        .menu-item:hover {
            background-color: #e2e8f0;
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
            <h2 class="text-lg font-semibold text-gray-700">S</h2>
        </div>
        <nav class="flex-1 px-2 py-6">
            <ul class="space-y-4">
                <li class="menu-item">
                    <a href="{{ route('dashboard') }}" class="flex items-center">
                        <span class="text-gray-600 hover:text-gray-900">📊</span>
                        <span class="menu-text text-sm font-medium text-gray-700">Dashboard</span>
                    </a>
                </li>
                <li class="menu-item">
                    <span class="text-gray-600 hover:text-gray-900">📅</span>
                    <span class="menu-text text-sm font-medium text-gray-700">Calendar</span>
                </li>
                <li class="menu-item">
                    <span class="text-gray-600 hover:text-gray-900">📝</span>
                    <span class="menu-text text-sm font-medium text-gray-700">Leave Form</span>
                </li>
                <li class="menu-item">
                    <span class="text-gray-600 hover:text-gray-900">📜</span>
                    <span class="menu-text text-sm font-medium text-gray-700">Leave History</span>
                </li>
            </ul>
        </nav>
        <div class="p-4 border-t">
            <button id="toggleSidebar" class="w-full text-left text-gray-600 font-semibold">
                ☰ Toggle
            </button>
        </div>
    </div>

    <!-- Main Content -->
    <div id="content" class="flex-1 p-8 ml-20 transition-all duration-300">
        <div class="max-w-lg mx-auto bg-white shadow-md rounded-lg p-6">
            <h2 class="text-2xl font-bold text-gray-700 mb-4 text-center">ขออนุมัติลา</h2>

            <!-- Leave Form -->
            <form action="{{ route('leave.store') }}" method="POST">
                @csrf

                <div class="mb-4">
                    <label for="type" class="block text-gray-700 font-semibold mb-1">ประเภทการลา</label>
                    <select name="type" id="type"
                        class="w-full p-2 border rounded-lg focus:ring focus:ring-blue-300">
                        <option value="sick">ลาป่วย</option>
                        <option value="vacation">ลาพักร้อน</option>
                        <option value="personal">ลากิจ</option>
                    </select>
                </div>

                <div class="mb-4">
                    <label for="start_date" class="block text-gray-700 font-semibold mb-1">วันที่เริ่มลา</label>
                    <input type="date" name="start_date"
                        class="w-full p-2 border rounded-lg focus:ring focus:ring-blue-300">
                </div>

                <div class="mb-4">
                    <label for="end_date" class="block text-gray-700 font-semibold mb-1">วันที่สิ้นสุดลา</label>
                    <input type="date" name="end_date"
                        class="w-full p-2 border rounded-lg focus:ring focus:ring-blue-300">
                </div>

                <!-- Reason for Leave -->
                <div class="mb-4">
                    <label for="reason" class="block text-gray-700 font-semibold mb-1">เหตุผลในการลา</label>
                    <textarea name="reason" id="reason" rows="3"
                        class="w-full p-2 border rounded-lg focus:ring focus:ring-blue-300 resize-none"
                        placeholder="กรุณากรอกเหตุผลในการลา..."></textarea>
                </div>

                <button type="submit"
                    class="w-full bg-blue-600 text-white py-2 rounded-lg font-semibold hover:bg-blue-700 transition duration-300">
                    ✉️ ส่งคำขอ
                </button>
            </form>
        </div>
    </div>

    <!-- Sidebar Toggle Script -->
    <script>
        document.getElementById('toggleSidebar').addEventListener('click', function() {
            document.getElementById('sidebar').classList.toggle('open');
        });
    </script>

</body>

</html>
