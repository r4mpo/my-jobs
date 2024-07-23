// Function to format ZipCode with hyphen
function formatZipCode(input) {
    // Remove non-numeric characters
    let cleaned = ('' + input.value).replace(/\D/g, '');

    // Limit to 8 characters (5 digits + hyphen + 3 digits)
    if (cleaned.length > 8) {
        cleaned = cleaned.slice(0, 8);
    }

    // Check if the input is not empty
    if (cleaned.length > 0) {
        // Apply formatting with hyphen
        cleaned = cleaned.replace(/^(\d{5})(\d{3})/, '$1-$2');
    }

    // Update the input value
    input.value = cleaned;
}

// Function to format currency in Brazilian format (R$2,50)
function formatCurrency(input) {
    // Remove non-numeric characters except dot (.)
    let cleaned = ('' + input.value).replace(/[^\d]/g, '');

    // If the cleaned value is empty, return early
    if (!cleaned) {
        input.value = '';
        return;
    }

    // Convert to number (in cents)
    let value = parseInt(cleaned, 10);

    // Check if it's a valid number
    if (isNaN(value)) {
        input.value = '';
        return;
    }

    // Format as currency with commas and period
    let formatted = 'R$ ' + (value / 100).toLocaleString('pt-BR', {
        minimumFractionDigits: 2,
        maximumFractionDigits: 2
    });

    // Update the input value
    input.value = formatted;
}

// Function to allow only numbers in a field
function allowOnlyNumbers(event) {
    // Ensure that only digits are allowed
    event.target.value = event.target.value.replace(/\D/g, '');
}
