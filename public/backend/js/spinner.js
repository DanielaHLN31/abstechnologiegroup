document.addEventListener('DOMContentLoaded', function() {
    // 1. élément de style et l'ajouter au head
    const style = document.createElement('style');
    style.textContent = `
      #global-spinner {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(255, 255, 255, 0.9);
        z-index: 9999;
        justify-content: center;
        align-items: center;
      }
      .sk-grid {
        width: 80px;
        height: 80px;
        margin: auto;
        display: flex;
        flex-wrap: wrap;
      }
      .sk-primary { color: #007bff; }
      .sk-grid-cube {
        width: 33.33%;
        height: 33.33%;
        background-color: currentColor;
        float: left;
        animation: sk-grid 1.3s infinite ease-in-out;
      }
      .sk-grid-cube:nth-child(1) { animation-delay: 0.2s; }
      .sk-grid-cube:nth-child(2) { animation-delay: 0.3s; }
      .sk-grid-cube:nth-child(3) { animation-delay: 0.4s; }
      .sk-grid-cube:nth-child(4) { animation-delay: 0.1s; }
      .sk-grid-cube:nth-child(5) { animation-delay: 0.2s; }
      .sk-grid-cube:nth-child(6) { animation-delay: 0.3s; }
      .sk-grid-cube:nth-child(7) { animation-delay: 0s; }
      .sk-grid-cube:nth-child(8) { animation-delay: 0.1s; }
      .sk-grid-cube:nth-child(9) { animation-delay: 0.2s; }
      @keyframes sk-grid {
        0%, 70%, 100% { transform: scale3D(1, 1, 1); }
        35% { transform: scale3D(0, 0, 1); }
      }
    `;
    document.head.appendChild(style);
  
    // 2. HTML du spinner et l'ajouter au body
    const spinner = document.createElement('div');
    spinner.id = 'global-spinner';
    spinner.innerHTML = `
      <div class="sk-grid sk-primary">
        <div class="sk-grid-cube"></div>
        <div class="sk-grid-cube"></div>
        <div class="sk-grid-cube"></div>
        <div class="sk-grid-cube"></div>
        <div class="sk-grid-cube"></div>
        <div class="sk-grid-cube"></div>
        <div class="sk-grid-cube"></div>
        <div class="sk-grid-cube"></div>
        <div class="sk-grid-cube"></div>
      </div>
    `;
    document.body.appendChild(spinner);
  
    // 3. Fonctions pour afficher/masquer le spinner
    function showSpinner() {
      spinner.style.display = 'flex';
    }
    
    function hideSpinner() {
      spinner.style.display = 'none';
    }
  
    // 4. Intercepter les requêtes AJAX
    const originalXhrOpen = XMLHttpRequest.prototype.open;
    XMLHttpRequest.prototype.open = function() {
        const url = arguments[1]; // L'URL est le deuxième argument
        const shouldShowSpinner = !url.includes('/users/check-email');

        if (shouldShowSpinner) {
            this.addEventListener('loadstart', showSpinner);
            this.addEventListener('loadend', hideSpinner);
        }
        originalXhrOpen.apply(this, arguments);
    };
    
    // Fetch
    const originalFetch = window.fetch;
    window.fetch = function(input, init) {
      const url = typeof input === 'string' ? input : input.url;
      const shouldShowSpinner = !url.includes('/work/check-actions/') && !url.includes('/dossiers/check-niveau/') && !url.includes('/tasks/tasks/count') && !url.includes('/tasks/count') && !url.includes('/work/get-action-details/') && !url.includes('/dossiers/update-parties');
      
      if (shouldShowSpinner) {
        showSpinner();
      }
      
      return originalFetch.apply(this, arguments).finally(() => {
        if (shouldShowSpinner) {
          hideSpinner();
        }
      });
    };
    
    // Fetch
    // const originalFetch = window.fetch;
    // window.fetch = function() {
    //   showSpinner();
    //   return originalFetch.apply(this, arguments).finally(hideSpinner);
    // };
    
    // Formulaires
    // document.querySelectorAll('form').forEach(form => {
    //   form.addEventListener('submit', showSpinner);
    // });
    
    // Boutons submit
    // document.querySelectorAll('button[type="submit"]').forEach(button => {
    //   button.addEventListener('click', function() {
    //     if (this.form && !this.form.checkValidity()) return;
    //     showSpinner();
    //   });
    // });
  
    // 5. Exposer les fonctions globalement
    window.showGlobalSpinner = showSpinner;
    window.hideGlobalSpinner = hideSpinner;
  });