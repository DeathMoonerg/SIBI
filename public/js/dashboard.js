// Dashboard JavaScript
document.addEventListener('DOMContentLoaded', function() {
    // Toggle sidebar
    const sidebarToggle = document.querySelector('.sidebar-toggle');
    const sidebar = document.querySelector('.sidebar');
    const mainContent = document.querySelector('.main-content');
    
    if(sidebarToggle) {
        sidebarToggle.addEventListener('click', function() {
            sidebar.classList.toggle('sidebar-collapsed');
            
            // Save the state in localStorage
            if(sidebar.classList.contains('sidebar-collapsed')) {
                localStorage.setItem('sidebarState', 'collapsed');
            } else {
                localStorage.setItem('sidebarState', 'expanded');
            }
        });
    }
    
    // Check sidebar state in localStorage
    const sidebarState = localStorage.getItem('sidebarState');
    if(sidebarState === 'collapsed' && sidebar) {
        sidebar.classList.add('sidebar-collapsed');
    }
    
    // Mobile sidebar toggle
    const mobileToggle = document.querySelector('.mobile-toggle');
    if(mobileToggle) {
        mobileToggle.addEventListener('click', function() {
            sidebar.classList.toggle('show');
        });
        
        // Close sidebar when clicking outside
        document.addEventListener('click', function(event) {
            if (!sidebar.contains(event.target) && !mobileToggle.contains(event.target) && window.innerWidth < 992) {
                sidebar.classList.remove('show');
            }
        });
    }
    
    // Dropdown toggle
    const dropdownToggles = document.querySelectorAll('.dropdown-toggle');
    dropdownToggles.forEach(toggle => {
        toggle.addEventListener('click', function(e) {
            e.preventDefault();
            const parent = this.parentElement;
            parent.classList.toggle('show');
            
            // Close other dropdowns
            dropdownToggles.forEach(otherToggle => {
                if(otherToggle !== toggle) {
                    otherToggle.parentElement.classList.remove('show');
                }
            });
            
            // Close dropdown when clicking outside
            document.addEventListener('click', function(event) {
                if (!parent.contains(event.target)) {
                    parent.classList.remove('show');
                }
            }, { once: true });
        });
    });
    
    // Tooltips initialization
    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    const tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
    
    // Back to top button
    const backToTopButton = document.querySelector('.back-to-top');
    if(backToTopButton) {
        window.addEventListener('scroll', function() {
            if (window.pageYOffset > 300) {
                backToTopButton.classList.add('show');
            } else {
                backToTopButton.classList.remove('show');
            }
        });
        
        backToTopButton.addEventListener('click', function() {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });
    }
    
    // Active sidebar link
    const currentPath = window.location.pathname;
    const sidebarLinks = document.querySelectorAll('.sidebar-link');
    
    sidebarLinks.forEach(link => {
        const href = link.getAttribute('href');
        
        if(href && currentPath.includes(href) && href !== '/') {
            link.classList.add('active');
            
            // Expand parent if in dropdown
            const parent = link.closest('.sidebar-dropdown');
            if(parent) {
                parent.classList.add('show');
            }
        }
        
        // Special case for home/dashboard
        if(currentPath === '/' && href === '/') {
            link.classList.add('active');
        }
    });
    
    // Form validation
    const forms = document.querySelectorAll('.needs-validation');
    
    Array.prototype.slice.call(forms).forEach(function (form) {
        form.addEventListener('submit', function (event) {
            if (!form.checkValidity()) {
                event.preventDefault();
                event.stopPropagation();
            }
            form.classList.add('was-validated');
        }, false);
    });
    
    // Student search filter
    const studentSearchInput = document.querySelector('#studentSearch');
    if(studentSearchInput) {
        studentSearchInput.addEventListener('keyup', function() {
            const searchValue = this.value.toLowerCase();
            const students = document.querySelectorAll('.student-item');
            
            students.forEach(student => {
                const studentName = student.querySelector('.student-name').textContent.toLowerCase();
                const studentGrade = student.querySelector('.student-grade').textContent.toLowerCase();
                
                if(studentName.includes(searchValue) || studentGrade.includes(searchValue)) {
                    student.style.display = '';
                } else {
                    student.style.display = 'none';
                }
            });
        });
    }
    
    // Toggle password visibility
    const togglePasswordButtons = document.querySelectorAll('.toggle-password');
    
    togglePasswordButtons.forEach(button => {
        button.addEventListener('click', function() {
            const passwordInput = document.querySelector(this.getAttribute('data-target'));
            
            if(passwordInput.type === 'password') {
                passwordInput.type = 'text';
                this.innerHTML = '<i class="fa fa-eye-slash"></i>';
            } else {
                passwordInput.type = 'password';
                this.innerHTML = '<i class="fa fa-eye"></i>';
            }
        });
    });
    
    // Date range picker initialization
    const dateRangePickers = document.querySelectorAll('.daterangepicker-input');
    
    dateRangePickers.forEach(picker => {
        if(typeof daterangepicker !== 'undefined') {
            new daterangepicker(picker, {
                opens: 'left',
                autoUpdateInput: false,
                locale: {
                    cancelLabel: 'Clear',
                    applyLabel: 'Apply',
                    format: 'DD/MM/YYYY'
                }
            });
            
            picker.addEventListener('apply.daterangepicker', function(ev, picker) {
                this.value = picker.startDate.format('DD/MM/YYYY') + ' - ' + picker.endDate.format('DD/MM/YYYY');
            });
            
            picker.addEventListener('cancel.daterangepicker', function(ev, picker) {
                this.value = '';
            });
        }
    });
    
    // Counter animation for statistics
    function animateCounters() {
        const counters = document.querySelectorAll('.counter');
        const speed = 200;
        
        counters.forEach(counter => {
            const target = +counter.getAttribute('data-target');
            const count = +counter.innerText;
            const increment = target / speed;
            
            if(count < target) {
                counter.innerText = Math.ceil(count + increment);
                setTimeout(animateCounters, 1);
            } else {
                counter.innerText = target;
            }
        });
    }
    
    // Check if elements are in viewport
    function isInViewport(element) {
        const rect = element.getBoundingClientRect();
        return (
            rect.top >= 0 &&
            rect.left >= 0 &&
            rect.bottom <= (window.innerHeight || document.documentElement.clientHeight) &&
            rect.right <= (window.innerWidth || document.documentElement.clientWidth)
        );
    }
    
    // Start counter animation when in viewport
    const counterSection = document.querySelector('.counter-section');
    if(counterSection) {
        let animated = false;
        
        window.addEventListener('scroll', function() {
            if(isInViewport(counterSection) && !animated) {
                animateCounters();
                animated = true;
            }
        });
        
        // Initial check
        if(isInViewport(counterSection)) {
            animateCounters();
            animated = true;
        }
    }
    
    // AJAX form submission
    const ajaxForms = document.querySelectorAll('.ajax-form');
    
    ajaxForms.forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const submitButton = this.querySelector('[type="submit"]');
            const originalText = submitButton.innerHTML;
            submitButton.disabled = true;
            submitButton.innerHTML = '<i class="fa fa-spinner fa-spin"></i> Loading...';
            
            const formData = new FormData(this);
            const url = this.getAttribute('action');
            const method = this.getAttribute('method') || 'POST';
            
            fetch(url, {
                method: method,
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.json())
            .then(data => {
                submitButton.disabled = false;
                submitButton.innerHTML = originalText;
                
                if(data.success) {
                    // Show success message
                    const successAlert = document.createElement('div');
                    successAlert.className = 'alert alert-success alert-dismissible fade show';
                    successAlert.innerHTML = `
                        ${data.message}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    `;
                    
                    form.prepend(successAlert);
                    
                    // Reset form if needed
                    if(data.reset) {
                        form.reset();
                    }
                    
                    // Redirect if needed
                    if(data.redirect) {
                        setTimeout(() => {
                            window.location.href = data.redirect;
                        }, 1000);
                    }
                } else {
                    // Show error message
                    const errorAlert = document.createElement('div');
                    errorAlert.className = 'alert alert-danger alert-dismissible fade show';
                    errorAlert.innerHTML = `
                        ${data.message}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    `;
                    
                    form.prepend(errorAlert);
                    
                    // Show validation errors
                    if(data.errors) {
                        Object.keys(data.errors).forEach(key => {
                            const input = form.querySelector(`[name="${key}"]`);
                            if(input) {
                                input.classList.add('is-invalid');
                                
                                const feedback = document.createElement('div');
                                feedback.className = 'invalid-feedback';
                                feedback.innerText = data.errors[key][0];
                                
                                input.parentNode.appendChild(feedback);
                            }
                        });
                    }
                }
            })
            .catch(error => {
                console.error('Error:', error);
                submitButton.disabled = false;
                submitButton.innerHTML = originalText;
                
                const errorAlert = document.createElement('div');
                errorAlert.className = 'alert alert-danger alert-dismissible fade show';
                errorAlert.innerHTML = `
                    An error occurred. Please try again.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                `;
                
                form.prepend(errorAlert);
            });
        });
    });
}); 