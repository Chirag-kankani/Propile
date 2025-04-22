document.addEventListener('DOMContentLoaded', function() {
    // Add subtle animation to features on scroll
    const features = document.querySelectorAll('.feature');
    if (features.length > 0) {
        features.forEach((feature, index) => {
            setTimeout(() => {
                feature.style.opacity = 0;
                feature.style.transform = 'translateY(20px)';
                
                setTimeout(() => {
                    feature.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
                    feature.style.opacity = 1;
                    feature.style.transform = 'translateY(0)';
                }, index * 150);
            }, 0);
        });
    }
    
    // Dashboard functionality
    const dashboardCards = document.querySelectorAll('.dashboard-card');
    const profileForm = document.querySelector('.profile-form');
    const getStartedBtn = document.querySelector('.get-started-btn');
    
    if (dashboardCards.length > 0) {
        dashboardCards.forEach(card => {
            card.addEventListener('click', function() {
                const cardType = this.dataset.type;
                
                // Show form when clicking on a card
                if (profileForm) {
                    profileForm.style.display = 'block';
                    
                    // Scroll to form
                    profileForm.scrollIntoView({ behavior: 'smooth' });
                    
                    // Show relevant form section based on card type
                    const formSections = document.querySelectorAll('.form-section');
                    formSections.forEach(section => {
                        if (section.dataset.type === cardType) {
                            section.style.display = 'block';
                        } else {
                            section.style.display = 'none';
                        }
                    });
                }
            });
        });
    }
    
    // Get Started button functionality
    if (getStartedBtn) {
        getStartedBtn.addEventListener('click', function() {
            if (profileForm) {
                profileForm.style.display = 'block';
                
                // Show all form sections when clicking Get Started
                const formSections = document.querySelectorAll('.form-section');
                formSections.forEach(section => {
                    section.style.display = 'block';
                });
                
                // Scroll to form
                profileForm.scrollIntoView({ behavior: 'smooth' });
            }
        });
    }
    
    // Add Project button functionality
    const addProjectBtns = document.querySelectorAll('.add-project-btn');
    if (addProjectBtns.length > 0) {
        addProjectBtns.forEach(btn => {
            btn.addEventListener('click', function() {
                const projectsContainer = document.getElementById('projects-container');
                const projectCount = document.querySelectorAll('.project-item').length + 1;
                
                const projectHtml = `
                    <div class="project-item">
                        <div class="form-row">
                            <div class="form-field">
                                <label class="form-label" for="project-name-${projectCount}">Project Name</label>
                                <input type="text" class="form-input" id="project-name-${projectCount}" name="project_name[]" placeholder="My Awesome Project">
                            </div>
                            <div class="form-field">
                                <label class="form-label" for="project-link-${projectCount}">GitHub Link</label>
                                <input type="url" class="form-input" id="project-link-${projectCount}" name="project_link[]" placeholder="https://github.com/yourusername/project">
                            </div>
                        </div>
                        <div class="form-field">
                            <label class="form-label" for="project-desc-${projectCount}">Description</label>
                            <textarea class="form-input" id="project-desc-${projectCount}" name="project_desc[]" rows="3" placeholder="Brief description of your project"></textarea>
                        </div>
                    </div>
                `;
                
                projectsContainer.insertAdjacentHTML('beforeend', projectHtml);
            });
        });
    }
    
    // Template selection
    const templateCards = document.querySelectorAll('.template-card');
    if (templateCards.length > 0) {
        templateCards.forEach(card => {
            card.addEventListener('click', function() {
                // Remove selected class from all cards
                templateCards.forEach(c => c.classList.remove('selected'));
                
                // Add selected class to clicked card
                this.classList.add('selected');
                
                // Set hidden input value
                const templateInput = document.getElementById('selected-template');
                if (templateInput) {
                    templateInput.value = this.dataset.template;
                }
            });
        });
    }
});

// Form validation
function validateForm(formId) {
    const form = document.getElementById(formId);
    if (!form) return true;
    
    let isValid = true;
    const requiredInputs = form.querySelectorAll('[required]');
    
    requiredInputs.forEach(input => {
        if (!input.value.trim()) {
            isValid = false;
            input.classList.add('error');
            
            // Add error message if it doesn't exist
            let errorMsg = input.parentElement.querySelector('.error-message');
            if (!errorMsg) {
                errorMsg = document.createElement('p');
                errorMsg.className = 'error-message';
                errorMsg.textContent = 'This field is required';
                errorMsg.style.color = '#e53e3e';
                errorMsg.style.fontSize = '0.8rem';
                errorMsg.style.marginTop = '4px';
                input.parentElement.appendChild(errorMsg);
            }
        } else {
            input.classList.remove('error');
            const errorMsg = input.parentElement.querySelector('.error-message');
            if (errorMsg) {
                errorMsg.remove();
            }
        }
    });
    
    return isValid;
}