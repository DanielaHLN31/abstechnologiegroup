/**
 * App Calendar - Version corrigée
 */

'use strict';

let direction = 'ltr';

if (isRtl) {
  direction = 'rtl';
}

document.addEventListener('DOMContentLoaded', function () {
  (function () {
    const calendarEl = document.getElementById('calendar'),
      appCalendarSidebar = document.querySelector('.app-calendar-sidebar'),
      addEventSidebar = document.getElementById('addEventSidebar'),
      appOverlay = document.querySelector('.app-overlay'),
      calendarsColor = {
        Professionnel: 'primary',
        Vacances: 'dark',
        Personnel: 'success',
        Familiale: 'info',
        Audience: 'danger',
        Task: 'warning',
        Autre: 'secondary',
      },
      offcanvasTitle = document.querySelector('.offcanvas-title'),
      btnToggleSidebar = document.querySelector('.btn-toggle-sidebar'),
      btnSubmit = document.querySelector('button[type="submit"]'),
      btnDeleteEvent = document.querySelector('.btn-delete-event'),
      btnCancel = document.querySelector('.btn-cancel'),
      eventTitle = document.querySelector('#eventTitle'),
      eventStartDate = document.querySelector('#eventStartDate'),
      eventEndDate = document.querySelector('#eventEndDate'),
      eventUrl = document.querySelector('#eventURL'),
      eventLabel = $('#eventLabel'),
      eventGuests = $('#eventGuests'),
      eventLocation = document.querySelector('#eventLocation'),
      eventDescription = document.querySelector('#eventDescription'),
      allDaySwitch = document.querySelector('.allDay-switch'),
      selectAll = document.querySelector('.select-all'),
      filterInput = [].slice.call(document.querySelectorAll('.input-filter')),
      inlineCalendar = document.querySelector('.inline-calendar');

    let eventToUpdate,
      currentEvents = events,
      isFormValid = false,
      inlineCalInstance,
      personnelsData = []; // Variable pour stocker les personnels

    // Init event Offcanvas
    const bsAddEventSidebar = new bootstrap.Offcanvas(addEventSidebar);

    
    function showSpinner() {
      // Désactiver le bouton submit et afficher le spinner
      btnSubmit.disabled = true;
      const originalText = btnSubmit.innerHTML;
      btnSubmit.setAttribute('data-original-text', originalText);
      btnSubmit.innerHTML = '<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>Enregistrement...';
    }

    function hideSpinner() {
      // Réactiver le bouton et restaurer le texte original
      btnSubmit.disabled = false;
      const originalText = btnSubmit.getAttribute('data-original-text');
      if (originalText) {
        btnSubmit.innerHTML = originalText;
        btnSubmit.removeAttribute('data-original-text');
      }
    }

    function validateEventDates(startDate, endDate) {
      if (!startDate || !endDate) {
        return { isValid: false, message: 'Les dates de début et de fin sont obligatoires' };
      }

      const start = new Date(startDate);
      const end = new Date(endDate);

      if (start >= end) {
        return {
          isValid: false,
          message: 'La date/heure de début doit être antérieure à la date/heure de fin'
        };
      }

      return { isValid: true, message: '' };
    }

    function showDateValidationError(message) {
      const existingError = document.querySelector('.date-validation-error');
      if (existingError) {
        existingError.remove();
      }

      const errorDiv = document.createElement('div');
      errorDiv.className = 'alert alert-danger date-validation-error mt-2';
      errorDiv.innerHTML = `<i class="ti ti-alert-circle me-2"></i>${message}`;

      const endDateContainer = eventEndDate.closest('.mb-3');
      endDateContainer.appendChild(errorDiv);
    }

    function clearDateValidationError() {
      const existingError = document.querySelector('.date-validation-error');
      if (existingError) {
        existingError.remove();
      }
    }

    // Event Label (select2)
    if (eventLabel.length) {
      function renderBadges(option) {
        if (!option.id) {
          return option.text;
        }
        var $badge =
          "<span class='badge badge-dot bg-" + $(option.element).data('label') + " me-2'> " + '</span>' + option.text;

        return $badge;
      }
      eventLabel.wrap('<div class="position-relative"></div>').select2({
        placeholder: 'Select value',
        dropdownParent: eventLabel.parent(),
        templateResult: renderBadges,
        templateSelection: renderBadges,
        minimumResultsForSearch: -1,
        escapeMarkup: function (es) {
          return es;
        }
      });
    }

    // Fonction pour initialiser le select des invités - VERSION CORRIGÉE
    function initializeGuestsSelect() {
    if (eventGuests.length) {
    function renderGuestAvatar(option) {
      if (!option.id) {
        return option.text;
      }

      const initials = $(option.element).data('initials') ||
                      option.text.split(' ').map(word => word.charAt(0)).join('').substring(0, 2).toUpperCase();

      const colors = ['primary', 'secondary', 'success', 'danger', 'warning', 'info', 'dark'];
      const colorIndex = initials.charCodeAt(0) % colors.length;
      const bgColor = colors[colorIndex];

      const $avatar =
        "<div class='d-flex flex-wrap align-items-center'>" +
        "<div class='avatar avatar-xs me-2'>" +
        "<span class='avatar-initial rounded-circle bg-" + bgColor + "'>" + initials + "</span>" +
        '</div>' +
        option.text +
        '</div>';

      return $avatar;
    }

    // Détruire l'instance select2 existante si elle existe
    if (eventGuests.hasClass("select2-hidden-accessible")) {
      eventGuests.select2('destroy');
    }

    // Supprimer le wrapper existant s'il existe
    if (eventGuests.parent().hasClass('position-relative')) {
      eventGuests.unwrap();
    }

    eventGuests.wrap('<div class="position-relative"></div>').select2({
      placeholder: 'Sélectionner des invités',
      dropdownParent: eventGuests.parent(),
      closeOnSelect: false,
      templateResult: renderGuestAvatar,
      templateSelection: renderGuestAvatar,
      escapeMarkup: function (es) {
        return es;
      }
    });
    }
    }

    // Fonction pour peupler le select des invités - VERSION CORRIGÉE
    function populateGuestsSelect(personnels) {
        console.log('Personnels reçus:', personnels); // Debug

        // Vider le select
        eventGuests.empty();

        // Détruire select2 s'il existe déjà
        if (eventGuests.hasClass("select2-hidden-accessible")) {
            eventGuests.select2('destroy');
        }

        // Ajouter une option vide par défaut
        eventGuests.append('<option value=""></option>');

        // Récupérer l'ID de l'utilisateur connecté (à adapter selon votre système)
        const currentUserId = window.currentUser.id; // Supposons que vous avez stocké l'ID utilisateur

        // Ajouter les options des personnels en excluant l'utilisateur courant
        if (personnels && personnels.length > 0) {
            personnels.forEach(function(personnel) {
                // Exclure l'utilisateur courant
                if (personnel.id != currentUserId) {
                    console.log('Ajout personnel:', personnel); // Debug

                    const option = $('<option></option>')
                        .attr('value', personnel.id)
                        .text(personnel.text || personnel.name || 'Personnel')
                        .attr('data-initials', personnel.initials)
                        .attr('data-email', personnel.email || '');

                    eventGuests.append(option);
                }
            });
        } else {
            console.warn('Aucun personnel trouvé');
        }

        // Initialiser select2 après avoir ajouté les options
        initializeGuestsSelect();

        console.log('Select2 initialisé avec', eventGuests.find('option').length - 1, 'personnels'); // Debug
    }

    // Fonction pour charger les personnels - VERSION AMÉLIORÉE
    function loadPersonnels() {
      console.log('Chargement des personnels...'); // Debug

      // Si les données sont déjà chargées, les utiliser directement
      if (personnelsData.length > 0) {
      console.log('Utilisation des données en cache:', personnelsData.length, 'personnels');
      populateGuestsSelect(personnelsData);
      return;
      }

      $.ajax({
      url: '/agenda/calendar/events',
      type: 'GET',
      success: function (response) {
        console.log('Réponse AJAX reçue:', response); // Debug

        // Vérifier différents formats de réponse
        let personnels = [];
        if (response.personnels) {
          personnels = response.personnels;
        } else if (response.users) {
          personnels = response.users;
        } else if (Array.isArray(response)) {
          // Si la réponse est directement un tableau
          personnels = response.filter(item => item.type === 'personnel' || item.personnels);
        }

        console.log('Personnels extraits:', personnels); // Debug

        personnelsData = personnels;
        populateGuestsSelect(personnelsData);
      },
      error: function (xhr, status, error) {
        console.error('Erreur lors du chargement des personnels:', {
          status: status,
          error: error,
          response: xhr.responseText
        });

        // En cas d'erreur, initialiser quand même le select avec des données de test
        const testData = [
          { id: '1', text: 'John Doe', initials: 'JD', email: 'john@example.com' },
          { id: '2', text: 'Jane Smith', initials: 'JS', email: 'jane@example.com' }
        ];

        populateGuestsSelect(testData);
      }
      });
    }


    // Fonction utilitaire pour forcer le rechargement des personnels
    function forceReloadPersonnels() {
    personnelsData = []; // Vider le cache
    loadPersonnels(); // Recharger
    }


    // Event start (flatpicker)
    if (eventStartDate) {
      var start = eventStartDate.flatpickr({
        enableTime: true,
        dateFormat: 'Y-m-d H:i:S',
        altInput: true,
        altFormat: 'd/m/Y H:i',
        time_24hr: true,
        locale: {
          firstDayOfWeek: 1,
          weekdays: {
            shorthand: ['Dim', 'Lun', 'Mar', 'Mer', 'Jeu', 'Ven', 'Sam'],
            longhand: ['Dimanche', 'Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi']
          },
          months: {
            shorthand: ['Jan', 'Fév', 'Mar', 'Avr', 'Mai', 'Juin', 'Juil', 'Aoû', 'Sep', 'Oct', 'Nov', 'Déc'],
            longhand: ['Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre']
          },
          time_24hr: true
        },
        onReady: function (selectedDates, dateStr, instance) {
          if (instance.isMobile) {
            instance.mobileInput.setAttribute('step', null);
          }
        }
      });
    }

    // Event end (flatpicker)
    if (eventEndDate) {
      var end = eventEndDate.flatpickr({
        enableTime: true,
        dateFormat: 'Y-m-d H:i:S',
        altInput: true,
        altFormat: 'd/m/Y H:i',
        time_24hr: true,
        locale: {
          firstDayOfWeek: 1,
          weekdays: {
            shorthand: ['Dim', 'Lun', 'Mar', 'Mer', 'Jeu', 'Ven', 'Sam'],
            longhand: ['Dimanche', 'Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi']
          },
          months: {
            shorthand: ['Jan', 'Fév', 'Mar', 'Avr', 'Mai', 'Juin', 'Juil', 'Aoû', 'Sep', 'Oct', 'Nov', 'Déc'],
            longhand: ['Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre']
          },
          time_24hr: true
        },
        onReady: function (selectedDates, dateStr, instance) {
          if (instance.isMobile) {
            instance.mobileInput.setAttribute('step', null);
          }
        }
      });
    }


    // Inline sidebar calendar (flatpicker)
      if (inlineCalendar){
          inlineCalInstance = inlineCalendar.flatpickr({
              monthSelectorType: 'static',
              inline: true,

              // Configuration française complète
              locale: {
                  firstDayOfWeek: 1, // Lundi
                  weekdays: {
                      shorthand: ['Dim', 'Lun', 'Mar', 'Mer', 'Jeu', 'Ven', 'Sam'],
                      longhand: ['Dimanche', 'Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi']
                  },
                  months: {
                      shorthand: ['Jan', 'Fév', 'Mar', 'Avr', 'Mai', 'Jun', 'Jul', 'Aoû', 'Sep', 'Oct', 'Nov', 'Déc'],
                      longhand: ['Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre']
                  },
                  daysInMonth: [31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31],
                  time_24hr: true,
                  rangeSeparator: ' au ',
                  weekAbbreviation: 'Sem',
                  scrollTitle: 'Défiler pour augmenter la valeur',
                  toggleTitle: 'Cliquer pour basculer',
                  amPM: ['AM', 'PM'],
                  yearAriaLabel: 'Année',
                  monthAriaLabel: 'Mois',
                  hourAriaLabel: 'Heure',
                  minuteAriaLabel: 'Minute'
              },

              // Format de date français
              dateFormat: 'd/m/Y',

              // Format de l'heure
              time_24hr: true
          });
      }



    
    function toggleFormFields(disable = false) {
      eventTitle.disabled = disable;
      eventStartDate.disabled = disable;
      eventEndDate.disabled = disable;
      eventUrl.disabled = disable;
      eventLocation.disabled = disable;
      eventDescription.disabled = disable;
      allDaySwitch.disabled = disable;

      if (disable) {
        eventLabel.prop('disabled', true).trigger('change');
        eventGuests.prop('disabled', true).trigger('change');
      } else {
        eventLabel.prop('disabled', false).trigger('change');
        eventGuests.prop('disabled', false).trigger('change');
      }
    }

    // Event click function
    function eventClick(info) {
      console.log('info=',info.event.url)
      eventToUpdate = info.event;
      if (eventToUpdate.url && eventToUpdate.url !== null && eventToUpdate.url !== "" && eventToUpdate.url !== "null") {
        
        info.jsEvent.preventDefault();
        window.open(eventToUpdate.url, '_blank');
        
      }
      bsAddEventSidebar.show();

      const isAudienceOrTask = eventToUpdate.extendedProps.type === 'audience' || eventToUpdate.extendedProps.type === 'task';

      if (offcanvasTitle) {
        if (isAudienceOrTask) {
          offcanvasTitle.innerHTML = eventToUpdate.extendedProps.type === 'audience' ? 'Consulter Audience' : 'Consulter Tâche';
          btnSubmit.classList.add('d-none');
          btnDeleteEvent.classList.add('d-none');
          toggleFormFields(true);
        } else {
          offcanvasTitle.innerHTML = 'Modifier un évennement';
        }
      }

      if (isAudienceOrTask) {
        btnSubmit.classList.add('d-none');
        btnDeleteEvent.classList.add('d-none');
        toggleFormFields(true);
      } else {
        btnSubmit.innerHTML = 'Modifier';
        btnSubmit.classList.add('btn-update-event');
        btnSubmit.classList.remove('btn-add-event', 'd-none');
        btnDeleteEvent.classList.remove('d-none');
        toggleFormFields(false);
      }

      eventTitle.value = eventToUpdate.title;
      start.setDate(eventToUpdate.start, true, 'Y-m-d');
      eventToUpdate.allDay === true ? (allDaySwitch.checked = true) : (allDaySwitch.checked = false);
      eventToUpdate.end !== null
        ? end.setDate(eventToUpdate.end, true, 'Y-m-d')
        : end.setDate(eventToUpdate.start, true, 'Y-m-d');
      // eventLabel.val(eventToUpdate.extendedProps.calendar).trigger('change');
    const calendarValue = eventToUpdate.extendedProps.calendar;
    console.log('Calendar value from event:', calendarValue); // Debug
    
    // Vérifier si la valeur existe dans le select
    const optionExists = eventLabel.find('option[value="' + calendarValue + '"]').length > 0;
    
      if (optionExists) {
        eventLabel.val(calendarValue).trigger('change');
      } else {
        // Si la valeur exacte n'existe pas, chercher une correspondance insensible à la casse
        let matchingOption = null;
        eventLabel.find('option').each(function() {
          if ($(this).val().toLowerCase() === calendarValue.toLowerCase()) {
            matchingOption = $(this).val();
            return false; // Arrêter la boucle
          }
        });
        
        if (matchingOption) {
          eventLabel.val(matchingOption).trigger('change');
          console.log('Selected matching option:', matchingOption);
        } else {
          console.warn('No matching option found for calendar value:', calendarValue);
          // Laisser vide ou sélectionner une valeur par défaut si nécessaire
          eventLabel.val('').trigger('change');
        }
      }
      eventToUpdate.extendedProps.location !== undefined
        ? (eventLocation.value = eventToUpdate.extendedProps.location)
        : null;
      eventToUpdate.extendedProps.guests !== undefined
        ? eventGuests.val(eventToUpdate.extendedProps.guests).trigger('change')
        : null;
      eventToUpdate.extendedProps.description !== undefined
        ? (eventDescription.value = eventToUpdate.extendedProps.description)
        : null;
    }

    // Modify sidebar toggler
    function modifyToggler() {
      const fcSidebarToggleButton = document.querySelector('.fc-sidebarToggle-button');
      fcSidebarToggleButton.classList.remove('fc-button-primary');
      fcSidebarToggleButton.classList.add('d-lg-none', 'd-inline-block', 'ps-0');
      while (fcSidebarToggleButton.firstChild) {
        fcSidebarToggleButton.firstChild.remove();
      }
      fcSidebarToggleButton.setAttribute('data-bs-toggle', 'sidebar');
      fcSidebarToggleButton.setAttribute('data-overlay', '');
      fcSidebarToggleButton.setAttribute('data-target', '#app-calendar-sidebar');
      fcSidebarToggleButton.insertAdjacentHTML('beforeend', '<i class="ti ti-menu-2 ti-sm text-heading"></i>');
    }

    // Filter events by calender
    function selectedCalendars() {
      let selected = [],
          filterInputChecked = [].slice.call(document.querySelectorAll('.input-filter:checked'));

      filterInputChecked.forEach(item => {
        const value = item.getAttribute('data-value');
        console.log("Filtre sélectionné:", value);
        selected.push(value);
      });

      return selected;
    }

    // AXIOS: fetchEvents

    function fetchEvents(info, successCallback) {
      $.ajax({
      url: '/agenda/calendar/events',
      type: 'GET',
      success: function (response) {
        console.log('Réponse fetchEvents:', response); // Debug

        // Stocker les personnels pour éviter de refaire l'appel
        if (response.personnels && response.personnels.length > 0) {
          if (personnelsData.length === 0) {
            personnelsData = response.personnels;
            console.log('Personnels stockés depuis fetchEvents:', personnelsData.length);
          }

          // Charger les personnels dans le select si ce n'est pas déjà fait
          if (!eventGuests.hasClass("select2-hidden-accessible") || eventGuests.find('option').length <= 1) {
            populateGuestsSelect(personnelsData);
          }
        }

        const calendars = selectedCalendars();
        console.log("Calendriers sélectionnés:", calendars);

        const events = Array.isArray(response) ? response : (response.events || []);
        console.log("Événements avant filtrage:", events);

        const filteredEvents = events.filter(event => {
          if (!event.extendedProps || !event.extendedProps.calendar) {
            return false;
          }

          const eventCalendar = event.extendedProps.calendar.toLowerCase();
          return calendars.some(cal => cal.toLowerCase() === eventCalendar);
        });

        console.log("Événements après filtrage:", filteredEvents);
        successCallback(filteredEvents);
      },
      error: function (error) {
        console.error('Erreur lors de la récupération des événements:', error);
        successCallback([]);
      }
      });
    }

    // Init FullCalendar
      let calendar = new Calendar(calendarEl, {
          // Localisation française
          locale: 'fr',

          initialView: 'dayGridMonth',
          events: fetchEvents,
          plugins: [dayGridPlugin, interactionPlugin, listPlugin, timegridPlugin],
          editable: true,
          dragScroll: true,
          dayMaxEvents: 2,
          eventResizableFromStart: true,
          eventDisplay: 'block',
          // Boutons personnalisés en français
          customButtons: {
              sidebarToggle: {
                  text: 'Menu'
              }
          },

          // Barre d'outils avec textes français
          headerToolbar: {
              start: 'sidebarToggle, prev,next, title',
              end: 'dayGridMonth,timeGridWeek,timeGridDay,listMonth'
          },

          // Textes personnalisés en français
          buttonText: {
              today: "Aujourd'hui",
              month: 'Mois',
              week: 'Semaine',
              day: 'Jour',
              list: 'Liste'
          },

          // Noms des mois en français
          monthNames: [
              'Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin',
              'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre'
          ],

          // Noms courts des mois
          monthNamesShort: [
              'Jan', 'Fév', 'Mar', 'Avr', 'Mai', 'Jun',
              'Jul', 'Aoû', 'Sep', 'Oct', 'Nov', 'Déc'
          ],

          // Noms des jours en français
          dayNames: [
              'Dimanche', 'Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi'
          ],

          // Noms courts des jours
          dayNamesShort: ['Dim', 'Lun', 'Mar', 'Mer', 'Jeu', 'Ven', 'Sam'],

          // Format de l'heure (24h)
          timeFormat: 'HH:mm',
          slotLabelFormat: {
              hour: '2-digit',
              minute: '2-digit',
              hour12: false
          },

          // Premier jour de la semaine (lundi)
          firstDay: 1,

          // Textes divers
          allDayText: 'Toute la journée',
          moreLinkText: 'en plus',
          noEventsText: 'Aucun événement à afficher',

          direction: direction,
          initialDate: new Date(),
          navLinks: true, // can click day/week names to navigate views

          eventClassNames: function ({ event: calendarEvent }) {
              const colorName = calendarsColor[calendarEvent._def.extendedProps.calendar];
              // Background Color
              return ['fc-event-' + colorName];
          },

          dateClick: function (info) {
              let date = moment(info.date).format('DD-MM-YYYY');
              resetValues();
              bsAddEventSidebar.show();

              // For new event set offcanvas title text: Add Event
              if (offcanvasTitle) {
                  offcanvasTitle.innerHTML = 'Ajouter un événement';
              }
              btnSubmit.innerHTML = 'Ajouter';
              btnSubmit.classList.remove('btn-update-event');
              btnSubmit.classList.add('btn-add-event');
              btnDeleteEvent.classList.add('d-none');
              eventStartDate.value = date;
              eventEndDate.value = date;
          },

          eventClick: function (info) {
              info.jsEvent.preventDefault();
              eventClick(info);
          },

          datesSet: function () {
              modifyToggler();
          },

          viewDidMount: function () {
              modifyToggler();
          },
          
    
          // OU utilisez cette approche plus directe :
          eventDidMount: function(info) {
              if (info.el.tagName === 'A') {
                  info.el.removeAttribute('href');
              }
              info.el.addEventListener('click', function(e) {
                  e.preventDefault();
              });
          },
    
      });

    // Render calendar
    calendar.render();
    modifyToggler();

    // Form validation
    const eventForm = document.getElementById('eventForm');
    const fv = FormValidation.formValidation(eventForm, {
      fields: {
        eventTitle: {
          validators: {
            notEmpty: {
              message: 'Entrez le titre '
            }
          }
        },
        eventStartDate: {
          validators: {
            notEmpty: {
              message: 'Entrez la date de début '
            }
          }
        },
        eventEndDate: {
          validators: {
            notEmpty: {
              message: 'Entrez la date de fin '
            }
          }
        },
        eventLabel: {
          validators: {
            notEmpty: {
              message: 'Sélectionnez une catégorie '
            }
          }
        },
        eventDescription: {
          validators: {
            notEmpty: {
              message: 'Entrez la description '
            }
          }
        }
      },
      plugins: {
        trigger: new FormValidation.plugins.Trigger(),
        bootstrap5: new FormValidation.plugins.Bootstrap5({
          eleValidClass: '',
          rowSelector: function (field, ele) {
            return '.mb-3';
          }
        }),
        submitButton: new FormValidation.plugins.SubmitButton(),
        autoFocus: new FormValidation.plugins.AutoFocus()
      }
    })
    .on('core.form.valid', function () {
      const dateValidation = validateEventDates(eventStartDate.value, eventEndDate.value);

      if (!dateValidation.isValid) {
        isFormValid = false;
        showDateValidationError(dateValidation.message);
        return false;
      }

      clearDateValidationError();
      isFormValid = true;
    })
    .on('core.form.invalid', function () {
      isFormValid = false;
    });

    // Date validation listeners
    if (eventStartDate) {
      eventStartDate.addEventListener('change', function() {
        if (eventEndDate.value) {
          const validation = validateEventDates(this.value, eventEndDate.value);
          if (!validation.isValid) {
            showDateValidationError(validation.message);
          } else {
            clearDateValidationError();
          }
        }
      });
    }

    if (eventEndDate) {
      eventEndDate.addEventListener('change', function() {
        if (eventStartDate.value) {
          const validation = validateEventDates(eventStartDate.value, this.value);
          if (!validation.isValid) {
            showDateValidationError(validation.message);
          } else {
            clearDateValidationError();
          }
        }
      });
    }

    // Sidebar Toggle Btn
    if (btnToggleSidebar) {
      btnToggleSidebar.addEventListener('click', e => {
        btnCancel.classList.remove('d-none');
      });
    }

    // Add Event function
    function addEvent(eventData) {
      showSpinner(); // Afficher le spinner
      
      $.ajax({
        url: '/agenda/calendar/events',
        type: 'POST',
        data: {
          title: eventData.title,
          start: eventData.start,
          end: eventData.end,
          all_day: eventData.allDay ? 1 : 0,
          url: eventData.url || '',
          calendar_type: eventData.extendedProps.calendar,
          location: eventData.extendedProps.location || '',
          description: eventData.extendedProps.description || '',
          guests: eventData.extendedProps.guests || [],
          _token: $('meta[name="csrf-token"]').attr('content')
        },
        success: function (response) {
          eventData.id = response.event.id;
          calendar.refetchEvents();
          
          // Attendre un court délai pour s'assurer que l'événement est affiché
          setTimeout(() => {
            hideSpinner();
            bsAddEventSidebar.hide();
            
            // Afficher un message de succès (optionnel)
            if (typeof toastr !== 'undefined') {
              toastr.success('Événement ajouté avec succès');
            }
          }, 500);
        },
        error: function (error) {
          hideSpinner();
          console.error('Erreur lors de l\'ajout de l\'événement:', error);
          
          // Afficher un message d'erreur
          if (typeof toastr !== 'undefined') {
            toastr.error('Erreur lors de l\'ajout de l\'événement');
          } else {
            alert('Erreur lors de l\'ajout de l\'événement');
          }
        }
      });
    }

    // Update Event function
    function updateEvent(eventData) {
      showSpinner(); 
      
      $.ajax({
        url: '/agenda/calendar/events/' + eventData.id,
        type: 'PUT',
        data: {
          title: eventData.title,
          start: eventData.start,
          end: eventData.end,
          all_day: eventData.allDay ? 1 : 0,
          url: eventData.url || '',
          calendar_type: eventData.extendedProps.calendar,
          location: eventData.extendedProps.location || '',
          description: eventData.extendedProps.description || '',
          guests: eventData.extendedProps.guests || [],
          _token: $('meta[name="csrf-token"]').attr('content')
        },
        success: function (response) {
          calendar.refetchEvents();
          
          // Attendre un court délai pour s'assurer que l'événement est mis à jour
          setTimeout(() => {
            hideSpinner();
            bsAddEventSidebar.hide();
            
            // Afficher un message de succès (optionnel)
            if (typeof toastr !== 'undefined') {
              toastr.success('Événement modifié avec succès');
            }
          }, 500);
        },
        error: function (error) {
          hideSpinner();
          console.error('Erreur lors de la mise à jour de l\'événement:', error);
          
          // Afficher un message d'erreur
          if (typeof toastr !== 'undefined') {
            toastr.error('Erreur lors de la modification de l\'événement');
          } else {
            alert('Erreur lors de la modification de l\'événement');
          }
        }
      });
    }

    // Remove Event function
    function removeEvent(eventId) {
      // Désactiver le bouton de suppression pendant l'opération
      btnDeleteEvent.disabled = true;
      const originalDeleteText = btnDeleteEvent.innerHTML;
      btnDeleteEvent.innerHTML = '<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>Suppression...';
      
      $.ajax({
        url: '/agenda/calendar/events/' + eventId,
        type: 'DELETE',
        data: {
          _token: $('meta[name="csrf-token"]').attr('content')
        },
        success: function (response) {
          calendar.refetchEvents();
          
          // Attendre un court délai pour s'assurer que l'événement est supprimé
          setTimeout(() => {
            btnDeleteEvent.disabled = false;
            btnDeleteEvent.innerHTML = originalDeleteText;
            bsAddEventSidebar.hide();
            
            // Afficher un message de succès (optionnel)
            if (typeof toastr !== 'undefined') {
              toastr.success('Événement supprimé avec succès');
            }
          }, 500);
        },
        error: function (error) {
          btnDeleteEvent.disabled = false;
          btnDeleteEvent.innerHTML = originalDeleteText;
          console.error('Erreur lors de la suppression de l\'événement:', error);
          
          // Afficher un message d'erreur
          if (typeof toastr !== 'undefined') {
            toastr.error('Erreur lors de la suppression de l\'événement');
          } else {
            alert('Erreur lors de la suppression de l\'événement');
          }
        }
      });
    }

    // Submit button event listener
    btnSubmit.addEventListener('click', e => {
      const dateValidation = validateEventDates(eventStartDate.value, eventEndDate.value);

      if (!dateValidation.isValid) {
        showDateValidationError(dateValidation.message);
        return;
      }

      clearDateValidationError();

      if (btnSubmit.classList.contains('btn-update-event')) {
        if (eventToUpdate.extendedProps.type === 'audience') {
          alert('Les audiences ne peuvent pas être modifiées depuis le calendrier.');
          return;
        }
        if (eventToUpdate.extendedProps.type === 'task') {
          alert('Les taches ne peuvent pas être modifiées depuis le calendrier.');
          return;
        }
      }

      if (btnSubmit.classList.contains('btn-add-event')) {
        if (isFormValid) {
          let newEvent = {
            id: calendar.getEvents().length + 1,
            title: eventTitle.value,
            start: eventStartDate.value,
            end: eventEndDate.value,
            startStr: eventStartDate.value,
            endStr: eventEndDate.value,
            display: 'block',
            extendedProps: {
              location: eventLocation.value,
              guests: eventGuests.val(),
              calendar: eventLabel.val(),
              description: eventDescription.value
            }
          };
          if (eventUrl.value) {
            newEvent.url = eventUrl.value;
          }
          if (allDaySwitch.checked) {
            newEvent.allDay = true;
          }
          addEvent(newEvent); 
        }
      } else {
        if (isFormValid) {
          let eventData = {
            id: eventToUpdate.id,
            title: eventTitle.value,
            start: eventStartDate.value,
            end: eventEndDate.value,
            url: eventUrl.value,
            extendedProps: {
              location: eventLocation.value,
              guests: eventGuests.val(),
              calendar: eventLabel.val(),
              description: eventDescription.value
            },
            display: 'block',
            allDay: allDaySwitch.checked ? true : false
          };

          updateEvent(eventData); // Le spinner et la fermeture du modal sont gérés dans updateEvent
        }
      }
    });

    // Delete button event listener
    btnDeleteEvent.addEventListener('click', e => {
      if (eventToUpdate.extendedProps.type === 'audience') {
        alert('Les audiences ne peuvent pas être supprimées depuis le calendrier.');
        return;
      }
      if (eventToUpdate.extendedProps.type === 'task') {
        alert('Les tache ne peuvent pas être supprimées.');
        return;
      }

      // Demander confirmation avant suppression
      if (confirm('Êtes-vous sûr de vouloir supprimer cet événement ?')) {
        const eventId = eventToUpdate.id.replace('event_', '');
        removeEvent(parseInt(eventId)); // Le spinner et la fermeture du modal sont gérés dans removeEvent
      }
    });

    // Reset form values
    function resetValues() {
      toggleFormFields(false);
      eventEndDate.value = '';
      eventUrl.value = '';
      eventStartDate.value = '';
      eventTitle.value = '';
      eventLocation.value = '';
      allDaySwitch.checked = false;
      eventGuests.val('').trigger('change');
      eventLabel.val('').trigger('change');
      eventDescription.value = '';
      clearDateValidationError();
      
      // Réinitialiser l'état des boutons
      hideSpinner();
      btnDeleteEvent.disabled = false;
      if (btnDeleteEvent.innerHTML.includes('spinner-border')) {
        btnDeleteEvent.innerHTML = 'Supprimer';
      }
    }

    // When modal hides reset input values
    addEventSidebar.addEventListener('hidden.bs.offcanvas', function () {
      resetValues();
    });

    // Toggle sidebar event listener
    btnToggleSidebar.addEventListener('click', e => {
      if (offcanvasTitle) {
        offcanvasTitle.innerHTML = 'Ajouter un évennement';
      }
      btnSubmit.innerHTML = 'Ajouter';
      btnSubmit.classList.remove('btn-update-event', 'd-none');
      btnSubmit.classList.add('btn-add-event');
      btnDeleteEvent.classList.add('d-none');

      toggleFormFields(false);

      btnCancel.classList.remove('d-none');
      appCalendarSidebar.classList.remove('show');
      appOverlay.classList.remove('show');

      // Charger les personnels si pas encore fait
      if (personnelsData.length === 0) {
        loadPersonnels();
      }
    });

    // Calendar filter functionality
    if (selectAll) {
      selectAll.addEventListener('click', e => {
        if (e.currentTarget.checked) {
          document.querySelectorAll('.input-filter').forEach(c => (c.checked = 1));
        } else {
          document.querySelectorAll('.input-filter').forEach(c => (c.checked = 0));
        }
        calendar.refetchEvents();
      });
    }

    if (filterInput) {
      filterInput.forEach(item => {
        item.addEventListener('click', () => {
          document.querySelectorAll('.input-filter:checked').length < document.querySelectorAll('.input-filter').length
            ? (selectAll.checked = false)
            : (selectAll.checked = true);
          calendar.refetchEvents();
        });
      });
    }

    // Jump to date on sidebar calendar change
    inlineCalInstance.config.onChange.push(function (date) {
      calendar.changeView(calendar.view.type, moment(date[0]).format('DD-MM-YYYY'));
      modifyToggler();
      appCalendarSidebar.classList.remove('show');
      appOverlay.classList.remove('show');
    });
  })();
});
