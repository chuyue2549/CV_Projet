/**
 * @file qcm-filters.js
 * JS script used to filter the qcms
 * 
 * @package DE-BUT
 */

const filterPanel = document.getElementById('filter-panel');
const filterButton = document.getElementById('filter-button');
const closeButton = document.getElementById('close-filter-button');
const cancelButton = document.getElementById('cancel-filter');

// Opens the filter panel
function openFilterPanel() {
    if (filterPanel) {
        filterPanel.classList.add('is-open');
        filterPanel.setAttribute('aria-hidden', 'false');
        if(filterButton)filterButton.classList.add('is-on')
    };
}

// Closes the filter panel
function closeFilterPanel() {
    if (filterPanel) {
        filterPanel.classList.remove('is-open');
        filterPanel.setAttribute('aria-hidden', 'true');
         if(filterButton)filterButton.classList.remove('is-on')
    }
}

function toggleFilterPanel() {
    if (!filterPanel) return;

    const isOpen = filterPanel.classList.contains('is-open');
    if (isOpen) {
        closeFilterPanel();
    } else {
        openFilterPanel();
    }
}

if (filterButton) {
    filterButton.addEventListener('click', toggleFilterPanel);
}

if (closeButton) {
    closeButton.addEventListener('click', closeFilterPanel);
}

if (cancelButton) {
    cancelButton.addEventListener('click', closeFilterPanel);
}