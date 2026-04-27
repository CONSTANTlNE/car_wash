import './echo';

// ── Theme ──────────────────────────────────────────────────────────────────
const html     = document.documentElement;
const themeBtn = document.getElementById('theme-toggle');
const iconSun  = document.getElementById('icon-sun');
const iconMoon = document.getElementById('icon-moon');

function applyTheme(dark) {
    html.classList.toggle('dark', dark);
    iconSun.classList.toggle('hidden', !dark);
    iconMoon.classList.toggle('hidden', dark);
    localStorage.setItem('theme', dark ? 'dark' : 'light');
}

const saved      = localStorage.getItem('theme');
const osDark     = window.matchMedia('(prefers-color-scheme: dark)').matches;
applyTheme(saved === 'dark' || (!saved && osDark));

themeBtn?.addEventListener('click', () => applyTheme(!html.classList.contains('dark')));

// ── Sidebar ────────────────────────────────────────────────────────────────
const sidebar        = document.getElementById('sidebar');
const backdrop       = document.getElementById('sidebar-backdrop');
const footerToggle   = document.getElementById('sidebar-toggle-desktop');
const footerIcon     = document.getElementById('sidebar-footer-icon');
const headerToggle   = document.getElementById('sidebar-toggle-header');

// Desktop: collapse / expand
function setSidebarCollapsed(collapsed) {
    sidebar.classList.toggle('collapsed', collapsed);
    if (footerIcon) footerIcon.style.transform = collapsed ? 'rotate(180deg)' : '';
    localStorage.setItem('sidebar-collapsed', collapsed ? '1' : '0');
}

setSidebarCollapsed(localStorage.getItem('sidebar-collapsed') === '1');

footerToggle?.addEventListener('click', () => {
    setSidebarCollapsed(!sidebar.classList.contains('collapsed'));
});

// Mobile: drawer open / close
function openMobileSidebar() {
    sidebar.classList.add('mobile-open');
    backdrop.classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}

function closeMobileSidebar() {
    sidebar.classList.remove('mobile-open');
    backdrop.classList.add('hidden');
    document.body.style.overflow = '';
}

backdrop?.addEventListener('click', closeMobileSidebar);

window.addEventListener('resize', () => {
    if (window.innerWidth >= 768) closeMobileSidebar();
});

// Header toggle: mobile → drawer, desktop → collapse
headerToggle?.addEventListener('click', () => {
    if (window.innerWidth < 768) {
        sidebar.classList.contains('mobile-open') ? closeMobileSidebar() : openMobileSidebar();
    } else {
        setSidebarCollapsed(!sidebar.classList.contains('collapsed'));
    }
});

// ── User dropdown ──────────────────────────────────────────────────────────
const userMenuBtn  = document.getElementById('user-menu-btn');
const userDropdown = document.getElementById('user-dropdown');
const userChevron  = document.getElementById('user-chevron');

function openDropdown() {
    userDropdown.classList.remove('hidden');
    userDropdown.classList.add('open');
    userChevron?.classList.add('rotate-180');
    userMenuBtn?.setAttribute('aria-expanded', 'true');
}

function closeDropdown() {
    userDropdown.classList.remove('open');
    userDropdown.classList.add('hidden');
    userChevron?.classList.remove('rotate-180');
    userMenuBtn?.setAttribute('aria-expanded', 'false');
}

userMenuBtn?.addEventListener('click', (e) => {
    e.stopPropagation();
    userDropdown.classList.contains('open') ? closeDropdown() : openDropdown();
});

// Close dropdown on outside click
document.addEventListener('click', (e) => {
    if (!document.getElementById('user-menu-wrapper')?.contains(e.target)) {
        closeDropdown();
    }
});

// Close dropdown on Escape
document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape') closeDropdown();
});

// ── Active nav item ────────────────────────────────────────────────────────
document.querySelectorAll('.nav-item:not(.active)').forEach(link => {
    link.addEventListener('click', function () {
        document.querySelectorAll('.nav-item').forEach(l => {
            l.classList.remove('active', 'bg-[var(--color-brand-500)]', 'text-white');
        });
        this.classList.add('active', 'bg-[var(--color-brand-500)]', 'text-white');
    });
});
