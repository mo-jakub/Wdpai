document.addEventListener('DOMContentLoaded', () => {
    // Mobile search input
    const mobileSearchInput = document.querySelector('.mobile-search-bar input');
    const mobileSearchResultsContainer = document.createElement('div');
    mobileSearchResultsContainer.className = 'search-results';
    if (mobileSearchInput) {
        // Set relative position on the parent to make absolute positioning work
        mobileSearchInput.parentElement.style.position = 'relative';
        mobileSearchInput.parentElement.appendChild(mobileSearchResultsContainer);
        attachSearchHandler(mobileSearchInput, mobileSearchResultsContainer);
    }

    // Desktop search input
    const desktopSearchInput = document.querySelector('.desktop-search-bar input');
    const desktopSearchResultsContainer = document.createElement('div');
    desktopSearchResultsContainer.className = 'search-results';
    if (desktopSearchInput) {
        // Set relative position on the parent to make absolute positioning work
        desktopSearchInput.parentElement.style.position = 'relative';
        desktopSearchInput.parentElement.appendChild(desktopSearchResultsContainer);
        attachSearchHandler(desktopSearchInput, desktopSearchResultsContainer);
    }
});

document.addEventListener('click', (e) => {
    // Close results if the click is outside the search bar or its results
    if (!e.target.closest('.search-bar') && !e.target.closest('.search-results')) {
        document.querySelectorAll('.search-results').forEach(container => {
            container.innerHTML = ''; // Clear results
        });
    }
});

// Function to attach search functionality
function attachSearchHandler(searchInput, resultsContainer) {
    searchInput.addEventListener('input', async () => {
        const query = searchInput.value.trim();

        if (query.length === 0) {
            resultsContainer.innerHTML = ''; // Clear results if input is empty
            return;
        }

        try {
            const response = await fetch(`/searchBooks?q=${encodeURIComponent(query)}`);
            if (!response.ok) {
                throw new Error(`HTTP Error: ${response.status}`);
            }
            const books = await response.json();
            displaySearchResults(books, resultsContainer);
        } catch (error) {
            console.error('Search failed:', error);
        }
    });
}

function displaySearchResults(books, container) {
    container.innerHTML = ''; // Clear previous results
    if (!books || books.length === 0) {
        container.innerHTML = '<p>No results found.</p>';
        return;
    }

    books.forEach(book => {
        const result = document.createElement('div');
        result.className = 'search-result';

        // Handle authors as an object
        let authorsText = 'Unknown'; // Default value if authors are missing
        if (book.authors) {
            try {
                // Manually extract the author name from the invalid JSON-like format
                const matches = book.authors.match(/\{"([^"]+)"\}/); // Extract value inside {"..."}
                if (matches && matches[1]) {
                    authorsText = matches[1]; // Match[1] contains the content inside the quotes
                }
            } catch (e) {
                console.warn('Failed to extract authors:', book.authors);
            }
        }

        // Create a link for the book
        const bookLink = document.createElement('a');
        bookLink.href = `/book/${book.id}`; // Link to the book's page
        bookLink.style.textDecoration = 'none'; // Optional: Remove underline
        bookLink.style.color = 'inherit'; // Optional: Inherit text color

        // Format the inner HTML of the link
        bookLink.innerHTML = `
            <strong>${book.title || 'Untitled'}</strong>
            <p>${book.description || 'No description available.'}</p>
            <small>Authors: ${authorsText}</small>
        `;

        result.appendChild(bookLink); // Add the link to the result container
        container.appendChild(result); // Add the result to the parent search results container
    });
}