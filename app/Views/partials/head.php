<?php
/**
 * Shared document head + opening <body>.
 * Dark-mode only. Tailwind via the Play CDN with the GGAMES brand theme
 * (orange + green accents on a dark neutral base).
 *
 * Expects (optional): $title
 */
$pageTitle = isset($title) ? $title : 'GGAMES';
?>
<!DOCTYPE html>
<html lang="de" class="dark">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= e($pageTitle) ?></title>
    <link rel="shortcut icon" href="assets/favicon.ico">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Russo+One&display=swap" rel="stylesheet">

    <!-- Icons -->
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>

    <!-- Tailwind (Play CDN) + brand theme -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        brand: {
                            orange: '#f97316',
                            'orange-soft': '#fb923c',
                            green: '#22c55e',
                            'green-soft': '#4ade80',
                        },
                    },
                    fontFamily: {
                        sans: ['Inter', 'ui-sans-serif', 'system-ui', 'sans-serif'],
                        display: ['"Russo One"', 'Inter', 'sans-serif'],
                    },
                    keyframes: {
                        'fade-in': {
                            '0%': { opacity: '0', transform: 'translateY(8px)' },
                            '100%': { opacity: '1', transform: 'translateY(0)' },
                        },
                    },
                    animation: {
                        'fade-in': 'fade-in .35s ease-out both',
                    },
                },
            },
        };
    </script>

    <!-- Reusable component classes (Tailwind @apply, no bespoke CSS) -->
    <style type="text/tailwindcss">
        @layer components {
            .btn { @apply inline-flex items-center justify-center gap-2 rounded-lg px-4 py-2 text-sm font-semibold transition focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-neutral-950 disabled:opacity-50 disabled:cursor-not-allowed; }
            .btn-primary { @apply btn bg-brand-orange text-white hover:bg-brand-orange-soft focus:ring-brand-orange; }
            .btn-green { @apply btn bg-brand-green text-neutral-950 hover:bg-brand-green-soft focus:ring-brand-green; }
            .btn-ghost { @apply btn bg-neutral-800 text-neutral-100 hover:bg-neutral-700 focus:ring-neutral-600; }
            .btn-danger { @apply btn bg-red-600 text-white hover:bg-red-500 focus:ring-red-500; }
            .card { @apply rounded-xl border border-neutral-800 bg-neutral-900 shadow-lg shadow-black/30; }
            .input { @apply w-full rounded-lg border border-neutral-700 bg-neutral-800 px-3 py-2 text-sm text-neutral-100 placeholder-neutral-500 focus:border-brand-orange focus:outline-none focus:ring-1 focus:ring-brand-orange; }
            .label { @apply mb-1 block text-sm font-medium text-neutral-300; }
            .chip { @apply inline-flex items-center gap-1 rounded-full px-2.5 py-0.5 text-xs font-semibold; }
        }
    </style>
</head>

<body class="min-h-screen bg-neutral-950 font-sans text-neutral-100 antialiased">
