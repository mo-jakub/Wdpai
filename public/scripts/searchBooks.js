/**
 * This script implements a live book search functionality for both desktop and mobile users.
 * It provides dynamic search results as the user types their query into the search bar.
 * The search results are populated using data retrieved from the server.
 */

document.addEventListener('DOMContentLoaded', () => {
    // Mobile search functionality
    const mobileSearchInput = document.querySelector('.mobile-search-bar input');
    const mobileSearchResultsContainer = document.createElement('div');
    mobileSearchResultsContainer.className = 'search-results';

    if (mobileSearchInput) {
        // Ensure parent element is properly positioned for accurate results display
        mobileSearchInput.parentElement.style.position = 'relative';
        mobileSearchInput.parentElement.appendChild(mobileSearchResultsContainer);

        // Attach the event handler to handle search input dynamically
        attachSearchHandler(mobileSearchInput, mobileSearchResultsContainer);
    }

    // Desktop search functionality
    const desktopSearchInput = document.querySelector('.desktop-search-bar input');
    const desktopSearchResultsContainer = document.createElement('div');
    desktopSearchResultsContainer.className = 'search-results';

    if (desktopSearchInput) {
        // Ensure parent element is properly positioned for accurate results display
        desktopSearchInput.parentElement.style.position = 'relative';
        desktopSearchInput.parentElement.appendChild(desktopSearchResultsContainer);

        // Attach the event handler to handle search input dynamically
        attachSearchHandler(desktopSearchInput, desktopSearchResultsContainer);
    }
});

document.addEventListener('click', (e) => {
    /**
     * Event listener to close the search results when the user clicks outside
     * the search bar or the search results container.
     *
     * @param {Event} e - The click event that occurs anywhere on the document.
     */
    if (!e.target.closest('.search-bar') && !e.target.closest('.search-results')) {
        // Clear all search results when clicked outside
        document.querySelectorAll('.search-results').forEach(container => {
            container.innerHTML = '';
        });
    }
});

/**
 * Attaches the search functionality to a search input field and results container.
 * Makes a server request to fetch search results based on the query entered by the user.
 *
 * @param {HTMLElement} searchInput - The search input field.
 * @param {HTMLElement} resultsContainer - The container where search results will be displayed.
 */
function attachSearchHandler(searchInput, resultsContainer) {
    searchInput.addEventListener('input', async () => {
        const query = searchInput.value.trim(); // Get the trimmed user input

        if (query.length === 0) {
            // Clear results if input is empty
            resultsContainer.innerHTML = '';
            return;
        }

        try {
            // Fetch search results from the server
            const response = await fetch(`/searchBooks?q=${encodeURIComponent(query)}`);
            if (!response.ok) {
                throw new Error(`HTTP Error: ${response.status}`); // Handle HTTP errors
            }

            const books = await response.json(); // Parse server response as JSON
            displaySearchResults(books, resultsContainer); // Display the search results
        } catch (error) {
            console.error('Search failed:', error); // Log any errors during the search
        }
    });
}

/**
 * Displays the search results inside the given container.
 * Formats each book's data and appends it as a search result.
 *
 * @param {Array} books - The array of book objects returned from the server.
 * @param {HTMLElement} container - The container where search results are displayed.
 */
function displaySearchResults(books, container) {
    container.innerHTML = ''; // Clear any existing results

    if (!books || books.length === 0) {
        // Show a fallback message if no books are found
        container.innerHTML = '<p>No results found.</p>';
        return;
    }

    books.forEach(book => {
        const result = document.createElement('div');
        result.className = 'search-result';

        // Extract author information, use a fallback if missing or improperly formatted
        let authorsText = 'Unknown'; // Default text if no author data exists
        if (book.authors) {
            try {
                // Extract the author's name from a JSON-like string format
                const matches = book.authors.match(/\{"([^"]+)"\}/); // Match patterns like {"Name"}
                if (matches && matches[1]) {
                    authorsText = matches[1]; // Assign the extracted author's name
                }
            } catch (e) {
                console.warn('Failed to extract authors:', book.authors); // Log extraction errors
            }
        }

        // Create a link element to display book details
        const bookLink = document.createElement('a');
        bookLink.href = `/book/${book.id}`; // Link to the book's details page
        bookLink.style.textDecoration = 'none'; // Optional: Remove underline from the link
        bookLink.style.color = 'inherit'; // Optional: Inherit text color from parent styles

        // Populate the inner content of the link with book details
        bookLink.innerHTML = `
            <strong>${book.title || 'Untitled'}</strong>
            <p>${book.description || 'No description available.'}</p>
            <small>Authors: ${authorsText}</small>
        `;

        result.appendChild(bookLink); // Append the link to the result container
        container.appendChild(result); // Append the result to the search results container
    });
}