<!-- Shared Responsive Styles for LiveOn Pages -->
<style>
    /* Base Responsive Utilities */
    .responsive-container {
        padding: 20px 15px;
        max-width: 1400px;
        margin: 0 auto;
    }

    .responsive-grid-2 {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 20px;
    }

    .responsive-flex {
        display: flex;
        gap: 20px;
        flex-wrap: wrap;
    }

    /* Navigation Responsive */
    @media (max-width: 768px) {
        .nav-links-desktop {
            display: none !important;
        }
        
        .mobile-menu-toggle {
            display: flex !important;
        }
    }

    /* Grid Responsive Breakpoints */
    @media (max-width: 1200px) {
        .hide-on-lg {
            display: none !important;
        }
    }

    @media (max-width: 992px) {
        .responsive-grid-2 {
            grid-template-columns: 1fr;
        }
        
        .sidebar-left,
        .sidebar-right {
            display: none !important;
        }
    }

    @media (max-width: 768px) {
        .responsive-container {
            padding: 15px 10px;
        }
        
        .card-horizontal {
            flex-direction: column !important;
        }
        
        .hide-on-mobile {
            display: none !important;
        }
        
        .full-width-mobile {
            width: 100% !important;
        }
    }

    @media (max-width: 576px) {
        h1, .h1 {
            font-size: 1.75rem !important;
        }
        
        h2, .h2 {
            font-size: 1.5rem !important;
        }
        
        .btn-responsive {
            font-size: 0.85rem !important;
            padding: 8px 12px !important;
        }
    }
</style>
