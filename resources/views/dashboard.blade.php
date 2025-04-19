<head>
    <!-- Other head content -->
    <link href="../css/dash.css" rel="stylesheet">
</head>

<x-app-layout>
    <!-- Add this to your header -->
<button id="darkModeToggle" class="fixed top-4 right-4 p-2 rounded-full bg-white/10 backdrop-blur-md border border-white/20 shadow-lg">
    🌓
</button>
<x-slot name="header">
    <h2 class="custom-header">
        {{ __('Admin Dashboard') }}
    </h2>
</x-slot>

<div class="container mx-auto p-8">
    <h1 class="custom-welcome">
        Bienvenue {{ Auth::user()->name }} !
    </h1>
</div>

<<<<<<< HEAD
<!-- Remplacer votre grid actuelle par : -->
<div class="flex flex-wrap justify-center gap-4 p-4">
    @foreach([
        ['name' => 'Themes', 'count' => 0, 'icon' => '📚'],
=======

        <div class="grid grid-cols-2 md:grid-cols-4 gap-6 p-4">
    @foreach([
        ['name' => 'Classes', 'count' => 0, 'icon' => '📚'],
>>>>>>> 1cd0c5f6e5e62f29d6aa133909f5e0afacfe481e
        ['name' => 'Salles', 'count' => 0, 'icon' => '🏠'],
        ['name' => 'Groups', 'count' => 0, 'icon' => '🏢'],
        ['name' => 'Professeurs', 'count' => 0, 'icon' => '👨‍🏫'],
    ] as $stat)
<<<<<<< HEAD
        <div class="bg-white/10 backdrop-blur-md border border-white/20 shadow-lg rounded-lg p-4 flex items-center gap-3 min-w-[150px]">
            <div class="text-2xl">{{ $stat['icon'] }}</div>
            <div>
                <h3 class="text-sm font-semibold">{{ $stat['name'] }}</h3>
                <p class="text-lg font-bold">{{ $stat['count'] }}</p>
            </div>
=======
        <div
            class="bg-white/10 backdrop-blur-md border border-white/20 text-black shadow-lg hover:shadow-purple-500/40 transition-all duration-300 rounded-xl p-6 flex flex-col items-center justify-center cursor-pointer hover:scale-105 group"
        >
            <div class="text-5xl mb-2 transition-transform duration-500 group-hover:scale-125">
                {{ $stat['icon'] }}
            </div>
            <h3 class="text-md font-semibold tracking-wide uppercase">{{ $stat['name'] }}</h3>
            <p class="text-2xl font-bold mt-1 animate-pulse">{{ $stat['count'] }}</p>
>>>>>>> 1cd0c5f6e5e62f29d6aa133909f5e0afacfe481e
        </div>
    @endforeach
</div>

    </div>
</x-app-layout>
<style>
 /* dash.css */

<<<<<<< HEAD
 /* Dans votre fichier dash.css */
.grid-cols-2.md\:grid-cols-4 {
    gap: 1rem; /* Réduire l'espace entre les cartes */
}

.bg-white\/10 {
    padding: 1rem !important; /* Réduire le padding */
    min-height: auto !important;
}

.text-5xl {
    font-size: 2rem !important; /* Réduire la taille des icônes */
}

.text-md {
    font-size: 0.9rem !important; /* Texte plus petit */
}

.text-2xl {
    font-size: 1.5rem !important; /* Chiffres plus petits */
}

=======
>>>>>>> 1cd0c5f6e5e62f29d6aa133909f5e0afacfe481e
/* Base Styles */
body {
    position: relative;
    overflow-x: hidden;
}

body::before {
    content: '';
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: 
        radial-gradient(circle at 20% 30%, rgba(106, 17, 203, 0.1) 0%, transparent 20%),
        radial-gradient(circle at 80% 70%, rgba(37, 117, 252, 0.1) 0%, transparent 20%);
    z-index: -1;
    animation: floatParticles 15s infinite alternate ease-in-out;
}

@keyframes floatParticles {
    0% { transform: translateY(0) translateX(0); }
    50% { transform: translateY(-50px) translateX(20px); }
    100% { transform: translateY(50px) translateX(-20px); }
}

/* Header Styles */
.custom-header {
    font-size: 2rem;
    font-weight: 800;
    background: linear-gradient(90deg, #6a11cb 0%, #2575fc 100%);
    -webkit-background-clip: text;
    background-clip: text;
    color: transparent;
    text-shadow: 0 2px 4px rgba(0,0,0,0.1);
    letter-spacing: -0.025em;
    padding: 0.5rem 0;
}

/* Welcome Message */
.custom-welcome {
    font-size: 2.5rem;
    font-weight: 700;
    color: #2d3748;
    position: relative;
    display: inline-block;
    margin-bottom: 2rem;
}

.custom-welcome::after {
    content: '';
    position: absolute;
    bottom: -8px;
    left: 0;
    width: 100%;
    height: 4px;
    background: linear-gradient(90deg, #6a11cb 0%, #2575fc 100%);
    border-radius: 2px;
    transform: scaleX(0);
    transform-origin: left;
    animation: welcomeUnderline 1.5s ease-out forwards;
}

@keyframes welcomeUnderline {
    to {
        transform: scaleX(1);
    }
}

/* Stats Cards */
.bg-white\/10 {
    background: rgba(255, 255, 255, 0.7) !important;
    backdrop-filter: blur(12px);
    border: 1px solid rgba(255, 255, 255, 0.3);
    border-radius: 16px;
    box-shadow: 0 4px 30px rgba(0, 0, 0, 0.1);
    overflow: hidden;
    position: relative;
    transition: all 0.3s ease;
}
.bg-white\/10 {
    background: rgba(255, 255, 255, 0.7) !important;
    backdrop-filter: blur(12px);
    border: 1px solid rgba(255, 255, 255, 0.3);
    color: #2d3748; /* Text color for light mode */
}

/* Dark mode override */
.dark .bg-white\/10 {
    background: rgba(15, 23, 42, 0.7) !important; /* Dark blue-gray with transparency */
    border-color: rgba(255, 255, 255, 0.1);
    color: #e2e8f0; /* Light text for dark mode */
}

/* Ensure text in cards adapts too */
.dark .text-md {
    color: #cbd5e0 !important; /* Lighter text for dark mode */
}

.dark .text-2xl {
    color: #a78bfa !important; /* Soft purple for counts in dark mode */
}
.bg-white\/10::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(45deg, rgba(106,17,203,0.1) 0%, rgba(37,117,252,0.1) 100%);
    z-index: -1;
    opacity: 0;
    transition: opacity 0.3s ease;
}

.bg-white\/10:hover {
    transform: translateY(-5px) scale(1.03);
    box-shadow: 0 10px 25px rgba(106, 17, 203, 0.3);
}

.bg-white\/10:hover::before {
    opacity: 1;
}

/* Card Content */
.text-5xl {
    font-size: 3.5rem;
    transition: all 0.5s cubic-bezier(0.34, 1.56, 0.64, 1);
}

.text-md {
    font-size: 1.1rem;
    font-weight: 600;
    color: #4a5568;
    margin: 0.5rem 0;
}

.text-2xl {
    font-size: 2rem;
    color: #6a11cb;
    position: relative;
}

/* Animated Pulse */
.animate-pulse {
    animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
}

@keyframes pulse {
    0%, 100% {
        transform: scale(1);
        opacity: 1;
    }
    50% {
        transform: scale(1.05);
        opacity: 0.8;
    }
}

/* Responsive Adjustments */
@media (max-width: 768px) {
    .custom-header {
        font-size: 1.5rem;
    }
    
    .custom-welcome {
        font-size: 2rem;
    }
    
    .grid-cols-2 {
        grid-template-columns: repeat(1, 1fr);
    }
}

/* Floating Animation */
@keyframes float {
    0% {
        transform: translateY(0px);
    }
    50% {
        transform: translateY(-10px);
    }
    100% {
        transform: translateY(0px);
    }
}

.bg-white\/10:hover .text-5xl {
    animation: float 3s ease-in-out infinite;
}
.bg-white\/10:hover {
    box-shadow: 0 0 15px rgba(106, 17, 203, 0.5), 
                0 0 30px rgba(37, 117, 252, 0.3);
}
.bg-white\/10 {
    position: relative;
}

.bg-white\/10::after {
    content: '';
    position: absolute;
    top: -2px;
    left: -2px;
    right: -2px;
    bottom: -2px;
    border-radius: 18px;
    background: linear-gradient(45deg, #6a11cb, #2575fc, #6a11cb);
    background-size: 200% 200%;
    z-index: -1;
    opacity: 0;
    transition: opacity 0.3s ease;
}

.bg-white\/10:hover::after {
    opacity: 1;
    animation: borderGradient 3s ease infinite;
}

@keyframes borderGradient {
    0% {
        background-position: 0% 50%;
    }
    50% {
        background-position: 100% 50%;
    }
    100% {
        background-position: 0% 50%;
    }
}
.bg-white\/10 {
    transform-style: preserve-3d;
    transition: all 0.5s ease;
}

.bg-white\/10:hover {
    transform: perspective(1000px) rotateX(5deg) rotateY(5deg);
}







.bg-white\/10 {
    position: relative;
    overflow: hidden;
}

.bg-white\/10::after {
    content: '';
    position: absolute;
    top: -50%;
    left: -50%;
    width: 200%;
    height: 200%;
    background: linear-gradient(
        45deg,
        rgba(106, 17, 203, 0.05) 0%,
        rgba(37, 117, 252, 0.05) 50%,
        transparent 100%
    );
    transform: rotate(30deg);
    animation: breathe 8s infinite linear;
    z-index: -1;
}

@keyframes breathe {
    0% { transform: rotate(30deg) translateY(0); }
    50% { transform: rotate(30deg) translateY(-20px); }
    100% { transform: rotate(30deg) translateY(0); }
}







/* Add this to your CSS */
.ripple-effect {
    position: absolute;
    width: 20px;
    height: 20px;
    background: rgba(255, 255, 255, 0.7);
    border-radius: 50%;
    transform: scale(0);
    animation: ripple 0.6s linear;
}

@keyframes ripple {
    to {
        transform: scale(10);
        opacity: 0;
    }
}
/* here is the dark mode */
/* Add these dark mode styles */
.dark body {
    background: linear-gradient(135deg, #0f0c29 0%, #302b63 50%, #24243e 100%);
}

.dark .custom-welcome {
    color: #e2e8f0;
}

.dark .bg-white\/10 {
    background: rgba(15, 23, 42, 0.7) !important;
    border-color: rgba(255, 255, 255, 0.1);
}

.dark .text-md {
    color: #cbd5e0;
}


/*this one for scrolling stylish touch */

html {
    scroll-behavior: smooth;
}

.bg-white\/10:focus {
    outline: none;
    box-shadow: 0 0 0 3px rgba(106, 17, 203, 0.5);
}

</style>
<script>
    // Add this to your JS (e.g., in a <script> tag or separate file)
document.querySelectorAll('.bg-white\\/10').forEach(card => {
    card.addEventListener('click', (e) => {
        const ripple = document.createElement('span');
        ripple.className = 'ripple-effect';
        ripple.style.left = `${e.clientX - card.getBoundingClientRect().left}px`;
        ripple.style.top = `${e.clientY - card.getBoundingClientRect().top}px`;
        card.appendChild(ripple);
        setTimeout(() => ripple.remove(), 1000);
    });
});
    // Example for animating the counters when the page loads
document.querySelectorAll('.animate-pulse').forEach(counter => {
    const target = parseInt(counter.textContent);
    let current = 0;
    const increment = target / 30;
    const updateCounter = () => {
        current += increment;
        if (current < target) {
            counter.textContent = Math.ceil(current);
            requestAnimationFrame(updateCounter);
        } else {
            counter.textContent = target;
        }
    };
    updateCounter();
});

// Add this JS
document.getElementById('darkModeToggle').addEventListener('click', () => {
    document.documentElement.classList.toggle('dark');
});
</script>