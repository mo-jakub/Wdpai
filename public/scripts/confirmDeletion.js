document.addEventListener("DOMContentLoaded", () => {
    const confirmDeletion = (itemId, itemType, deleteUrl) => {
        if (confirm(`Are you sure you want to delete this ${itemType}?`)) {
            const form = document.createElement("form");
            form.action = deleteUrl;
            form.method = "post";

            // Add hidden inputs
            const idInput = document.createElement("input");
            idInput.type = "hidden";
            idInput.name = "id";
            idInput.value = itemId;
            form.appendChild(idInput);

            const typeInput = document.createElement("input");
            typeInput.type = "hidden";
            typeInput.name = "type";
            typeInput.value = itemType;
            if (itemType !== "book") {
                form.appendChild(typeInput); // 'type' field only for non-book deletions
            }

            document.body.appendChild(form);
            form.submit();
        }
    };

    // Add event listeners to delete buttons
    document.querySelectorAll("[data-delete]").forEach((deleteButton) => {
        deleteButton.addEventListener("click", (event) => {
            const itemId = deleteButton.dataset.id;
            const itemType = deleteButton.dataset.type || "book";
            const deleteUrl = deleteButton.dataset.url;

            confirmDeletion(itemId, itemType, deleteUrl);
        });
    });
});