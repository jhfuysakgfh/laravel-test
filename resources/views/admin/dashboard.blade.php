
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AI Teacher | Admin Dashboard</title>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Arial, sans-serif;
            background: #f5f6fc;
            color: #252747;
        }

        .layout {
            display: flex;
            min-height: 100vh;
        }

        /* Sidebar */

        .sidebar {
            width: 250px;
            background: #201b4b;
            color: white;
            padding: 28px 18px;
            flex-shrink: 0;
        }

        .brand {
            font-size: 24px;
            font-weight: 800;
            padding: 0 12px;
            margin-bottom: 45px;
        }

        .brand span {
            color: #a99bff;
        }

        .menu-label {
            color: #a7a2c7;
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 1px;
            padding: 0 12px;
            margin: 25px 0 12px;
        }

        .menu-item {
            display: block;
            color: #d5d1ec;
            text-decoration: none;
            padding: 13px 14px;
            border-radius: 9px;
            margin-bottom: 6px;
            font-size: 14px;
        }

        .menu-item.active {
            background: #6554ce;
            color: white;
        }

        .menu-item:hover {
            background: rgba(255,255,255,.1);
        }

        /* Main content */

        .main {
            flex: 1;
            min-width: 0;
        }

        .topbar {
            background: white;
            padding: 20px 35px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid #ececf4;
        }

        .topbar h2 {
            font-size: 21px;
        }

        .admin-info {
            display: flex;
            align-items: center;
            gap: 12px;
            font-size: 13px;
        }

        .avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: #eeeaff;
            color: #6554ce;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 800;
        }

        .content {
            padding: 35px;
        }

        .welcome {
            background: linear-gradient(110deg, #5142b8, #8572ed);
            padding: 30px;
            border-radius: 16px;
            color: white;
            margin-bottom: 30px;
        }

        .welcome h1 {
            font-size: 25px;
            margin-bottom: 10px;
        }

        .welcome p {
            color: #e7e3ff;
            font-size: 14px;
            line-height: 1.7;
        }

        .section-title {
            font-size: 18px;
            margin-bottom: 18px;
        }

        .stats {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 18px;
            margin-bottom: 30px;
        }

        .stat-card {
            background: white;
            border-radius: 13px;
            padding: 22px;
            border: 1px solid #ededf5;
        }

        .stat-icon {
            font-size: 25px;
            margin-bottom: 17px;
        }

        .stat-card h3 {
            font-size: 25px;
            margin-bottom: 7px;
        }

        .stat-card p {
            color: #85889f;
            font-size: 13px;
        }

        .bottom-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }

        .panel {
            background: white;
            border: 1px solid #ededf5;
            border-radius: 13px;
            padding: 24px;
        }

        .panel h3 {
            font-size: 16px;
            margin-bottom: 18px;
        }

        .panel-item {
            padding: 14px 0;
            border-bottom: 1px solid #f0f0f5;
            font-size: 14px;
            color: #656982;
        }

        .panel-item:last-child {
            border-bottom: none;
        }

        .logout-button {
            border: none;
            background: #fff0f0;
            color: #d04444;
            padding: 9px 14px;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
        }

        .logout-button:hover {
            background: #ffe0e0;
        }

        @media(max-width: 1000px) {
            .stats {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media(max-width: 700px) {
            .sidebar {
                display: none;
            }

            .topbar {
                padding: 17px;
            }

            .content {
                padding: 18px;
            }

            .bottom-grid {
                grid-template-columns: 1fr;
            }
        }

        @media(max-width: 450px) {
            .stats {
                grid-template-columns: 1fr;
            }

            .admin-info span {
                display: none;
            }
        }
    </style>
</head>

<body>

<div class="layout">

    <!-- Sidebar -->
    <aside class="sidebar">

        <div class="brand">
            AI <span>Teacher.</span>
        </div>

        <div class="menu-label">MAIN MENU</div>

        <a href="{{ route('admin.dashboard') }}" class="menu-item active">
            🏠 Dashboard
        </a>

        <div class="menu-label">ACADEMIC MANAGEMENT</div>

        <div class="menu-item">📚 Books Management</div>
        <div class="menu-item">🎓 Boards & Classes</div>
        <div class="menu-item">📖 Subjects & Chapters</div>
        <div class="menu-item">🎬 Lessons Management</div>

        <div class="menu-label">PLATFORM MANAGEMENT</div>

        <div class="menu-item">🤖 AI Teacher</div>
        <div class="menu-item">👨‍🎓 Students</div>
        <div class="menu-item">💳 Payments</div>
        <div class="menu-item">⚙️ Settings</div>

    </aside>

    <!-- Main Content -->
    <main class="main">

        <header class="topbar">

            <h2>Dashboard Overview</h2>

            <div class="admin-info">

                <div class="avatar">
                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                </div>

                <span>{{ auth()->user()->name }}</span>

                <form method="POST" action="{{ route('admin.logout') }}">
                    @csrf
                    <button type="submit" class="logout-button">
                        Logout
                    </button>
                </form>

            </div>

        </header>

        <div class="content">

            <section class="welcome">
                <h1>Welcome back, {{ auth()->user()->name }}! 👋</h1>

                <p>
                    Manage your AI-powered learning platform from one place.
                    Create educational books, organize lessons and monitor
                    your students' learning journey.
                </p>
            </section>

            <h3 class="section-title">Platform Overview</h3>

            <section class="stats">

                <div class="stat-card">
                    <div class="stat-icon">📚</div>
                    <h3>{{ $totalBooks }}</h3>
                    <p>Total Books</p>
                </div>

                <div class="stat-card">
                    <div class="stat-icon">🎓</div>
                    <h3>{{ $totalClasses  }}</h3>
                    <p>Total Classes</p>
                </div>

                <div class="stat-card">
                    <div class="stat-icon">📖</div>
                    <h3>{{ $totalLessons }}</h3>
                    <p>Total Lessons</p>
                </div>

                <div class="stat-card">
                    <div class="stat-icon">👨‍🎓</div>
                    <h3>{{ $totalStudents }}</h3>
                    <p>Total Students</p>
                </div>

            </section>

            <section class="bottom-grid">

                <div class="panel">
                    <h3>📚 Academic Management</h3>

                    <div class="panel-item">
                        Manage educational books
                    </div>

                    <div class="panel-item">
                        Organize boards, classes and subjects
                    </div>

                    <div class="panel-item">
                        Create chapters and daily lessons
                    </div>
                </div>

                <div class="panel">
                    <h3>🤖 AI Teacher Management</h3>

                    <div class="panel-item">
                        Manage bilingual lesson content
                    </div>

                    <div class="panel-item">
                        Manage AI-generated teaching videos
                    </div>

                    <div class="panel-item">
                        Review and approve educational content
                    </div>
                </div>

            </section>

        </div>

    </main>

</div>

</body>
</html>
