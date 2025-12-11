<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'LiveOn - Find Concert Buddies')</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        :root {
            --primary-color: #FF6B6B;
            --secondary-color: #FFE66D;
            --dark-color: #2C3E50;
            --light-color: #ECF0F1;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f8f9fa;
            color: var(--dark-color);
        }

        .navbar {
            /* Custom navbar styles removed - using inline styles instead */
        }

        .navbar-brand {
            /* Custom navbar-brand styles removed - using inline styles instead */
        }

        .nav-link {
            /* Custom nav-link styles removed - using inline styles instead */
        }

        .nav-link:hover {
            /* Custom nav-link:hover styles removed - using inline styles instead */
        }

        .nav-link.active {
            /* Custom nav-link.active styles removed - using inline styles instead */
        }

        .navbar-toggler {
            border: none;
            padding: 0.25rem 0.75rem;
        }

        .navbar-toggler:focus {
            box-shadow: none;
            outline: none;
        }

        .navbar-toggler-icon {
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 30 30'%3e%3cpath stroke='%23666' stroke-linecap='round' stroke-miterlimit='10' stroke-width='2' d='M4 7h22M4 15h22M4 23h22'/%3e%3c/svg%3e");
        }

        .btn-primary {
            background-color: var(--primary-color);
            border: none;
            transition: 0.3s;
        }

        .btn-primary:hover {
            background-color: #FF5252;
            transform: translateY(-2px);
        }

        .btn-secondary {
            background-color: var(--secondary-color);
            color: var(--dark-color);
            border: none;
        }

        .btn-secondary:hover {
            background-color: #FDD835;
            color: var(--dark-color);
        }

        .card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            transition: 0.3s;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.15);
        }

        .concert-post {
            border-left: 5px solid var(--primary-color);
            padding: 20px;
            background: white;
            border-radius: 8px;
            margin-bottom: 20px;
            transition: 0.3s;
        }

        .concert-post:hover {
            box-shadow: 0 5px 20px rgba(0,0,0,0.1);
        }

        .header-auth {
            background: linear-gradient(135deg, var(--primary-color), #FF5252);
            color: white;
            padding: 40px 0;
            margin-bottom: 40px;
        }

        .input-group-text {
            background-color: var(--light-color);
            border: 1px solid #ddd;
        }

        .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.2rem rgba(255, 107, 107, 0.25);
        }

        .alert {
            border-radius: 8px;
            border: none;
        }

        .alert-danger {
            background-color: #FFE5E5;
            color: #C41E3A;
        }

        .badge-primary {
            background-color: var(--primary-color);
        }

        .badge-warning {
            background-color: var(--secondary-color);
            color: var(--dark-color);
        }

        .profile-header {
            position: relative;
            background: linear-gradient(135deg, var(--primary-color), #FF5252);
            color: white;
            padding: 30px 0;
            margin-bottom: 40px;
        }

        .profile-pic {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            object-fit: cover;
            border: 5px solid white;
            margin-top: -60px;
        }

        .modal-content {
            border: none;
            border-radius: 10px;
        }

        .modal-header {
            background: linear-gradient(135deg, var(--primary-color), #FF5252);
            color: white;
            border: none;
        }

        .text-time {
            font-size: 0.85rem;
            color: #999;
            margin-top: 5px;
        }

        .spot-filled {
            display: inline-block;
            background: var(--primary-color);
            color: white;
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 0.85rem;
        }

        @media (max-width: 768px) {
            .navbar {
                padding: 1rem 0.5rem;
            }

            .nav-link {
                margin: 5px 0;
                font-size: 0.9rem;
            }

            .concert-post {
                padding: 15px;
            }

            .profile-pic {
                width: 80px;
                height: 80px;
            }

            .header-auth {
                padding: 30px 0;
                margin-bottom: 30px;
            }
        }

        .join-btn {
            min-width: 80px;
        }

        .message-item {
            padding: 15px;
            border-bottom: 1px solid #eee;
            cursor: pointer;
            transition: 0.3s;
        }

        .message-item:hover {
            background-color: #f5f5f5;
        }

        .message-item.unread {
            background-color: #FFF3CD;
        }

        .message-text {
            padding: 12px 15px;
            border-radius: 8px;
            margin-bottom: 10px;
            max-width: 70%;
        }

        .message-text.sent {
            background-color: var(--primary-color);
            color: white;
            margin-left: auto;
        }

        .message-text.received {
            background-color: #f0f0f0;
            color: var(--dark-color);
        }

        .messages-container {
            display: flex;
            flex-direction: column;
            height: 500px;
            overflow-y: auto;
            padding: 20px;
        }

        .input-message-group {
            display: flex;
            gap: 10px;
            padding: 15px;
            background: white;
            border-top: 1px solid #ddd;
        }

        .input-message-group input {
            flex: 1;
        }

        .input-message-group button {
            padding: 10px 20px;
        }

        .summary-card {
            background: linear-gradient(135deg, var(--primary-color), #FF5252);
            color: white;
            padding: 20px;
            border-radius: 10px;
            text-align: center;
            margin-bottom: 20px;
        }

        .summary-card h3 {
            font-size: 2rem;
            margin-bottom: 5px;
        }

        .summary-card p {
            font-size: 0.9rem;
            opacity: 0.9;
        }

        .filter-section {
            background: white;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 30px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }

        .hero-section {
            background: linear-gradient(135deg, var(--primary-color), #FF5252);
            color: white;
            padding: 100px 20px;
            text-align: center;
        }

        .hero-section h1 {
            font-size: 3rem;
            margin-bottom: 20px;
            font-weight: 700;
        }

        .hero-section p {
            font-size: 1.2rem;
            margin-bottom: 30px;
            opacity: 0.95;
        }

        .hero-buttons {
            display: flex;
            gap: 15px;
            justify-content: center;
            flex-wrap: wrap;
        }

        .info-section {
            padding: 60px 20px;
        }

        .info-card {
            text-align: center;
            padding: 30px;
        }

        .info-card i {
            font-size: 2.5rem;
            color: var(--primary-color);
            margin-bottom: 15px;
        }

        .info-card h3 {
            margin-bottom: 15px;
            font-weight: 600;
        }

        @media (max-width: 576px) {
            .hero-section h1 {
                font-size: 2rem;
            }

            .hero-section p {
                font-size: 1rem;
            }

            .hero-buttons {
                flex-direction: column;
            }

            .hero-buttons a {
                width: 100%;
            }

            .message-text {
                max-width: 90%;
            }
        }
    </style>
</head>
<body>
    @include('components.navbar')
    @yield('content')
    
    @include('components.create-post-modal')
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Auto-hide alerts after 5 seconds
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(alert => {
                setTimeout(() => {
                    const bsAlert = new bootstrap.Alert(alert);
                    bsAlert.close();
                }, 5000);
            });

            // Scroll to bottom in messages
            const messagesContainer = document.querySelector('.messages-container');
            if (messagesContainer) {
                messagesContainer.scrollTop = messagesContainer.scrollHeight;
            }
        });
    </script>
</body>
</html>
