// Wait until the DOM is fully loaded
document.addEventListener('DOMContentLoaded', function() {
    const animalInput = document.getElementById('animalName');
    const dateInput = document.getElementById('createdAt');
    const reportItems = document.querySelectorAll('.report-item'); // Select all report items

    // Function to filter reports based on animal name and created date
    function filterReports() {
        const animalName = animalInput.value.toLowerCase(); // Get animal name input
        const selectedDate = dateInput.value; // Get selected date

        // Loop through all report items
        reportItems.forEach(item => {
            const animal = item.getAttribute('data-animal-name');
            const createdAt = item.getAttribute('data-created-at');

            // Check if the item matches the animal name and date filters
            const matchesAnimal = animal.includes(animalName);
            const matchesDate = createdAt === selectedDate || selectedDate === ''; // Show all if no date selected

            // Show or hide the item based on matches
            if (matchesAnimal && matchesDate) {
                item.style.display = ''; // Show item if both match
            } else {
                item.style.display = 'none'; // Hide item if not matching
            }
        });
    }

    // Event listeners for input changes
    animalInput.addEventListener('input', filterReports); // Filter when animal name input changes
    dateInput.addEventListener('input', filterReports); // Filter when date input changes
});
