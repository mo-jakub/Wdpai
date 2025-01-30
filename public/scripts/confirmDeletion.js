/**
 * This script handles the confirmation and submission of deletion requests
 * for items on a webpage. When a user clicks a delete button, they are prompted
 * with a confirmation dialog. If confirmed, the item is deleted via a dynamically
 * created form submission using POST.
 */

document.addEventListener("DOMContentLoaded", () => {
    /**
     * Displays a confirmation dialog and handles the submission of a
     * deletion request form if the user confirms.
     *
     * @param {string} itemId - The unique identifier of the item to be deleted.
     * @param {string} itemType - The type of the item (e.g., "book", "author").
     * @param {string} deleteUrl - The URL endpoint to process the deletion.
     */
    const confirmDeletion = (itemId, itemType, deleteUrl) => {
        if (confirm(`Are you sure you want to delete this ${itemType}?`)) {
            // Create a form dynamically for the deletion request
            const form = document.createElement("form");
            form.action = deleteUrl; // URL to send the deletion request
            form.method = "post"; // Use POST for the request

            // Add a hidden input field for the item ID
            const idInput = document.createElement("input");
            idInput.type = "hidden";
            idInput.name = "id"; // Form field name as "id"
            idInput.value = itemId; // Set the value to the provided item ID
            form.appendChild(idInput);

            // Add a hidden input field for the item type (if not "book")
            const typeInput = document.createElement("input");
            typeInput.type = "hidden";
            typeInput.name = "type"; // Form field name as "type"
            typeInput.value = itemType;

            // Only append the `type` field if the item is not a "book"
            if (itemType !== "book") {
                form.appendChild(typeInput);
            }

            // Append the form to the body and submit it
            document.body.appendChild(form);
            form.submit();
        }
    };

    /**
     * Attaches click event listeners to all elements with the `data-delete`
     * attribute. When clicked, the associated item's details are retrieved from
     * the element's dataset, and the `confirmDeletion` function is invoked.
     */
    document.querySelectorAll("[data-delete]").forEach((deleteButton) => {
        deleteButton.addEventListener("click", (event) => {
            // Retrieve item details from the dataset of the clicked button
            const itemId = deleteButton.dataset.id; // Get the item ID
            const itemType = deleteButton.dataset.type || "book"; // Default type is "book"
            const deleteUrl = deleteButton.dataset.url; // Get the URL for deletion

            // Call the confirmation and deletion handler
            confirmDeletion(itemId, itemType, deleteUrl);
        });
    });
});