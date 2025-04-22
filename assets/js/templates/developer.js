// Add smooth scrolling to all links
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
        e.preventDefault();
        
        document.querySelector(this.getAttribute('href')).scrollIntoView({
            behavior: 'smooth'
        });
    });
});

// Add scroll reveal animation
window.addEventListener('DOMContentLoaded', () => {
    const sections = document.querySelectorAll('section');
    
    const observerOptions = {
        root: null,
        rootMargin: '0px',
        threshold: 0.1
    };
    
    const observer = new IntersectionObserver((entries, observer) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.opacity = 1;
                entry.target.style.transform = 'translateY(0)';
                observer.unobserve(entry.target);
            }
        });
    }, observerOptions);
    
    sections.forEach(section => {
        section.style.opacity = 0;
        section.style.transform = 'translateY(20px)';
        section.style.transition = 'opacity 0.6s ease-out, transform 0.6s ease-out';
        observer.observe(section);
    });
});

// Typewriter effect for hero section
const heroTitle = document.querySelector('.hero-name');
if (heroTitle) {
    const text = heroTitle.textContent;
    heroTitle.textContent = '';
    
    let i = 0;
    const typeWriter = () => {
        if (i < text.length) {
            heroTitle.textContent += text.charAt(i);
            i++;
            setTimeout(typeWriter, 100);
        }
    };
    
    setTimeout(typeWriter, 500);
}

// Add highlighting for code elements
const codeElements = document.querySelectorAll('code');
codeElements.forEach(code => {
    const highlight = () => {
        const content = code.textContent;
        
        // Simple syntax highlighting
        const keywordRegex = /(const|let|var|function|return|if|else|for|while|class|import|export|from)/g;
        const stringRegex = /(['"`])(.*?)\1/g;
        const commentRegex = /(\/\/.*|\/\*[\s\S]*?\*\/)/g;
        
        let highlighted = content
            .replace(keywordRegex, '<span class="keyword">$1</span>')
            .replace(stringRegex, '<span class="string">$&</span>')
            .replace(commentRegex, '<span class="comment">$1</span>');
        
        code.innerHTML = highlighted;
    };
    
    highlight();
});

// Add styles for syntax highlighting
const style = document.createElement('style');
style.textContent = `
    code {
        font-family: var(--font-mono);
    }
    
    .keyword {
        color: var(--liquid-lava);
    }
    
    .string {
        color: #10B981;
    }
    
    .comment {
        color: var(--dusty-grey);
    }
`;
document.head.appendChild(style);