{{-- Admin Onboarding Tour — reusable per-page component --}}
{{-- Usage: @include('admin.partials.tour', ['tourPage' => 'dashboard', 'tourSteps' => [...]]) --}}
@if(Auth::check() && Auth::user()->is_admin)
@php
    $hasCompleted = Auth::user()->hasCompletedTour($tourPage);
@endphp

<div id="admin-tour-overlay" class="fixed inset-0 z-[9999] pointer-events-none transition-opacity duration-300 {{ $hasCompleted ? 'hidden' : '' }}" style="opacity: 0;">
    {{-- Backdrop --}}
    <div id="tour-backdrop" class="fixed inset-0 bg-black/60 pointer-events-auto" style="z-index: 1;"></div>

    {{-- Spotlight cutout --}}
    <div id="tour-spotlight" class="fixed rounded-xl transition-all duration-500 ease-in-out pointer-events-none" style="z-index: 2; top: 0; left: 0; width: 0; height: 0; opacity: 0; box-shadow: 0 0 0 9999px rgba(0,0,0,0.6);"></div>

    {{-- Tour Card --}}
    <div id="tour-card" class="fixed pointer-events-auto bg-white dark:bg-gray-800 rounded-2xl shadow-2xl border border-gray-200 dark:border-gray-700 w-[340px] sm:w-[400px] transition-all duration-500 ease-in-out" style="z-index: 3; opacity: 0; top: 50%; left: 50%; transform: translate(-50%, -50%);">
        <div class="h-1.5 bg-gray-100 dark:bg-gray-700 rounded-t-2xl overflow-hidden">
            <div id="tour-progress" class="h-full bg-gradient-to-r from-red-500 to-red-600 transition-all duration-500 ease-out" style="width: 0%"></div>
        </div>

        <div class="p-6">
            <div class="flex items-center justify-between mb-4">
                <span id="tour-step-indicator" class="text-xs font-semibold text-red-600 dark:text-red-400 bg-red-50 dark:bg-red-900/20 px-3 py-1 rounded-full"></span>
                <button id="tour-skip-btn" class="text-xs text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 transition-colors font-medium">
                    {{ __('messages.tour_skip') }}
                </button>
            </div>

            <div id="tour-icon" class="w-14 h-14 bg-red-50 dark:bg-red-900/20 rounded-2xl flex items-center justify-center mb-4"></div>

            <h3 id="tour-title" class="text-xl font-bold text-gray-900 dark:text-gray-100 mb-2"></h3>
            <p id="tour-description" class="text-sm text-gray-600 dark:text-gray-400 leading-relaxed mb-6"></p>

            <div id="tour-dots" class="flex items-center justify-center gap-2 mb-5"></div>

            <div class="flex items-center gap-3">
                <button id="tour-prev-btn" class="hidden flex-1 px-4 py-2.5 text-sm font-semibold text-gray-700 dark:text-gray-300 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 rounded-xl transition-all duration-200">
                    {{ __('messages.tour_previous') }}
                </button>
                <button id="tour-next-btn" class="flex-1 px-4 py-2.5 text-sm font-semibold text-white bg-red-600 hover:bg-red-700 dark:bg-red-700 dark:hover:bg-red-800 rounded-xl transition-all duration-200 shadow-lg shadow-red-600/20">
                    {{ __('messages.tour_next') }}
                </button>
            </div>
        </div>
    </div>
</div>

{{-- Replay Tour Button --}}
@if($hasCompleted)
<div id="tour-replay-container" class="fixed bottom-6 right-6 z-50">
    <button id="tour-replay-btn"
            class="group flex items-center gap-2 px-4 py-2.5 bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-300 border border-gray-200 dark:border-gray-700 rounded-xl shadow-lg hover:shadow-xl hover:border-red-300 dark:hover:border-red-700 transition-all duration-300">
        <svg class="w-4 h-4 text-red-600 dark:text-red-400 group-hover:rotate-180 transition-transform duration-500" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M4 2a1 1 0 011 1v2.101a7.002 7.002 0 0111.601 2.566 1 1 0 11-1.885.666A5.002 5.002 0 005.999 7H9a1 1 0 010 2H4a1 1 0 01-1-1V3a1 1 0 011-1zm.008 9.057a1 1 0 011.276.61A5.002 5.002 0 0014.001 13H11a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0v-2.101a7.002 7.002 0 01-11.601-2.566 1 1 0 01.61-1.276z" clip-rule="evenodd"/>
        </svg>
        <span class="text-sm font-semibold">{{ __('messages.tour_replay') }}</span>
    </button>
</div>
@endif

<script>
document.addEventListener('DOMContentLoaded', function() {
    var tourPage = @json($tourPage);
    var tourSteps = @json($tourSteps);

    var currentStep = 0;
    var overlay = document.getElementById('admin-tour-overlay');
    var spotlight = document.getElementById('tour-spotlight');
    var card = document.getElementById('tour-card');
    var backdrop = document.getElementById('tour-backdrop');
    var titleEl = document.getElementById('tour-title');
    var descEl = document.getElementById('tour-description');
    var iconEl = document.getElementById('tour-icon');
    var prevBtn = document.getElementById('tour-prev-btn');
    var nextBtn = document.getElementById('tour-next-btn');
    var skipBtn = document.getElementById('tour-skip-btn');
    var progressBar = document.getElementById('tour-progress');
    var stepIndicator = document.getElementById('tour-step-indicator');
    var dotsContainer = document.getElementById('tour-dots');
    var replayBtn = document.getElementById('tour-replay-btn');
    var replayContainer = document.getElementById('tour-replay-container');

    var completeUrl = @json(route('admin.tour.complete', ['page' => '__PAGE__']));
    var resetUrl = @json(route('admin.tour.reset', ['page' => '__PAGE__']));

    function buildDots() {
        dotsContainer.innerHTML = '';
        tourSteps.forEach(function(_, i) {
            var dot = document.createElement('button');
            dot.className = 'w-2 h-2 rounded-full transition-all duration-300 ' + (i === currentStep ? 'bg-red-600 dark:bg-red-400 w-6' : 'bg-gray-300 dark:bg-gray-600');
            dot.setAttribute('aria-label', 'Go to step ' + (i + 1));
            dot.addEventListener('click', function() { goToStep(i); });
            dotsContainer.appendChild(dot);
        });
    }

    function positionCard(step) {
        var targetEl = step.target ? document.querySelector(step.target) : null;

        if (!targetEl || step.position === 'center') {
            spotlight.style.opacity = '0';
            backdrop.style.display = 'block';
            card.style.top = '50%';
            card.style.left = '50%';
            card.style.transform = 'translate(-50%, -50%)';
            return;
        }

        card.style.transform = 'none';

        var rect = targetEl.getBoundingClientRect();
        var padding = 12;
        var gap = 16;

        backdrop.style.display = 'none';
        spotlight.style.opacity = '1';
        spotlight.style.top = (rect.top - padding) + 'px';
        spotlight.style.left = (rect.left - padding) + 'px';
        spotlight.style.width = (rect.width + padding * 2) + 'px';
        spotlight.style.height = (rect.height + padding * 2) + 'px';

        var cardWidth = card.offsetWidth || 400;
        var cardHeight = card.offsetHeight || 280;
        var vw = window.innerWidth;
        var vh = window.innerHeight;

        var spaceBottom = vh - rect.bottom - gap;
        var spaceTop = rect.top - gap;
        var spaceRight = vw - rect.right - gap;
        var spaceLeft = rect.left - gap;

        var candidates = [
            { dir: 'bottom', fits: spaceBottom >= cardHeight, space: spaceBottom },
            { dir: 'top',    fits: spaceTop    >= cardHeight, space: spaceTop    },
            { dir: 'right',  fits: spaceRight  >= cardWidth,  space: spaceRight  },
            { dir: 'left',   fits: spaceLeft   >= cardWidth,  space: spaceLeft   }
        ];

        var chosen = candidates.find(function(c) { return c.fits; });
        if (!chosen) {
            chosen = candidates.reduce(function(a, b) { return a.space > b.space ? a : b; });
        }

        var top, left;

        switch (chosen.dir) {
            case 'bottom':
                top = rect.bottom + gap;
                left = rect.left + rect.width / 2 - cardWidth / 2;
                break;
            case 'top':
                top = rect.top - cardHeight - gap;
                left = rect.left + rect.width / 2 - cardWidth / 2;
                break;
            case 'right':
                top = rect.top + rect.height / 2 - cardHeight / 2;
                left = rect.right + gap;
                break;
            case 'left':
                top = rect.top + rect.height / 2 - cardHeight / 2;
                left = rect.left - cardWidth - gap;
                break;
        }

        left = Math.max(12, Math.min(left, vw - cardWidth - 12));
        top = Math.max(12, Math.min(top, vh - cardHeight - 12));

        card.style.top = top + 'px';
        card.style.left = left + 'px';
    }

    function isSidebarTarget(step) {
        return step.target && step.target.indexOf('sidebar') !== -1;
    }

    function ensureSidebarVisible(step) {
        if (!isSidebarTarget(step)) return;
        var isMobile = window.innerWidth < 1024;
        if (isMobile) {
            // Open sidebar on mobile via Alpine
            var aside = document.querySelector('aside[x-data]');
            if (aside && aside.__x) {
                aside.__x.$data.sidebarOpen = true;
            }
        }
    }

    function scrollToTarget(step) {
        ensureSidebarVisible(step);
        var targetEl = step.target ? document.querySelector(step.target) : null;
        if (targetEl) {
            // For sidebar elements, scroll within the sidebar nav
            var sidebarNav = targetEl.closest('nav');
            if (sidebarNav && isSidebarTarget(step)) {
                targetEl.scrollIntoView({ behavior: 'smooth', block: 'center' });
            } else {
                targetEl.scrollIntoView({ behavior: 'smooth', block: 'center' });
            }
        }
    }

    function showStep(stepIndex) {
        var step = tourSteps[stepIndex];

        // Close sidebar on mobile when moving away from sidebar steps
        if (!isSidebarTarget(step)) {
            closeSidebarIfMobile();
        }

        titleEl.textContent = step.title;
        descEl.textContent = step.description;
        iconEl.innerHTML = step.icon;
        stepIndicator.textContent = @json(__('messages.tour_step_of'))
            .replace(':current', stepIndex + 1)
            .replace(':total', tourSteps.length);
        progressBar.style.width = ((stepIndex + 1) / tourSteps.length * 100) + '%';

        prevBtn.classList.toggle('hidden', stepIndex === 0);

        if (stepIndex === tourSteps.length - 1) {
            nextBtn.textContent = @json(__('messages.tour_finish'));
            skipBtn.classList.add('hidden');
        } else {
            nextBtn.textContent = @json(__('messages.tour_next'));
            skipBtn.classList.remove('hidden');
        }

        buildDots();

        scrollToTarget(step);
        setTimeout(function() {
            requestAnimationFrame(function() { positionCard(step); });
        }, 350);
    }

    function goToStep(index) {
        if (index >= 0 && index < tourSteps.length) {
            currentStep = index;
            showStep(currentStep);
        }
    }

    function startTour() {
        currentStep = 0;
        overlay.classList.remove('hidden');
        if (replayContainer) replayContainer.classList.add('hidden');

        requestAnimationFrame(function() {
            overlay.style.opacity = '1';
            overlay.style.pointerEvents = 'auto';
            card.style.opacity = '1';
            showStep(0);
        });
    }

    function closeSidebarIfMobile() {
        var isMobile = window.innerWidth < 1024;
        if (isMobile) {
            var aside = document.querySelector('aside[x-data]');
            if (aside && aside.__x) {
                aside.__x.$data.sidebarOpen = false;
            }
        }
    }

    function endTour() {
        closeSidebarIfMobile();
        card.style.opacity = '0';
        overlay.style.opacity = '0';

        setTimeout(function() {
            overlay.classList.add('hidden');
            overlay.style.pointerEvents = 'none';
            if (replayContainer) replayContainer.classList.remove('hidden');
        }, 300);

        fetch(completeUrl.replace('__PAGE__', tourPage), {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json'
            }
        });
    }

    function resetTour() {
        fetch(resetUrl.replace('__PAGE__', tourPage), {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json'
            }
        }).then(function() { startTour(); });
    }

    nextBtn.addEventListener('click', function() {
        if (currentStep < tourSteps.length - 1) {
            currentStep++;
            showStep(currentStep);
        } else {
            endTour();
        }
    });

    prevBtn.addEventListener('click', function() {
        if (currentStep > 0) {
            currentStep--;
            showStep(currentStep);
        }
    });

    skipBtn.addEventListener('click', endTour);

    if (replayBtn) {
        replayBtn.addEventListener('click', resetTour);
    }

    var resizeTimeout;
    window.addEventListener('resize', function() {
        clearTimeout(resizeTimeout);
        resizeTimeout = setTimeout(function() {
            if (!overlay.classList.contains('hidden')) {
                positionCard(tourSteps[currentStep]);
            }
        }, 150);
    });

    document.addEventListener('keydown', function(e) {
        if (overlay.classList.contains('hidden')) return;
        if (e.key === 'Escape') endTour();
        if (e.key === 'ArrowRight' || e.key === 'Enter') {
            if (currentStep < tourSteps.length - 1) { currentStep++; showStep(currentStep); }
            else endTour();
        }
        if (e.key === 'ArrowLeft' && currentStep > 0) { currentStep--; showStep(currentStep); }
    });

    @if(!$hasCompleted)
        setTimeout(startTour, 500);
    @endif
});
</script>
@endif
