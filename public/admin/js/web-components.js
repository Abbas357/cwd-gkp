class FormSkeleton extends HTMLElement {
    constructor() {
        super();
        this.attachShadow({ mode: 'open' });
    }

    static get observedAttributes() {
        return [
            'tabs', 'input-rows', 'input-columns', 'textareas',
            'loading-text', 'show-footer', 'show-close-btn', 
            'show-loading-text', 'no-border', 'no-padding', 'buttons'
        ];
    }

    connectedCallback() {
        this.render();
    }

    attributeChangedCallback() {
        this.render();
    }

    get tabs() {
        return parseInt(this.getAttribute('tabs') || '4');
    }

    get inputRows() {
        return parseInt(this.getAttribute('input-rows') || '3');
    }

    get inputColumns() {
        return parseInt(this.getAttribute('input-columns') || '2');
    }

    get textareas() {
        return parseInt(this.getAttribute('textareas') || '1');
    }

    get loadingText() {
        return this.getAttribute('loading-text') || 'Loading...';
    }

    get showFooter() {
        return this.getAttribute('show-footer') !== 'false';
    }

    get showCloseBtn() {
        return this.getAttribute('show-close-btn') !== 'false';
    }

    get showLoadingText() {
        return this.getAttribute('show-loading-text') !== 'false';
    }

    get noBorder() {
        return this.getAttribute('no-border') === 'true';
    }

    get noPadding() {
        return this.getAttribute('no-padding') === 'true';
    }

    get buttons() {
        return parseInt(this.getAttribute('buttons') || '2');
    }

    render() {
        const styles = `
            <style>
                :host {
                    display: block;
                    width: 100%;
                }

                .skeleton-loader {
                    animation: skeleton-shimmer 1.5s infinite ease-in-out;
                    background: linear-gradient(90deg, #f0f0f0 25%, #e0e0e0 50%, #f0f0f0 75%);
                    background-size: 200% 100%;
                    border-radius: 4px;
                    display: block;
                }

                @keyframes skeleton-shimmer {
                    0% { background-position: 200% 0; }
                    100% { background-position: -200% 0; }
                }

                .skeleton-container {
                    background: white;
                    border-radius: 8px;
                    overflow: hidden;
                    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
                    border: 1px solid #e5e7eb;
                    width: 100%;
                }

                .skeleton-container.no-border {
                    border: none;
                    box-shadow: none;
                    background: transparent;
                }

                .skeleton-title {
                    height: 1.5rem;
                    width: 200px;
                    background: rgba(255, 255, 255, 0.2);
                    border-radius: 4px;
                }

                .skeleton-close-btn {
                    height: 1.5rem;
                    width: 1.5rem;
                    background: rgba(255, 255, 255, 0.2);
                    border-radius: 50%;
                }

                .skeleton-body {
                    padding: 2rem;
                }

                .skeleton-body.no-padding {
                    padding: 0;
                }

                .skeleton-tabs {
                    display: flex;
                    border-bottom: 2px solid #e5e7eb;
                    margin-bottom: 2rem;
                    gap: 1rem;
                    flex-wrap: wrap;
                }

                .skeleton-tab {
                    height: 2.5rem;
                    border-radius: 6px 6px 0 0;
                    flex: 1;
                    max-width: 120px;
                    min-width: 80px;
                }

                .skeleton-tab:first-child {
                    background: linear-gradient(90deg, #3b82f6 25%, #2563eb 50%, #3b82f6 75%);
                    background-size: 200% 100%;
                    animation: skeleton-shimmer 1.5s infinite ease-in-out;
                }

                .skeleton-form-grid {
                    display: grid;
                    grid-template-columns: repeat(var(--columns), 1fr);
                    gap: 1.5rem;
                    margin-bottom: 2rem;
                }

                .skeleton-form-group {
                    display: flex;
                    flex-direction: column;
                    gap: 0.5rem;
                }

                .skeleton-label {
                    height: 1rem;
                    width: 80px;
                    border-radius: 4px;
                }

                .skeleton-input {
                    height: 2.5rem;
                    border-radius: 6px;
                }

                .skeleton-textarea-group {
                    grid-column: 1 / -1;
                    display: flex;
                    flex-direction: column;
                    gap: 0.5rem;
                }

                .skeleton-textarea {
                    height: 6rem;
                    border-radius: 6px;
                }

                .skeleton-footer {
                    background: #f9fafb;
                    padding: 1.5rem 2rem;
                    border-top: 1px solid #e5e7eb;
                    display: flex;
                    justify-content: flex-end;
                    gap: 1rem;
                    flex-wrap: wrap;
                }

                .skeleton-btn {
                    height: 2.5rem;
                    border-radius: 6px;
                    min-width: 80px;
                }

                .skeleton-btn-primary {
                    width: 100px;
                    background: linear-gradient(90deg, #3b82f6 25%, #2563eb 50%, #3b82f6 75%);
                    background-size: 200% 100%;
                    animation: skeleton-shimmer 1.5s infinite ease-in-out;
                }

                .skeleton-btn-secondary {
                    width: 80px;
                }

                .skeleton-btn-danger {
                    width: 90px;
                    background: linear-gradient(90deg, #ef4444 25%, #dc2626 50%, #ef4444 75%);
                    background-size: 200% 100%;
                    animation: skeleton-shimmer 1.5s infinite ease-in-out;
                }

                .loading-text {
                    color: #6b7280;
                    font-weight: 500;
                    margin-bottom: 1.5rem;
                    text-align: center;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    gap: 8px;
                }

                .loading-icon {
                    animation: spin 1s linear infinite;
                }

                @keyframes spin {
                    from { transform: rotate(0deg); }
                    to { transform: rotate(360deg); }
                }

                /* Dark mode support */
                @media (prefers-color-scheme: dark) {
                    .skeleton-loader {
                        background: linear-gradient(90deg, #374151 25%, #4b5563 50%, #374151 75%);
                    }
                    
                    .skeleton-container {
                        background: #1f2937;
                        border-color: #374151;
                    }
                    
                    .skeleton-tabs {
                        border-color: #374151;
                    }
                    
                    .skeleton-footer {
                        background: #374151;
                        border-color: #4b5563;
                    }

                    .skeleton-title,
                    .skeleton-close-btn {
                        background: rgba(255, 255, 255, 0.1);
                    }

                    .loading-text {
                        color: #d1d5db;
                    }
                }

                /* Responsive design */
                @media (max-width: 768px) {
                    .skeleton-form-grid {
                        grid-template-columns: 1fr !important;
                    }
                    
                    .skeleton-body {
                        padding: 1.5rem;
                    }
                    
                    .skeleton-body.no-padding {
                        padding: 0;
                    }
                    
                    .skeleton-footer {
                        padding: 1rem 1.5rem;
                        justify-content: center;
                    }
                    
                    .skeleton-tabs {
                        gap: 0.5rem;
                    }
                    
                    .skeleton-tab {
                        max-width: none;
                        min-width: 70px;
                    }
                }

                @media (max-width: 480px) {
                    
                    .skeleton-body {
                        padding: 1rem;
                    }
                    
                    .skeleton-footer {
                        padding: 1rem;
                        flex-direction: column;
                    }
                    
                    .skeleton-btn {
                        width: 100%;
                        min-width: auto;
                    }
                    
                    .skeleton-form-grid {
                        gap: 1rem;
                    }
                }
            </style>
        `;

        const loadingTextHTML = this.showLoadingText ? `
            <div class="loading-text">
                <svg class="loading-icon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M21 12a9 9 0 11-6.219-8.56"/>
                </svg>
                ${this.loadingText}
            </div>
        ` : '';

        const tabsHTML = this.tabs > 0 ? `
            <div class="skeleton-tabs">
                ${Array.from({length: this.tabs}, () => '<div class="skeleton-loader skeleton-tab"></div>').join('')}
            </div>
        ` : '';

        const inputsHTML = Array.from({length: this.inputRows}, () => 
            Array.from({length: this.inputColumns}, () => `
                <div class="skeleton-form-group">
                    <div class="skeleton-loader skeleton-label"></div>
                    <div class="skeleton-loader skeleton-input"></div>
                </div>
            `).join('')
        ).join('');

        const textareasHTML = Array.from({length: this.textareas}, () => `
            <div class="skeleton-textarea-group">
                <div class="skeleton-loader skeleton-label"></div>
                <div class="skeleton-loader skeleton-textarea"></div>
            </div>
        `).join('');

        const buttonsHTML = this.buttons > 0 ? Array.from({length: this.buttons}, (_, i) => {
            const buttonClass = i === 0 ? 'skeleton-btn-primary' : 
                              i === 1 ? 'skeleton-btn-secondary' : 
                              'skeleton-btn-danger';
            return `<div class="skeleton-loader skeleton-btn ${buttonClass}"></div>`;
        }).join('') : '';

        const footerHTML = this.showFooter ? `
            <div class="skeleton-footer">
                ${buttonsHTML}
            </div>
        ` : '';

        this.shadowRoot.innerHTML = `
            ${styles}
            ${loadingTextHTML}
            <div class="skeleton-container ${this.noBorder ? 'no-border' : ''}">
                <div class="skeleton-body ${this.noPadding ? 'no-padding' : ''}">
                    ${tabsHTML}
                    <div class="skeleton-form-grid" style="--columns: ${this.inputColumns};">
                        ${inputsHTML}
                        ${textareasHTML}
                    </div>
                </div>
                ${footerHTML}
            </div>
        `;
    }
}

customElements.define('form-skeleton', FormSkeleton);