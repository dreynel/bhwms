<!-- SweetAlert2 Configuration & Helper Script -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Theme-aware SweetAlert Toast Instance
        const isDark = document.documentElement.classList.contains('dark') || localStorage.getItem('theme') !== 'light';
        
        const SwalToast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 4500,
            timerProgressBar: true,
            background: isDark ? '#0f172a' : '#ffffff',
            color: isDark ? '#f8fafc' : '#0f172a',
            customClass: {
                popup: 'rounded-2xl border border-slate-200 dark:border-slate-800 shadow-2xl backdrop-blur-md'
            },
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer);
                toast.addEventListener('mouseleave', Swal.resumeTimer);
            }
        });

        // Flash Messages Trigger
        @if(session('success'))
            SwalToast.fire({
                icon: 'success',
                title: 'Success!',
                text: "{{ session('success') }}"
            });
        @endif

        @if(session('warning'))
            SwalToast.fire({
                icon: 'warning',
                title: 'Attention',
                text: "{{ session('warning') }}"
            });
        @endif

        @if(session('error'))
            SwalToast.fire({
                icon: 'error',
                title: 'Error!',
                text: "{{ session('error') }}"
            });
        @endif

        @if(session('info'))
            SwalToast.fire({
                icon: 'info',
                title: 'Information',
                text: "{{ session('info') }}"
            });
        @endif

        // Global Event Delegation for SWAL Confirmations
        document.addEventListener('submit', function (e) {
            const form = e.target;
            if (form.hasAttribute('data-confirm')) {
                e.preventDefault();
                const confirmMessage = form.getAttribute('data-confirm') || 'Are you sure you want to perform this action?';
                const confirmTitle = form.getAttribute('data-confirm-title') || 'Confirm Action';
                const confirmButtonText = form.getAttribute('data-confirm-button') || 'Yes, Proceed';
                const iconType = form.getAttribute('data-confirm-icon') || 'warning';

                Swal.fire({
                    title: confirmTitle,
                    text: confirmMessage,
                    icon: iconType,
                    showCancelButton: true,
                    confirmButtonColor: '#0038a8',
                    cancelButtonColor: '#64748b',
                    confirmButtonText: confirmButtonText,
                    cancelButtonText: 'Cancel',
                    background: isDark ? '#0f172a' : '#ffffff',
                    color: isDark ? '#f8fafc' : '#0f172a',
                    customClass: {
                        popup: 'rounded-2xl border border-slate-200 dark:border-slate-800 shadow-2xl p-6',
                        confirmButton: 'px-5 py-2.5 rounded-xl font-bold text-sm shadow-md',
                        cancelButton: 'px-5 py-2.5 rounded-xl font-bold text-sm shadow-md'
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.removeAttribute('data-confirm');
                        form.submit();
                    }
                });
            }
        });
    });

    // Helper Function for Manual Triggering in Views
    window.confirmAction = function(options) {
        const isDark = document.documentElement.classList.contains('dark') || localStorage.getItem('theme') !== 'light';
        return Swal.fire({
            title: options.title || 'Are you sure?',
            text: options.text || 'This action cannot be undone.',
            icon: options.icon || 'warning',
            showCancelButton: true,
            confirmButtonColor: options.confirmButtonColor || '#0038a8',
            cancelButtonColor: '#64748b',
            confirmButtonText: options.confirmButtonText || 'Yes, proceed',
            cancelButtonText: 'Cancel',
            background: isDark ? '#0f172a' : '#ffffff',
            color: isDark ? '#f8fafc' : '#0f172a',
            customClass: {
                popup: 'rounded-2xl border border-slate-200 dark:border-slate-800 shadow-2xl p-6'
            }
        });
    };
</script>
